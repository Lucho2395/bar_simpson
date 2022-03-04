



<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Asistencia</h1>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body" style="text-align: center;">
                            <a href="<?= _SERVER_;?>RHumanos/asistencia_personal">
                                <button class="boton_blanco">
                                    <img src="<?=_SERVER_ . _STYLES_LOGIN_;?>images/cliente_listar.png" height="60%">
                                    <br><br>
                                    <h4 class="font-weight-bold">REGISTRAR ASISTENCIAS</h4>
                                    <p class="card-text">Registrar Asistencia del Personal</p>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                if($role == 2 || $role ==3){
                ?>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body" style="text-align: center;">
                            <a href="<?= _SERVER_;?>RHumanos/opciones">
                                <button class="boton_blanco">
                                    <img src="<?=_SERVER_ . _STYLES_LOGIN_;?>images/reporte_dia.png" height="60%">
                                    <br><br>
                                    <h4 class="font-weight-bold">CONSULTAR ASISTENCIAS</h4>
                                    <p class="card-text">Visualizar las Asistencias por Periodos Determinados</p>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>

                <div class="col-lg-4" style="display:none;">
                    <div class="card">
                        <div class="card-body" style="text-align: center;">
                            <a href="<?= _SERVER_;?>RHumanos/feriados">
                                <button class="boton_blanco">
                                    <img src="<?=_SERVER_ . _STYLES_LOGIN_;?>images/calendariooo.jpg" height="60%">
                                    <br><br>
                                    <h5 class="font-weight-bold">GESTIONAR FERIADOS</h5>
                                    <p class="card-text">Registrar Días declarados como feriados</p>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4" style="display: none">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Registrar Asistencia</strong></h5>
                            <p class="card-text">Registrar Asistencia del Personal</p>
                            <a href="<?= _SERVER_;?>RHumanos/asistencia_personal" type="button" class="btn btn-success">Acceder</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4" style="display: none">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Consultar Asistencias</strong></h5>

                            <a href="<?= _SERVER_;?>RHumanos/opciones" type="button" class="btn btn-success">Acceder</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4" style="display: none">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Gestionar Feriados</strong></h5>
                            <p class="card-text">Registrar Días declarados como feriados</p>
                            <a href="<?= _SERVER_;?>RHumanos/feriados" type="button" class="btn btn-success">Acceder</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4" style="display: none">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Proyectar Asistencias</strong></h5>
                            <p class="card-text">Proyectar Asistencia del Personal</p>
                            <a href="<?= _SERVER_;?>RHumanos/proyectar_asistencia" type="button" class="btn btn-success">Acceder</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script>

</script>