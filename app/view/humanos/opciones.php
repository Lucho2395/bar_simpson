<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Recursos Humanos / Consultar Asistencia</h1>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body" style="text-align: center;">
                            <a href="<?= _SERVER_ . 'RHumanos/aprobar_asistencias';?>">
                                <button class="boton_blanco">
                                    <img src="<?=_SERVER_ . _STYLES_LOGIN_;?>images/aprobar.png">
                                    <br><br>
                                    <h4 class="font-weight-bold">Aprobar Asistencias</h4>
                                    <p class="card-text">Vista para aprobar las Asistencias del día</p>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body" style="text-align: center;">
                            <a href="<?= _SERVER_ . 'RHumanos/por_persona';?>">
                                <button class="boton_blanco">
                                    <img src="<?=_SERVER_ . _STYLES_LOGIN_;?>images/por_persona.jpg">
                                    <br><br>
                                    <h4 class="font-weight-bold">Por Persona</h4>
                                    <p class="card-text">Visualizar Persona por Periodo Determinado</p>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body" style="text-align: center;">
                            <a href="<?= _SERVER_ . 'RHumanos/consultar';?>">
                                <button class="boton_blanco">
                                    <img src="<?=_SERVER_ . _STYLES_LOGIN_;?>images/por_periodo.png">
                                    <br><br>
                                    <h4 class="font-weight-bold">Por Periodo</h4>
                                    <p class="card-text">Visualizar Vista Por Periodo Determinado</p>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body" style="text-align: center;">
                            <a href="<?= _SERVER_ . 'RHumanos/asignar_turnos';?>">
                                <button class="boton_blanco">
                                    <img src="<?=_SERVER_ . _STYLES_LOGIN_;?>images/asignar.jpg">
                                    <br><br>
                                    <h4 class="font-weight-bold">Asignar Turnos al Personal</h4>
                                    <p class="card-text">Vista para asignar los turnos al personal</p>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body" style="text-align: center;">
                            <a href="<?= _SERVER_ . 'RHumanos/gestionar_turnos';?>">
                                <button class="boton_blanco">
                                    <img src="<?=_SERVER_ . _STYLES_LOGIN_;?>images/gestion_turnos.jpg">
                                    <br><br>
                                    <h4 class="font-weight-bold">Gestionar los Turnos</h4>
                                    <p class="card-text">Vista para gestionar turnos del personal</p>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="display: none">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Aprobar Asistencias</strong></h5>
                            <p class="card-text">Vista para aprobar las Asistencias del día</p>
                            <a href="<?= _SERVER_ . 'RHumanos/aprobar_asistencias';?>"  class="btn btn-primary">Acceder</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="display: none">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Por Persona</strong></h5>
                            <p class="card-text">Visualizar Vista Por Persona en un Periodo Determinado</p>
                            <a href="<?= _SERVER_ . 'RHumanos/por_persona';?>"  class="btn btn-primary">Acceder</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="display: none">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Por Periodo</strong></h5>
                            <p class="card-text">Visualizar Vista Por Periodo Determinado</p>
                            <a href="<?= _SERVER_ . 'RHumanos/consultar';?>"  class="btn btn-danger">Acceder</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="display: none">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Por Otros Filtros</strong></h5>
                            <p class="card-text">Visualizar Vista Por Departamento, Empresa Contratante, Entidad Financiera y Tipo de Contrato</p>
                            <a href="<?= _SERVER_ . 'Asistencia/otras_consultas';?>"  class="btn btn-success">Acceder</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="text-align: right; ">
                <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
            </div>

        </div>
    </div>
</div>
<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>