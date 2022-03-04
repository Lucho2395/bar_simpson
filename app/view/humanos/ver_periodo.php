
<?php
if($periodo->id_contrato==2 ||$periodo->id_contrato==3 ||$periodo->id_contrato==7 ){
    if($periodo->id_contrato==2) {
        $title_modal = "CONTRATO DE TRABAJO SUJETO A MODALIDAD";
    }elseif($periodo->id_contrato==3){
        $title_modal = "CONTRATO DE TRABAJO DE OBRA DETERMINADA O SERVICIO ESPECÍFICO";
    }elseif ($periodo->id_contrato==7){
        $title_modal = "CONTRATO DE TRABAJO DEL PERSONAL EXTRANJERO";
    }
    $last_periodo = $this->humanos->listar_ultimo_nro_contrato();
    if(isset($last_periodo->id_periodo)){
        $nro=$last_periodo->periodo_nro_contrato * 1 + 1;
    }else{
        $nro=1000001;
    }
    require 'app/models/plantilla.php';
    require 'app/models/conversor.php';
    $day=date('d');
    $mes=get_mes(date('m'));
    $year=date('Y');
    $persona = $this->humanos->list_all($periodo->id_persona);
    $fecha_ini=explode("-",$periodo->periodo_fechainicio);
    $fecha_fini=explode("-",$periodo->periodo_fechafin);
    $monto=$periodo->periodo_sueldo;
    $monto2=$periodo->periodo_movilidad;
    $num_ = explode(".",$monto);
    $num_2 = explode(".",$monto2);
    $dec = round($num_[1],2);
    $dec2 = round($num_2[1],2);
    if(strlen($dec)==1){
        $dec = $dec ."0";
        ($dec==0) ? $monto = $monto.".00": $monto = $monto."0";
    }
    if(strlen($dec2)==1){
        $dec2 = $dec2 ."0";
        ($dec2==0) ? $monto2 = $monto2.".00": $monto2 = $monto2."0";
    }
    $resultado = convertir($num_[0]);
    $resultado2 = convertir($num_2[0]);
    $dx=0;$dy=0;
    if(!isset($_SESSION['nombre_empresa'])){
        $_SESSION['nombre_empresa'] = "";
    }
    ?>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="padding-left: 15px;padding-right: 15px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">VISTA PREVIA</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7"><img src="<?= _SERVER_.'media/logo/logo_conchita_pdf.png'; ?>" width="170"></div>
                        <div class="col-md-5" style="text-align: right">
                            <p><?= $periodo->empresa_razon_social; ?><br><?= $periodo->empresa_ruc; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: justify">
                            <p><center><b><u><?= $title_modal;?></u></b><br><?= "Contrato Laboral N° XXXXXXXX - ".$year." - ".$periodo->empresa_razon_social; ?></center></p>
                            <?php
                            if($periodo->id_contrato==2) {
                                ?>
                                <p><?= "Conste por el presente documento el Contrato Sujeto a modalidad de Naturaleza Temporal por <b><u>Necesidad del Mercado</u></b> que celebran, de conformidad con la <b>Ley de Promoción de la Competitividad, Formalización y Desarrollo de la Micro y Pequeña Empresa y del Acceso al empleo decente, Decreto Legislativo N° 1086, aprobado por D.S N°007-2008-TR y su Reglamento aprobado por el Decreto Supremo N° 008-2008,</b> que celebran de una parte la empresa <b><u>".$_SESSION['nombre_empresa']."</u></b> con R.U.C. Nº <u>".$_SESSION['ruc']."</u> y domicilio fiscal en ".$periodo->empresa_domiciliofiscal.", debidamente representada por <b><u>COLLAZOS VARGAS CLAUDIA ANGELICA</u></b> identificada con D.N.I. Nº <b><u>76062022</u></b>, quien se desempeña como Gerente General, a quien en adelante se le denominará <b><u>EL EMPLEADOR</u></b>; y de la otra parte <b><u>".$persona->persona_nombre." ".$persona->persona_apellido_paterno." ".$persona->persona_apellido_materno."</u></b> con D.N.I. Nº <b>".$persona->persona_dni."</b>, de nacionalidad <b>".$persona->persona_nacionalidad."</b>, domiciliado en ".$persona->persona_direccion." ,".$persona->persona_distrito.", ".$persona->persona_provincia.", ".$persona->persona_departamento.", a quien en adelante se le denominará <b><u>EL TRABAJADOR</u></b>; en los términos y condiciones siguientes:";?></p><br>
                                <p><?= "<b>PRIMERO:</b> <u>DE LA ACTIVIDAD DE LA EMPRESA.-</u> <b>EL EMPLEADOR</b> es una empresa dedicada a la actividad empresarial de <b>RESTAURANTES Y SERVICIO MOVIL DE COMIDA. LA EMPRESA</b> requiere para el desarrollo de actividades las labores de personal para <b><u>ATENCION AL CLIENTE</u></b>, cumpliendo <vb>EL TRABAJADOR</vb> las condiciones necesarias para la prestación de los servicios."; ?></p><br>
                                <p><?= "<b>SEGUNDO:</b> En función de lo expuesto en el párrafo precedente,<b>EL EMPLEADOR</b> requiere contratar personal idóneo a plazo determinado para cumplir con las actividades expuestas."; ?></p><br>
                                <p><?= "<b>TERCERO:</b><u>DEL OBJETO DEL CONTRATO.-</u> Por el presente contrato y de conformidad con la <b>Ley de Promoción de la Competitividad, Formalización y Desarrollo de la Micro y Pequeña Empresa y del Acceso al empleo decente, Decreto Legislativo N° 1086, aprobado por D.S. N° 007-2008-TR y su Reglamento aprobado por el Decreto Supremo N° 008-2008, EL EMPLEADOR</b> contrata a <b>EL TRABAJADOR</b> bajo la modalidad de <u>Contrato por Necesidad del Mercado</u> para que desarrolle las labores de <b><u>ATENCION AL CLIENTE</u></b>."; ?></p><br>
                                <p><?= "<b>CUARTA:</b> <u>DE LA PRESTACION DE SERVICIOS</u>.- <b>EL TRABAJADOR</b> desempeñara sus laborales en el cargo de <b><u>".$periodo->cargo_nombre."</u></b>; <b>EL EMPLEADOR</b> esta facultado a efectuar modificaciones razonables en función de la capacidad y aptitud de <b>EL TRABAJADOR</b> y a las necesidades y requerimientos de este, sin que dichas variaciones signifiquen menoscabo de categoria y/o remuneración. Queda entendido que la prestación de servicios deberá ser efectuada de manera personal, no pudiendo <b>EL TRABAJADOR</b> ser reemplazado ni ayudado por tercera persona."; ?></p><br>
                                <p><?= "<b>QUINTA:</b> <u>DE LA JORNADA Y HORARIO DE TRABAJO</u>.- Las partes estipulan que la jornada y el horario laboral de <b>EL TRABAJADOR</b> acuerdan de común acuerdo que la jornada máxima de trabajo será de cuarentiocho (48) horas semanales, de lunes a domingo, estableciendo <b>EL EMPLEADOR</b> turnos rotativos, además del dia de descanzo obligatorio durante la semana. <b>EL EMPLEADOR</b> esta facultado a efectuar modificaciones en la jornada de trabao, de acuerdo con el procedimiento establecido en el articulo 2 del Texto Único Ordenado del Decreto Legislativo N° 854, Ley de Jornada de Trabajo, Horario y Trabajo de Sobretiempo, aprobado por Decreto Supremo N° 007-2002-TR, respetando el máximo legal de 48 horas semanales."; ?></p><br>
                                <p><?= "<b>SEXTA:</b> <u>DE LA REMUNERACION</u>.- <b>EL TRABAJADOR</b> percibirá como contraprestación por sus servicios una remuneración mensual ascendente a la suma de <b>S/. ".$periodo->periodo_total." ($resultado CON $dec/00 Nuevos Soles)</b>; durante el tiempo de duración de la relación laboral, así como los beneficios que por ley corresponden. Las ausencias injustificadas de la por parte de <b>EL TRABAJADOR</b> implican la perdida de la remuneración proporcionalmente a la duración de dicha ausencia, sin perjuicio del ejercicio de las facultades disciplinarias propias de <b>EL EMPLEADOR</b> previstas en la legislación laboral y normas internas de <b>EL EMPLEADOR</b>."; ?></p><br>
                                <p><?= "<b>SEPTIMA:</b> <u>DE LA VIGENCIA DEL CONTRATO</u>.- El presente contrato <b>SE RENUEVA</b> y tendrá una vigencia desde <b><u>".$fecha_ini[2]."-".$fecha_ini[1]."-".$fecha_ini[0]."</b> y vencerá el <b>".$fecha_fini[2]."-".$fecha_fini[1]."-".$fecha_fini[0]."</u></b>, sin que exista comunicación previa de su extinción. A la conclusión del contrato <b>EL EMPLEADOR</b> abonara a <b>EL TRABAJADOR</b>, los beneficios sociales que le corresponde de acuerdo con la legislación laboral vigente. No obstante lo antes mencionado el presente contrato podrá prorrogarse de común acuerdo. La suspención del contrato de trabajo por alguna de las causales previstas en la ley, no interrumpirá el plazo de duración de este."; ?></p><br>
                                <p><?= "<b>OCTAVO:</b> <u>DE LAS VACACIONES DEL TRABAJADOR</u>.- <b>EL TRABAJADOR</b> tendrá derecho a un mínimo de 15 (quince) días de descanzo vacacional por año de trabajo o su parte proporcional."; ?></p><br>
                                <p><?= "<b>NOVENA:</b> <u>DE LAS OBLIGACIONES DEL TRABAJADOR</u>.- <vb>EL TRABAJADOR</vb> se compromete a cumplir con lealtad y eficiencia las labores principales, conexas y complementarias inherentes a su puesto de trabajo, aplicando para tal fin toda su experiencia y capacidad, y velando por los intereses de <vb>EL EMPLEADOR</vb>. Asimismo, deberá ejercer las funciones propias de su cargo con la mayor diligencia y responsabilidad."; ?></p><br>
                                <p><?= "<b>DECIMO:</b> <u>DE LA CONFIDENCIALIDAD</u>.- <b>EL TRABAJADOR</b> se compromete a guardar confidencialidad del caso, en el desempeño de sus funciones, ante su incumplimiento <b>EL EMPLEADOR</b> podrá prescindir de sus servicios."; ?></p><br>
                                <p><?= "<b>DECIMO PRIMERO:</b> <u>DE LA RESCISIÓN DEL CONTRATO</u>.- Las partes pactan que este contrato podrá ser rescindido por las causales establecidas en el articulo 16 de la LPCL."; ?></p><br>
                                <p><?= "<b>DECIMO SEGUNDO:</b> <u>DE LA JURISDICCIÓN Y COMPETENCIA</u>.- Las partes acuerdan que en caso de existir conflictos sobre la aplicación de la legislación aplicable, se somete a la jurisdicción y competencia de los jueces de la Provincia de Maynas."; ?></p><br>
                                <p><?= "<b>DECIMO TERCERO:</b> El presente contrato será puesto en conocimiento de la Autoridad Administrativa de Trabajo, para su registro y fines legales, establecidos en la LPFMYPE."; ?></p><br>
                                <?php
                            }elseif($periodo->id_contrato==3){
                                if($periodo->id_cargo== 29 ||
                                    $periodo->id_cargo== 43 ||
                                    $periodo->id_cargo== 57 ||
                                    $periodo->id_cargo== 78 ||
                                    $periodo->id_cargo== 33 ||
                                    $periodo->id_cargo== 34 ||
                                    $periodo->id_cargo== 47 ||
                                    $periodo->id_cargo== 48 ||
                                    $periodo->id_cargo== 61 ||
                                    $periodo->id_cargo== 62 ||
                                    $periodo->id_cargo== 82 ||
                                    $periodo->id_cargo== 83 ||
                                    $periodo->id_cargo== 28 ||
                                    $periodo->id_cargo== 42 ||
                                    $periodo->id_cargo== 56 ||
                                    $periodo->id_cargo== 77 ||
                                    $periodo->id_cargo== 27 ||
                                    $periodo->id_cargo== 41 ||
                                    $periodo->id_cargo== 55 ||
                                    $periodo->id_cargo== 76 ||
                                    $periodo->id_cargo== 26 ||
                                    $periodo->id_cargo== 40 ||
                                    $periodo->id_cargo== 54 ||
                                    $periodo->id_cargo== 75
                                ){
                                    $dx=28;$dy=7;
                                }else{
                                    $dx=21;$dy=10;
                                }
                                ?>
                                <p><?= "Conste por el presente documento el Contrato de Trabajo a plazo fijo bajo la modalidad de \"Contrato para Obra Determinada\" o \"Servicio Específico\", que celebran al amparo del Art. 63º de la Ley de Productividad y Competitividad Laboral aprobado por D. S. Nº 003-97-TR, y normas complementarias, de una parte <b>".$_SESSION['nombre_empresa']."</b> con R.U.C. Nº ".$_SESSION['ruc']." y  domicilio fiscal en ".$periodo->empresa_domiciliofiscal." debidamente representada por <b>AQUI IRA EL NOMBRE DEL REPRESENTANTE</b> con D.N.I. Nº <b>AQUI SU DNI</b>, quien se desempeña como Gerente Central, a quien en adelante se le denominará <b>EL EMPLEADOR</b>; y de la otra parte <b>".$persona->persona_nombre." ".$persona->persona_apellido_paterno." ".$persona->persona_apellido_materno."</b> con D.N.I. Nº <b>".$persona->persona_dni."</b>, domiciliado en ".$persona->persona_direccion." ,".$persona->persona_distrito.", ".$persona->persona_provincia.", ".$persona->persona_departamento.", correo electrónico ".$persona->persona_email.", y teléfono celular ".$persona->persona_telefono." a quien en adelante se le denominará simplemente <b>EL TRABAJADOR</b>; en los términos y condiciones siguientes:";?></p>
                                <p><?= "<b>PRIMERO: EL EMPLEADOR</b> es una sociedad cuyo objeto social es dedicarse a las actividad de gestión de residuos de sólidos, desde su acondicionamiento, recolección, transporte, tratamiento, comercialización y disposición final tanto peligroso y no peligrosos del ámbito municipal y no municipal, Limpieza y Remediacion de contingencias ambientales generados por el derrame de hidrocarburos y otros materiales peligrosos entre otras actividades derivadas o conexas permitidas por ley, para lo cual cuenta con la infraestructura, equipos y recursos necesarios para realizar estas labores, y requiere de los servicios del <b>TRABAJADOR</b> para el cumplimiento de un servicio específico."; ?></p>
                                <p><?= "<b>SEGUNDO:</b> Por el presente documento <b>EL EMPLEADOR</b> contrata <b>a plazo fijo sujeto a modalidad</b>, los servicios de <b>EL TRABAJADOR</b> quien desempeñará el cargo de <b>".$periodo->cargo_nombre."</b> bajo la dependencia del Departamento de <b>".$periodo->departamento_nombre."</b> asignadas en una de las actividades señaladas en la cláusula primera. El centro laboral asignado para <b>EL TRABAJADOR</b> es en el/la <b>".$periodo->sede_nombre."</b>."; ?></p>
                                <div class="row"><span><?= "<b>TERCERO:</b> El presente contrato se iniciará el <b>".$fecha_ini[2]."-".$fecha_ini[1]."-".$fecha_ini[0]."</b> y vencerá el <b>".$fecha_fini[2]."-".$fecha_fini[1]."-".$fecha_fini[0]."</b></span> . <span> El régimen laboral será de </span><input onblur='get_ddx()' class='form-control' type='number' id='dx' min='0' max='99' style='width: 80px;margin-top: -10px;margin-left: 5px;' value='$dx'> días de trabajo por <input  onblur='get_ddx()' class='form-control' min='0' max='99' style='width: 80px;margin-top: -10px;margin-left: 5px;'  type='number' id='dy' value='$dy'> días de descanso."; ?></div>
                                <p><?= "<b>CUARTO: EL TRABAJADOR</b> conviene y acepta en brindar los servicios a que se contrae la presente contratación, con sujeción a los horarios fijos y/o rotativos que pudiera establecer <b>EL EMPLEADOR</b> de acuerdo a la naturaleza y requerimientos de sus actividades operativas, encontrándose en consecuencia, facultada a través de una comunicación escrita variar el Centro Laboral de <b>EL TRABAJADOR</b> en atención a sus necesidades operativas."; ?></p>
                                <p><?= "<b>QUINTO: EL TRABAJADOR</b> deberá cumplir con las normas propias del Centro de Trabajo, así como las contenidas en el Reglamento Interno de Trabajo, Manual de Organización y Funciones, y en las demás normas laborales, y las que se impartan por necesidades del servicio en ejercicio de las facultades de administración de la empresa, de conformidad con el Art. 9º TUO del D. Leg. Nº 728 aprobado por D. S. Nº 00397-TR Ley de Productividad y Competitividad Laboral."; ?></p>
                                <p><?= "<b>SEXTO: EL EMPLEADOR</b> abonará al <b>TRABAJADOR</b> la cantidad de <b>S/. ".$periodo->periodo_sueldo." ($resultado CON $dec/00 Nuevos Soles)</b> como remuneración mensual, de la cual se deducirá las aportaciones y descuentos por tributos establecidos en la ley que le resulten aplicables."; ?>
                                    <?php if($periodo->periodo_movilidad>0){
                                        echo "<b>EL EMPLEADOR</b> abonará también al <b> TRABAJADOR </b> la cantidad de <b>S/. ".$periodo->periodo_movilidad."</b> ($resultado2 CON $dec2/00 Nuevos Soles), a modo de bonificación extraordinaria, de forma excepcional, por concepto de trabajo en zona y/o localidad alejada (campamento en zona indígena). Esta bonificación no tiene carácter remunerativo por su carencia de regularidad.";
                                    } ?>
                                </p>
                                <p><?= "<b>SEPTIMO:</b> Queda entendido que <b>EL EMPLEADOR</b> no está obligado a dar aviso alguno adicional referente al término del presente contrato, operando su extinción en la fecha de su vencimiento conforme la cláusula tercera, oportunidad en la cual se abonará al <b>TRABAJADOR</b> los beneficios sociales que le pudieran corresponder de acuerdo a ley."; ?></p>
                                <p><?= "<b>OCTAVO:</b> Este contrato queda sujeto a las disposiciones que contiene el TUO del D. Leg. Nº 728 aprobado por D. S. Nº 003-97-TR Ley de Productividad y Competitividad Laboral, y demás normas legales que lo regulen o que sean dictadas durante la vigencia del contrato."; ?></p>
                                <p><?= "<b>NOVENO:</b> En cumplimiento con el inciso \"c\" del artículo 35 de la Ley 29783 Ley de Seguridad y Salud en el Trabajo y su reglamento DS-005-2012-TR, se indican los riesgos a los que estará expuesto el trabajador:"; ?></p>
                                <p><?= "-   Riesgo de accidente de tránsito, durante sus desplazamientos.<br>-  Riesgos disergonómicos que puedan ocasionar disturbios músculo - esqueléticos.<br>-  Riesgos relacionados a las condiciones ambientales y climáticas de su zona de trabajo."; ?></p>
                                <p><?= "<b>DÉCIMO:</b> Son causales de despido inmediato las faltas graves siguientes:"; ?></p>
                                <p><?= "-	El incumplimiento de las obligaciones de trabajo que supone el quebrantamiento de la buena fe laboral.<br>-	La reiterada resistencia a las órdenes relacionadas con las labores encomendadas por el empleador. <br>-	La reiterada paralización intempestiva de labores y la inobservancia del Reglamento Interno de Trabajo o del Reglamento de Seguridad e Higiene Industrial gravedad, que revistan de gravedad.<br>-	La disminución deliberada y reiterada en el rendimiento de las labores o del volumen o de la calidad de producción.<br>-	La apropiación consumada o frustrada de bienes o servicios del empleador o que se encuentran bajo su custodia, así como la retención o utilización indebidas de los mismos, en beneficio propio o de terceros, con prescindencia de su valor.<br>-	El uso o entrega a terceros de información reservada del empleador. <br>-	La sustracción o utilización no autorizada de documentos de la empresa.<br>-	La información falsa al empleador con la intención de causarle perjuicio u obtener una ventaja.<br>-	La competencia desleal.<br>-	La concurrencia reiterada en estado de embriaguez o bajo influencia de drogas o sustancias estupefacientes, y aunque no sea reiterada cuando por la naturaleza de la función o del trabajo revista excepcional gravedad.<br>-	Los actos de violencia, grave indisciplina, injuria y falta de palabra verbal o escrita en agravio del empleador, de sus representantes, del personal jerárquico o de otros trabajadores, sea que se cometan dentro del centro de trabajo o fuera de él cuando los hechos se deriven directamente de la relación laboral. <br>-	El daño intencional a los edificios, instalaciones, obras, maquinarias, instrumentos, documentación, materias primas y demás bienes de propiedad de la empresa -   o en posesión de ésta. <br>-	El abandono de trabajo por más de tres (3) días consecutivos.<br>-	La impuntualidad reiterada, si ha sido acusada por el empleador, siempre que se hayan aplicado sanciones disciplinarias previas de amonestaciones escritas y suspensiones.<br>-	El hostigamiento sexual cometido por los representantes del empleador o quien ejerza autoridad sobre el trabajador, así como el cometido por un trabajador cualquiera sea la ubicación de la víctima del hostigamiento en la estructura jerárquica del centro de trabajo<br>-	A solicitud del cliente u organismo relacionados al servicio."; ?></p>
                                <p><?= "<b>DÉCIMO PRIMERO:</b> En el anexo 01 se le informa sobre su régimen atípico (Los días de Trabajo y los días de Descanso) durante su periodo laboral. Si por razones operativas y previa aprobación de Gerencia, se le aprueba laborar el día de descanso, se le retribuirá un sobrecargo del 100% sobre la remuneración diaria, en el caso de ser feriado, será un sobrecargo del 200% de la remuneración diaria."; ?></p>
                                <p><?= "<b>DÉCIMO SEGUNDO:</b> Para los efectos de las comunicaciones que las partes tengan a bien realizarse, se tendrán como válidas las comunicaciones que, de forma indistinta, se remitan y sean recibidas en cualquiera de los domicilios y/o lugares, teléfonos o correo electrónico que aparecen descritos en el exordio del presente contrato.</p>"; ?>
                                <?php
                            }elseif($periodo->id_contrato==7){
                                $fecha_ini_1= new DateTime($periodo->periodo_fechainicio);
                                $fecha_fin_1= new DateTime($periodo->periodo_fechafin);
                                $diferencia =$fecha_ini_1->diff($fecha_fin_1);
                                $meses = ($diferencia->y * 12) + $diferencia->m;
                                if($meses<6){
                                    $grati = 0;
                                }elseif($meses<12){
                                    $grati = $periodo->periodo_total;
                                }else{
                                    $grati = $periodo->periodo_total * 2;
                                }
                                $monto=$periodo->periodo_total + $grati;

                                $num_ = explode(".",$monto);
                                $dec = round($num_[1],2);
                                if(strlen($dec)==1){
                                    $dec = $dec ."0";
                                    ($dec==0) ? $monto = $monto.".00": $monto = $monto."0";
                                }
                                $resultado = convertir($num_[0]);
                                ?>
                                <p><?= "Conste por el presente documento el Contrato de Trabajo a plazo fijo bajo la modalidad de \"Contrato para Obra Determinada\" o \"Servicio Específico\", que celebran al amparo del Art. 63º de la Ley de Productividad y Competitividad Laboral aprobado por D. S. Nº 003-97-TR, y normas complementarias, de una parte <b>".$_SESSION['nombre_empresa']."</b> con R.U.C. Nº ".$_SESSION['ruc']." y  domicilio fiscal en ".$periodo->empresa_domiciliofiscal." debidamente representada por <b>NOMBRE DEL REPRESENTANTE</b> con D.N.I. Nº <b>SU DNI</b>, quien se desempeña como Gerente Central, a quien en adelante se le denominará <b>EL EMPLEADOR</b>; y de la otra parte <b>".$persona->person_name." ".$persona->persona_apellido_paterno." ".$persona->persona_apellido_materno."</b> con Pasaporte Nº <b>".$persona->persona_dni."</b>, domiciliado en ".$persona->persona_direccion." ,".$persona->persona_distrito.", ".$persona->persona_provincia.", ".$persona->persona_departamento.", de Nacionalidad ".$persona->persona_nacionalidad." a quien en adelante se le denominará <b>EL TRABAJADOR</b>; en los términos y condiciones siguientes:"; ?></p>
                                <p><?= "<b>PRIMERO: EL EMPLEADOR</b> es una sociedad cuyo objeto social es dedicarse a las actividad de gestión de residuos de sólidos, desde su acondicionamiento, recolección, transporte, tratamiento, comercialización y disposición final tanto peligroso y no peligrosos del ámbito municipal y no municipal, Limpieza y Remediacion de contingencias ambientales generados por el derrame de hidrocarburos y otros materiales peligrosos entre otras actividades derivadas o conexas permitidas por ley, para lo cual cuenta con la infraestructura, equipos y recursos necesarios para realizar estas labores, y requiere de los servicios del <b>TRABAJADOR</b> para el cumplimiento de un servicio específico."; ?></p>
                                <p><?= "<b>SEGUNDO:</b> Por el presente documento <b>EL EMPLEADOR</b> contrata a <b>plazo fijo de Obra determinada o Servicio Especifico</b>, los servicios de <b>EL TRABAJADOR</b> quien desempeñará el cargo de <b>".$periodo->cargo_nombre."</b> bajo la dependencia del Departamento de <b>".$periodo->departamento_nombre."</b>  asignadas en una de las actividades señaladas en la cláusula primera. El centro laboral asignado para <b>EL TRABAJADOR</b> es en el/la <b>".$periodo->sede_nombre."</b>"; ?></p>
                                <p><?= "<b>TERCERO:</b> El presente contrato se iniciará el <b>".$fecha_ini[2]."-".$fecha_ini[1]."-".$fecha_ini[0]."</b> y vencerá el <b>".$fecha_fini[2]."-".$fecha_fini[1]."-".$fecha_fini[0]."</b>."; ?></p>
                                <p><?= "<b>CUARTO: EL TRABAJADOR</b> conviene y acepta en brindar los servicios a que se contrae la presente contratación, con sujeción a los horarios fijos y/o rotativos que pudiera establecer <b>EL EMPLEADOR</b> de acuerdo a la naturaleza y requerimientos de sus actividades operativas, encontrándose en consecuencia, facultada a través de una comunicación escrita variar el Centro Laboral de <b>EL TRABAJADOR</b> en atención a sus necesidades operativas."; ?></p>
                                <p><?= "<b>QUINTO: EL TRABAJADOR </b>deberá cumplir con las normas propias del Centro de Trabajo, así como las contenidas en el Reglamento Interno de Trabajo, Manual de Organización y Funciones, y en las demás normas laborales, y las que se impartan por necesidades del servicio en ejercicio de las facultades de administración de la empresa, de conformidad con el Art. 9º TUO del D. Leg. Nº 728 aprobado por D. S. Nº 00397-TR Ley de Productividad y Competitividad Laboral."; ?></p>
                                <p><?= "<b>SEXTO: EL EMPLEADOR</b> abonará al <b>TRABAJADOR</b> la cantidad dineraria de <b>S/. ".$periodo->periodo_total."</b> como remuneración mensual por <b>$meses</b> meses haciendo un total de <b>S/. ".$periodo->periodo_total."</b> más <b>S/. $grati </b> por concepto de gratificaciones haciendo una Remuneración Total de <b> S/. $monto ($resultado CON $dec/00 Nuevos Soles)</b>."; ?></p>
                                <p><?= "<b>SEPTIMO:</b> Queda entendido que <b>EL EMPLEADOR</b> no está obligado a dar aviso alguno adicional referente al término del presente contrato, operando su extinción en la fecha de su vencimiento conforme la cláusula tercera, oportunidad en la cual se abonará al <b>TRABAJADOR</b> los beneficios sociales que le pudieran corresponder de acuerdo a ley."; ?></p>
                                <p><?= "<b>OCTAVO:</b> Este contrato queda sujeto a las disposiciones que contiene el TUO del D. Leg. Nº 728 aprobado por D. S. Nº 003-97-TR Ley de Productividad y Competitividad Laboral, y demás normas legales que lo regulen o que sean dictadas durante la vigencia del contrato."; ?></p>
                                <p><?= "<b>NOVENO:</b> En cumplimiento con el inciso \"c\" del artículo 35 de la Ley 29783 Ley de Seguridad y Salud en el Trabajo y su reglamento DS-005-2012-TR, se indican los riesgos a los que estará expuesto el trabajador:"; ?></p>
                                <p><?= "-   Riesgo de accidente de tránsito, durante sus desplazamientos.<br>-  Riesgos disergonómicos que puedan ocasionar disturbios músculo - esqueléticos.<br>-  Riesgos relacionados a las condiciones ambientales y climáticas de su zona de trabajo."; ?></p>
                                <p><?= "<b>DECIMO:</b> Son causales de despido inmediato las faltas graves siguientes:"; ?></p>
                                <p><?= "-	El incumplimiento de las obligaciones de trabajo que supone el quebrantamiento de la buena fe laboral.<br>-	La reiterada resistencia a las órdenes relacionadas con las labores encomendadas por el empleador. <br>-	La reiterada paralización intempestiva de labores y la inobservancia del Reglamento Interno de Trabajo o del Reglamento de Seguridad e Higiene Industrial gravedad, que revistan de gravedad.<br>-	La disminución deliberada y reiterada en el rendimiento de las labores o del volumen o de la calidad de producción.<br>-	La apropiación consumada o frustrada de bienes o servicios del empleador o que se encuentran bajo su custodia, así como la retención o utilización indebidas de los mismos, en beneficio propio o de terceros, con prescindencia de su valor.<br>-	El uso o entrega a terceros de información reservada del empleador. <br>-	La sustracción o utilización no autorizada de documentos de la empresa.<br>-	La información falsa al empleador con la intención de causarle perjuicio u obtener una ventaja.<br>-	La competencia desleal.<br>-	La concurrencia reiterada en estado de embriaguez o bajo influencia de drogas o sustancias estupefacientes, y aunque no sea reiterada cuando por la naturaleza de la función o del trabajo revista excepcional gravedad.<br>-	Los actos de violencia, grave indisciplina, injuria y falta de palabra verbal o escrita en agravio del empleador, de sus representantes, del personal jerárquico o de otros trabajadores, sea que se cometan dentro del centro de trabajo o fuera de él cuando los hechos se deriven directamente de la relación laboral. <br>-	El daño intencional a los edificios, instalaciones, obras, maquinarias, instrumentos, documentación, materias primas y demás bienes de propiedad de la empresa -   o en posesión de ésta. <br>-	El abandono de trabajo por más de tres (3) días consecutivos.<br>-	La impuntualidad reiterada, si ha sido acusada por el empleador, siempre que se hayan aplicado sanciones disciplinarias previas de amonestaciones escritas y suspensiones.<br>-	El hostigamiento sexual cometido por los representantes del empleador o quien ejerza autoridad sobre el trabajador, así como el cometido por un trabajador cualquiera sea la ubicación de la víctima del hostigamiento en la estructura jerárquica del centro de trabajo<br>-	A solicitud del cliente u organismo relacionados al servicio."; ?></p>
                                <p><?= "<b>DECIMO PRIMERO:</b> En materia de obligaciones Tributarias <b>EL TRABAJADOR</b> queda claramente instruido que está sujeto a la Legislación Peruana. En consecuencia, deberá cumplir con presentar su Declaración Jurada de Impuestos a la renta como Trabajador, así como cumplir con todas las demás obligaciones tributarias. <b>EL EMPLEADOR</b> se compromete a efectuar las retenciones de Ley que correspondan."; ?></p>
                                <p><?= "<b>DECIMO SEGUNDO:</b> El presente contrato será sometido a la Autoridad Administrativa de Trabajo para su aprobación, en observancia de lo dispuesto por el Art. 2° del Decreto Legislativo 689, concordado con el Art. 1° de su Reglamento, aprobado por Decreto Supremo N° 014-92-TR."; ?></p>
                                <?php
                            }
                            ?>
                            <p><?= "Ambas partes declaran estar de acuerdo en todas las cláusulas del presente contrato y proceden a suscribirlos y autorizarlos en señal de conformidad, en la Ciudad de Iquitos, a los $day días del mes $mes del año $year"; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <!--<br><img style="margin-left: 20px" src="<?= _SERVER_.'styles/brunner/img/firma.jpg'; ?>" width="150">-->
                            <p style="padding-top: 0;margin-top: -10px;">-----------------------------------------------
                                <br>Collazos Vargas Claudia Angélica<br><b>EL EMPLEADOR</b></p>
                        </div>
                        <div class="col-md-6">
                            <br><br><br>
                            <p>-----------------------------------------------<br>
                                <?= $persona->persona_apellido_paterno." ".$persona->persona_apellido_materno." ".$persona->persona_nombre; ?><br><b>EL TRABAJADOR</b></p>
                        </div>
                    </div>
                    <?php
                    if($periodo->id_contrato==3){
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <p><center><b>ANEXO 01</b></center></p>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Apellidos y Nombres</th>
                                        <th>DNI</th>
                                        <th>Puesto</th>
                                        <th>Fecha</th>
                                        <th>Asistencia</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $f1=strtotime($periodo->periodo_fechainicio);
                                    $f2=strtotime($periodo->periodo_fechafin);
                                    $a=1;
                                    $cond=1;
                                    $ass=1;
                                    //$asistencia = new Asistencia();
                                    for($i=$f1;$i<=$f2;$i+=86400) {
                                        $fecha_ap = date('Y-m-d', $i);
                                        ?>
                                        <tr>
                                            <td><?= $a; ?></td>
                                            <td><?= $persona->persona_apellido_paterno." ".$persona->persona_apellido_materno." ".$persona->persona_nombre; ?></td>
                                            <td><?= $persona->persona_dni; ?></td>
                                            <td><?= $periodo->cargo_nombre; ?></td>
                                            <td><?= $fecha_ap; ?></td>
                                            <td><?= $asist; ?></td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                    <form target="_blank" method="get" action="<?= _SERVER_ ?>api.php">
                        <input type="hidden" name="c" id="c" value="RHumanos">
                        <input type="hidden" name="a" id="a" value="generar_contrato">
                        <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                        <input type="hidden" name="dedx" id="dedx" value="<?= $dx; ?>">
                        <input type="hidden" name="dedy" id="dedy" value="<?= $dy; ?>">
                        <input type="submit" class="btn btn-success" value="Generar Contrato">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Ver Periodo</h1>
            </div>


            <div class="box box-primary">
                <div class="box-header with-border">
                    <h5 class="card-title"><strong>Datos: </strong><?php echo $person->persona_apellido_paterno; ?> <?php echo $person->persona_apellido_materno; ?>, <?php echo $person->persona_nombre; ?> | <?php echo $person->persona_tipo_documento; ?>: <?php echo $person->persona_dni; ?></h5>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header" style="font-size: 20px; font-weight: bold;">
                                    Datos Ubicación
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Seleccionar Empresa</label>
                                        <select class="form-control" name="id_empresa" id="id_empresa" style="height: 44px; font-size: 12px;" readonly>
                                            <option value="">Seleccionar ...</option>
                                            <?php
                                            foreach ($empresas as $em){
                                                ?>
                                                <option value="<?= $em->id_empresa;?>" <?php echo ($em->id_empresa == $periodo->id_empresa) ? 'selected' : '';?> ><?= $em->empresa_razon_social;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Seleccionar Departamento</label>
                                        <select class="form-control" name="id_departamento" id="id_departamento" style="height: 44px; font-size: 12px;" readonly>
                                            <option value="">Seleccionar ...</option>
                                            <?php
                                            foreach ($departamentos as $d){
                                                ?>
                                                <option value="<?= $d->id_departamento;?>" <?php echo ($d->id_departamento == $periodo->id_departamento) ? 'selected' : '';?> ><?= $d->departamento_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Seleccionar Cargo</label>
                                        <select class="form-control" name="id_cargo" id="id_cargo" style="height: 44px; font-size: 12px;" readonly>
                                            <option value="">Seleccionar ...</option>
                                            <?php
                                            foreach ($cargos as $cg){
                                                ?>
                                                <option value="<?= $cg->id_cargo;?>" <?php echo ($cg->id_cargo == $periodo->id_cargo) ? 'selected' : '';?> ><?= $cg->cargo_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Centro Laboral</label>
                                        <select class="form-control" name="id_sede" id="id_sede" style="height: 44px; font-size: 12px;" readonly>
                                            <option value="">Seleccionar ...</option>
                                            <?php
                                            foreach ($sedes as $s){
                                                ?>
                                                <option value="<?= $s->id_sede;?>" <?php echo ($s->id_sede == $periodo->id_sede) ? 'selected' : '';?> ><?= $s->sede_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header" style="font-size: 20px; font-weight: bold;">
                                    Periodo Laboral
                                </div>
                                <div class="card-body">
                                    <div class="form-group ml-1 mr-1">
                                        <label for="exampleFormControlSelect1">Tipo de Contratación</label>
                                        <select class="form-control" name="id_contrato" id="id_contrato" readonly>
                                            <option value="">Seleccionar ...</option>
                                            <?php
                                            foreach ($contratos as $con){
                                                ?>
                                                <option value="<?= $con->id_contrato;?>" <?php echo ($con->id_contrato == $periodo->id_contrato) ? 'selected' : '';?> ><?= $con->contrato_nombre;?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-row ml-1 mr-1">
                                        <div class="form-group col-md-6">
                                            <label for="">Desde</label>
                                            <input type="date" class="form-control" placeholder="" name="periodo_fechainicio" value="<?= $periodo->periodo_fechainicio;?>" id="periodo_fechainicio" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Hasta</label>
                                            <input type="date" class="form-control" placeholder="" name="periodo_fechafin" id="periodo_fechafin" value="<?= $periodo->periodo_fechafin;?>" readonly>
                                        </div>

                                    </div>

                                    <div class="form-row ml-1 mr-1">
                                        <div class="form-group col-md-4">
                                            <label for="">Remuneración Bruta</label>
                                            <input type="number" step="0.01" class="form-control" onchange="total_ingresos()" id="periodo_sueldo" placeholder="" name="periodo_sueldo" value="<?= $periodo->periodo_sueldo;?>" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Otros Ingresos</label>
                                            <input type="number" step="0.01" class="form-control" onchange="total_ingresos()" id="periodo_movilidad" placeholder="" name="periodo_movilidad" value="<?= $periodo->periodo_movilidad;?>" readonly>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Total Ingresos</label>
                                            <input type="number"  class="form-control" id="periodo_total" placeholder="" name="periodo_total" value="<?= $periodo->periodo_total;?>" oninput="cal()" readonly>
                                        </div>

                                    </div>
                                        <div class="form-row ml-1 mr-1">
                                            <div class="form-group col-md-4">
                                                <label for="">Bonificación Mensual</label>
                                                <input type="number" step="1" class="form-control" id="periodo_bono" name="periodo_bono" value="<?= $periodo->periodo_bono;?>" readonly>
                                            </div>
                                        </div>
                                    <?php
                                    if($periodo->periodo_observa != ""){
                                        ?>
                                        <div class="form-group">
                                            <label for="periodo_observa">Motivo de Modificación</label>
                                            <textarea class="form-control" id="periodo_observa" rows="2" readonly><?= $periodo->periodo_observa;?></textarea>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <?php
                                    if($periodo->periodo_contrato==null){
                                        ?>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong"><i class="fa fa-file"></i> Ver Contrato</button>
                                        <a class="btn btn-success" target="_blank" href="<?= _SERVER_ ?>api/RHumanos/generar_contrato/<?= $id; ?>" role="button" ><i class="fa fa-eye"></i> Generar Contrato</a>
                                        <?php
                                    }else{
                                        ?>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong"><i class="fa fa-file"></i> Ver Contrato</button>
                                        <a class="btn btn-danger" href="<?= _SERVER_?>RHumanos/detalle_periodo_laboral/<?= $periodo->id_persona?>" role="button" >Regresar</a>
                                        <?php
                                    }
                                ?>
                           </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="card">
                <div class="card-header" style="font-size: 20px; font-weight: bold;">
                    Documentos Adjuntos
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-cero" width="100%" cellspacing="0">
                            <thead class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th>Tipo Documento</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Ver</th>
                                <!--<th>Acción</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($adjuntos as $m){
                                $archivo=explode('media_adjuntos/',$m->docum_nombre);
                                $existe = true;
                                $archivo=explode('media_adjuntos/',$m->docum_nombre);
                                if(!file_exists($m->docum_nombre)){
                                    $existe = false;
                                }
                                ?>
                                <tr>
                                    <td><?php echo $a;?></td>
                                    <td><?php echo $m->adjunto_nombre;?></td>
                                    <td><?php echo $m->docum_fechainicio;?></td>
                                    <td><?php echo $m->docum_fechafin;?></td>
                                    <td>
                                        <?php
                                        if($existe){
                                            ?>
                                            <a class="text-dark" href="<?php echo _SERVER_ . $m->docum_nombre;?>" data-toggle="tooltip" title="Ver Documento" target="_blank"><i class="fa fa-eye ver_detalle"></i></a>
                                            <a class="text-dark" download="<?= (isset($archivo[1]))?$archivo[1]:'';?>" href="<?php echo _SERVER_ . $m->docum_nombre;?>" data-toggle="tooltip" title="Descargar"><i class="fa fa-download pdf"></i></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a class="text-dark" >No Existe Archivo</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $a++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>

<script>
    function get_ddx() {
        var ddx =$("#dx").val();
        var ddy =$("#dy").val();
        $("#dedx").val(ddx);
        $("#dedy").val(ddy);
    }

    function consulta_dni() {
        var valor = true;
        var dni = $('#dni_representante').val();
        if(dni == ""){
            alertify.error('Ingrese un DNI');
            valor = false;
        }
        if(valor){
            var cadena = "dni=" + dni;
            $.ajax({
                type:"POST",
                url: urlweb + "api/Person/consulta_sunat_dni",
                data : cadena,
                dataType: 'json',
                beforeSend: function () {
                    //$("#button-consultar").html("Consultando...");
                    $("#button-consultar").attr("disabled", true);
                },
                success:function (r) {
                    $("#button-consultar").html("<i class=\"fa fa-search\"></i>");
                    $("#button-consultar").attr("disabled", false);
                    switch (r.result.code) {
                        case 1:
                            alertify.success("¡Encontrado!");
                            $('#nombre_representante').val(r.data.nombre);
                            $('#dni_representante').val(r.data.dni);
                            break;
                        case 2:
                            alertify.error("El DNI no puedo ser consultado o no existe.");
                            $('#nombre_representante').val("");
                            $('#dni_representante').val("");
                            break;
                        default:
                            alertify.error("Error Desconocido");
                    }
                }
            });
        }
    }

    function consulta_ruc(){
        var ruc = $('#ruc_centroestudio').val();
        if(ruc.length==11){
            if(!isNaN(ruc)){
                if(ruc=="00000000000"){
                    alertify.success("Proveedor Extranjero");
                    $('#cliente_condicion').val("HABIDO");
                }else{
                    $("#button-consultar").attr("disabled", true);
                    var formData = new FormData();
                    formData.append("token", "uTZu2aTvMPpqWFuzKATPRWNujUUe7Re1scFlRsTy9Q15k1sjdJVAc9WGy57m");
                    formData.append("ruc", ruc);
                    var request = new XMLHttpRequest();
                    request.open("POST", "https://api.migo.pe/api/v1/ruc");
                    request.setRequestHeader("Accept", "application/json");
                    request.send(formData);
                    $('.loader').show();
                    request.onload = function() {
                        var data = JSON.parse(this.response);
                        if(data.success){
                            $('.loader').hide();
                            alertify.success("Datos Encontrados");
                            if(data.condicion_de_domicilio=="NO HABIDO"){
                                alert("Este ruc se encuentra como NO HABIDO.");
                            }else{
                                $('#nombre_centroestudio').val(data.nombre_o_razon_social);
                                $('#direccion_centroestudio').val(data.direccion);
                                $("#button-consultar").attr("disabled", false);
                                /*var nombre_generador = $('#nombre_generador').val();
                                var ruc_generador = $('#ruc_generador').val();
                                if(nombre_generador == "" && ruc_generador != ""){
                                    $('#nombre_generador').val(data.nombre_o_razon_social);
                                }else{
                                    $('#razon_social_').val(data.nombre_o_razon_social);
                                }*/
                                //$('#cliente_direccion').val(data.direccion);
                            }
                        }else{
                            $('.loader').hide();
                            alertify.error(data.message);
                        }
                    };
                }
            }else{
                alertify.error("El ruc debe contener solo números.");
                $('#cliente_condicion').val("");
            }
        }else{
            alertify.error("El ruc debe contener 11 dígitos.");
            $('#cliente_condicion').val("");
        }
    }

    function guardar_datos_centro_practicante() {
        var boton = "btn-periodo";
        var valor = true;
        var id = $('#id_periodolaboral').val();
        var ruc_centroestudio = $('#ruc_centroestudio').val();
        var nombre_centroestudio = $('#nombre_centroestudio').val();
        var dni_representante = $('#dni_representante').val();
        var nombre_representante = $('#nombre_representante').val();
        var select_ciclo = $('#select_ciclo').val();
        var especialista = $('#especialista').val();
        var direccion_centroestudio = $('#direccion_centroestudio').val();

        valor = validar_campo_vacio('ruc_centroestudio', ruc_centroestudio, valor);
        valor = validar_campo_vacio('nombre_centroestudio', nombre_centroestudio, valor);
        valor = validar_campo_vacio('dni_representante', dni_representante, valor);
        valor = validar_campo_vacio('nombre_representante', nombre_representante, valor);
        valor = validar_campo_vacio('select_ciclo', select_ciclo, valor);
        valor = validar_campo_vacio('especialista', especialista, valor);
        valor = validar_campo_vacio('direccion_centroestudio', direccion_centroestudio, valor);

        if (valor){
            var cadena = "ruc_centroestudio=" + ruc_centroestudio +
                "&nombre_centroestudio=" + nombre_centroestudio +
                "&dni_representante=" + dni_representante +
                "&nombre_representante=" + nombre_representante +
                "&select_ciclo=" + select_ciclo +
                "&direccion_centroestudio=" + direccion_centroestudio +
                "&especialista=" + especialista;
            $.ajax({
                type:"POST",
                url: urlweb + "api/RHumanos/generar_contrato_practicante/" + id,
                data: cadena,
                dataType: 'json',
                beforeSend: function () {
                    respuesta("Generando contrato, espere un momento...",'success');
                },
                success:function (r) {
                    if(r.result.code == 1) {
                        respuesta("¡Generado!",'success');
                        //document.execCommand(r.result.nombre_descarga,true,urlweb + r.result.archivo);
                        window.open(urlweb + r.result.archivo, '_blank')
                        location.reload();
                    }else{
                        respuesta("Recargando página para verificar si se creo el contrato adecuadamente...",'success');
                        setTimeout(function () {
                            location.reload();
                        }, 700);
                    }
                }
            });
        }
    }
</script>