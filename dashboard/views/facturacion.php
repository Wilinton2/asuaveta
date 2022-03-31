<?php require_once 'nav.php';
?>
<div class="panel-header">
    <div class="header text-center">
        <h3 class="title">Área de facturación</h3>
        <p class="text-muted">Gestión y generación de facturas pendientes</p>
        <a href="../controllers/reportes/facturas_periodo_actual.php" target="_blank" class="btn btn-info"><strong class="text-uppercase">FACTURAR <?php echo strftime("%B de %Y", strtotime(date("Y-m"))) ?></strong></a>
    </div>
</div>
<div class="container">
    <div class="card text-center bg-default">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item" id="pagar_factura">
                    <a onclick="vacio()" type="button" class="nav-link active">Recibir pagos</a>
                </li>
                <li class="nav-item" id="btnfac">
                    <a type="button" class="nav-link active">Generar factura</a>
                </li>
            </ul>
        </div>
        <div class="m-4 card-body">
            <div id="intro_fac" class="text-dark font-weight-bold">Bienvenido al sistema de facturación ASUAVETA<br><br>
                <p class="text-muted">Aquí podrás generar nuevas facturas mensuales así como realizar sus pagos de forma manual, consultar y descargar copias de las mismas.</p>
            </div>
            <!-- En este div se almacena el contenido externo -->
            <div id="contenido" style="display: block;"></div>
        </div>
        <div class="card-footer">
            <small class="text-muted">¡Equidad y compromiso!</small>
        </div>
    </div>
</div>
<script>
    //Llamado al archivo para crear factura
    $('#btnfac').click(function() {
        $.ajax({
            url: "new_invoice.php",
            success: function(data) {
                $('#contenido').html(data);
                $("#intro_fac").css("display", "none");
            }
        });
    });
    //Llamado al archivo para pagar factura manualmente
    $('#pagar_factura').click(function() {
        $.ajax({
            url: "pago_manual.php",
            success: function(data) {
                $('#contenido').html(data);
                $("#intro_fac").css("display", "none");
            }
        });
    });

</script>
<?php
require_once 'footer.php';
?>