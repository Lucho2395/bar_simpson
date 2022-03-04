


<div class="modal fade" id="agregar_persona" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="save_persona">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="person_name" class="col-form-label">Nombres *</label>
                                <input class="form-control" type="text" name="persona_nombre" id="persona_nombre" onchange="return validar_solo_texto(this.id)">
                            </div>
                            <div class="col-md-3">
                                <label for="person_surname" class="col-form-label">Apellido Paterno *</label>
                                <input class="form-control" type="text" name="persona_apellido_paterno" id="persona_apellido_paterno" onchange="return validar_solo_texto(this.id)">
                            </div>
                            <div class="col-md-3">
                                <label for="person_surname2" class="col-form-label">Apellido Materno *</label>
                                <input class="form-control" type="text" name="persona_apellido_materno" id="persona_apellido_materno" onchange="return validar_solo_texto(this.id)">
                            </div>
                            <div class="col-md-3">
                                <label for="imagen" class="col-form-label">Foto</label>
                                <input type="file" class="form-control" name="persona_foto" id="persona_foto" accept="image/*">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="persona_tipo_documento" class="col-form-label">Tipo de Documento *</label>
                                <select class="form-control" name="persona_tipo_documento" id="persona_tipo_documento">
                                    <option value="">Seleccione Una Opción...</option>
                                    <option value="DNI">DNI</option>
                                    <option value="PASAPORTE">PASAPORTE</option>
                                    <option value="CARNET DE EXTRANJERIA">CARNET DE EXTRANJERIA</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="persona_dni" class="col-form-label">Número de Documento *</label>
                                <input class="form-control" type="text" name="persona_dni" id="persona_dni" maxlength="15" onkeyup="return validar_numeros(this.id)">
                            </div>
                            <div class="col-md-2">
                                <label for="person_nacionality" class="col-form-label">Nacionalidad</label>
                                <select class="form-control" name="persona_nacionalidad" id="persona_nacionalidad">
                                    <option value="Elegir">Elegir opción</option>
                                    <option>ALEMANA</option>
                                    <option>ARGENTINA</option>
                                    <option>BOLIVIANA</option>
                                    <option>CHILENA</option>
                                    <option>CHINO</option>
                                    <option>COLOMBIANA</option>
                                    <option>CUBANA</option>
                                    <option>ECUATORIANA</option>
                                    <option>ESPAÑOL</option>
                                    <option>FRANCESA</option>
                                    <option>ITALIANO</option>
                                    <option>JAPONES</option>
                                    <option>OTROS</option>
                                    <option>PANAMEÑO</option>
                                    <option>PERUANA</option>
                                    <option>VENEZOLANA</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="persona_nacimiento" class="col-form-label">Fecha de Nacimiento</label>
                                <input class="form-control" name="persona_nacimiento" type="date" id="persona_nacimiento">
                            </div>
                            <div class="col-md-2">
                                <label for="persona_telefono" class="col-form-label">Número de Celular</label>
                                <input class="form-control" type="text" name="persona_telefono" id="persona_telefono" onkeyup="return validar_numeros(this.id)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="persona_telefono" class="col-form-label">N° de Celular Alterno</label>
                                <input class="form-control" type="text" name="persona_telefono_2" id="persona_telefono_2" onkeyup="return validar_numeros(this.id)">
                            </div>
                            <div class="col-md-2">
                                <label for="persona_sexo" class="col-form-label">Sexo</label>
                                <select class="form-control" name="persona_sexo" id="persona_sexo">
                                    <option value="">Seleccione...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="persona_estado_civil" class="col-form-label">Estado Civil</label>
                                <select class="form-control" name="persona_estado_civil" id="persona_estado_civil">
                                    <option value="">Seleccione...</option>
                                    <option value="SOLTERO">SOLTERO</option>
                                    <option value="CASADO">CASADO</option>
                                    <option value="VIUDO">VIUDO</option>
                                    <option value="DIVORCIADO">DIVORCIADO</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="persona_discapacidad" class="col-form-label">Discapacidad</label>
                                <input class="form-control" type="text" id="persona_discapacidad" name="persona_discapacidad">
                            </div>
                            <div class="col-md-2">
                                <label for="persona_hijos" class="col-form-label">¿Hijos?</label>
                                <input class="form-control" type="number" id="persona_hijos" name="persona_hijos" value="0">
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Grado Instrucción</label>
                                <select class="form-control" name="persona_job" id="persona_job">
                                    <option value="">Seleccione ...</option>
                                    <option value="Primaria Incompleta">Primaria Incompleta</option>
                                    <option value="Primaria Completa">Primaria Completa</option>
                                    <option value="Secundaria Incompleta">Secundaria Incompleta</option>
                                    <option value="Secundaria Completa">Secundaria Completa</option>
                                    <option value="Superior Técnica Completa">Superior Técnica Completa</option>
                                    <option value="Superior Técnica Incompleta">Superior Técnica Incompleta</option>
                                    <option value="Universitario Completo">Universitario Completo</option>
                                    <option value="Universitario Incompleto">Universitario Incompleto</option>
                                    <option value="Posgrado">Posgrado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="id_empresa" class="col-form-label">Empresa *</label>
                                <select class="form-control" name="id_empresa" id="id_empresa">
                                    <option value="">Seleccione ...</option>
                                    <?php
                                    foreach ($empresas as $e){
                                        ?>
                                        <option value="<?= $e->id_empresa;?>"><?= $e->empresa_razon_social;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="persona_direccion" class="col-form-label">Dirección Casa</label>
                                <input type="text" class="form-control" name="persona_direccion" id="persona_direccion">
                            </div>
                            <div class="col-md-2">
                                <label for="selectDepartamento" class="col-form-label">Departamento</label>
                                <select id="selectDepartamento" name="selectDepartamento" onchange="cambia()"  class="form-control">
                                    <option value="">Seleccione</option>
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
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="selectDistrito" class="col-form-label">Distrito</label>
                                <select class="form-control" id="selectDistrito" name="selectDistrito">
                                    <option value="">Seleccione el Distrito</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-md-6">
                                <label for="person_afp" class="col-form-label">Fondo de Pensiones</label>
                                <select class="form-control" name="persona_afp" id="persona_afp">
                                    <option value="">--Seleccione--</option>
                                    <option value="ONP">ONP</option>
                                    <option value="Prima AFP">Prima AFP</option>
                                    <option value="AFP Profuturo">AFP Profuturo</option>
                                    <option value="AFP Integra">AFP Integra</option>
                                    <option value="AFP Habitat">AFP Habitat</option>
                                </select>
                            </div>
                            <!--<div class="col-md-3">
                                <label class="col-form-label">Afiliación</label>
                                <input type="date" class="form-control" name="person_afiliac" id="person_afiliac">
                            </div>-->
                            <div class="col-md-3">
                                <label class="col-form-label">Banco (Sueldo)</label>
                                <select id="persona_bank" name="persona_bank" class="form-control">
                                    <option value="">--Seleccione--</option>
                                    <option>BANBIF</option>
                                    <option>BANCO DE COMERCIO</option>
                                    <option>BANCO DE LA NACION</option>
                                    <option>BANCO FALABELLA</option>
                                    <option>BANCO PICHINCHA</option>
                                    <option>BANCO GNB</option>
                                    <option>BANCO CONTINENTAL</option>
                                    <option>BANCO DE CREDITO</option>
                                    <option>CAJA AREQUIPA</option>
                                    <option>CAJA CUSCO</option>
                                    <option>CAJA PIURA</option>
                                    <option>CAJA SULLANA</option>
                                    <option>CAJA TRUJILLO</option>
                                    <option>CITIBANK</option>
                                    <option>CREDISCOTIA</option>
                                    <option>INTERBANK</option>
                                    <option>MIBANCO</option>
                                    <option>SCOTIABANK</option>
                                    <option>EFECTIVO</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">Número Cuenta (Sueldo)</label>
                                <input class="form-control" name="person_number_account" type="text" id="person_number_account"  placeholder="Ingrese Número de Cuenta...">
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-md-6">
                                <label class="col-form-label">CUSPP</label>
                                <input type="text" class="form-control" name="persona_cuspp" id="persona_cuspp" placeholder="Ingresar CUSPP...">
                            </div>
                            <!--<div class="col-md-3">
                                <label class="col-form-label">Afiliación</label>
                                <input type="date" class="form-control" name="person_afiliac" id="person_afiliac">
                            </div>-->
                            <div class="col-md-3">
                                <label class="col-form-label">Banco (CTS)</label>
                                <select id="persona_bank_cts" name="persona_bank_cts" class="form-control">
                                    <option value="">--Seleccione--</option>
                                    <option>BANBIF</option>
                                    <option>BANCO DE COMERCIO</option>
                                    <option>BANCO DE LA NACION</option>
                                    <option>BANCO FALABELLA</option>
                                    <option>BANCO PICHINCHA</option>
                                    <option>BANCO GNB</option>
                                    <option>BANCO CONTINENTAL</option>
                                    <option>BANCO DE CREDITO</option>
                                    <option>CAJA AREQUIPA</option>
                                    <option>CAJA CUSCO</option>
                                    <option>CAJA PIURA</option>
                                    <option>CAJA SULLANA</option>
                                    <option>CAJA TRUJILLO</option>
                                    <option>CITIBANK</option>
                                    <option>CREDISCOTIA</option>
                                    <option>INTERBANK</option>
                                    <option>MIBANCO</option>
                                    <option>SCOTIABANK</option>
                                    <option>EFECTIVO</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">Número Cuenta (CTS)</label>
                                <input class="form-control" name="persona_account_cts" type="text" id="persona_account_cts"  placeholder="Ingrese Número de Cuenta...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label">Información Adicional</label>
                                <input class="form-control" type="text" name="persona_adicional" id="persona_adicional" placeholder="Ingrese Información Adicional...">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">Banco (Alterna)</label>
                                <select id="persona_bank_alt" name="persona_bank_alt" class="form-control">
                                    <option value="">--Seleccione--</option>
                                    <option>BANBIF</option>
                                    <option>BANCO DE COMERCIO</option>
                                    <option>BANCO DE LA NACION</option>
                                    <option>BANCO FALABELLA</option>
                                    <option>BANCO PICHINCHA</option>
                                    <option>BANCO GNB</option>
                                    <option>BANCO CONTINENTAL</option>
                                    <option>BANCO DE CREDITO</option>
                                    <option>CAJA AREQUIPA</option>
                                    <option>CAJA CUSCO</option>
                                    <option>CAJA PIURA</option>
                                    <option>CAJA SULLANA</option>
                                    <option>CAJA TRUJILLO</option>
                                    <option>CITIBANK</option>
                                    <option>CREDISCOTIA</option>
                                    <option>INTERBANK</option>
                                    <option>MIBANCO</option>
                                    <option>SCOTIABANK</option>
                                    <option>EFECTIVO</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">Número Cuenta (Alterna)</label>
                                <input class="form-control" name="persona_number_account_alt" type="text" id="persona_number_account_alt"  placeholder="Ingrese Número de Cuenta...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <label class="col-form-label">Correo Electronico</label>
                                <input class="form-control" type="text" name="persona_email" id="persona_email" placeholder="Ingrese Correo...">
                            </div>
                            <div class="col-md-3">
                                <label for="person_cv" class="col-form-label">Curriculum Vitae</label>
                                <input type="file" class="form-control" name="persona_cv" id="persona_cv" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <p style="color: darkred">DATOS PARA EL USUARIO</p>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Usuario *</label>
                                    <input class="form-control" type="text" id="usuario_nickname" name="usuario_nickname" maxlength="16" placeholder="Ingrese Información...">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Contraseña *</label>
                                    <input class="form-control" type="password" id="usuario_contrasenha" name="usuario_contrasenha" maxlength="30" placeholder="Ingrese Información...">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Repita Contraseña *</label>
                                    <input class="form-control" type="password" id="usuario_contrasenha2" name="usuario_contrasenha2" maxlength="30" placeholder="Ingrese Información...">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">Rol *</label>
                                    <select id="id_rol" name="id_rol" class="form-control">
                                        <?php
                                        foreach ($roles as $r){
                                            ?>
                                            <option value="<?= $r->id_rol;?>"><?= $r->rol_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p style="color: darkred">* Campos Obligatorios</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-person-add"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editar_persona" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="save_persona_edit">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="person_name" class="col-form-label">Nombres</label>
                                <input type="hidden" id="id_persona_" name="id_persona_">
                                <input class="form-control" type="text" name="persona_nombre_e" id="persona_nombre_e" onchange="return validar_solo_texto(this.id)">
                            </div>
                            <div class="col-md-3">
                                <label for="person_surname" class="col-form-label">Apellido Paterno</label>
                                <input class="form-control" type="text" name="persona_apellido_paterno_e" id="persona_apellido_paterno_e" onchange="return validar_solo_texto(this.id)">
                            </div>
                            <div class="col-md-3">
                                <label for="person_surname2" class="col-form-label">Apellido Materno</label>
                                <input class="form-control" type="text" name="persona_apellido_materno_e" id="persona_apellido_materno_e" onchange="return validar_solo_texto(this.id)">
                            </div>
                            <div class="col-md-3">
                                <label for="imagen" class="col-form-label">Foto</label>
                                <input type="file" class="form-control" name="persona_foto_e" id="persona_foto_e" accept="image/*">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="persona_tipo_documento" class="col-form-label">Tipo de Documento</label>
                                <select class="form-control" name="persona_tipo_documento_e" id="persona_tipo_documento_e">
                                    <option value="">Seleccione Una Opción...</option>
                                    <option value="DNI">DNI</option>
                                    <option value="PASAPORTE">PASAPORTE</option>
                                    <option value="CARNET DE EXTRANJERIA">CARNET DE EXTRANJERIA</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="persona_dni" class="col-form-label">Número de Documento</label>
                                <input class="form-control" type="text" name="persona_dni_e" id="persona_dni_e" maxlength="15" onkeyup="return validar_numeros(this.id)">
                            </div>
                            <div class="col-md-3">
                                <label for="person_nacionality" class="col-form-label">Nacionalidad</label>
                                <select class="form-control" name="persona_nacionalidad_e" id="persona_nacionalidad_e">
                                    <option value="Elegir">Elegir opción</option>
                                    <option>ALEMANA</option>
                                    <option>ARGENTINA</option>
                                    <option>BOLIVIANA</option>
                                    <option>CHILENA</option>
                                    <option>CHINO</option>
                                    <option>COLOMBIANA</option>
                                    <option>CUBANA</option>
                                    <option>ECUATORIANA</option>
                                    <option>ESPAÑOL</option>
                                    <option>FRANCESA</option>
                                    <option>ITALIANO</option>
                                    <option>JAPONES</option>
                                    <option>OTROS</option>
                                    <option>PANAMEÑO</option>
                                    <option>PERUANA</option>
                                    <option>VENEZOLANA</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="persona_nacimiento" class="col-form-label">Fecha de Nacimiento</label>
                                <input class="form-control" name="persona_nacimiento_e" type="date" id="persona_nacimiento_e">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="persona_telefono" class="col-form-label">Número de Celular</label>
                                <input class="form-control" type="text" name="persona_telefono_e" id="persona_telefono_e" onkeyup="return validar_numeros(this.id)">
                            </div>
                            <div class="col-md-2">
                                <label for="persona_sexo" class="col-form-label">Sexo</label>
                                <select class="form-control" name="persona_sexo_e" id="persona_sexo_e">
                                    <option value="">Seleccione...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="persona_estado_civil" class="col-form-label">Estado Civil</label>
                                <select class="form-control" name="persona_estado_civil_e" id="persona_estado_civil_e">
                                    <option value="">Seleccione...</option>
                                    <option value="SOLTERO">SOLTERO</option>
                                    <option value="CASADO">CASADO</option>
                                    <option value="VIUDO">VIUDO</option>
                                    <option value="DIVORCIADO">DIVORCIADO</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="persona_discapacidad" class="col-form-label">Discapacidad</label>
                                <input class="form-control" name="persona_discapacidad_e" id="persona_discapacidad_e">
                            </div>
                            <div class="col-md-2">
                                <label for="persona_hijos" class="col-form-label">¿Hijos?</label>
                                <select class="form-control" name="persona_hijos_e" id="persona_hijos_e">
                                    <option value="">Seleccione...</option>
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Grado Instrucción</label>
                                <select class="form-control" name="persona_job_e" id="persona_job_e">
                                    <option value="">Seleccione ...</option>
                                    <option value="Primaria Incompleta">Primaria Incompleta</option>
                                    <option value="Primaria Completa">Primaria Completa</option>
                                    <option value="Secundaria Incompleta">Secundaria Incompleta</option>
                                    <option value="Secundaria Completa">Secundaria Completa</option>
                                    <option value="Superior Técnica Completa">Superior Técnica Completa</option>
                                    <option value="Superior Técnica Incompleta">Superior Técnica Incompleta</option>
                                    <option value="Universitario Completo">Universitario Completo</option>
                                    <option value="Universitario Incompleto">Universitario Incompleto</option>
                                    <option value="Posgrado">Posgrado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="id_empresa" class="col-form-label">Empresa</label>
                                <select class="form-control" name="id_empresa_e" id="id_empresa_e">
                                    <option value="">Seleccione ...</option>
                                    <?php
                                    foreach ($empresas as $e){
                                        ?>
                                        <option value="<?= $e->id_empresa;?>"><?= $e->empresa_razon_social;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="persona_direccion" class="col-form-label">Dirección Casa</label>
                                <input type="text" class="form-control" name="persona_direccion_e" id="persona_direccion_e">
                            </div>
                            <div class="col-md-2">
                                <label for="selectDepartamento" class="col-form-label">Departamento</label>
                                <select id="selectDepartamento_e" name="selectDepartamento_e" onchange="cambia_e()"  class="form-control">
                                    <option value="">Seleccione</option>
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
                                <select class="form-control" id="selectProvincia_e" name="selectProvincia_e" onchange="cambiaDistrito_e()">
                                    <option value="">Seleccione la Provincia</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="selectDistrito" class="col-form-label">Distrito</label>
                                <select class="form-control" id="selectDistrito_e" name="selectDistrito_e">
                                    <option value="">Seleccione el Distrito</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="person_afp" class="col-form-label">Fondo de Pensiones</label>
                                <select class="form-control" name="persona_afp_e" id="persona_afp_e">
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
                                <select id="persona_bank_e" name="persona_bank_e" class="form-control">
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
                                <input class="form-control" type="text" name="persona_number_account_e" id="persona_number_account_e" value="<?= $person->person_number_account;?>"  placeholder="Ingrese Número de Cuenta...">
                                <input type="hidden" id="id_person" name="id_person" value="<?= $id;?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label">CUSPP</label>
                                <input type="text" class="form-control" name="persona_cuspp_e" id="persona_cuspp_e" value="<?= $person->persona_cuspp;?>" placeholder="Ingresar CUSPP...">
                            </div>
                            <!--<div class="col-md-3">
                            <label class="col-form-label">Afiliación</label>
                            <input type="date" class="form-control" name="person_afiliac" id="person_afiliac" value="<?= $person->persona_afiliac;?>">
                        </div>-->
                            <div class="col-md-3">
                                <label class="col-form-label">Banco (CTS)</label>
                                <select id="persona_bank_cts_e" name="persona_bank_cts_e" class="form-control">
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
                                <input class="form-control" type="text" name="persona_account_cts_e" id="person_account_cts_e" value="<?= $person->persona_account_cts;?>"  placeholder="Ingrese Número de Cuenta...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <label class="col-form-label">Información Adicional</label>
                                <input class="form-control" type="text" name="persona_adicional_e" id="persona_adicional_e" placeholder="Ingrese Información Adicional...">
                            </div>
                            <div class="col-md-3">
                                <label for="person_cv" class="col-form-label">Curriculum Vitae</label>
                                <input type="file" class="form-control" name="persona_cv_e" id="persona_cv_e">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <label class="col-form-label">Correo Electronico</label>
                                <input class="form-control" type="text" name="persona_email_e" id="persona_email_e" placeholder="Ingrese Correo...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-person-add"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Gestión de Personal</h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h3 class="card-title">Gestión de Personal</h3>

                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-row" method="post" action="<?= _SERVER_ . 'RHumanos/gestion_personal';?>">
                                <div class="form-group col-md-4">
                                    <input required name="parametro" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Nombre, Apellido Paterno o Documento de Identidad">
                                </div>
                                <div class="form-group col-md-4" >
                                    <button type="submit" class="btn btn-success">Buscar Ahora</button>
                                    <a type="button" data-toggle="modal" data-target="#agregar_persona" class="btn btn-success" style="color: white;">Agregar Personal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if($datos){
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h3 class="m-0 font-weight-bold text-success">Resultados de Búsqueda: <?= $parametro;?></h3>
                            </div>
                            <div class="card-body">
                                <div class="tabla-responsive">
                                    <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th>#</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>DNI</th>
                                            <th>Foto</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        foreach ($person as $m){
                                            $estilo = "";
                                            $foto = _SERVER_ . 'media/persona/default.png';
                                            if($m->persona_foto != ""){
                                                if(file_exists($m->persona_foto)){
                                                    $foto = _SERVER_ . $m->persona_foto;
                                                }
                                            }

                                            if($m->person_blacklist == "SI"){
                                                $estilo = "style=\"background-color: #FF6B70\"";
                                            }
                                            ?>
                                            <tr <?= $estilo;?>>
                                                <td><?php echo $a;?></td>
                                                <td><?php echo $m->persona_apellido_paterno;?> <?php echo $m->persona_apellido_materno;?>, <?php echo $m->persona_nombre;?></td>
                                                <td><?php echo $m->persona_dni;?></td>
                                                <td><img class="rounded" src="<?= $foto;?>" alt="Foto de <?php echo $m->persona_nombre;?>" width="60"></td>
                                                <td>
                                                    <!--<a class="text-dark" href="<?php echo _SERVER_ . 'Person/detalle/' . $m->id_persona;?>" data-toggle="tooltip" title="Ver detalles"><i class="fa fa-eye ver_detalle margen"></i></a>-->
                                                    <!--<a class="text-dark" href="<?php echo _SERVER_ . 'Person/subir_foto/' . $m->id_persona;?>" data-toggle="tooltip" title="Actualizar Foto"><i class="fa fa-upload"></i></a>-->
                                                    <!--<a data-toggle="modal" data-target="#editar_persona" title="Editar" onclick="editar_personal(<?= $m->id_persona?>,'<?= $m->id_empresa?>','<?= $m->persona_nombre?>','<?= $m->persona_apellido_paterno?>','<?= $m->persona_apellido_materno?>','<?= $m->persona_email?>','<?= $m->persona_tipo_documento?>','<?= $m->persona_dni?>','<?= $m->persona_nacionalidad?>','<?= $m->persona_estado_civil?>','<?= $m->persona_direccion?>','<?= $m->persona_discapacidad?>','<?= $m->persona_job?>','<?= $m->persona_nacimiento?>','<?= $m->persona_sexo?>','<?= $m->persona_telefono?>','<?= $m->persona_foto?>','<?= $m->persona_hijos?>','<?= $m->persona_departamento?>','<?= $m->persona_provincia?>','<?= $m->persona_distrito?>','<?= $m->persona_adicional?>','<?= $m->persona_cv?>')" type="button" class="text-success" ><i class="fa fa-edit ver_detalle"></i></a>-->
                                                    <a href="<?php echo _SERVER_ . 'RHumanos/editar_personal/' . $m->id_persona;?>" data-toggle="tooltip" title='Editar'><i class='fa fa-edit text-success editar margen'></i></a>
                                                    <a data-toggle="tooltip" type="button" onclick="preguntar('¿Esta Seguro que desea Eliminar este personal?','eliminar_personal','SÍ','NO',<?= $m->id_persona;?>)" title='Eliminar'>
                                                        <i class='fa fa-times text-danger eliminar margen'></i>
                                                    </a>
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
                <?php
            }
            ?>

        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>humanos.js"></script>
<script>
    $("#save_persona").on('submit', function(e){
        e.preventDefault();
        var valor = true;
        var persona_nombre = $('#persona_nombre').val();
        var persona_apellido_paterno = $('#persona_apellido_paterno').val();
        var persona_apellido_materno = $('#persona_apellido_materno').val();
        var persona_tipo_documento = $('#persona_tipo_documento').val();
        var persona_dni = $('#persona_dni').val();
        var id_empresa = $('#id_empresa').val();

        var usuario_nickname = $('#usuario_nickname').val();
        var usuario_contrasenha = $('#usuario_contrasenha').val();
        var usuario_contrasenha2 = $('#usuario_contrasenha2').val();
        var id_rol = $('#id_rol').val();

        valor = validar_campo_vacio('persona_nombre', persona_nombre, valor);
        valor = validar_campo_vacio('persona_apellido_paterno', persona_apellido_paterno, valor);
        valor = validar_campo_vacio('persona_apellido_materno', persona_apellido_materno, valor);
        valor = validar_campo_vacio('persona_tipo_documento', persona_tipo_documento, valor);
        valor = validar_campo_vacio('persona_dni', persona_dni, valor);
        valor = validar_campo_vacio('id_empresa', id_empresa, valor);

        valor = validar_campo_vacio('usuario_nickname', usuario_nickname, valor);
        valor = validar_campo_vacio('usuario_contrasenha', usuario_contrasenha, valor);
        valor = validar_campo_vacio('usuario_contrasenha2', usuario_contrasenha2, valor);
        valor = validar_campo_vacio('id_rol', id_rol, valor);
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
                                location.href = urlweb +  'RHumanos/periodolaboral/';
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