<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 23/04/2021
 * Time: 09:32 a. m.
 */
require 'app/models/cantidad_en_letras.php';

class GeneradorXML
{
    function CrearXMLFactura($nombrexml, $emisor, $cliente, $comprobante, $detalle)
    {

        $doc = new DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

        $total_letras = CantidadEnLetra($comprobante->venta_total);
        $tipo_documento_emisor = "6";
        if($cliente->tipodocumento_codigo==6){
            $razon_social = $cliente->cliente_razonsocial;
        }else{
            $razon_social = $cliente->cliente_nombre;
        }
        $anho = date('Y');
        if($anho == "2021"){
            $icbper = "0.30";
        }elseif($anho == "2022"){
            $icbper = "0.40";
        }else{
            $icbper = "0.50";
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
      <Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
         <ext:UBLExtensions>
            <ext:UBLExtension>
               <ext:ExtensionContent />
            </ext:UBLExtension>
         </ext:UBLExtensions>
         <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
         <cbc:CustomizationID>2.0</cbc:CustomizationID>
         <cbc:ID>'.$comprobante->venta_serie.'-'.$comprobante->venta_correlativo.'</cbc:ID>
         <cbc:IssueDate>'.date('Y-m-d', strtotime($comprobante->venta_fecha)).'</cbc:IssueDate>
         <cbc:IssueTime>'.date('H:i:s', strtotime($comprobante->venta_fecha)).'</cbc:IssueTime>
         <cbc:DueDate>'.date('Y-m-d', strtotime($comprobante->venta_fecha)).'</cbc:DueDate>
         <cbc:InvoiceTypeCode listID="0101">'.$comprobante->venta_tipo.'</cbc:InvoiceTypeCode>
         <cbc:Note languageLocaleID="1000"><![CDATA['.$total_letras.']]></cbc:Note>
         <cbc:DocumentCurrencyCode>'.$comprobante->abrstandar.'</cbc:DocumentCurrencyCode>
         <cac:Signature>
            <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
            <cbc:Note><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Note>
            <cac:SignatoryParty>
               <cac:PartyIdentification>
                  <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
               </cac:PartyName>
            </cac:SignatoryParty>
            <cac:DigitalSignatureAttachment>
               <cac:ExternalReference>
                  <cbc:URI>#SIGN-EMPRESA</cbc:URI>
               </cac:ExternalReference>
            </cac:DigitalSignatureAttachment>
         </cac:Signature>
         <cac:AccountingSupplierParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="'.$tipo_documento_emisor.'">'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Name>
               </cac:PartyName>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cbc:ID>'.$emisor->empresa_ubigeo.'</cbc:ID>
                     <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>
                     <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>
                     <cbc:CityName>'.$emisor->empresa_provincia.'</cbc:CityName>
                     <cbc:CountrySubentity>'.$emisor->empresa_departamento.'</cbc:CountrySubentity>
                     <cbc:District>'.$emisor->empresa_distrito.'</cbc:District>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$emisor->empresa_domiciliofiscal.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>'.$emisor->empresa_pais.'</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingSupplierParty>
         <cac:AccountingCustomerParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="'.$cliente->tipodocumento_codigo.'">'.$cliente->cliente_numero.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$cliente->cliente_direccion.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingCustomerParty>';
        //tipo de pago
        $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';

        /*if($comprobante->id_tipo_pago != "5"){
            $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';
        }else{
            $xml.='<cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Credito</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                     </cac:PaymentTerms>
                            
                     <cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Cuota001</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                        <cbc:PaymentDueDate>'.date('Y-m-d').'</cbc:PaymentDueDate>
                    </cac:PaymentTerms>';
        }*/
        $impuesto = $comprobante->venta_totaligv + $comprobante->venta_icbper;
        $xml.='<cac:TaxTotal>
            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$impuesto.'</cbc:TaxAmount>
            <cac:TaxSubtotal>
               <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
               <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
               <cac:TaxCategory>
                  <cac:TaxScheme>
                     <cbc:ID>1000</cbc:ID>
                     <cbc:Name>IGV</cbc:Name>
                     <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                  </cac:TaxScheme>
               </cac:TaxCategory>
            </cac:TaxSubtotal>';


        if($comprobante->venta_totalexonerada>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalexonerada.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>
                        <cbc:Name>EXO</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }

        if($comprobante->venta_totalinafecta>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalinafecta.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
                        <cbc:Name>INA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalgratuita>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgratuita.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9996</cbc:ID>
                        <cbc:Name>GRA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_icbper>0){
            $xml.='<cac:TaxSubtotal>
                      <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_icbper.'</cbc:TaxAmount>
                      <cac:TaxCategory>
                         <cac:TaxScheme>
                            <cbc:ID>7152</cbc:ID>
                            <cbc:Name>ICBPER</cbc:Name>
                            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                         </cac:TaxScheme>
                      </cac:TaxCategory>
                   </cac:TaxSubtotal>';
        }

        $total_antes_de_impuestos = $comprobante->venta_totalgravada+$comprobante->venta_totalexonerada+$comprobante->venta_totalinafecta;

        $xml.='</cac:TaxTotal>
         <cac:LegalMonetaryTotal>
            <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$total_antes_de_impuestos.'</cbc:LineExtensionAmount>
            <cbc:TaxInclusiveAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:TaxInclusiveAmount>
            <cbc:PayableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:PayableAmount>
         </cac:LegalMonetaryTotal>';
        $item = 1;
        foreach($detalle as $v){

            $xml.='<cac:InvoiceLine>
               <cbc:ID>'.$item.'</cbc:ID>
               <cbc:InvoicedQuantity unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:InvoicedQuantity>
               <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:LineExtensionAmount>
               <cac:PricingReference>';
            if($v->codigo == "21"){
                $xml.= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_precio_unitario.'</cbc:PriceAmount>
                     <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }else {
                $xml .= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $v->venta_detalle_precio_unitario . '</cbc:PriceAmount>
                     <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }
            $total_impuesto_bolsa = number_format($v->venta_detalle_cantidad * $icbper, 2);
            $impuesto_items = ($v->venta_detalle_total_igv) + ($total_impuesto_bolsa) * 1;
            $xml.= '</cac:PricingReference>
               <cac:TaxTotal>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                  <cac:TaxSubtotal>
                     <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:TaxableAmount>
                     <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                     <cac:TaxCategory>
                        <cbc:Percent>'.$v->venta_detalle_porcentaje_igv.'</cbc:Percent>
                        <cbc:TaxExemptionReasonCode>'.$v->producto_precio_codigoafectacion.'</cbc:TaxExemptionReasonCode>
                        <cac:TaxScheme>
                           <cbc:ID>'.$v->codigo_afectacion.'</cbc:ID>
                           <cbc:Name>'.$v->nombre_afectacion.'</cbc:Name>
                           <cbc:TaxTypeCode>'.$v->tipo_afectacion.'</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                     </cac:TaxCategory>
                  </cac:TaxSubtotal>';

            if($v->id_receta == "131"){

                $xml.= '<cac:TaxSubtotal>
                            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$total_impuesto_bolsa.'</cbc:TaxAmount>
                            <cbc:BaseUnitMeasure unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:BaseUnitMeasure>
                        <cac:TaxCategory>
                        <cbc:PerUnitAmount currencyID="PEN">'.$icbper.'</cbc:PerUnitAmount>
                            <cac:TaxScheme>
                                <cbc:ID>7152</cbc:ID>
                                <cbc:Name>ICBPER</cbc:Name>
                                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                        </cac:TaxSubtotal>';
            }

            $xml.=
               '</cac:TaxTotal>';

            $xml.= '<cac:Item>
                      <cbc:Description><![CDATA['.$v->venta_detalle_nombre_producto.']]></cbc:Description>
                      <cac:SellersItemIdentification>
                         <cbc:ID>'.$v->id_producto_precio.'</cbc:ID>
                      </cac:SellersItemIdentification>
                   </cac:Item>';

            if($v->codigo == "21"){
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:PriceAmount>
               </cac:Price>
            </cac:InvoiceLine>';
            }else{
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_unitario.'</cbc:PriceAmount>
               </cac:Price>
            </cac:InvoiceLine>';
            }

            $item++;
        }

        $xml.="</Invoice>";

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }

    function CrearXMLNotaCredito($nombrexml, $emisor, $cliente, $comprobante, $detalle, $descripcion_nota)
    {
        $doc = new DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

        $total_letras = CantidadEnLetra($comprobante->venta_total);
        if($cliente->tipodocumento_codigo==6){
            $razon_social = $cliente->cliente_razonsocial;
        }else{
            $razon_social = $cliente->cliente_nombre;
        }
        $anho = date('Y');
        if($anho == "2021"){
            $icbper = "0.30";
        }elseif($anho == "2022"){
            $icbper = "0.40";
        }else{
            $icbper = "0.50";
        }


        $xml = '<?xml version="1.0" encoding="UTF-8"?>
      <CreditNote xmlns="urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
         <ext:UBLExtensions>
            <ext:UBLExtension>
               <ext:ExtensionContent />
            </ext:UBLExtension>
         </ext:UBLExtensions>
         <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
         <cbc:CustomizationID>2.0</cbc:CustomizationID>
         <cbc:ID>'.$comprobante->venta_serie.'-'.$comprobante->venta_correlativo.'</cbc:ID>
         <cbc:IssueDate>'.date('Y-m-d', strtotime($comprobante->venta_fecha)).'</cbc:IssueDate>
         <cbc:IssueTime>'.date('H:i:s', strtotime($comprobante->venta_fecha)).'</cbc:IssueTime>
         <cbc:Note languageLocaleID="1000"><![CDATA['.$total_letras.']]></cbc:Note>
         <cbc:DocumentCurrencyCode>'.$comprobante->abrstandar.'</cbc:DocumentCurrencyCode>
         <cac:DiscrepancyResponse>
            <cbc:ReferenceID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ReferenceID>
            <cbc:ResponseCode>'.$comprobante->venta_codigo_motivo_nota.'</cbc:ResponseCode>
            <cbc:Description>'.$descripcion_nota->tipo_nota_descripcion.'</cbc:Description>
         </cac:DiscrepancyResponse>
         <cac:BillingReference>
            <cac:InvoiceDocumentReference>
               <cbc:ID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ID>
               <cbc:DocumentTypeCode>'.$comprobante->tipo_documento_modificar.'</cbc:DocumentTypeCode>
            </cac:InvoiceDocumentReference>
         </cac:BillingReference>
         <cac:Signature>
            <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
            <cbc:Note><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Note>
            <cac:SignatoryParty>
               <cac:PartyIdentification>
                  <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
               </cac:PartyName>
            </cac:SignatoryParty>
            <cac:DigitalSignatureAttachment>
               <cac:ExternalReference>
                  <cbc:URI>#SIGN-EMPRESA</cbc:URI>
               </cac:ExternalReference>
            </cac:DigitalSignatureAttachment>
         </cac:Signature>
         <cac:AccountingSupplierParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="6">'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Name>
               </cac:PartyName>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cbc:ID>'.$emisor->empresa_ubigeo.'</cbc:ID>
                     <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>
                     <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>
                     <cbc:CityName>'.$emisor->empresa_provincia.'</cbc:CityName>
                     <cbc:CountrySubentity>'.$emisor->empresa_departamento.'</cbc:CountrySubentity>
                     <cbc:District>'.$emisor->empresa_distrito.'</cbc:District>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$emisor->empresa_domiciliofiscal.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>'.$emisor->empresa_pais.'</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingSupplierParty>
         <cac:AccountingCustomerParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="'.$cliente->tipodocumento_codigo.'">'.$cliente->cliente_numero.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$cliente->cliente_direccion.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingCustomerParty>';

        $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';

        /*if($comprobante->id_tipo_pago != "5"){
            $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';
        }else{
            $xml.='<cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Credito</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                     </cac:PaymentTerms>
                            
                     <cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Cuota001</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                        <cbc:PaymentDueDate>'.date('Y-m-d').'</cbc:PaymentDueDate>
                    </cac:PaymentTerms>';
        }*/

        $xml.='<cac:TaxTotal>
            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
            <cac:TaxSubtotal>
               <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
               <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
               <cac:TaxCategory>
                  <cac:TaxScheme>
                     <cbc:ID>1000</cbc:ID>
                     <cbc:Name>IGV</cbc:Name>
                     <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                  </cac:TaxScheme>
               </cac:TaxCategory>
            </cac:TaxSubtotal>';

        if($comprobante->venta_totalexonerada>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalexonerada.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>
                        <cbc:Name>EXO</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalinafecta>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalinafecta.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
                        <cbc:Name>INA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalgratuita>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgratuita.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9996</cbc:ID>
                        <cbc:Name>GRA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_icbper>0){
            $xml.='<cac:TaxSubtotal>
                      <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_icbper.'</cbc:TaxAmount>
                      <cac:TaxCategory>
                         <cac:TaxScheme>
                            <cbc:ID>7152</cbc:ID>
                            <cbc:Name>ICBPER</cbc:Name>
                            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                         </cac:TaxScheme>
                      </cac:TaxCategory>
                   </cac:TaxSubtotal>';
        }

        $total_antes_de_impuestos = $comprobante->venta_totalgravada+$comprobante->venta_totalexonerada+$comprobante->venta_totalinafecta;

        $xml.='</cac:TaxTotal>
         <cac:LegalMonetaryTotal>
            <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$total_antes_de_impuestos.'</cbc:LineExtensionAmount>
            <cbc:TaxInclusiveAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:TaxInclusiveAmount>
            <cbc:PayableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:PayableAmount>
         </cac:LegalMonetaryTotal>';
        $item = 1;

        foreach($detalle as $v){

            $xml.='<cac:CreditNoteLine>
               <cbc:ID>'.$item.'</cbc:ID>
               <cbc:CreditedQuantity unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:CreditedQuantity>
               <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:LineExtensionAmount>
               <cac:PricingReference>';
            if($v->codigo == "21"){
                $xml.= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_precio_unitario.'</cbc:PriceAmount>
                     <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }else {
                $xml .= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $v->venta_detalle_precio_unitario . '</cbc:PriceAmount>
                     <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }
            $xml.= '</cac:PricingReference>
               <cac:TaxTotal>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                  <cac:TaxSubtotal>
                     <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:TaxableAmount>
                     <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                     <cac:TaxCategory>
                        <cbc:Percent>'.$v->venta_detalle_porcentaje_igv.'</cbc:Percent>
                        <cbc:TaxExemptionReasonCode>'.$v->producto_precio_codigoafectacion.'</cbc:TaxExemptionReasonCode>
                        <cac:TaxScheme>
                           <cbc:ID>'.$v->codigo_afectacion.'</cbc:ID>
                           <cbc:Name>'.$v->nombre_afectacion.'</cbc:Name>
                           <cbc:TaxTypeCode>'.$v->tipo_afectacion.'</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                     </cac:TaxCategory>
                  </cac:TaxSubtotal>';

            if($v->id_receta == "131"){
                $total_impuesto_bolsa = number_format($v->venta_detalle_cantidad * $icbper, 2);
                $xml.= '<cac:TaxSubtotal>
                            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$total_impuesto_bolsa.'</cbc:TaxAmount>
                            <cbc:BaseUnitMeasure unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:BaseUnitMeasure>
                        <cbc:PerUnitAmount currencyID="PEN">'.$icbper.'</cbc:PerUnitAmount>
                        <cac:TaxCategory>
                            <cac:TaxScheme>
                                <cbc:ID>7152</cbc:ID>
                                <cbc:Name>ICBPER</cbc:Name>
                                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                        </cac:TaxSubtotal>';
            }

            $xml.=
               '</cac:TaxTotal>';

            $xml.= '<cac:Item>
                      <cbc:Description><![CDATA['.$v->venta_detalle_nombre_producto.']]></cbc:Description>
                      <cac:SellersItemIdentification>
                         <cbc:ID>'.$v->id_producto_precio.'</cbc:ID>
                      </cac:SellersItemIdentification>
                   </cac:Item>';

            if($v->codigo == "21"){
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:PriceAmount>
               </cac:Price>
            </cac:CreditNoteLine>';
            }else{
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_unitario.'</cbc:PriceAmount>
               </cac:Price>
            </cac:CreditNoteLine>';
            }

            $item++;
        }
        $xml.='</CreditNote>';

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }

    function CrearXMLNotaDebito($nombrexml, $emisor, $cliente, $comprobante, $detalle, $descripcion_nota)
    {

        $doc = new DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

        $total_letras = CantidadEnLetra($comprobante->venta_total);
        if($cliente->tipodocumento_codigo==6){
            $razon_social = $cliente->cliente_razonsocial;
        }else{
            $razon_social = $cliente->cliente_nombre;
        }
        $anho = date('Y');
        if($anho == "2021"){
            $icbper = "0.30";
        }elseif($anho == "2022"){
            $icbper = "0.40";
        }else{
            $icbper = "0.50";
        }


        $xml = '<?xml version="1.0" encoding="UTF-8"?>
      <DebitNote xmlns="urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
         <ext:UBLExtensions>
            <ext:UBLExtension>
               <ext:ExtensionContent />
            </ext:UBLExtension>
         </ext:UBLExtensions>
         <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
         <cbc:CustomizationID>2.0</cbc:CustomizationID>
         <cbc:ID>'.$comprobante->venta_serie.'-'.$comprobante->venta_correlativo.'</cbc:ID>
         <cbc:IssueDate>'.date('Y-m-d', strtotime($comprobante->venta_fecha)).'</cbc:IssueDate>
         <cbc:IssueTime>'.date('H:i:s', strtotime($comprobante->venta_fecha)).'</cbc:IssueTime>
         <cbc:Note languageLocaleID="1000"><![CDATA['.$total_letras.']]></cbc:Note>
         <cbc:DocumentCurrencyCode>'.$comprobante->abrstandar.'</cbc:DocumentCurrencyCode>
         <cac:DiscrepancyResponse>
            <cbc:ReferenceID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ReferenceID>
            <cbc:ResponseCode>'.$comprobante->venta_codigo_motivo_nota.'</cbc:ResponseCode>
            <cbc:Description>'.$descripcion_nota->tipo_nota_descripcion.'</cbc:Description>
         </cac:DiscrepancyResponse>
         <cac:BillingReference>
            <cac:InvoiceDocumentReference>
               <cbc:ID>'.$comprobante->serie_modificar.'-'.$comprobante->correlativo_modificar.'</cbc:ID>
               <cbc:DocumentTypeCode>'.$comprobante->tipo_documento_modificar.'</cbc:DocumentTypeCode>
            </cac:InvoiceDocumentReference>
         </cac:BillingReference>
         <cac:Signature>
            <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
            <cbc:Note><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Note>
            <cac:SignatoryParty>
               <cac:PartyIdentification>
                  <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
               </cac:PartyName>
            </cac:SignatoryParty>
            <cac:DigitalSignatureAttachment>
               <cac:ExternalReference>
                  <cbc:URI>#SIGN-EMPRESA</cbc:URI>
               </cac:ExternalReference>
            </cac:DigitalSignatureAttachment>
         </cac:Signature>
         <cac:AccountingSupplierParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="6">'.$emisor->empresa_ruc.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyName>
                  <cbc:Name><![CDATA['.$emisor->empresa_nombrecomercial.']]></cbc:Name>
               </cac:PartyName>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cbc:ID>'.$emisor->empresa_ubigeo.'</cbc:ID>
                     <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>
                     <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>
                     <cbc:CityName>'.$emisor->empresa_provincia.'</cbc:CityName>
                     <cbc:CountrySubentity>'.$emisor->empresa_departamento.'</cbc:CountrySubentity>
                     <cbc:District>'.$emisor->empresa_distrito.'</cbc:District>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$emisor->empresa_domiciliofiscal.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>'.$emisor->empresa_pais.'</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingSupplierParty>
         <cac:AccountingCustomerParty>
            <cac:Party>
               <cac:PartyIdentification>
                  <cbc:ID schemeID="'.$cliente->tipodocumento_codigo.'">'.$cliente->cliente_numero.'</cbc:ID>
               </cac:PartyIdentification>
               <cac:PartyLegalEntity>
                  <cbc:RegistrationName><![CDATA['.$razon_social.']]></cbc:RegistrationName>
                  <cac:RegistrationAddress>
                     <cac:AddressLine>
                        <cbc:Line><![CDATA['.$cliente->cliente_direccion.']]></cbc:Line>
                     </cac:AddressLine>
                     <cac:Country>
                        <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                     </cac:Country>
                  </cac:RegistrationAddress>
               </cac:PartyLegalEntity>
            </cac:Party>
         </cac:AccountingCustomerParty>';

        $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';

        /*if($comprobante->id_tipo_pago != "5"){
            $xml.='<cac:PaymentTerms>
                    <cbc:ID>FormaPago</cbc:ID>
                    <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
                   </cac:PaymentTerms>';
        }else{
            $xml.='<cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Credito</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                     </cac:PaymentTerms>
                            
                     <cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Cuota001</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">'.$comprobante->venta_total.'</cbc:Amount>
                        <cbc:PaymentDueDate>'.date('Y-m-d').'</cbc:PaymentDueDate>
                    </cac:PaymentTerms>';
        }*/

        $xml.='<cac:TaxTotal>
                <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>';
        $xml .= '<cac:TaxSubtotal>
                   <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
                   <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
                   <cac:TaxCategory>
                      <cac:TaxScheme>
                         <cbc:ID>1000</cbc:ID>
                         <cbc:Name>IGV</cbc:Name>
                         <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                      </cac:TaxScheme>
                   </cac:TaxCategory>
                </cac:TaxSubtotal>';
        /*if($comprobante->venta_totalgravada>0){
            $xml .= '<cac:TaxSubtotal>
                   <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgravada.'</cbc:TaxableAmount>
                   <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totaligv.'</cbc:TaxAmount>
                   <cac:TaxCategory>
                      <cac:TaxScheme>
                         <cbc:ID>1000</cbc:ID>
                         <cbc:Name>IGV</cbc:Name>
                         <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                      </cac:TaxScheme>
                   </cac:TaxCategory>
                </cac:TaxSubtotal>';
        }*/

        if($comprobante->venta_totalexonerada>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalexonerada.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>
                        <cbc:Name>EXO</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalinafecta>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalinafecta.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
                        <cbc:Name>INA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_totalgratuita>0){
            $xml.='<cac:TaxSubtotal>
                  <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_totalgratuita.'</cbc:TaxableAmount>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:TaxAmount>
                  <cac:TaxCategory>
                     <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                     <cac:TaxScheme>
                        <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9996</cbc:ID>
                        <cbc:Name>GRA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                     </cac:TaxScheme>
                  </cac:TaxCategory>
               </cac:TaxSubtotal>';
        }
        if($comprobante->venta_icbper>0){
            $xml.='<cac:TaxSubtotal>
                      <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_icbper.'</cbc:TaxAmount>
                      <cac:TaxCategory>
                         <cac:TaxScheme>
                            <cbc:ID>7152</cbc:ID>
                            <cbc:Name>ICBPER</cbc:Name>
                            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                         </cac:TaxScheme>
                      </cac:TaxCategory>
                   </cac:TaxSubtotal>';
        }

        $total_antes_de_impuestos = $comprobante->venta_totalgravada+$comprobante->venta_totalexonerada+$comprobante->venta_totalinafecta;

        $xml.='</cac:TaxTotal>
         <cac:RequestedMonetaryTotal>
            
            <cbc:PayableAmount currencyID="'.$comprobante->abrstandar.'">'.$comprobante->venta_total.'</cbc:PayableAmount>
         </cac:RequestedMonetaryTotal>';
        $item = 1;

        foreach($detalle as $v){

            $xml.='<cac:DebitNoteLine>
               <cbc:ID>'.$item.'</cbc:ID>
               <cbc:DebitedQuantity unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:DebitedQuantity>
               <cbc:LineExtensionAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:LineExtensionAmount>
               <cac:PricingReference>';
            if($v->codigo == "21"){
                $xml.= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_precio_unitario.'</cbc:PriceAmount>
                     <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }else {
                $xml .= '<cac:AlternativeConditionPrice>
                     <cbc:PriceAmount currencyID="' . $comprobante->abrstandar . '">' . $v->venta_detalle_precio_unitario . '</cbc:PriceAmount>
                     <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                  </cac:AlternativeConditionPrice>';
            }
            $xml.= '</cac:PricingReference>
               <cac:TaxTotal>
                  <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                  <cac:TaxSubtotal>
                     <cbc:TaxableAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_total.'</cbc:TaxableAmount>
                     <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_total_igv.'</cbc:TaxAmount>
                     <cac:TaxCategory>';
            if($v->producto_precio_codigoafectacion == "10"){
                $xml.= '<cbc:Percent>'.$v->venta_detalle_porcentaje_igv.'</cbc:Percent>';
            }else{
                $xml.= '<cbc:Percent>0.00</cbc:Percent>';
            }
            $xml.= '<cbc:TaxExemptionReasonCode>'.$v->producto_precio_codigoafectacion.'</cbc:TaxExemptionReasonCode>
                        <cac:TaxScheme>
                           <cbc:ID>'.$v->codigo_afectacion.'</cbc:ID>
                           <cbc:Name>'.$v->nombre_afectacion.'</cbc:Name>
                           <cbc:TaxTypeCode>'.$v->tipo_afectacion.'</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                     </cac:TaxCategory>
                  </cac:TaxSubtotal>';

            if($v->id_receta == "131"){
                $total_impuesto_bolsa = number_format($v->venta_detalle_cantidad * $icbper, 2);
                $xml.= '<cac:TaxSubtotal>
                            <cbc:TaxAmount currencyID="'.$comprobante->abrstandar.'">'.$total_impuesto_bolsa.'</cbc:TaxAmount>
                            <cbc:BaseUnitMeasure unitCode="'.$v->medida_codigo_unidad.'">'.$v->venta_detalle_cantidad.'</cbc:BaseUnitMeasure>
                        <cbc:PerUnitAmount currencyID="PEN">'.$icbper.'</cbc:PerUnitAmount>
                        <cac:TaxCategory>
                            <cac:TaxScheme>
                                <cbc:ID>7152</cbc:ID>
                                <cbc:Name>ICBPER</cbc:Name>
                                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                        </cac:TaxSubtotal>';
            }

            $xml.=
                '</cac:TaxTotal>';

            $xml.= '<cac:Item>
                      <cbc:Description><![CDATA['.$v->venta_detalle_nombre_producto.']]></cbc:Description>
                      <cac:SellersItemIdentification>
                         <cbc:ID>'.$v->id_producto_precio.'</cbc:ID>
                      </cac:SellersItemIdentification>
                   </cac:Item>';

            if($v->codigo == "21"){
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">0.00</cbc:PriceAmount>
               </cac:Price>
            </cac:CreditNoteLine>';
            }else{
                $xml.= '<cac:Price>
                  <cbc:PriceAmount currencyID="'.$comprobante->abrstandar.'">'.$v->venta_detalle_valor_unitario.'</cbc:PriceAmount>
               </cac:Price>
            </cac:DebitNoteLine>';
            }

            $item++;
        }
        $xml.='</DebitNote>';

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }

    function CrearXMLResumenDocumentos($emisor, $cabecera, $detalle, $nombrexml, $fecha_emision)
    {
        $doc = new DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
           <SummaryDocuments xmlns="urn:sunat:names:specification:ubl:peru:schema:xsd:SummaryDocuments-1" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2">
          <ext:UBLExtensions>
              <ext:UBLExtension>
                  <ext:ExtensionContent />
              </ext:UBLExtension>
          </ext:UBLExtensions>
          <cbc:UBLVersionID>2.0</cbc:UBLVersionID>
          <cbc:CustomizationID>1.1</cbc:CustomizationID>
          <cbc:ID>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:ID>
          <cbc:ReferenceDate>'.$fecha_emision.'</cbc:ReferenceDate>
          <cbc:IssueDate>'.date('Y-m-d').'</cbc:IssueDate>
          <cac:Signature>
              <cbc:ID>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:ID>
              <cac:SignatoryParty>
                  <cac:PartyIdentification>
                      <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
                  </cac:PartyIdentification>
                  <cac:PartyName>
                      <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
                  </cac:PartyName>
              </cac:SignatoryParty>
              <cac:DigitalSignatureAttachment>
                  <cac:ExternalReference>
                      <cbc:URI>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:URI>
                  </cac:ExternalReference>
              </cac:DigitalSignatureAttachment>
          </cac:Signature>
          <cac:AccountingSupplierParty>
              <cbc:CustomerAssignedAccountID>'.$emisor->empresa_ruc.'</cbc:CustomerAssignedAccountID>
              <cbc:AdditionalAccountID>6</cbc:AdditionalAccountID>
              <cac:Party>
                  <cac:PartyLegalEntity>
                      <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  </cac:PartyLegalEntity>
              </cac:Party>
          </cac:AccountingSupplierParty>';
        $item = 1;
        foreach ($detalle as $v) {

            if($v->venta_totalgravada != 0){
                $tipo_total = "01"; //gravada
            }elseif($v->venta_totalexonerada != 0){
                $tipo_total = "02"; //exonerada
            }
            else{
                $tipo_total = "03"; //inafecta
            }
            $xml.='<sac:SummaryDocumentsLine>
                 <cbc:LineID>'.$item.'</cbc:LineID>
                 <cbc:DocumentTypeCode>'.$v->venta_tipo.'</cbc:DocumentTypeCode>
                 <cbc:ID>'.$v->venta_serie.'-'.$v->venta_correlativo.'</cbc:ID>';
            if($v->venta_total > 700){
                $xml .= '<cac:AccountingCustomerParty>
                             <cbc:CustomerAssignedAccountID>'.$v->cliente_numero.'</cbc:CustomerAssignedAccountID>
                             <cbc:AdditionalAccountID>'.$v->tipodocumento_codigo.'</cbc:AdditionalAccountID>
                         </cac:AccountingCustomerParty>';
            }

            if($v->venta_tipo == "07" || $v->venta_tipo == "08"){
                $xml .= '<cac:BillingReference>
                         <cac:InvoiceDocumentReference>
                            <cbc:ID>'.$v->serie_modificar.'-'.$v->correlativo_modificar.'</cbc:ID>
                            <cbc:DocumentTypeCode>'.$v->tipo_documento_modificar.'</cbc:DocumentTypeCode>
                         </cac:InvoiceDocumentReference>
                     </cac:BillingReference>';
            }

            $xml.= '<cac:Status>
                    <cbc:ConditionCode>'.$v->venta_condicion_resumen.'</cbc:ConditionCode>
                 </cac:Status>                
                 <sac:TotalAmount currencyID="'.$v->abrstandar.'">'.$v->venta_total.'</sac:TotalAmount>';

            $xml.='<sac:BillingPayment>
                           <cbc:PaidAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totalgravada.'</cbc:PaidAmount>
                           <cbc:InstructionID>01</cbc:InstructionID>
                       </sac:BillingPayment>';

            if($v->venta_totalexonerada != 0){
                $xml.=
                    '<sac:BillingPayment>
                           <cbc:PaidAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totalexonerada.'</cbc:PaidAmount>
                           <cbc:InstructionID>02</cbc:InstructionID>
                       </sac:BillingPayment>';
            }
            if($v->venta_totalinafecta != 0){
                $xml.=
                    '<sac:BillingPayment>
                           <cbc:PaidAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totalinafecta.'</cbc:PaidAmount>
                           <cbc:InstructionID>03</cbc:InstructionID>
                       </sac:BillingPayment>';
            }
            if($v->venta_totalgratuita != 0){
                $xml.=
                    '<sac:BillingPayment>
                           <cbc:PaidAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totalgratuita.'</cbc:PaidAmount>
                           <cbc:InstructionID>05</cbc:InstructionID>
                       </sac:BillingPayment>';
            }

            $xml.='<cac:TaxTotal>
                     <cbc:TaxAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totaligv.'</cbc:TaxAmount>';


            /*if($v->venta_totalexonerada != 0){
                $codigo_afectacion = "9997";
                $nombre_afectacion = "EXO";
                $tipo_afectacion = "VAT";
                $xml.='<cac:TaxSubtotal>
                         <cbc:TaxAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totalexonerada.'</cbc:TaxAmount>
                         <cac:TaxCategory>
                             <cac:TaxScheme>
                                 <cbc:ID>'.$codigo_afectacion.'</cbc:ID>
                                 <cbc:Name>'.$nombre_afectacion.'</cbc:Name>
                                 <cbc:TaxTypeCode>'.$tipo_afectacion.'</cbc:TaxTypeCode>
                             </cac:TaxScheme>
                         </cac:TaxCategory>
                     </cac:TaxSubtotal>';
            }
            if($v->venta_totalinafecta != 0){
                $codigo_afectacion = "9998";
                $nombre_afectacion = "INA";
                $tipo_afectacion = "FRE";
                $xml.='<cac:TaxSubtotal>
                         <cbc:TaxAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totalinafecta.'</cbc:TaxAmount>
                         <cac:TaxCategory>
                             <cac:TaxScheme>
                                 <cbc:ID>'.$codigo_afectacion.'</cbc:ID>
                                 <cbc:Name>'.$nombre_afectacion.'</cbc:Name>
                                 <cbc:TaxTypeCode>'.$tipo_afectacion.'</cbc:TaxTypeCode>
                             </cac:TaxScheme>
                         </cac:TaxCategory>
                     </cac:TaxSubtotal>';
            }*/

            $xml.='<cac:TaxSubtotal>
                         <cbc:TaxAmount currencyID="'.$v->abrstandar.'">'.$v->venta_totaligv.'</cbc:TaxAmount>
                         <cac:TaxCategory>
                             <cac:TaxScheme>
                                 <cbc:ID>1000</cbc:ID>
                                 <cbc:Name>IGV</cbc:Name>
                                 <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                             </cac:TaxScheme>
                         </cac:TaxCategory>
                     </cac:TaxSubtotal>';

            $xml.='</cac:TaxTotal>
             </sac:SummaryDocumentsLine>';
            $item++;
        }

        $xml.='</SummaryDocuments>';

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }

    function CrearXmlBajaDocumentos($emisor, $cabecera, $detalle, $nombrexml)
    {
        $doc = new DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'utf-8';

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <VoidedDocuments xmlns="urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
          <ext:UBLExtensions>
              <ext:UBLExtension>
                  <ext:ExtensionContent />
              </ext:UBLExtension>
          </ext:UBLExtensions>
          <cbc:UBLVersionID>2.0</cbc:UBLVersionID>
          <cbc:CustomizationID>1.0</cbc:CustomizationID>
          <cbc:ID>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:ID>
          <cbc:ReferenceDate>'.date('Y-m-d', strtotime($detalle->venta_fecha)).'</cbc:ReferenceDate>
          <cbc:IssueDate>'.date('Y-m-d').'</cbc:IssueDate>
          <cac:Signature>
              <cbc:ID>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:ID>
              <cac:SignatoryParty>
                  <cac:PartyIdentification>
                      <cbc:ID>'.$emisor->empresa_ruc.'</cbc:ID>
                  </cac:PartyIdentification>
                  <cac:PartyName>
                      <cbc:Name><![CDATA['.$emisor->empresa_razon_social.']]></cbc:Name>
                  </cac:PartyName>
              </cac:SignatoryParty>
              <cac:DigitalSignatureAttachment>
                  <cac:ExternalReference>
                      <cbc:URI>'.$cabecera['tipocomp'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'].'</cbc:URI>
                  </cac:ExternalReference>
              </cac:DigitalSignatureAttachment>
          </cac:Signature>
          <cac:AccountingSupplierParty>
              <cbc:CustomerAssignedAccountID>'.$emisor->empresa_ruc.'</cbc:CustomerAssignedAccountID>
              <cbc:AdditionalAccountID>6</cbc:AdditionalAccountID>
              <cac:Party>
                  <cac:PartyLegalEntity>
                      <cbc:RegistrationName><![CDATA['.$emisor->empresa_razon_social.']]></cbc:RegistrationName>
                  </cac:PartyLegalEntity>
              </cac:Party>
          </cac:AccountingSupplierParty>';


            $xml.='<sac:VoidedDocumentsLine>
                 <cbc:LineID>1</cbc:LineID>
                 <cbc:DocumentTypeCode>'.$detalle->venta_tipo.'</cbc:DocumentTypeCode>
                 <sac:DocumentSerialID>'.$detalle->venta_serie.'</sac:DocumentSerialID>
                 <sac:DocumentNumberID>'.$detalle->venta_correlativo.'</sac:DocumentNumberID>
                 <sac:VoidReasonDescription><![CDATA[Error en Documento]]></sac:VoidReasonDescription>
             </sac:VoidedDocumentsLine>';


        $xml.='</VoidedDocuments>';

        $doc->loadXML($xml);
        $doc->save($nombrexml.'.XML');
    }
}