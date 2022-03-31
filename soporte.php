<?php include_once 'nav_in.php'; ?>
<!-- Page content-->
<section class="py-0">
    <link rel="stylesheet" href="css/estilos_contacto.css">
    <div class="container mt-4 bg-light" id="contacto">
        <div class="ima">
            <img src="assets/img/callcenter.png" width="350px" alt="callcenter-servicio al cliente">
        </div><br>
        <h5 style="text-align: center;">Para nosotros es un gusto atender tu solicitud. !Contáctanos!</h5><br>
        <p id="respuesta"></p>
        <div class="login-form enc">
            <form method="POST" onsubmit="return butdis()" enctype="multipart/form-data" action="dashboard/controllers/mailer/callcenter.php">
                <div class="row align-items-stretch mb-5">
                    <div class="col-md-6">
                        <div class="form-group fondito">
                            <i class="bi bi-patch-question-fill form-control-feedback ui"></i>
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 14px;" class="form-control" type="text" placeholder="Nombre completo..." required name="nombre_callcenter" />
                        </div>
                        <div class="form-group fondito">
                            <i class="fa fa-envelope form-control-feedback ui"></i>
                            <input onkeyup="javascript:this.value=this.value.toUpperCase();" style="font-size: 14px;" class="form-control" type="email" placeholder="Correo" required name="correo_callcenter" />
                        </div>
                        <div class="form-group mb-md-0 fondito">
                            <i class="fa fa-mobile form-control-feedback ui"></i>
                            <input style="font-size: 14px;" class="form-control" type="number" placeholder="Telefono" required name="telefono_callcenter" />
                        </div>
                        <div class="form-group mb-md-0 fondito">
                            <i class="fa fa-file form-control-feedback ui"></i>
                            <input style="font-size: 14px;" class="form-control" type="file" id="file" multiple name="archivo_callcenter[]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-textarea mb-md-0 fondito">
                            <i class="fa fa-pencil-alt form-control-feedback ui"></i>
                            <textarea style="font-size: 14px;" class="form-control" placeholder="Mensaje..." required rows="10" name="mensaje_callcenter"></textarea>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="but" type="submit" id="btn"><i class="fa fa-paper-plane"></i> Enviar mensaje</button>
                    <script>
                        function butdis() {
                            var btn = document.getElementById('btn');
                            btn.disabled = true;
                            btn.innerText = 'Enviando mensaje...'
                        }
                    </script>
            </form>
        </div>
    </div>
    <div class="mt-4 text-center enc">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">
                 Vereda La Veta - Cocorná
                </div>
                <div class="card-body ">
                    <div style="height:500px" id="map" class="map"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function iniciarMap() {
            var coord = {
                lat: 6.0042446,
                lng: -75.0809652
            };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: coord
            });
            var marker = new google.maps.Marker({
                position: coord,
                map: map
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDaeWicvigtP9xPv919E-RNoxfvC-Hqik&callback=iniciarMap"></script>
    <!-- Contact cards-->
    <div class="row gx-5 row-cols-2 row-cols-lg-4 py-5 mb-3">
        <div class="col">
            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-chat-dots"></i></div>
            <div class="h5 mb-2"><a class="text-dark" href="#Sc">Escríbenos</a></div>
            <p class="text-muted mb-0">Ponte en contacto con nosotros al correo <small><a href="mailto:atencionalcliente.asuaveta@gmail.com">atencionalcliente.asuaveta@gmail.com</a></small> para atender tus requerimientos.</p>
        </div>
        <div class="col">
            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-people"></i></div>
            <div class="h5"><a class="text-dark" href="#">Pregunta a la comunidad</a></div>
            <p class="text-muted mb-0">Explore el foro de comentarios, dudas e inquietudes de nuestra comunidad y comuníquese con otros usuarios.</p>
        </div>
        <div class="col">
            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-question-circle"></i></div>
            <div class="h5"><a class="text-dark" href="apoyo.php">Centro de apoyo</a></div>
            <p class="text-muted mb-0">Explore las preguntas frecuentes y los documentos de soporte para encontrar soluciones.</p>
        </div>
        <div class="col">
            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-telephone"></i></div>
            <div class="h5">Llámanos</div>
            <p class="text-muted mb-0">Llámenos durante el horario comercial al <a href="tel:3128998259">(57) 3128998259</a>.</p>
        </div>
    </div>
</section>
</main>
<?php if (isset($_GET['dhddbufgffudghfuihfuihfhfdifuihfiofhiofdhfdiohofdihfiohfihfiofhfiohfiohfdohfiohfiohfiohfdiohfiohfiohfuihfiohvfihvuiofhvouifvhufvhfvhfvfifhvfhfvihfiofjijfijfiojfiojf1'])) { ?>
    <script>
        Swal.fire({
            type: 'info',
            html: "<strong>PQR enviada</strong><br><br>Recibirás una confirmación a tu correo",
        });
        setTimeout(function() {
            window.location.href = "soporte.php";
        }, 2000);
    </script>
<?php } elseif (isset($_GET['dhddbufgffudghfuihfuihfhfdifuihfiofhiofdhfdiohofdihfiohfihfiofhfiohfiohfdohfiohfiohfiohfdiohfiohfiohfuihfiohvfihvuiofhvouifvhufvhfvhfvfifhvfhfvihfiofjijfijfiojfiojf2'])) { ?>
    <script>
        Swal.fire({
            type: 'error',
            html: "<strong>¡Error!</strong><br><br>Por favor intenta más tarde...",
        });
        setTimeout(function() {
            window.location.href = "soporte.php";
        }, 2000);
    </script>
<?php } ?>

<?php include_once 'footer.php' ?>