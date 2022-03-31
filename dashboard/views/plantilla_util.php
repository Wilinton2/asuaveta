<?php include_once 'nav.php'; ?>
<div class="panel-header">
    <div class="header text-center">
        <h2 class="title">Notificaciones</h2>
        <p class="category">Cualquier petición, queja o reclamo, lo podrás radicar por medio de la <a target="_blank" href="../../views/Index.php#contacto">Sección de contacto (PQRS)</a> y con gusto te atenderemos...</p>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Mis notificaciones</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success alert-with-icon text-justify" data-notify="container">
                    <button type="button" aria-hidden="true" class="close">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </button>
                        <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                        <span data-notify="message"><b> NOMBRE DEL REMITENTE</b><br>Esta es una notificación general emitida por nuestro personal administrativo pra todos los usuarios registrados en nuestr sistema de información.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Generales</h4>
                </div>
                <div class="card-body">
                <div class="alert alert-info alert-with-icon text-justify" data-notify="container">
                    <button type="button" aria-hidden="true" class="close">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </button>
                        <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                        <span data-notify="message"><b> NOMBRE DEL REMITENTE</b><br>Esta es una notificación general emitida por nuestro personal administrativo pra todos los usuarios registrados en nuestr sistema de información.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>