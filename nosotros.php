<?php include_once 'nav_in.php'; 
//Datos del gerente
include_once 'dashboard/controllers/conexion.php';
$sql_gerente = "SELECT id_usu, nombre_usu, apellido_usu FROM tbl_usuario
WHERE fk_rol_usu =3";
$cons_gerente = $pdo->prepare($sql_gerente);
$cons_gerente->execute();
$gerente = $cons_gerente->fetch(PDO::FETCH_OBJ);
?>
<!-- Header-->
        <header class="py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-11 col-xxl-6">
                        <div class="text-center my-5">
                            <h1 class="fw-bolder mb-3">Nuestra misión es facilitar a la comunidad el acceso a un agua limpia y saludable...</h1>
                            <p class="lead fw-normal text-muted mb-4">Somos una empresa local dedicada a la prestación del servicio público de acueducto encaminados al desarrollo social en términos de medio ambiente y reserva natural. Trabajamos para crear soluciones oportunas y confiables para
                                el manejo integral del tratamiento de agua y recreación acuática. Con nuestras operaciones diarias, contribuimos con el mejoramiento del medio ambiente y el desarrollo social sostenible. Nuestro equipo está comprometido
                                en satisfacer las necesidades de todos sus clientes. Para el cumplimiento de dicha filosofía, nuestros procesos contemplan la realización del diseño, fabricación, suministro, montaje y operación de los productos, haciendo
                                una amplia diferencia en el acompañamiento que brindamos a nuestros clientes durante todo el proyecto y la vida útil de sus servicios.</p>
                            <a class="btn btn-light" href="#procedimiento_a">Más Información</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- About section one-->
        <section class="py-5" id="procedimiento_a">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0" src="assets/img/proceso_agua.png" alt="Potabilización ASUAVETA" width="600" height="400"></div>
                    <div class="col-lg-6">
                        <h2 class="fw-bolder">Potabilización del agua </h2>
                        <p style="text-align: justify;" class="lead fw-normal text-muted mb-0">El agua es vital para la vida humana, pero antes de ser utilizada debe pasar por un proceso en el que será purificada, este proceso es necesario para que no haya color, sabores u olores en la misma. Aquí te explicamos el proceso
                            o etapas de la potabilización, previo a ser distribuida en los hogares. El proceso o etapas para potabilizar el agua están compuestos por 8 pasos: Captación, desbaste, desarenado/predecantación, coagulación y floculación, decantación,
                            filtración, cloración y almacenamiento.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-3 bg-light">
            <h2 class="fw-bolder text-center">Procedimiento </h2>
            <div class="container px-5 my-2">
                <div class="row gx-5 align-items-center">
                    <hr>
                    <div class="card col-lg-6">
                        <div class="card-body">
                            <h5 class="card-title">Fuente</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Origen del producto</h6>
                            <p class="card-text">El agua que actualmente procesamos es completamente natural y proviniente de nuestras montañas aledañas. Se transporta por tuberías anticorrosivas de manera subterránea hasta la planta principal, desde allí se distribuye por
                                diferentes sectores garantizando la limpieza de la misma.</p>
                        </div>
                    </div>
                    <div class="card col-lg-6">
                        <div class="card-body">
                            <h5 class="card-title">Sistema</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Equipo productivo</h6>
                            <p class="card-text">Realizamos la gestión integral del recurso hídrico gracias al sistema de acueducto, que está formado por varios componentes que cumplen cada uno una función en la captación, transporte, tratamiento, almacenamiento y distribución
                                del agua para brindar una eficiencia en la calidad de nuestro servicio.
                            </p>
                        </div>
                    </div>
                    <div class="card col-lg-6">
                        <div class="card-body">
                            <h5 class="card-title">Captación</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Obtención del recurso</h6>
                            <p class="card-text">El agua se obtiene de quebradas aledañas; En algunos casos se transporta mediante su propia corriente y en el más común es trasladada mediante tuberías hasta el primer tanque.
                            </p>
                        </div>
                    </div>
                    <div class="card col-lg-6">
                        <div class="card-body">
                            <h5 class="card-title">Desbaste</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Exclusión de sólidos grandes</h6>
                            <p class="card-text">En esta etapa, se quitan los sólidos grandes que están presentes en el agua (piedras, ramas, animales, etc), esto se hace mediante unas rejas que están en las plantas de tratamiento de aguas.
                            </p>
                        </div>
                    </div>
                    <div class="card col-lg-6">
                        <div class="card-body">
                            <h5 class="card-title">Predecantación</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Desarenado</h6>
                            <p class="card-text">Aquí se eliminan la arena del agua y otras partículas con el peso para ser decantadas. Esta fase debe hacerse, para evitar que partículas pequeñas, dañen la maquinaria con que se purifica el agua.
                            </p>
                        </div>
                    </div>
                    <div class="card col-lg-6">
                        <div class="card-body">
                            <h5 class="card-title">Coagulación y floculación</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Solidificación de partículas</h6>
                            <p class="card-text">En esta etapa del proceso de potabilización, se agrega en el agua una sustancia para coagular partículas pequeñas que están en el agua, con el fin de ser sedimentadas en la siguiente fase del proceso.
                            </p>
                        </div>
                    </div>
                    <div class="card col-lg-6">
                        <div class="card-body">
                            <h5 class="card-title">Decantación</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Sedimentación de partículas</h6>
                            <p class="card-text">En esta fase se disminuye la velocidad del agua, con el objetivo de sedimentar las partículas solidas que se formaron del anterior proceso.(Coagulación/Floculación/Solidificación).
                            </p>
                        </div>
                    </div>
                    <div class="card col-lg-6">
                        <div class="card-body">
                            <h5 class="card-title">Filtración</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Filtro con arena</h6>
                            <p class="card-text">Se realiza el proceso de filtración con arena especial que sirve para retener los sólidos más diminutos, que están presentes en el agua. Para esta etapa, el agua ya se encuentra clara.
                            </p>
                        </div>
                    </div>
                    <div class="card col-lg-6">
                        <div class="card-body">
                            <h5 class="card-title">Cloración</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Desinfección</h6>
                            <p class="card-text">Una de las últimas etapas del proceso de potabilización del agua es la desinfección con cloro con el fin de atacar las membranas de las bacterias y destruirlas.
                            </p>
                        </div>
                    </div>
                    <div class="card col-lg-6">
                        <div class="card-body">
                            <h5 class="card-title">Almacenamiento</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Filtro con arena</h6>
                            <p class="card-text">El agua es almacenada para que esté en contacto con el cloro, así la potabilización será más segura. Finalmente se distribuye a los hogares lista para ser consumida.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About section two-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6 order-first order-lg-last"><img class="img-fluid rounded mb-5 mb-lg-0" src="assets/img/proceso_agua.png" alt="Potabilización ASUAVETA" width="600" height="400"></div>
                    <div class="col-lg-6">
                        <h2 class="fw-bolder">Nuestro trabajo</h2>
                        <p style="text-align:justify;" class="lead fw-normal text-muted mb-0">En resumen, el proceso inicia desde la captación de las fuentes de agua y luego pasa a las líneas de aducción o transporte del agua cruda, luego a los embalses donde se almacena, las plantas de tratamiento, las conducciones de
                            agua tratada desde las plantas de tratamiento hasta los tanques de almacenamiento y compensación, y por último, las estaciones de bombeo para garantizar el suministro de agua potable a las viviendas, locales y sitios turisticos
                            de la vereda La Veta y aledaños. Con este sistema se garantiza la seguridad, durabilidad, funcionalidad, calidad técnica, eficiencia de operación y sostenibilidad de los sistemas de acueducto brindados por la empresa.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Team members section-->
        <section class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="text-center">
                    <h2 class="fw-bolder">Nuestro equipo</h2>
                    <p class="lead fw-normal text-muted mb-5">Dedicados a la calidad y al éxito</p>
                </div>
                <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5 mb-5 mb-sm-0">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-4 px-4" src="assets/img/user_client.jpg" alt="Gerente de operaciones" width="150" height="150">
                            <h5 class="fw-bolder"><?php echo @$gerente->nombre_usu." ".@$gerente->apellido_usu ?></h5>
                            <div class="fst-italic text-muted">Gerente de general</div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-4 px-4" src="assets/img/user_admin.jpg" alt="Desarrollador" width="150" height="150">
                            <h5 class=" fw-bolder ">WILINTON CASTAÑO CIFUENTES</h5>
                            <div class="fst-italic text-muted ">Desarrollador de software</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include_once 'footer.php' ?>