<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 14/10/2020
 * Time: 21:47
 */
?>
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; <a href="<?= _MYSITE_;?>" target="_blank">Bufeo Tec</a> <?= date('Y');?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>
<script type="text/javascript">
    document.title = "<?= $_SESSION['controlador'] . '/' . $_SESSION['accion'] . ' - ' . _TITLE_;?>";
</script>
<!--JS para información personal del usuario-->
<script src="<?php echo _SERVER_ . _JS_;?>datos_personales.js"></script>
<!-- Bootstrap core JavaScript-->
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<!--<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>vendor/chart.js/Chart.min.js"></script>-->

<!-- Page level custom scripts -->
<!--<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>js/demo/chart-area-demo.js"></script>
  <script src="<?= _SERVER_ . _STYLES_ADMIN_;?>js/demo/chart-pie-demo.js"></script>-->

<!-- Page level plugins -->
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script src="<?= _SERVER_ . _STYLES_ADMIN_;?>js/demo/datatables-demo.js"></script>
<!--SweetAlert-->
<script src="<?=_SERVER_ . _LIBS_;?>sweetalert/sweetalert2.min.js"></script>
<script src="<?=_SERVER_ . _JS_;?>main-sweet.js"></script>

</body>

</html>