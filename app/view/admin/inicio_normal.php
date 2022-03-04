<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 10/03/2021
 * Time: 9:58
 */
?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!-- Approach -->
                    <div class="card shadow mb-4 bg-gradient-success text-white">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Bienvenido a <?php echo _TITLE_;?>, <?php echo $this->encriptar->desencriptar($_SESSION['p_n'],_FULL_KEY_) . ' ' . $this->encriptar->desencriptar($_SESSION['p_p'],_FULL_KEY_);?></h6>
                        </div>
                        <div class="card-body" style="text-align: center;">
                            <h2 style="padding-top: 20px;">Su Rol de Usuario es: <?php echo $this->encriptar->desencriptar($_SESSION['rn'],_FULL_KEY_);?></h2><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<!-- End of Main Content -->
