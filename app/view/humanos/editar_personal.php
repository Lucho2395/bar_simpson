<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Edición Personal</h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Editar Datos del Personal</h4>
                            </div>
                        </div>
                        <form enctype="multipart/form-data" method="post" id="edit_person">
                            <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="person_name" class="col-form-label">Nombres</label>
                                    <input type="hidden" id="id_persona" name="id_persona" value="<?= $id;?>">
                                    <input class="form-control" type="text" name="persona_nombre" id="persona_nombre" value="<?= $person->persona_nombre;?>" onchange="return validar_solo_texto(this.id)">
                                </div>
                                <div class="col-md-3">
                                    <label for="person_surname" class="col-form-label">Apellido Paterno</label>
                                    <input class="form-control" type="text" name="persona_apellido_paterno" id="persona_apellido_paterno" value="<?= $person->persona_apellido_paterno;?>" onchange="return validar_solo_texto(this.id)">
                                </div>
                                <div class="col-md-3">
                                    <label for="person_surname2" class="col-form-label">Apellido Materno</label>
                                    <input class="form-control" type="text" name="persona_apellido_materno" id="persona_apellido_materno" value="<?= $person->persona_apellido_materno;?>" onchange="return validar_solo_texto(this.id)">
                                </div>
                                <div class="col-md-3">
                                    <label for="imagen" class="col-form-label">Foto</label>
                                    <input type="file" class="form-control" name="persona_foto" id="persona_foto" accept="image/*">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="persona_tipo_documento" class="col-form-label">Tipo de Documento</label>
                                    <select class="form-control" name="persona_tipo_documento" id="persona_tipo_documento">
                                        <option value="">Seleccione Una Opción...</option>
                                        <option value="DNI" <?php echo ($person->persona_tipo_documento == "DNI") ? 'selected' : '';?>>DNI</option>
                                        <option value="PASAPORTE" <?php echo ($person->persona_tipo_documento == "PASAPORTE") ? 'selected' : '';?>>PASAPORTE</option>
                                        <option value="CARNET DE EXTRANJERIA" <?php echo ($person->persona_tipo_documento == "CARNET DE EXTRANJERIA") ? 'selected' : '';?>>CARNET DE EXTRANJERIA</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="persona_dni" class="col-form-label">Número de Documento</label>
                                    <input class="form-control" type="text" name="persona_dni" id="persona_dni" value="<?= $person->persona_dni;?>" maxlength="15" onkeyup="return validar_numeros(this.id)">
                                </div>
                                <div class="col-md-2">
                                    <label for="person_nacionality" class="col-form-label">Nacionalidad</label>
                                    <select class="form-control" name="persona_nacionalidad" id="persona_nacionalidad">
                                        <option value="Elegir">Elegir opción</option>
                                        <option value="ALEMANA" <?php echo ($person->persona_nacionalidad == "ALEMANA") ? 'selected' : '';?>>ALEMANA</option>
                                        <option value="ARGENTINA"<?php echo ($person->persona_nacionalidad == "ARGENTINA") ? 'selected' : '';?>>ARGENTINA</option>
                                        <option value="BOLIVIANA" <?php echo ($person->persona_nacionalidad == "BOLIVIANA") ? 'selected' : '';?>>BOLIVIANA</option>
                                        <option value="CHILENA" <?php echo ($person->persona_nacionalidad == "CHILENA") ? 'selected' : '';?>>CHILENA</option>
                                        <option value="CHINO" <?php echo ($person->persona_nacionalidad == "CHINO") ? 'selected' : '';?>>CHINO</option>
                                        <option value="COLOMBIANA" <?php echo ($person->persona_nacionalidad == "COLOMBIANA") ? 'selected' : '';?>>COLOMBIANA</option>
                                        <option value="CUBANA" <?php echo ($person->persona_nacionalidad == "CUBANA") ? 'selected' : '';?>>CUBANA</option>
                                        <option value="ECUATORIANA" <?php echo ($person->persona_nacionalidad == "ECUATORIANA") ? 'selected' : '';?>>ECUATORIANA</option>
                                        <option value="ESPAÑOL" <?php echo ($person->persona_nacionalidad == "ESPAÑOL") ? 'selected' : '';?>>ESPAÑOL</option>
                                        <option value="FRANCESA" <?php echo ($person->persona_nacionalidad == "FRANCESA") ? 'selected' : '';?>>FRANCESA</option>
                                        <option value="ITALIANO" <?php echo ($person->persona_nacionalidad == "ITALIANO") ? 'selected' : '';?>>ITALIANO</option>
                                        <option value="JAPONES" <?php echo ($person->persona_nacionalidad == "JAPONES") ? 'selected' : '';?>>JAPONES</option>
                                        <option value="OTROS" <?php echo ($person->persona_nacionalidad == "OTROS") ? 'selected' : '';?>>OTROS</option>
                                        <option value="PANAMEÑO" <?php echo ($person->persona_nacionalidad == "PANAMEÑO") ? 'selected' : '';?>>PANAMEÑO</option>
                                        <option value="PERUANA" <?php echo ($person->persona_nacionalidad == "PERUANA") ? 'selected' : '';?>>PERUANA</option>
                                        <option value="VENEZOLANA" <?php echo ($person->persona_nacionalidad == "VENEZOLANA") ? 'selected' : '';?>>VENEZOLANA</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="persona_nacimiento" class="col-form-label">Fecha de Nacimiento</label>
                                    <input class="form-control" name="persona_nacimiento" type="date" id="persona_nacimiento" value="<?= $person->persona_nacimiento;?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="persona_telefono" class="col-form-label">Número de Celular</label>
                                    <input class="form-control" type="text" name="persona_telefono" id="persona_telefono" value="<?= $person->persona_telefono;?>" onkeyup="return validar_numeros(this.id)">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="persona_telefono" class="col-form-label">N° de Celular Alterno</label>
                                    <input class="form-control" type="text" name="persona_telefono_2" id="persona_telefono_2" value="<?= $person->persona_telefono_2;?>" onkeyup="return validar_numeros(this.id)">
                                </div>
                                <div class="col-md-2">
                                    <label for="persona_sexo" class="col-form-label">Sexo</label>
                                    <select class="form-control" name="persona_sexo" id="persona_sexo">
                                        <option value="">Seleccione...</option>
                                        <option value="M" <?php echo ($person->persona_sexo == "M") ? 'selected' : '';?>>Masculino</option>
                                        <option value="F" <?php echo ($person->persona_sexo == "F") ? 'selected' : '';?>>Femenino</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="persona_estado_civil" class="col-form-label">Estado Civil</label>
                                    <select class="form-control" name="persona_estado_civil" id="persona_estado_civil">
                                        <option <?php echo ($person->persona_estado_civil == "SOLTERO") ? 'selected' : '';?> value="SOLTERO">SOLTERO</option>
                                        <option <?php echo ($person->persona_estado_civil == "CASADO") ? 'selected' : '';?> value="CASADO">CASADO</option>
                                        <option <?php echo ($person->persona_estado_civil == "VIUDO") ? 'selected' : '';?> value="VIUDO">VIUDO</option>
                                        <option <?php echo ($person->persona_estado_civil == "DIVORCIADO") ? 'selected' : '';?> value="DIVORCIADO">DIVORCIADO</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="persona_discapacidad" class="col-form-label">Discapacidad</label>
                                    <input class="form-control" name="persona_discapacidad" id="persona_discapacidad" value="<?= $person->persona_discapacidad?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="persona_hijos" class="col-form-label">¿Hijos?</label>
                                    <input class="form-control" name="persona_hijos" id="persona_hijos" value="<?= $person->persona_hijos?>">
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label">Grado Instrucción</label>
                                    <select class="form-control" name="persona_job" id="persona_job">
                                        <option value="">Seleccione ...</option>
                                        <option value="Primaria Incompleta" <?php echo ($person->persona_job == "Primaria Incompleta") ? 'selected' : '';?>>Primaria Incompleta</option>
                                        <option value="Primaria Completa" <?php echo ($person->persona_job == "Primaria Completa") ? 'selected' : '';?>>Primaria Completa</option>
                                        <option value="Secundaria Incompleta" <?php echo ($person->persona_job == "Secundaria Incompleta") ? 'selected' : '';?>>Secundaria Incompleta</option>
                                        <option value="Secundaria Completa" <?php echo ($person->persona_job == "Secundaria Completa") ? 'selected' : '';?>>Secundaria Completa</option>
                                        <option value="Superior Técnica Completa" <?php echo ($person->persona_job == "Superior Técnica Completa") ? 'selected' : '';?>>Superior Técnica Completa</option>
                                        <option value="Superior Técnica Incompleta" <?php echo ($person->persona_job == "Superior Técnica Incompleta") ? 'selected' : '';?>>Superior Técnica Incompleta</option>
                                        <option value="Universitario Completo" <?php echo ($person->persona_job == "Universitario Completo") ? 'selected' : '';?>>Universitario Completo</option>
                                        <option value="Universitario Incompleto" <?php echo ($person->persona_job == "Universitario Incompleto") ? 'selected' : '';?>>Universitario Incompleto</option>
                                        <option value="Posgrado" <?php echo ($person->persona_job == "Posgrado") ? 'selected' : '';?>>Posgrado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="id_empresa" class="col-form-label">Empresa</label>
                                    <select class="form-control" name="id_empresa" id="id_empresa">
                                        <option value="">Seleccione ...</option>
                                        <?php
                                        foreach ($empresas as $e){
                                            ?>
                                            <option value="<?= $e->id_empresa;?>" <?php echo ($person->id_empresa == $e->id_empresa) ? 'selected' : '';?>><?= $e->empresa_razon_social;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="persona_direccion" class="col-form-label">Dirección Casa</label>
                                    <input type="text" class="form-control" name="persona_direccion" id="persona_direccion" value="<?= $person->persona_direccion;?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="selectDepartamento" class="col-form-label">Departamento</label>
                                    <select id="selectDepartamento" name="selectDepartamento" onchange="cambia()"  class="form-control">
                                        <option value="">Seleccione</option>
                                        <option value="<?= $person->persona_departamento;?>" selected><?= $person->persona_departamento;?></option>
                                        <option value="Amazonas">Amazonas</option>
                                        <option value="Ancash">Ancash</option>
                                        <option value="Apurímac">Apurímac</option>
                                        <option value="Arequipa">Arequipa</option>
                                        <option value="Ayacucho">Ayacucho</option>
                                        <option value="Cajamarca">Cajamarca</option>
                                        <option value="Callao">Callao</option>
                                        <option value="Cuzco">Cuzco </option>
                                        <option value="Huancavelica">Huancavelica</option>
                                        <option value="Huánuco">Huánuco</option>
                                        <option value="Ica">Ica</option>
                                        <option value="Junín">Junín</option>
                                        <option value="La_Libertad">La Libertad</option>
                                        <option value="Lambayeque">Lambayeque</option>
                                        <option value="Lima">Lima</option>
                                        <option value="Loreto">Loreto</option>
                                        <option value="Madre_de_Dios">Madre de Dios</option>
                                        <option value="Moquegua">Moquegua</option>
                                        <option value="Pasco">Pasco</option>
                                        <option value="Piura">Piura</option>
                                        <option value="Puno">Puno</option>
                                        <option value="San_Martín">San Martín</option>
                                        <option value="Tacna">Tacna</option>
                                        <option value="Tumbes">Tumbes</option>
                                        <option value="Ucayali">Ucayali</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="selectProvincia" class="col-form-label">Provincia</label>
                                    <select class="form-control" id="selectProvincia" name="selectProvincia" onchange="cambiaDistrito()">
                                        <option value="">Seleccione la Provincia</option>
                                        <option selected><?= $person->persona_provincia;?></option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="selectDistrito" class="col-form-label">Distrito</label>
                                    <select class="form-control" id="selectDistrito" name="selectDistrito">
                                        <option value="">Seleccione el Distrito</option>
                                        <option selected><?= $person->persona_distrito;?></option>
                                    </select>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="person_afp" class="col-form-label">Fondo de Pensiones</label>
                                        <select class="form-control" name="persona_afp" id="persona_afp">
                                            <option value="">--Seleccione--</option>
                                            <option value="ONP" <?php echo ($person->persona_afp == "ONP") ? 'selected' : '';?>>ONP</option>
                                            <option value="Prima AFP" <?php echo ($person->persona_afp == "Prima AFP") ? 'selected' : '';?>>Prima AFP</option>
                                            <option value="AFP Profuturo" <?php echo ($person->persona_afp == "AFP Profuturo") ? 'selected' : '';?>>AFP Profuturo</option>
                                            <option value="AFP Integra" <?php echo ($person->persona_afp == "AFP Integra") ? 'selected' : '';?>>AFP Integra</option>
                                            <option value="AFP Habitat" <?php echo ($person->persona_afp == "AFP Habitat") ? 'selected' : '';?>>AFP Habitat</option>
                                        </select>
                                    </div>
                                    <!--<div class="col-md-3">
                            <label class="col-form-label">Afiliación</label>
                            <input type="date" class="form-control" name="person_afiliac" id="person_afiliac" value="<?= $person->person_afiliac;?>">
                        </div>-->
                                    <div class="col-md-3">
                                        <label class="col-form-label">Banco (Sueldo)</label>
                                        <select id="persona_bank" name="persona_bank" class="form-control">
                                            <option value="">--Seleccione--</option>
                                            <option <?php echo ($person->person_bank == "BANBIF") ? 'selected' : '';?>>BANBIF</option>
                                            <option <?php echo ($person->person_bank == "BANCO DE COMERCIO") ? 'selected' : '';?>>BANCO DE COMERCIO</option>
                                            <option <?php echo ($person->person_bank == "BANCO DE LA NACION") ? 'selected' : '';?>>BANCO DE LA NACION</option>
                                            <option <?php echo ($person->person_bank == "BANCO FALABELLA") ? 'selected' : '';?>>BANCO FALABELLA</option>
                                            <option <?php echo ($person->person_bank == "BANCO PICHINCHA") ? 'selected' : '';?>>BANCO PICHINCHA</option>
                                            <option <?php echo ($person->person_bank == "BANCO GNB") ? 'selected' : '';?>>BANCO GNB</option>
                                            <option <?php echo ($person->person_bank == "BANCO CONTINENTAL") ? 'selected' : '';?>>BANCO CONTINENTAL</option>
                                            <option <?php echo ($person->person_bank == "BANCO DE CREDITO") ? 'selected' : '';?>>BANCO DE CREDITO</option>
                                            <option <?php echo ($person->person_bank == "CAJA AREQUIPA") ? 'selected' : '';?>>CAJA AREQUIPA</option>
                                            <option <?php echo ($person->person_bank == "CAJA CUSCO") ? 'selected' : '';?>>CAJA CUSCO</option>
                                            <option <?php echo ($person->person_bank == "CAJA PIURA") ? 'selected' : '';?>>CAJA PIURA</option>
                                            <option <?php echo ($person->person_bank == "CAJA SULLANA") ? 'selected' : '';?>>CAJA SULLANA</option>
                                            <option <?php echo ($person->person_bank == "CAJA TRUJILLO") ? 'selected' : '';?>>CAJA TRUJILLO</option>
                                            <option <?php echo ($person->person_bank == "CITIBANK") ? 'selected' : '';?>>CITIBANK</option>
                                            <option <?php echo ($person->person_bank == "CREDISCOTIA") ? 'selected' : '';?>>CREDISCOTIA</option>
                                            <option <?php echo ($person->person_bank == "INTERBANK") ? 'selected' : '';?>>INTERBANK</option>
                                            <option <?php echo ($person->person_bank == "MIBANCO") ? 'selected' : '';?>>MIBANCO</option>
                                            <option <?php echo ($person->person_bank == "SCOTIABANK") ? 'selected' : '';?>>SCOTIABANK</option>
                                            <option <?php echo ($person->person_bank == "EFECTIVO") ? 'selected' : '';?>>EFECTIVO</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">Número Cuenta (Sueldo)</label>
                                        <input class="form-control" type="text" name="persona_number_account" id="persona_number_account" value="<?= $person->person_number_account;?>"  placeholder="Ingrese Número de Cuenta...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label">CUSPP</label>
                                        <input type="text" class="form-control" name="persona_cuspp" id="persona_cuspp" value="<?= $person->persona_cuspp;?>" placeholder="Ingresar CUSPP...">
                                    </div>
                                    <!--<div class="col-md-3">
                            <label class="col-form-label">Afiliación</label>
                            <input type="date" class="form-control" name="person_afiliac" id="person_afiliac" value="<?= $person->persona_afiliac;?>">
                        </div>-->
                                    <div class="col-md-3">
                                        <label class="col-form-label">Banco (CTS)</label>
                                        <select id="persona_bank_cts" name="persona_bank_cts" class="form-control">
                                            <option value="">--Seleccione--</option>
                                            <option <?php echo ($person->persona_bank_cts == "BANBIF") ? 'selected' : '';?>>BANBIF</option>
                                            <option <?php echo ($person->persona_bank_cts == "BANCO DE COMERCIO") ? 'selected' : '';?>>BANCO DE COMERCIO</option>
                                            <option <?php echo ($person->persona_bank_cts == "BANCO DE LA NACION") ? 'selected' : '';?>>BANCO DE LA NACION</option>
                                            <option <?php echo ($person->persona_bank_cts == "BANCO FALABELLA") ? 'selected' : '';?>>BANCO FALABELLA</option>
                                            <option <?php echo ($person->persona_bank_cts == "BANCO PICHINCHA") ? 'selected' : '';?>>BANCO PICHINCHA</option>
                                            <option <?php echo ($person->persona_bank_cts == "BANCO GNB") ? 'selected' : '';?>>BANCO GNB</option>
                                            <option <?php echo ($person->persona_bank_cts == "BANCO CONTINENTAL") ? 'selected' : '';?>>BANCO CONTINENTAL</option>
                                            <option <?php echo ($person->persona_bank_cts == "BANCO DE CREDITO") ? 'selected' : '';?>>BANCO DE CREDITO</option>
                                            <option <?php echo ($person->persona_bank_cts == "CAJA AREQUIPA") ? 'selected' : '';?>>CAJA AREQUIPA</option>
                                            <option <?php echo ($person->persona_bank_cts == "CAJA CUSCO") ? 'selected' : '';?>>CAJA CUSCO</option>
                                            <option <?php echo ($person->persona_bank_cts == "CAJA PIURA") ? 'selected' : '';?>>CAJA PIURA</option>
                                            <option <?php echo ($person->persona_bank_cts == "CAJA SULLANA") ? 'selected' : '';?>>CAJA SULLANA</option>
                                            <option <?php echo ($person->persona_bank_cts == "CAJA TRUJILLO") ? 'selected' : '';?>>CAJA TRUJILLO</option>
                                            <option <?php echo ($person->persona_bank_cts == "CITIBANK") ? 'selected' : '';?>>CITIBANK</option>
                                            <option <?php echo ($person->persona_bank_cts == "CREDISCOTIA") ? 'selected' : '';?>>CREDISCOTIA</option>
                                            <option <?php echo ($person->persona_bank_cts == "INTERBANK") ? 'selected' : '';?>>INTERBANK</option>
                                            <option <?php echo ($person->persona_bank_cts == "MIBANCO") ? 'selected' : '';?>>MIBANCO</option>
                                            <option <?php echo ($person->persona_bank_cts == "SCOTIABANK") ? 'selected' : '';?>>SCOTIABANK</option>
                                            <option <?php echo ($person->persona_bank_cts == "EFECTIVO") ? 'selected' : '';?>>EFECTIVO</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">Número Cuenta (CTS)</label>
                                        <input class="form-control" type="text" name="persona_account_cts" id="person_account_cts" value="<?= $person->persona_account_cts;?>"  placeholder="Ingrese Número de Cuenta...">
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label">Información Adicional</label>
                                    <input class="form-control" type="text" name="persona_adicional" id="persona_adicional" value="<?= $person->persona_adicional;?>" placeholder="Ingrese Información Adicional...">
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">Banco (Alterna)</label>
                                    <select id="persona_bank_cts" name="persona_bank_alt" class="form-control">
                                        <option value="">--Seleccione--</option>
                                        <option <?php echo ($person->persona_bank_alt == "BANBIF") ? 'selected' : '';?>>BANBIF</option>
                                        <option <?php echo ($person->persona_bank_alt == "BANCO DE COMERCIO") ? 'selected' : '';?>>BANCO DE COMERCIO</option>
                                        <option <?php echo ($person->persona_bank_alt == "BANCO DE LA NACION") ? 'selected' : '';?>>BANCO DE LA NACION</option>
                                        <option <?php echo ($person->persona_bank_alt == "BANCO FALABELLA") ? 'selected' : '';?>>BANCO FALABELLA</option>
                                        <option <?php echo ($person->persona_bank_alt == "BANCO PICHINCHA") ? 'selected' : '';?>>BANCO PICHINCHA</option>
                                        <option <?php echo ($person->persona_bank_alt == "BANCO GNB") ? 'selected' : '';?>>BANCO GNB</option>
                                        <option <?php echo ($person->persona_bank_alt == "BANCO CONTINENTAL") ? 'selected' : '';?>>BANCO CONTINENTAL</option>
                                        <option <?php echo ($person->persona_bank_alt == "BANCO DE CREDITO") ? 'selected' : '';?>>BANCO DE CREDITO</option>
                                        <option <?php echo ($person->persona_bank_alt == "CAJA AREQUIPA") ? 'selected' : '';?>>CAJA AREQUIPA</option>
                                        <option <?php echo ($person->persona_bank_alt == "CAJA CUSCO") ? 'selected' : '';?>>CAJA CUSCO</option>
                                        <option <?php echo ($person->persona_bank_alt == "CAJA PIURA") ? 'selected' : '';?>>CAJA PIURA</option>
                                        <option <?php echo ($person->persona_bank_alt == "CAJA SULLANA") ? 'selected' : '';?>>CAJA SULLANA</option>
                                        <option <?php echo ($person->persona_bank_alt == "CAJA TRUJILLO") ? 'selected' : '';?>>CAJA TRUJILLO</option>
                                        <option <?php echo ($person->persona_bank_alt == "CITIBANK") ? 'selected' : '';?>>CITIBANK</option>
                                        <option <?php echo ($person->persona_bank_alt == "CREDISCOTIA") ? 'selected' : '';?>>CREDISCOTIA</option>
                                        <option <?php echo ($person->persona_bank_alt == "INTERBANK") ? 'selected' : '';?>>INTERBANK</option>
                                        <option <?php echo ($person->persona_bank_alt == "MIBANCO") ? 'selected' : '';?>>MIBANCO</option>
                                        <option <?php echo ($person->persona_bank_alt == "SCOTIABANK") ? 'selected' : '';?>>SCOTIABANK</option>
                                        <option <?php echo ($person->persona_bank_alt == "EFECTIVO") ? 'selected' : '';?>>EFECTIVO</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">Número Cuenta (Alterna)</label>
                                    <input class="form-control" type="text" name="persona_number_account_alt" id="personas_number_account_alt" value="<?= $person->person_number_account_alt;?>"  placeholder="Ingrese Número de Cuenta...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Lista Negra</label>
                                    <select class="form-control" name="persona_blacklist" id="persona_blacklist">
                                        <option value="">Seleccione Una Opción...</option>
                                        <option value="NO" <?php echo ($person->persona_blacklist == "NO") ? 'selected' : '';?>>NO</option>
                                        <option value="SI" <?php echo ($person->persona_blacklist == "SI") ? 'selected' : '';?>>SI</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">Correo Electronico</label>
                                    <input class="form-control" type="text" name="persona_email" id="persona_email" value="<?= $person->persona_email;?>" placeholder="Ingrese Correo...">
                                </div>
                                <div class="col-md-3">
                                    <label for="person_cv" class="col-form-label">Curriculum Vitae</label>
                                    <input type="file" class="form-control" name="persona_cv" id="persona_cv">
                                </div>
                                <div class="col-md-3" style="margin-top: 38px">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                                    <a type="button" href="javascript:history.back()" class="btn btn-primary"><i class=""></i>Regresar</a>
                                </div>
                            </div>
                            <br>
                        </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>
<script>
    $("#edit_person").on('submit', function(e){
        e.preventDefault();
        var valor = true;
        var persona_nombre = $('#persona_nombre').val();
        var persona_apellido_paterno = $('#persona_apellido_paterno').val();
        var persona_apellido_materno = $('#persona_apellido_materno').val();
        var persona_tipo_documento = $('#persona_tipo_documento').val();
        var persona_dni = $('#persona_dni').val();
        var id_empresa = $('#id_empresa').val();

        valor = validar_campo_vacio('persona_nombre', persona_nombre, valor);
        valor = validar_campo_vacio('persona_apellido_paterno', persona_apellido_paterno, valor);
        valor = validar_campo_vacio('persona_apellido_materno', persona_apellido_materno, valor);
        valor = validar_campo_vacio('persona_tipo_documento', persona_tipo_documento, valor);
        valor = validar_campo_vacio('persona_dni', persona_dni, valor);
        valor = validar_campo_vacio('id_empresa', id_empresa, valor);

        if (valor){
            $.ajax({
                type:"POST",
                url: urlweb + "api/RHumanos/guardar_personal",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                dataType: 'json',
                beforeSend: function () {
                    $("#btn-person-add").attr("disabled", true);
                },
                success:function (r) {
                    $("#btn-person-add").attr("disabled", false);
                    switch (r.result.code) {
                        case 1:
                            respuesta("¡Guardado con Exito...Recargando!",'success');
                            setTimeout(function () {
                                location.href = urlweb +  'RHumanos/gestion_personal';
                            }, 1000);
                            break;
                        case 2:
                            respuesta("Fallo el envio",'error');
                            break;
                        case 3:
                            respuesta("Esta número de tipo de documento ya se encuentra registrado.",'error');
                            $('#persona_tipo_documento').css('border','solid red');
                            $('#persona_dni').css('border','solid red');
                            break;
                        case 6:
                            respuesta("Algún dato fue ingresado de manera erronéa. Por favor ingrese todos los datos de forma correcta.",'error');
                            break;
                        default:
                            respuesta("ERROR DESCONOCIDO",'error');
                    }
                }
            });
        }
    });
</script>