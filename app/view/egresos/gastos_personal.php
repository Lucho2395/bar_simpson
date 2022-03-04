

<!-- Modal Agregar Personas-->
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
                        <div class="row" style="display: none">
                            <div class="col-md-9">
                                <label class="col-form-label">Correo Electronico</label>
                                <input class="form-control" type="text" name="persona_email" id="persona_email" placeholder="Ingrese Correo...">
                            </div>
                            <div class="col-md-3" >
                                <label for="person_cv" class="col-form-label">Curriculum Vitae</label>
                                <input type="file" class="form-control" name="persona_cv" id="persona_cv" >
                            </div>
                        </div>
                        <br>
                        <div class="row" style="display: none">
                            <p style="color: darkred">DATOS PARA EL USUARIO</p>
                        </div>
                        <div class="row" style="display: none">
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

<!-- Modal Agregar gastos-->
<div class="modal fade" id="movi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 55% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="sucursal">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Personal:</label>
                                    <select class="form-control" id= "id_persona" name="id_persona">
                                        <?php
                                        foreach($personal as $s){
                                            ?>
                                            <option value="<?php echo $s->id_persona;?>"><?php echo $s->persona_nombre;?> <?php echo $s->persona_apellido_paterno;?> <?php echo $s->persona_apellido_materno;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Monto:</label>
                                    <input class="form-control" type="text" id="gasto_personal_monto" onkeyup="return validar_numeros_decimales_dos(this.id)" name="gasto_personal_monto" placeholder="Ingrese Monto...">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Fecha:</label>
                                    <input class="form-control" type="date" id="gasto_personal_fecha" name="gasto_personal_fecha" value="<?= date('Y-m-d')?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Concepto:</label>
                                    <textarea rows="3" class="form-control" type="text" id="gasto_personal_concepto" name="gasto_personal_concepto" maxlength="300" placeholder="Ingrese Concepto..."></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="gastos()" class="btn btn-success" id="btn-agregar-gasto"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editar_gp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editar_gastos">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="sucursal">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="hidden" id="id_gasto_personal" name="id_gasto_personal">
                                        <label class="col-form-label">Personal:</label>
                                        <select class="form-control" id= "id_persona_e" name="id_persona_e">
                                            <?php
                                            foreach($personal as $s){
                                                ?>
                                                <option value="<?php echo $s->id_persona;?>"><?php echo $s->persona_nombre;?> <?php echo $s->persona_apellido_paterno;?> <?php echo $s->persona_apellido_materno;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Monto:</label>
                                        <input class="form-control" type="text" id="gasto_personal_monto_e" onkeyup="return validar_numeros_decimales_dos(this.id)" name="gasto_personal_monto_e" placeholder="Ingrese Monto...">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha</label>
                                        <input class="form-control" type="date" id="gasto_personal_fecha_e" name="gasto_personal_fecha_e">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Concepto:</label>
                                        <textarea rows="3" class="form-control" type="text" id="gasto_personal_concepto_e" name="gasto_personal_concepto_e" maxlength="300" placeholder="Ingrese Concepto..."></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-editar-gasto"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
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
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>
            <div class="row">
                <div class="col-lg-9"></div>
                <div class="col-lg-2" style="text-align: right;display: none">
                    <button data-toggle="modal" data-target="#agregar_persona" class=" btn btn-success"><i class="fa fa-plus text-white-50"></i> Agregar Personal</button>
                </div>
                <div class="col-lg-2" style="text-align: right">
                    <button data-toggle="modal" data-target="#movi" class=" btn btn-success"><i class="fa fa-plus text-white-50"></i> Agregar Gasto</button>
                </div>
                <div class="col-lg-1"></div>
            </div>
            <br>
            <form method="post" action="<?= _SERVER_ ?>Egreso/gastos_personal">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-2 col-xs-3 col-md-3 col-sm-3">
                        <label for="turno">Nombre:</label>
                        <input type="text" class="form-control" id="parametro" name="parametro" value="<?= $parametro?>">
                    </div>
                    <div class="col-lg-2 col-xs-3 col-md-3 col-sm-3">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" step="1" value="<?php echo $fecha_filtro;?>">
                    </div>
                    <div class="col-lg-2 col-xs-3 col-md-3 col-sm-3">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_filtro_fin;?>">
                    </div>
                    <div class="col-lg-3 col-xs-3 col-md-3 col-sm-3">
                        <button style="margin-top: 35px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Persona</th>
                                        <th>Concepto</th>
                                        <th>Monto</th>
                                        <th>Fecha de Registro</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($gasto_personal as $m){
                                        ?>
                                        <tr id="gasto<?= $m->id_gasto_personal;?>">
                                            <td><?= $a;?></td>
                                            <td><?= $m->persona_nombre;?> <?= $m->persona_apellido_paterno;?> <?= $m->persona_apellido_materno;?></td>
                                            <td><?= $m->gasto_personal_concepto;?></td>
                                            <td>S/. <?= $m->gasto_personal_monto;?></td>
                                            <td><?= date('d-m-Y H:m:s',strtotime($m->gasto_personal_fecha_registro))?></td>
                                            <td>
                                                <button data-toggle="modal" data-target="#editar_gp" onclick="editar_gasto(<?= $m->id_gasto_personal;?>,'<?= $m->id_persona;?>','<?= $m->gasto_personal_concepto;?>','<?= $m->gasto_personal_monto;?>','<?= $m->gasto_personal_fecha;?>')" class="btn btn-sm btn-info btne" ><i class="fa fa-pencil"></i></button>
                                                <button id="btn-eliminar_gasto<?= $m->id_gasto_personal;?>" class="btn btn-sm btn-secondary btn-danger" onclick="preguntar('¿Está seguro que desea eliminar este registro','eliminar_gasto','Si','No',<?= $m->id_gasto_personal;?>)"><i class="fa fa-trash"></i></button>
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
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>egresos.js"></script>

<script>
    function gastos(){
        var valor = true;
        var id_persona = $('#id_persona').val();
        var gasto_personal_concepto = $('#gasto_personal_concepto').val();
        var gasto_personal_monto = $('#gasto_personal_monto').val();
        var gasto_personal_fecha = $('#gasto_personal_fecha').val();

        valor = validar_campo_vacio('gasto_personal_concepto', gasto_personal_concepto, valor);
        valor = validar_campo_vacio('id_persona', id_persona, valor);
        valor = validar_campo_vacio('gasto_personal_monto', gasto_personal_monto, valor);
        valor = validar_campo_vacio('gasto_personal_fecha', gasto_personal_fecha, valor);

        if(valor){
            //Cadena donde enviaremos los parametros por POST
            var cadena = "id_persona=" + id_persona + "&gasto_personal_concepto=" + gasto_personal_concepto +
                "&gasto_personal_monto=" + gasto_personal_monto +
                "&gasto_personal_fecha=" + gasto_personal_fecha;
            $.ajax({
                type: "POST",
                url: urlweb + "api/Egreso/guardar_gasto_personal",
                data: cadena,
                dataType: 'json',
                success:function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Guardado...recargando!', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 400);
                            break;
                        case 2:
                            respuesta('Error al guardar, recargue la página', 'error');
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    }
</script>