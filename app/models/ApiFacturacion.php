<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 23/04/2021
 * Time: 10:10 a. m.
 */
require 'app/models/Signature.php';
require_once ("app/models/Ventas.php");


class ApiFacturacion
{
    public function EnviarComprobanteElectronico($emisor, $nombre, $rutacertificado, $ruta_archivo_xml, $ruta_archivo_cdr,$id_venta)
    {
        //require 'app/models/Ventas.php';
        $objfirma = new Signature();
        $objventa = new Ventas();
        $flg_firma = 0; //Posicion del XML: 0 para firma
        // $ruta_xml_firmar = $ruta . '.XML'; //es el archivo XML que se va a firmar
        $ruta = $ruta_archivo_xml . $nombre . '.XML';

        //variable para seguir un orden del proceso,
        $result = 2; //result 2 es error y 1 es ok

        $ruta_firma = $rutacertificado. 'certificado_prueba.pfx'; //ruta del archivo del certicado para firmar
        //$ruta_firma = $rutacertificado. 'certificado_20606798939.pfx';
        $pass_firma = '12345678'; //contraseña del certificado
        //$pass_firma = 'jgt2DTB24EezBeL';

        $resp = $objfirma->signature_xml($flg_firma, $ruta, $ruta_firma, $pass_firma);
        //print_r($resp);
        if($resp['respuesta'] == 'ok'){
            $ruta_xml = $ruta_archivo_xml.$nombre.'.XML';
            $result = $objventa->guardar_ruta_xml_venta($id_venta,$ruta_xml);
        }
        //echo '</br> XML FIRMADO';

        //FIRMAR XML - FIN
        if($result == 1){
            //CONVERTIR A ZIP - INICIO
            $zip = new ZipArchive();

            $nombrezip = $nombre.".ZIP";
            $rutazip = $ruta_archivo_xml . $nombre.".ZIP";

            if($zip->open($rutazip, ZipArchive::CREATE) === TRUE)
            {
                $zip->addFile($ruta, $nombre . '.XML');
                $zip->close();
                $result = 1;
            }else{
                $result = 2;
            }

            //echo '</br>XML ZIPEADO';
            //CONVERTIR A ZIP - FIN
            if($result == 1){

                //ENVIAR EL ZIP A LOS WS DE SUNAT - INICIO
                $ws = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService'; //ruta del servicio web de pruebad e SUNAT para enviar documentos
                //$ws = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService'; //Modo produccion
                $ruta_archivo = $rutazip;
                $nombre_archivo = $nombrezip;

                $contenido_del_zip = base64_encode(file_get_contents($ruta_archivo)); //codificar y convertir en texto el .zip

                //echo '</br> '. $contenido_del_zip;
                $xml_envio ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                        <soapenv:Header>
                        <wsse:Security>
                            <wsse:UsernameToken>
                                <wsse:Username>'.$emisor->empresa_ruc.$emisor->empresa_usuario_sol.'</wsse:Username>
                                <wsse:Password>'.$emisor->empresa_clave_sol.'</wsse:Password>
                            </wsse:UsernameToken>
                        </wsse:Security>
                        </soapenv:Header>
                        <soapenv:Body>
                        <ser:sendBill>
                            <fileName>'.$nombre_archivo.'</fileName>
                            <contentFile>'.$contenido_del_zip.'</contentFile>
                        </ser:sendBill>
                        </soapenv:Body>
                    </soapenv:Envelope>';

                $header = array(
                    "Content-type: text/xml; charset=\"utf-8\"",
                    "Accept: text/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "SOAPAction: ",
                    "Content-lenght: ".strlen($xml_envio)
                );

                $ch = curl_init(); //iniciar la llamada
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 1); //
                curl_setopt($ch,CURLOPT_URL, $ws);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch,CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch,CURLOPT_TIMEOUT, 30);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, $xml_envio);
                curl_setopt($ch,CURLOPT_HTTPHEADER, $header);

