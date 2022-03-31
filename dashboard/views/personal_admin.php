<?php include_once 'nav.php';
//Selección de los datos de los administradores
$sql = "SELECT id_usu, nombre_usu, apellido_usu, correo_usu, direccion_usu, telefono_usu, fecha_registro_usu, fk_estado_usu, tipo_estado FROM tbl_usuario AS USU
INNER JOIN tbl_estado AS EST ON EST.id_estado=USU.fk_estado_usu
WHERE fk_rol_usu=2 ORDER BY fecha_registro_usu DESC";
$consulta = $pdo->prepare($sql);
$consulta->execute();
$resultado_mostrar = $consulta->fetchAll();
if ($user->fk_rol_usu != 3) {
    echo "<script>alert('¡No tienes permisos para acceder a esta parte del sistema!')</script>";
    echo "<script>document.location.href='javascript:history.back()';</script>";
}
?>
<div class="panel-header">
    <div class="header text-center">
        <h2 class="title">Gestión de personal administrativo</h2>
        <p class="category">Registro y eliminación de administradores ASUAVETA</p>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <a type="button" class="btn btn-info" href="../controllers/reportes/admins.php" target="_blank">Exportar información <i class="fas fa-print"></i></a>
            <button class="btn btn-success" data-toggle="modal" data-target="#registro_administrador"><i class="fa fa-plus"></i> Registrar administrador</button>
        </div>
        <!--Modal para Registrar-->
        <div class="modal fade" id="registro_administrador" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><i class="fa fa-user-plus"></i> Registrar Administrador...</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" onsubmit="return RegistroAdmin()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size: 12px;" class="font-weight-bold col-form-label">Nombre:</label>
                                        <input required onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 15px;" type="text" class="form-control" id="newS_nom">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size: 12px;" class="font-weight-bold col-form-label">Apellido:</label>
                                        <input required onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 15px;" type="text" class="form-control" id="newS_ape">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size: 12px;" class="font-weight-bold col-form-label">Documento:</label>
                                        <input style="font-size: 15px;" type="number" class="form-control" id="newS_doc" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size: 12px;" class="font-weight-bold col-form-label">Teléfono:</label>
                                        <input required style="font-size: 15px;" type="number" class="form-control" id="newS_tel">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size: 12px;" class="font-weight-bold col-form-label">Correo electrónico:</label>
                                        <input required onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 15px;" type="email" class="form-control" id="newS_cor">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size: 12px;" class="font-weight-bold col-form-label">Confirmar correo:</label>
                                        <input required onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 15px;" type="email" class="form-control" id="newS_cor2">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label style="font-size: 11px;" class="font-weight-bold col-form-label">Dirección:</label>
                                        <textarea required onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 15px;" type="text" class="form-control" id="newS_dir" placeholder="Dirección del nuevo usuario..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-info">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Estimado administrador del SIA...</strong>
                    <p>En este espacio, podrás gestionar la información de los clientes registrados en el sistema que cuentan con un servicio activo. Puedes realizar la búsqueda del usuario por su nombre o por su número de cédula para una mayor precisión.</p>
                </div>
                <div class="card-body">
                    <table id="ustab" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center text-sm">CC</th>
                                <th class="text-center">NOMBRE</th>
                                <th class="text-center">DETALLES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultado_mostrar as $datos) : ?>
                                <tr>
                                    <td class="text-center"><?php echo $datos['id_usu']; ?></td>
                                    <td class="text-center"><?php echo $datos['nombre_usu'] . " " . $datos['apellido_usu']; ?></td>
                                    <td class="text-center"><button class="btn tn-sm btn-success" data-toggle="modal" data-target="#gestion_usuario<?php echo $datos['id_usu']; ?>">Actualizar <i class="fa fa-cogs"> </i></button></td>
                                    <!--Modal para Gestionar usuario-->
                                    <div class="modal fade" id="gestion_usuario<?php echo $datos['id_usu']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title font-weight-bold"><i class="fa fa-user-shield"></i> DATOS - ADMINISTRADOR</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <form method="post" onsubmit="return editUsuario('<?php echo $datos['id_usu'] ?>')">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-user-edit"></i> Nombres:</label>
                                                                    <input type="text" value="<?php echo $datos['nombre_usu'] ?>" id="CogUsNombre<?php echo $datos['id_usu'] ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-user-edit"></i> Apellidos:</label>
                                                                    <input type="text" value="<?php echo $datos['apellido_usu'] ?>" id="CogUsApellido<?php echo $datos['id_usu'] ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-id-card"></i> Cédula:</label>
                                                                    <input type="number" value="<?php echo $datos['id_usu'] ?>" class="form-control is-valid" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-envelope"></i> Correo:</label>
                                                                    <input type="email" value="<?php echo $datos['correo_usu'] ?>" id="CogUsCorreo<?php echo $datos['id_usu'] ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-mobile"></i> Celular:</label>
                                                                    <input type="number" value="<?php echo $datos['telefono_usu'] ?>" id="CogUsTelefono<?php echo $datos['id_usu'] ?>" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-calendar-alt"></i> Fecha de registro:</label>
                                                                    <input type="date" class="form-control is-valid" value="<?php echo $datos['fecha_registro_usu'] ?>" disabled required>
                                                                    <input type="hidden" id="CogUsIdUsu<?php echo $datos['id_usu'] ?>" value="<?php echo $datos['id_usu'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-7">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fas fa-map-marker-smile"></i> Dirección:</label>
                                                                    <textarea id="CogUsDireccion<?php echo $datos['id_usu'] ?>" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" required><?php echo $datos['direccion_usu'] ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold col-form-label text-primary"><i class="fad fa-gem"></i> Estado de la cuenta:</label>
                                                                    <select id="CogUsEstado<?php echo $datos['id_usu'] ?>" class="form-control" required>
                                                                        <option value="<?php echo $datos['fk_estado_usu'] ?>" selected>EST. <?php echo $datos['tipo_estado'] ?></option>
                                                                        <option value="1">ACTIVO(A)</option>
                                                                        <option value="2">INACTIVO(A)</option>
                                                                    </select>
                                                                    <input type="hidden" value="<?php echo $datos['id_usu'] ?>" id="CogUsDocumento<?php echo $datos['id_usu'] ?>" required>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary"><i class="fas fa-sync"></i> Actualizar datos</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //Formulario de nuevo servicio
    function RegistroAdmin() {
        var newS_nombre = document.getElementById('newS_nom').value;
        var newS_apellido = document.getElementById('newS_ape').value;
        var newS_documento = document.getElementById('newS_doc').value;
        var newS_telefono = document.getElementById('newS_tel').value;
        var newS_correo = document.getElementById('newS_cor').value;
        var newS_correo2 = document.getElementById('newS_cor2').value;
        var newS_direccion = document.getElementById('newS_dir').value;
        if (newS_correo == newS_correo2) {
            var todo_serv = 'newS_nom=' + newS_nombre + '&newS_ape=' + newS_apellido + '&newS_docAdministr=' + newS_documento + '&newS_tel=' + newS_telefono + '&newS_cor=' + newS_correo + '&newS_dir=' + newS_direccion;
            $.ajax({
                url: '../controllers/registro.php',
                type: 'post',
                data: todo_serv,
                beforeSend: function() {
                    Swal.fire({
                        type: 'info',
                        text: 'Validando información...',
                        showConfirmButton: false,
                    });
                },
                success: function(resp_Admin) {
                    if (resp_Admin == 1) {
                        Swal.fire({
                            type: 'success',
                            title: '¡Perfecto!',
                            html: '<strong>El administrador se ha registrado correctamente</strong>',
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: '¡Error!',
                            html: resp_Admin,
                        });
                    }
                }
            });
        } else {
            Swal.fire({
                type: 'warning',
                title: '¡Error!',
                html: 'Los correos ingresados no coinciden, por favor verifica e intenta nuevamente...',
            });
        }
        return false;
    };

    $(document).ready(function() {
        $('#ustab').DataTable({
            "order": false
        });
    });
    //Editar información de usuario
    function editUsuario(tokin) {
        var CogUsNombre = document.getElementById('CogUsNombre' + tokin).value;
        var CogUsApellido = document.getElementById('CogUsApellido' + tokin).value;
        var CogUsDocumento = document.getElementById('CogUsDocumento' + tokin).value;
        var CogUsCorreo = document.getElementById('CogUsCorreo' + tokin).value;
        var CogUsTelefono = document.getElementById('CogUsTelefono' + tokin).value;
        var CogUsDireccion = document.getElementById('CogUsDireccion' + tokin).value;
        var CogUsEstado = document.getElementById('CogUsEstado' + tokin).value;
        var CogUsIdUsu = document.getElementById('CogUsIdUsu' + tokin).value;
        var datosUsu = 'CogUsNombre=' + CogUsNombre + '&CogUsApellido=' + CogUsApellido + '&CogUsDocumento=' + CogUsDocumento + '&CogUsCorreo=' + CogUsCorreo + '&CogUsTelefono=' + CogUsTelefono + '&CogUsDireccion=' + CogUsDireccion + '&CogUsEstado=' + CogUsEstado + '&CogUsIdUsu=' + CogUsIdUsu;
        $.ajax({
            url: '../controllers/editar.php',
            type: 'post',
            data: datosUsu,
            beforeSend: function() {
                Swal.fire({
                    type: 'info',
                    html: 'Actualizando...',
                    showConfirmButton: false,
                });
            },
            success: function(respContrato) {
                if (respContrato == 1) {
                    Swal.fire({
                        type: 'success',
                        title: 'Muy bien!',
                        html: 'La información de <strong>' + CogUsNombre + ' ' + CogUsApellido + '</strong> se ha actualizado correactamente...',
                        showConfirmButton: true,
                    });
                } else {
                    Swal.fire({
                        type: 'error',
                        title: '¡Error!',
                        html: respContrato,
                        showConfirmButton: true,
                    });
                }
            }
        });
        return false;
    }
</script>
<?php include_once 'footer.php'; ?>