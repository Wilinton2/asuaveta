<?php require_once '../controllers/conexion.php';
//Todo de la tabla usuario para mostrar las opciones en el datalist
$sql_but = "SELECT id_serv, id_usu, nombre_usu, apellido_usu FROM tbl_usuario as USU
INNER JOIN tbl_servicio as SER ON SER.fk_suscriptor_serv=USU.id_usu
WHERE fk_estado_serv=1";
$consulta_but = $pdo->prepare($sql_but);
$consulta_but->execute();
$resultado_but = $consulta_but->rowCount();
$usuario_cons = $consulta_but->fetchAll();
//Consulta para datos del servicio y tarifa
@$medidor = $_POST['medidor'];
$sql_ser = "SELECT id_usu, nombre_usu, apellido_usu, fecha_actual_fac, lectura_actual_fac, id_serv, fk_tarifa_serv, cargo_fijo_tar, precio_mt_tar FROM tbl_servicio as SER
INNER JOIN tbl_tarifa as TAR ON TAR.id_tar=SER.fk_tarifa_serv
INNER JOIN tbl_usuario as US ON US.id_usu=SER.fk_suscriptor_serv
INNER JOIN tbl_factura as FAC ON FAC.fk_servicio_fac=SER.id_serv WHERE id_serv =? ORDER BY numero_fac DESC LIMIT 1";
$consulta_ser = $pdo->prepare($sql_ser);
$consulta_ser->execute(array($medidor));
$resultado_ser = $consulta_ser->rowCount();
$servicio = $consulta_ser->fetch(PDO::FETCH_OBJ);
//Generar un numero de factura según el código del servicio /medidor y el periodo facturado
@$fech_list = str_replace('-', '', $servicio->fecha_anterior_fac);
@$num_f = $servicio->id_servicio . $fech_list;
$num_factura = substr($num_f, 0, -2);
//Diferencia entre fechas (Días de consumo)
@$fecha_anterior = @$servicio->fecha_actual_fac;
$fecha_actual = date('Y-m-d');
$desde_php = new DateTime($fecha_anterior);
$hasta_php = new DateTime($fecha_actual);
$dias_con = $desde_php->diff($hasta_php);
$dias_consumo = $dias_con->days;
//Fecha para mostrar el periodo en la alerta de confirmación
@$fecha_alert = strftime("%B del año %Y", strtotime(@$servicio->fecha_actual_fac));
?>
<div id="retorno"></div>
<div class="container" id="todo">
    <form method="POST" id="form_per" onsubmit="quitar()">
        <p id="quit_intro" class="text-muted text-center">Para generar una nueva factura, debes tener en cuenta el número de contrato del servicio a facturar, si no lo encuentras dentro de las opciones, quiere decir que el servicio ya fue facturado para el periodo actual (<strong class="text-uppercase"><?php echo strftime("%B de %Y", strtotime(date("Y-m"))) ?></strong>) por ende, no podrás generar una nueva factura.</p>
        <div class="col-md-4 mb-3 text-center" id="sobra" style="display: block; margin: 0 auto;">
            <label class="font-weight-bold text-uppercase">Contrato:</label>
            <input type="text" class="form-control is-valid" list="usuarios" id="medidor" required>
            <input type="hidden" id="verificar_array" value="<?php echo $resultado_ser ?>">
            <datalist id="usuarios">
                <?php foreach ($usuario_cons as $usuario) {
                    if (date("Y-m", strtotime($usuario['fecha_anterior_fac'])) != date("Y-m")) {
                ?>
                        <option value="<?php echo @$usuario['id_serv'] ?>"><?php echo @$usuario['nombre_usu'] . " " . @$usuario['apellido_usu'] ?> - CC: <?php echo $usuario['id_usu'] ?></option>
                <?php }
                } ?>
            </datalist>
            <div class="valid-feedback">
                Buscar por nombre, documento o contrato
            </div>
            <div class="text-center">
                <button class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>
    <?php if (isset($medidor)) { ?>
        <div style="margin-top: -80px;" class="container p-5" id="cont" style="display: none;">
            <form method="POST" onsubmit="return formulario()" id="form_generar">
                <div class="form-row">
                    <h5 class="col-12 title m-3 text-primary">CREAR FACTURA</h5>
                    <div class="col-md-2 mb-3">
                        <label class="font-weight-bold text-uppercase">Contrato:</label>
                        <input type="number" class="form-control is-valid" id="fk_servicio_fac" value="<?php echo @$servicio->id_serv ?>" required readonly>
                        <div class="valid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-10 mb-3">
                        <label class="font-weight-bold text-uppercase">Titular:</label>
                        <input type="text" class="form-control is-valid" value="<?php echo @$servicio->nombre_usu . " " . @$servicio->apellido_usu . " | CÉDULA: " . @$servicio->id_usu . " | TARIFA AQUA: " . @$servicio->fk_tarifa_serv ?>" required readonly>
                        <div class="valid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="font-weight-bold text-uppercase">Consumo desde:</label>
                        <input type="text" class="form-control is-valid" id="desde" value="<?php echo date(@$servicio->fecha_actual_fac); ?>" required readonly>
                        <div class="valid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="font-weight-bold text-uppercase">Consumo hasta:</label>
                        <input type="text" class="form-control is-valid" id="hasta" value="<?php echo date('Y-m-d') ?>" disabled>
                        <div class="valid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="font-weight-bold text-uppercase" for="validationServer02">Días de consumo:</label>
                        <input type="number" class="form-control is-valid" id="dias_consumo" value="<?php echo @$dias_consumo ?>" required readonly>
                        <div class="valid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold text-uppercase">Periodo a facturar:</label>
                        <input type="month" class="form-control is-valid text-uppercase" value="<?php echo substr($servicio->fecha_actual_fac,0,-3) ?>" readonly required>
                        <div class="valid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold text-uppercase">Metros consumidos:</label>
                        <input type="number" class="form-control is-valid" id="esta" disabled>
                        <div class="invalid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="font-weight-bold text-uppercase">Tarifa:</label>
                        <input type="text" class="form-control is-valid" id="tarifa_serv" value="<?php echo @$servicio->fk_tarifa_serv; ?>" required readonly>
                        <div class="invalid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="font-weight-bold text-uppercase">Cargo fijo $:</label>
                        <input type="text" class="form-control is-valid" id="cargo_fijo" value="<?php echo @$servicio->cargo_fijo_tar; ?>" required readonly>
                        <div class="valid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="font-weight-bold text-uppercase">Precio m3 $:</label>
                        <input type="text" class="form-control is-valid" id="precio_mt" value="<?php echo @$servicio->precio_mt_tar; ?>" required readonly>
                        <div class="invalid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold text-uppercase">Lectura anterior:</label>
                        <input type="number" class="form-control is-valid" id="lectura_anterior" value="<?php echo @$servicio->lectura_actual_fac ?>" required readonly>
                        <div class="invalid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold text-uppercase" for="validationServer02">Subtotal $:</label>
                        <input type="text" class="form-control is-valid" id="subtotal" required readonly>
                        <div class="valid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold text-uppercase">Lectura actual:</label>
                        <input type="number" class="form-control bg-light is-valid" id="lectura_actual" min="<?php echo @$servicio->lectura_actual_fac ?>" max="9999" placeholder="Valor del medidor..." onchange="facturacion()" required>
                        <div class="invalid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold text-uppercase">Otros conceptos $:</label>
                        <input type="number" class="form-control is-valid bg-light" onchange="facturacion()" id="concepto" value="0" min="0" required>
                        <div class="invalid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold text-uppercase">Descuento $:</label>
                        <input type="number" class="form-control is-valid bg-light" onchange="facturacion()" id="descuento" value="0" min="0" required>
                        <div class="invalid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold text-uppercase text-success">Total $:</label>
                        <input type="text" class="form-control is-valid" id="total_factura" required readonly>
                        <div class="invalid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold text-uppercase">Observaciones: (opcional)</label>
                        <textarea class="form-control bg-light is-valid" spellcheck="true" maxlength="600" auto id="mensaje_fac">La Asociación de Usuarios del Acueducto Veredal ASUAVETA, lo invita a cuidar el recurso hídrico y preservar el medio ambiente, recuerda que el agua es la fuerza motriz de toda la naturaleza. ¡Cuídala!
                </textarea>
                        <div class="invalid-feedback">
                            ¡Todo bien!
                        </div>
                    </div>
                </div>
                <div class="form-group ml-4">
                    <input class="form-check-input valid" type="checkbox" required>
                    <input type="hidden" id="fecha_alerta" value="<?php echo strtoupper($fecha_alert) ?>">
                    <label class="form-check-label">
                        <p>Al momento de generar esta factura usted debe tener en cuenta que la información suministrada para el origen de la misma sea verídica y correcta. ¿Estás seguro que deseas continuar?</p>
                    </label>
                </div>
                <p class="font-weight-bold" id="respuesta_fac"></p>
                <button onsubmit="limpiar()" class="btn btn-success" type="submit" id="finish"><i class="fa fa-download"> GENERAR FACTURA</i></button>
            </form>
        </div>
    <?php } ?>
    <script>
        $("#form_per").bind("submit", function() {
            //Enviar formulario por ajax
            var contrato = document.getElementById('medidor').value;
            var pasar = 'medidor=' + contrato;
            $.ajax({
                url: 'new_invoice.php',
                type: 'post',
                data: pasar,
                success: function(resp) {
                    $("#cont").css("display", "block");
                    $("#retorno").html(resp);
                    $("#form_per").css("display", "none");
                    var verificar_array = document.getElementById('verificar_array').value;
                    if (verificar_array == 0) {
                        Swal.fire({
                            type: 'warning',
                            title: '¡Servicio no encontrado: ' + contrato + '!',
                            text: 'Por favor verifica la información ingresada, e intenta nuevamente...',
                        });
                        $("#cont").css("display", "none");
                        $("#form_per").css("display", "block");
                    }
                },
                processData: false
            });
            return false;
        });
        //Eliminar el input que sobra
        function quitar() {
            $("#sobra").css("display", "none");
            $("#quit_intro").css("display", "none");
        }
        //Función para la facturación
        function facturacion() {
            var n1 = document.getElementById('lectura_anterior').value;
            var n2 = document.getElementById('lectura_actual').value;
            var cargo_fijo = document.getElementById('cargo_fijo').value;
            var concepto = document.getElementById('concepto').value;
            var descuento = document.getElementById('descuento').value;
            if (n1 > n2 || n2 > 9999) {
                Swal.fire({
                    type: 'warning',
                    title: '¡favor verfificar!',
                    text: 'La lectura actual no puede ser menor a la lectura anterior ni mayor a 9999, por favor verifica e intenta nuevamente...',
                    showConfirmButton: false,
                    timer: 2400 //el tiempo que dura el mensaje en ms
                });
            } else {
                var resta = parseInt(n2) - parseInt(n1);
                var dias = document.getElementById("esta");
                dias.value = resta;
                var n1 = document.getElementById('precio_mt').value;
                var subtotal = parseInt(n1) * parseInt(resta) + parseInt(cargo_fijo);
                tot = document.getElementById("subtotal");
                tot.value = subtotal;
                var total = parseInt(subtotal) + parseInt(concepto) - parseInt(descuento);
                tot = document.getElementById("total_factura");
                tot.value = total;
            }
        }
        //Información del formulario para procesar el almacenamiento de la factura
        function formulario() {
            var lectura_anterior = document.getElementById('lectura_anterior').value;
            var lectura_actual = document.getElementById('lectura_actual').value;
            var desde = document.getElementById('desde').value;
            var hasta = document.getElementById('hasta').value;
            var concepto = document.getElementById('concepto').value;
            var descuento = document.getElementById('descuento').value;
            var mensaje_fac = document.getElementById('mensaje_fac').value;
            var tarifa_serv = document.getElementById('tarifa_serv').value;
            var cargo_fijo = document.getElementById('cargo_fijo').value;
            var precio_mt = document.getElementById('precio_mt').value;
            var fk_servicio_fac = document.getElementById('fk_servicio_fac').value;
            //Mostrar periodo en la alerta
            var captura = document.getElementById('fecha_alerta').value;
            var datos = 'lectura_anterior=' + lectura_anterior + '&lectura_actual=' + lectura_actual + '&desde=' + desde + '&hasta=' + hasta + '&concepto=' + concepto + '&descuento=' + descuento + '&mensaje_fac=' + mensaje_fac + '&tarifa_serv=' + tarifa_serv + '&cargo_fijo=' + cargo_fijo + '&precio_mt=' + precio_mt + '&fk_servicio_fac=' + fk_servicio_fac;
            $.ajax({
                url: '../controllers/registro.php',
                type: 'post',
                data: datos,
                success: function(resp) {
                    $('#finish').prop('disabled', true);
                    if (resp == 1) {
                        Swal.fire({
                            position: 'top-start', //permite "top-end"
                            type: 'success',
                            title: 'Factura generada con éxito',
                            text: 'La factura correspondiente al periodo de ' + captura + ' se ha generado y almacenado exitosamente...',
                            showConfirmButton: false,
                            timer: 3500 //el tiempo que dura el mensaje en ms
                        });
                    } else {
                        if (resp == 4) {
                            Swal.fire({
                                type: 'error',
                                title: '¡No existe contrato!',
                                text: 'Esta factura no puede ser generada debido a que el usuario no tiene algún servicio instalado...',
                            });
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: '¡La factura ya existe!',
                                text: resp,
                                showConfirmButton: false,
                                timer: 2000 //el tiempo que dura el mensaje en ms
                            });
                        }

                    }
                }
            });
            return false;
        }
    </script>