                //para ejecutar los procesos de forma local en windows
                //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
                curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem"); //solo en local, si estas en el servidor web con ssl comentar esta línea

                $response = curl_exec($ch); // ejecucion del llamado y respuesta del WS SUNAT.

                $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE); // objten el codigo de respuesta de la peticion al WS SUNAT
                $estadofe = "0"; //inicializo estado de operación interno

                if($httpcode == 200)//200: La comunicacion fue satisfactoria
                {
                    $doc = new DOMDocument();//clase que nos permite crear documentos XML
                    $doc->loadXML($response); //cargar y crear el XML por medio de text-xml response

                    if( isset( $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue ) ) // si en la etique de rpta hay valor entra
                    {
                        $cdr = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue; //guadarmos la respuesta(text-xml) en la variable
                        $cdr = base64_decode($cdr); //decodificando el xml
                        file_put_contents($ruta_archivo_cdr . 'R-' . $nombrezip, $cdr ); //guardo el CDR zip en la carpeta cdr
                        $zip = new ZipArchive();
                        if($zip->open($ruta_archivo_cdr. 'R-' . $nombrezip ) === true ) //rpta es identica existe el archivo
                        {
                            $zip->extractTo($ruta_archivo_cdr, 'R-' . $nombre . '.XML');
                            $zip->close();
                            $ruta_cdr = $ruta_archivo_cdr.'R-' . $nombre . '.XML';
                            $result = $objventa->guardar_ruta_cdr_venta($id_venta,$ruta_cdr);
                            if($result == 1){
                                //INICIO - VERIFICAR RESPUESTA DEL CDR
                                $xml_cdr = simplexml_load_file($ruta_cdr);
                                $xml_cdr->registerXPathNamespace('c', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

                                $DocumentResponse = array();

                                $ReferenceID    = $xml_cdr->xpath('///c:ReferenceID');
                                $ResponseCode   = $xml_cdr->xpath('///c:ResponseCode');
                                $Description    = $xml_cdr->xpath('///c:Description');
                                $Notes          = $xml_cdr->xpath('///c:Note');

                                $DocumentResponse['RefenceID']      = (string)$ReferenceID[0];
                                $DocumentResponse['ResponseCode']   = (string)$ResponseCode[0];
                                $DocumentResponse['Description']    = (string)$Description[0];

                                if(count($Notes) > 0){
                                    foreach ($Notes as $note){
                                        $DocumentResponse['Notes'][] = (string)$Notes[0];
                                    }
                                }
                                //FIN - VERIFICAR RESPUESTA DEL CDR

                                $estado_sunat = $DocumentResponse['Description'];
                                $objventa->guardar_repuesta_venta($id_venta, $estado_sunat);
                            }
                            //$estadofe = '1';
                            //echo 'Procesado correctamente, OK';
                        }else{
                            $result = 2;
                        }

                    }
                    else {
                        $estadofe = '2';
                        $result = 3; //error de envio comprobante
                        $codigo = $doc->getElementsByTagName('faultcode')->item(0)->nodeValue;
                        $mensaje = $doc->getElementsByTagName('faultstring')->item(0)->nodeValue;
                        //LOG DE TRAX ERRORES DB
                        $estado_sunat = 'Ocurrio un error con código: ' . $codigo . ' Msje:' . $mensaje;
                        $objventa->guardar_repuesta_venta($id_venta, $estado_sunat);
                        //echo 'Ocurrio un error con código: ' . $codigo . ' Msje:' . $mensaje;
                    }
                }
                else { //Problemas de comunicacion
                    $estadofe = "3";
                    $result = 4; //error de comunicacion(internet o sunat)
                    //LOG DE TRAX ERRORES DB
                    echo curl_error($ch);
                    $estado_sunat = 'Hubo o existe un problema de conexión';
                    $objventa->guardar_repuesta_venta($id_venta, $estado_sunat);
                    //echo 'Hubo existe un problema de conexión';
                }

                curl_close($ch);

                //ENVIAR EL ZIP A LOS WS DE SUNAT - FIN
            }

        }
        return $result;

    }

    public function EnviarResumenComprobantes($emisor,$nombre, $rutacertificado, $ruta_archivo_xml)
    {
        //firma del documento
        $objSignature = new Signature();
        $result = 2;
        $flg_firma = "0";
        //$ruta_archivo_xml = "xml/";
        $ruta = $ruta_archivo_xml.$nombre.'.XML';

        $ruta_firma = $rutacertificado. 'certificado_prueba.pfx'; //ruta del archivo del certicado para firmar
        //$ruta_firma = $rutacertificado. 'certificado_20606798939.pfx';
        $pass_firma = '12345678'; //contraseña del certificado
        //$pass_firma = 'jgt2DTB24EezBeL';

        $resp = $objSignature->signature_xml($flg_firma, $ruta, $ruta_firma, $pass_firma);
        //print_r($resp); //hash
        if($resp['respuesta'] == 'ok'){
            //Generar el .zip

            $zip = new ZipArchive();

            $nombrezip = $nombre.".ZIP";
            $rutazip = $ruta_archivo_xml.$nombre.".ZIP";

            if($zip->open($rutazip,ZIPARCHIVE::CREATE)===true){
                $zip->addFile($ruta, $nombre.'.XML');
                $zip->close();
                $result = 1;
            }else{
                $result = 2;
            }
        }
        $ticket = "0";
        $mensaje = "";
        if($result == 1){
            //Enviamos el archivo a sunat

            $ws = "https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService";
            //$ws = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService'; //Modo produccion


            $ruta_archivo = $ruta_archivo_xml.$nombrezip;
            $nombre_archivo = $nombrezip;
            $ruta_archivo_cdr = "libs/ApiFacturacion/cdr/";

            $contenido_del_zip = base64_encode(file_get_contents($ruta_archivo));


            $xml_envio ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				 <soapenv:Header>
				 	<wsse:Security>
				 		<wsse:UsernameToken>
				 			<wsse:Username>'.$emisor->empresa_ruc.$emisor->empresa_usuario_sol.'</wsse:Username>
				 			<wsse:Password>'.$emisor->empresa_clave_sol.'</wsse:Password>
				 		</wsse:UsernameToken>
				 	</wsse:Security>
				 </soapenv:Header>
				 <soapenv:Body>
				 	<ser:sendSummary>
				 		<fileName>'.$nombre_archivo.'</fileName>
				 		<contentFile>'.$contenido_del_zip.'</contentFile>
				 	</ser:sendSummary>
				 </soapenv:Body>
				</soapenv:Envelope>';


            $header = array(
                "Content-type: text/xml; charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: ",
                "Content-lenght: ".strlen($xml_envio)
            );


            $ch = curl_init();
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
            curl_setopt($ch,CURLOPT_URL,$ws);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_ANY);
            curl_setopt($ch,CURLOPT_TIMEOUT,55);
            curl_setopt($ch,CURLOPT_POST,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$xml_envio);
            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
            //para ejecutar los procesos de forma local en windows
            //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
            curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");


            $response = curl_exec($ch);

            $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
            $estadofe = "0";

            $ticket = "0";
            if($httpcode == 200){
                $doc = new DOMDocument();
                $doc->loadXML($response);

                if (isset($doc->getElementsByTagName('ticket')->item(0)->nodeValue)) {
                    $ticket = $doc->getElementsByTagName('ticket')->item(0)->nodeValue;
                    //echo "TODO OK NRO TK: ".$ticket;
                    $result = 1;
                    $mensaje = "TICKET ENVIADO";
                }else{

                    $codigo = $doc->getElementsByTagName("faultcode")->item(0)->nodeValue;
                    $mensaje = $doc->getElementsByTagName("faultstring")->item(0)->nodeValue;
                    //echo "error ".$codigo.": ".$mensaje;
                    $mensaje = "error ".$codigo.": ".$mensaje;
                    $result = 4;
                }

            }else{
                echo curl_error($ch);
                //echo "Problema de conexión";
                $mensaje = "Problema de conexión";
                $result = 3;
            }

            curl_close($ch);
            //return $ticket;
        }
        $resultado = array(
            "result" => $result,
            "ticket" => $ticket,
            "mensaje" => $mensaje
        );
        return $resultado;

    }


    function ConsultarTicket($emisor, $cabecera, $ticket, $ruta_archivo_cdr, $tipo)
    {
        $objventa = new Ventas();
        $ws = "https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService"; //modo beta
        //$ws = "https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService"; //modo produccion
        $ruta_archivo_xml = "libs/ApiFacturacion/xml/";
        $nombre	= $emisor->empresa_ruc.'-'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];
        $nombre_xml	= $nombre.".XML";

        //===============================================================//
        //FIRMADO DEL cpe CON CERTIFICADO DIGITAL
        $objSignature = new Signature();
        $flg_firma = "0";
        $ruta = $ruta_archivo_xml.$nombre_xml;

        $ruta_firma = "certificado_20567274421.pfx";
        $pass_firma = "cOnch1t4Buf30";

        //===============================================================//

        //ALMACENAR EL ARCHIVO EN UN ZIP
        $zip = new ZipArchive();

        $nombrezip = $nombre.".ZIP";

        /*if($zip->open($nombrezip,ZIPARCHIVE::CREATE)===true){
            $zip->addFile($ruta, $nombre_xml);
            $zip->close();
        }*/

        //===============================================================//

        //ENVIAR ZIP A SUNAT
        $ruta_archivo = $nombre;
        $nombre_archivo = $nombre;
        //$ruta_archivo_cdr = "cdr/";

        //$contenido_del_zip = base64_encode(file_get_contents($ruta_archivo.'.ZIP'));
        //FIN ZIP

        $xml_envio = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <soapenv:Header>
                <wsse:Security>
                    <wsse:UsernameToken>
                    <wsse:Username>'.$emisor->empresa_ruc.$emisor->empresa_usuario_sol.'</wsse:Username>
                    <wsse:Password>'.$emisor->empresa_clave_sol.'</wsse:Password>
                    </wsse:UsernameToken>
                </wsse:Security>
            </soapenv:Header>
            <soapenv:Body>
                <ser:getStatus>
                    <ticket>' . $ticket . '</ticket>
                </ser:getStatus>
            </soapenv:Body>
        </soapenv:Envelope>';


        $header = array(
            "Content-type: text/xml; charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ",
            "Content-lenght: ".strlen($xml_envio)
        );


        $ch = curl_init();
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,1);
        curl_setopt($ch,CURLOPT_URL,$ws);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_ANY);
        curl_setopt($ch,CURLOPT_TIMEOUT,60);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml_envio);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        //para ejecutar los procesos de forma local en windows
        //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        //echo "codigo:".$httpcode;

        if($httpcode == 200){
            $doc = new DOMDocument();
            $doc->loadXML($response);

            if(isset($doc->getElementsByTagName('content')->item(0)->nodeValue)){
                $cdr = $doc->getElementsByTagName('content')->item(0)->nodeValue;
                $cdr = base64_decode($cdr);


                file_put_contents($ruta_archivo_cdr."R-".$nombre_archivo.".ZIP", $cdr);

                $zip = new ZipArchive;
                if($zip->open($ruta_archivo_cdr."R-".$nombre_archivo.".ZIP")===true){
                    $zip->extractTo($ruta_archivo_cdr,'R-'.$nombre_archivo.'.XML');
                    $zip->close();
                }
                $mensaje_consulta = "Ha sido aceptado";
                $nombre_ruta_cdr = $ruta_archivo_cdr.'R-'.$nombre_archivo.'.XML';
                //INICIO - VERIFICAR RESPUESTA DEL CDR
                $xml_cdr = simplexml_load_file($nombre_ruta_cdr);
                $xml_cdr->registerXPathNamespace('c', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

                $DocumentResponse = array();

                $ReferenceID    = $xml_cdr->xpath('///c:ReferenceID');
                $ResponseCode   = $xml_cdr->xpath('///c:ResponseCode');
                $Description    = $xml_cdr->xpath('///c:Description');
                $Notes          = $xml_cdr->xpath('///c:Note');

                $DocumentResponse['RefenceID']      = (string)$ReferenceID[0];
                $DocumentResponse['ResponseCode']   = (string)$ResponseCode[0];
                $DocumentResponse['Description']    = (string)$Description[0];

                if(count($Notes) > 0){
                    foreach ($Notes as $note){
                        $DocumentResponse['Notes'][] = (string)$Notes[0];
                    }
                }
                //FIN - VERIFICAR RESPUESTA DEL CDR
                $mensaje_consulta = $DocumentResponse['Description'];
                if($tipo == 1){
                    $objventa->actualizar_estadoconsulta_x_ticket($ticket,$nombre_ruta_cdr,$mensaje_consulta);
                }else{
                    $objventa->actualizar_estadoconsulta_x_ticket_anulado($ticket,$nombre_ruta_cdr,$mensaje_consulta);
                }
                //echo "TODO OK";
                $result = 1;
            }else{
                $codigo = $doc->getElementsByTagName("faultcode")->item(0)->nodeValue;
                $mensaje = $doc->getElementsByTagName("faultstring")->item(0)->nodeValue;
                //echo "error ".$codigo.": ".$mensaje;
                $mensaje_consulta = "error ".$codigo.": ".$mensaje;
                $nombre_ruta_cdr = '';
                if($tipo == 1){
                    $objventa->actualizar_estadoconsulta_x_ticket($ticket,$nombre_ruta_cdr,$mensaje_consulta);
                }else{
                    $objventa->actualizar_estadoconsulta_x_ticket_anulado($ticket,$nombre_ruta_cdr,$mensaje_consulta);
                }
                $result = 4;
            }

        }else{
            echo curl_error($ch);
            echo "Problema de conexión";
            $result = 3;
        }

        curl_close($ch);
        return $result;
    }

    function consultarComprobante($emisor, $comprobante)
    {
        try{
            $ws = "https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService";
           // $ws = "https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService";
            $soapUser = "";
            $soapPassword = "";

            $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
				xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" 
				xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
					<soapenv:Header>
						<wsse:Security>
							<wsse:UsernameToken>
								<wsse:Username>'.$emisor->empresa_ruc.$emisor->empresa_usuario_sol.'</wsse:Username>
								<wsse:Password>'.$emisor->empresa_clave_sol.'</wsse:Password>
							</wsse:UsernameToken>
						</wsse:Security>
					</soapenv:Header>
					<soapenv:Body>
						<ser:getStatus>
							<rucComprobante>'.$emisor->empresa_ruc.'</rucComprobante>
							<tipoComprobante>'.$comprobante['tipo_comprobante'].'</tipoComprobante>
							<serieComprobante>'.$comprobante['serie'].'</serieComprobante>
							<numeroComprobante>'.$comprobante['correlativo'].'</numeroComprobante>
						</ser:getStatus>
					</soapenv:Body>
				</soapenv:Envelope>';

            $headers = array(
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: ",
                "Content-length: " . strlen($xml_post_string),
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $ws);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            //para ejecutar los procesos de forma local en windows
            //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
            curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $result = var_dump($response);

        } catch (Exception $e) {
            //echo "SUNAT ESTA FUERA SERVICIO: ".$e->getMessage();
            $result = "SUNAT ESTA FUERA SERVICIO";
        }
        return $result;
    }
}