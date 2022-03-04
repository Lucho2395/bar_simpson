


<div class="modal fade" id="grupos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="persona">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Nombre del Grupo</label>
                                <input type="text" class="form-control" id="grupo_nombre" name="grupo_nombre" value="">
                            </div>
                            <div class="col-lg-12">
                                <label for="">Nombre Ticketera</label>
                                <input type="text" class="form-control" id="grupo_ticketera" name="grupo_ticketera" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="agregar_grupo()" class="btn btn-success" id="btn-agregar"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-bsm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>
            <div class="row">
                <div class="col-lg-10"></div>
                <div class="col-lg-2 col-md-2 col-xs-2">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#grupos"><i class="fa fa-save"></i> Agregar Grupo</button>
                </div>
            </div>
            <br>

            <div class="row">
                <?php
                foreach($grupos as $g){
                    ?>
                    <div class="col-md-3">
                        <a style="background: #63c76a;margin: 1px; border-radius: 20px;padding: 30px 10px 30px 10px;text-align: center; width: 100%" class="text-white" href="<?php echo _SERVER_ . 'Pedido/listado_detalle_grupo/' . $g->id_grupo;?>"><?= $g->grupo_nombre;?></a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>pedido.js"></script>