<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        ASUAVETA
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body>
    <script>
        function close_tab() {
            if (confirm("¿Seguro que quieres cerrar esta pestaña?")) {
                window.close();
            }
        }
    </script>
    <!-- Navbar -->
    <nav style="background-color: #224E82;" class="navbar navbar-expand-lg navbar-absolute">
        <div class="container-fluid">
            <div class="logo">
                <a href="../../views/index.php" class="simple-text logo-normal" style="text-decoration: none;">
                    <strong style="font-size: 18px;">ASUAVETA</strong>
                </a>
            </div>
            <div class="navbar-wrapper">
                <a class="navbar-brand" href="#">¡BIENVENIDO AL REPOSITORIO DE DOCUMENTOS DE ASUAVETA!</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <a href="javascript:close_tab();"><button class="btn btn-success">X CERRAR</button></a>
            </button>
        </div>
    </nav>
    <!-- End Navbar -->




    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Visor de documentos generales SIA</h5>
                        <p class="category">Los documentos aquí presentados podrían ser confidenciales para la empresa <a target="_blank" href="../../views/index.php">ASUAVETA</a></p>
                    </div>
                    <?php if (isset($_GET['terminos'])) : ?>
                        <!--Términos y condiciones-->
                        <div class="card-body">
                            <div class="row">
                                <div class="modal-body text-justify">
                                    <strong>TÉRMINOS Y CONDICIONES DEL SITIO WEB</strong><br>
                                    Última actualización 21 de agosto de 2021 <br><br>

                                    <h6>Información general</h6>
                                    Este sitio web es operado por ASUAVETA con nombre comercial Acueducto Público Rural La Veta. En todo el sitio, los términos “nosotros”, “nos” y “nuestro” se refieren a ASUAVETA con nombre comercial previamente mencionado, ofrece este sitio web, incluyendo toda la información, herramientas y servicios disponibles para ti en este sitio, el usuario, está condicionado a la aceptación de todos los términos, condiciones, políticas y notificaciones aquí establecidos.
                                    Al visitar nuestro sitio y/o adquirir un servicio con nosotros, participas en nuestro “Servicio” y aceptas los siguientes términos y condiciones (“Términos de Servicio”, “Términos”), incluidos todos los términos y condiciones adicionales y las políticas a las que se hace referencia en el presente documento y/o disponible a través de hipervínculos. Estas Condiciones de Servicio se aplican a todos los usuarios del sitio, incluyendo sin limitación a usuarios que sean navegadores, proveedores, clientes, comerciantes, y/o colaboradores de contenido.
                                    Por favor, lee estos Términos de Servicio cuidadosamente antes de acceder o utilizar nuestro sitio web. Al acceder o utilizar cualquier parte del sitio, estás aceptando los Términos de Servicio. Si no estás de acuerdo con todos los términos y condiciones de este acuerdo, entonces no deberías acceder a la página web o usar cualquiera de los servicios. Si los Términos de Servicio son considerados una oferta, la aceptación está expresamente limitada a estos Términos de Servicio.
                                    Cualquier función nueva o herramienta que se añadan a la aplicación actual, también estarán sujetas a los Términos de Servicio. Puedes revisar la versión actualizada de los Términos de Servicio, en cualquier momento en este sitio web. Nos reservamos el derecho de actualizar, cambiar o reemplazar cualquier parte de los Términos de Servicio mediante la publicación de actualizaciones y/o cambios en nuestro sitio web. Es tu responsabilidad revisar esta página periódicamente para verificar cambios. Tu uso continuo o el acceso al sitio web después de la publicación de cualquier cambio constituye la aceptación de dichos cambios.<br><br>

                                    <h6>Sección 1 – Términos de la empresa ASUAVETA</h6>
                                    Al utilizar este sitio, declaras que tienes al menos la mayoría de edad en tu estado o provincia de residencia, o que tienes la mayoría de edad en tu estado o provincia de residencia y que nos has dado tu consentimiento para permitir que cualquiera de tus dependientes menores use este sitio.
                                    No puedes usar nuestros productos con ningún propósito ilegal o no autorizado tampoco puedes, en el uso del Servicio, violar cualquier ley en tu jurisdicción (incluyendo pero no limitando a las leyes de derecho de autor).
                                    No debes transmitir gusanos, troyanos, virus o cualquier código de naturaleza destructiva.
                                    El incumplimiento o violación de cualquiera de estos Términos darán lugar al cese inmediato de tus Servicios. <br><br>

                                    <h6>Sección 2 – Condiciones generales</h6>
                                    Nos reservamos el derecho de rechazar la prestación de servicio a cualquier persona, por cualquier motivo y en cualquier momento.
                                    Entiendes que tu contenido (sin incluir la información de tu contraseña), puede ser transferida sin encriptar e involucrar (a) transmisiones a través de varias redes; y (b) cambios para ajustarse o adaptarse a los requisitos técnicos de conexión de redes o dispositivos. La información de contraseñas está siempre encriptada durante la transferencia a través de las redes.
                                    Estás de acuerdo con no reproducir, duplicar, copiar, vender, revender o explotar cualquier parte del Servicio, uso del Servicio, o acceso al Servicio o cualquier contacto en el sitio web a través del cual se presta el servicio, sin el expreso permiso por escrito de nuestra parte.
                                    Los títulos utilizados en este acuerdo se incluyen solo por conveniencia y no limita o afecta a estos Términos. <br><br>

                                    <h6>Sección 3 – Exactitud, exhaustividad y actualidad de la información</h6>
                                    No nos hacemos responsables si la información disponible en este sitio no es exacta, completa o actual. El material en este sitio es provisto sólo para información general y no debe confiarse en ella o utilizarse como la única base para la toma de decisiones sin consultar primeramente, información más precisa, completa u oportuna. Cualquier dependencia en materia de este sitio es bajo su propio riesgo.
                                    Este sitio puede contener cierta información histórica. La información histórica, no es necesariamente actual y es provista únicamente para tu referencia. Nos reservamos el derecho de modificar los contenidos de este sitio en cualquier momento, pero no tenemos obligación de actualizar cualquier información en nuestro sitio. Aceptas que es tu responsabilidad de monitorear los cambios en nuestro sitio. <br><br>

                                    <h6>Sección 4 – Modificaciones al servicio y precios</h6>
                                    Los precios de nuestro servicio de agua, ya sea litros, mililitros, tuberías, u otros, están sujetos a cambio sin previo aviso.
                                    Nos reservamos el derecho de modificar o discontinuar el Servicio (o cualquier parte del contenido) en cualquier momento sin aviso previo.
                                    No seremos responsables ante ti o alguna tercera parte por cualquier modificación, cambio de precio, suspensión o discontinuidad del Servicio.<br><br>

                                    <h6>Sección 5 – Productos o servicios</h6>
                                    Ciertos productos o servicios pueden estar disponibles exclusivamente en línea a través del sitio web, como promociones, bonos en la factura, etc. Estos productos o servicios pueden tener cantidades limitadas.
                                    Hemos hecho el esfuerzo de mostrar los colores y las imágenes de nuestros servicios instalados en algunos domicilios, con la mayor precisión posible. No podemos garantizar que el monitor de tu computadora muestre los colores e imagen de manera exacta o que las que condiciones de instalación sean precisamente igual.
                                    Todas las promociones no son acumulables con otras promociones. Aplican hasta agotar existencias y están restringidas a una por persona beneficiaria del servicio.
                                    Nos reservamos el derecho, pero no estamos obligados, para limitar las ventas de nuestro servicio a cualquier persona. Podemos ejercer este derecho basados en cada caso. Nos reservamos el derecho de limitar las cantidades de los servicios que ofrecemos. Todas las descripciones de servicios o precios de los servicios están sujetas a cambios en cualquier momento sin previo aviso, a nuestra sola discreción. Nos reservamos el derecho de discontinuar cualquier servicio en cualquier momento.
                                    No garantizamos que la calidad del servicio, información u otro material comprado u obtenido por ti cumpla con tus expectativas, o que cualquier error en el Servicio será corregido inmediatamente.
                                    ASUAVETA se compromete a proporcionar un servicio de acueducto de buena calidad que cumpla con nuestros estándares de aseo, así como cumplir con la más alta seguridad de la salud y los requisitos reglamentarios aplicables relacionados. En el caso de que alguno de nuestros productos no cumpla con los más altos estándares, no nos hacemos responsables de los daños resultantes de la falta de uso o defecto del servicio, y se suspenderá el servicio de inmediato hasta dar solución a dicho problema.<br><br>

                                    <h6>Sección 6 – Exactitud de facturación e información de cuenta</h6>
                                    Nos reservamos el derecho de rechazar cualquier solicitud de servicio que realice con nosotros. Podemos, a nuestra discreción, limitar o cancelar las cantidades solicitadas por persona. Estas restricciones pueden incluir servicios a nombre de personas que no tienen un buen historial comercial en la empresa, que desean solicitar un nuevo servicio pero que no está en condiciones para ser aceptado.
                                    Los Precios pueden variar sin previo aviso debido a factores externos: devaluaciones monetarias, alteraciones drásticas en el tipo de cambio, entre otras.
                                    En el caso de que hagamos un cambio o cancelemos un servicio, podemos intentar notificarle poniéndonos en contacto vía correo electrónico y/o dirección de facturación / número de teléfono proporcionado en el momento que se solicitó el servicio. Nos reservamos el derecho de limitar o prohibir los servicios que, a nuestro juicio, parecen ser colocados por los concesionarios, revendedores o distribuidores.
                                    Te comprometes a proporcionar información actual, completa y precisa. Te comprometes a actualizar rápidamente tu cuenta y otra información, incluyendo tu dirección de correo electrónico y números de contacto para que podamos validar tus servicios y cuenta y contactarte cuando sea necesario.<br><br>

                                    <h6>Sección 7 – Enlaces de terceras partes</h6>
                                    Cierto contenido y servicios disponibles vía nuestro Servicio puede incluir material de terceras partes.
                                    Enlaces de terceras partes en este sitio pueden redireccionarse a sitios web de terceras partes que no están afiliadas con nosotros. No nos responsabilizamos de examinar o evaluar el contenido o exactitud y no garantizamos ni tendremos ninguna obligación o responsabilidad por cualquier material de terceros o sitios web, o de cualquier material, productos o servicios de terceros.
                                    No nos hacemos responsables de cualquier daño o daños relacionados con la adquisición o utilización de bienes, servicios, recursos, contenidos, o cualquier otra transacción realizadas en conexión con sitios web de terceros. Por favor revisa cuidadosamente las políticas y prácticas de terceros y asegúrate de entenderlas antes de participar en cualquier transacción. Quejas, reclamos, inquietudes o preguntas con respecto a productos de terceros deben ser dirigidas a la tercera parte.<br><br>

                                    <h6>Sección 8 – Comentarios de usuarios, captación y prestación</h6>
                                    Si, a pedido nuestro, envías ciertas presentaciones específicas (por ejemplo la participación en concursos) o sin un pedido de nuestra parte envías ideas creativas, sugerencias, proposiciones, planes, u otros materiales, ya sea en línea, por email, por correo postal, o de otra manera (colectivamente, ‘comentarios’), aceptas que podamos, en cualquier momento, sin restricción, editar, copiar, publicar, distribuir, traducir o utilizar por cualquier medio comentarios que nos hayas enviado. No tenemos ni tendremos ninguna obligación (1) de mantener ningún comentario confidencialmente; (2) de pagar compensación por comentarios; o (3) de responder a comentarios.
                                    Nosotros podemos, pero no tenemos obligación de, monitorear, editar o remover contenido que consideremos sea ilegítimo, ofensivo, amenazante, calumnioso, difamatorio, pornográfico, obsceno u objetable o viole la propiedad intelectual de cualquiera de las partes o los Términos de Servicio.
                                    Aceptas que tus comentarios no violará los derechos de terceras partes, incluyendo derechos de autor, marca, privacidad, personalidad u otro derechos personal o de propiedad. Asimismo, aceptas que tus comentarios no contienen material difamatorio o ilegal, abusivo u obsceno, o contienen virus informáticos u otro malware que pudiera, de alguna manera, afectar el funcionamiento del Servicio o de cualquier sitio web relacionado. No puedes utilizar una dirección de correo electrónico falsa, usar otra identidad que no sea legítima, o engañar a terceras partes o a nosotros en cuanto al origen de tus comentarios. Tu eres el único responsable por los comentarios que haces y su precisión. No nos hacemos responsables y no asumimos ninguna obligación con respecto a los comentarios publicados por ti o cualquier tercer parte.<br><br>

                                    <h6>Sección 9 – Información personal</h6>
                                    Tu presentación de información personal a través del sitio se rige por nuestra Política de Privacidad. Para ver nuestro Aviso de Privacidad, deberás acceder a nuestro sitio web donde se indicará dicha información.<br><br>

                                    <h6>Sección 10 – Errores, inexactitudes y omisiones</h6>
                                    De vez en cuando puede haber información en nuestro sitio o en el Servicio que contiene errores tipográficos, inexactitudes u omisiones que puedan estar relacionadas con las descripciones de servicios, precios, promociones, ofertas, y la disponibilidad. Nos reservamos el derecho de corregir los errores, inexactitudes u omisiones y de cambiar o actualizar la información si alguna información en el Servicio o en cualquier sitio web relacionado es inexacta en cualquier momento sin previo aviso.<br><br>

                                    <h6>Sección 11 – Usos prohibidos</h6>
                                    En adición a otras prohibiciones como se establece en los Términos de Servicio, se prohíbe el uso del sitio o su contenido: (a) para ningún propósito ilegal; (b) para pedirle a otros que realicen o participen en actos ilícitos; (c) para violar cualquier regulación, reglas, leyes internacionales, federales, provinciales o estatales, u ordenanzas locales; (d) para infringir o violar el derecho de propiedad intelectual nuestro o de terceras partes; (e) para acosar, abusar, insultar, dañar, difamar, calumniar, desprestigiar, intimidar o discriminar por razones de género, orientación sexual, religión, etnia, raza, edad, nacionalidad o discapacidad; (f) para presentar información falsa o engañosa; (g) para cargar o transmitir virus o cualquier otro tipo de código malicioso que sea o pueda ser utilizado en cualquier forma que pueda comprometer la funcionalidad o el funcionamiento del Servicio o de cualquier sitio web relacionado, otros sitios o Internet; (h) para recopilar o rastrear información personal de otros; (i) para generar spam, phish, pharm, pretext, spider, crawl, or scrape; (j) para cualquier propósito obsceno o inmoral; o (k) para interferir con o burlar los elementos de seguridad del Servicio o cualquier sitio web relacionado u otros sitios o Internet. Nos reservamos el derecho de suspender el uso del Servicio o de cualquier sitio web relacionado por violar cualquiera de los ítems de los usos prohibidos.<br><br>

                                    <h6>Sección 12 – Exclusión de garantías; limitación de responsabilidad</h6>
                                    No garantizamos ni aseguramos que el uso de nuestro servicio será ininterrumpido, puntual, seguro o libre de errores.
                                    No garantizamos que los resultados que se puedan obtener del uso del servicio serán exactos o confiables.
                                    Aceptas que de vez en cuando podemos quitar el servicio por períodos de tiempo indefinidos o cancelar el servicio en cualquier momento sin previo aviso.
                                    Aceptas expresamente que el uso de, o la posibilidad de utilizar, el servicio es bajo tu propio riesgo. El servicio y todos los productos y servicios proporcionados a través del servicio son (salvo lo expresamente manifestado por nosotros) proporcionados «tal cual» y «según esté disponible» para su uso, sin ningún tipo de representación, garantías o condiciones de ningún tipo, ya sea expresa o implícita, incluidas todas las garantías o condiciones implícitas de comercialización, calidad comercializable, la aptitud para un propósito particular, durabilidad, título y no infracción.
                                    En ningún caso ASUAVETA, nuestros directores, funcionarios, empleados, afiliados, agentes, contratistas, internos, proveedores, prestadores de servicios o licenciantes serán responsables por cualquier daño, pérdida, reclamo, o daños directos, indirectos, incidentales, punitivos, especiales o consecuentes de cualquier tipo, incluyendo, sin limitación, pérdida de beneficios, pérdida de ingresos, pérdida de ahorros, pérdida de datos, costos de reemplazo, o cualquier daño similar, ya sea basado en contrato, agravio (incluyendo negligencia), responsabilidad estricta o de otra manera, como consecuencia del uso de cualquiera de los servicios o productos adquiridos mediante el servicio, o por cualquier otro reclamo relacionado de alguna manera con el uso del servicio o cualquier producto, incluyendo pero no limitado, a cualquier error u omisión en cualquier contenido, o cualquier pérdida o daño de cualquier tipo incurridos como resultados de la utilización del servicio o cualquier contenido (o producto) publicado, transmitido, o que se pongan a disposición a través del servicio, incluso si se avisa de su posibilidad. Nuestra responsabilidad se limitará en la medida máxima permitida por la ley.<br><br>

                                    <h6>Sección 13 – Indemnización</h6>
                                    Aceptas indemnizar, defender y mantener indemne ASUAVETA y nuestras matrices, subsidiarias, afiliados, socios, funcionarios, directores, agentes, contratistas, concesionarios, proveedores de servicios, subcontratistas, proveedores, internos y empleados, de cualquier reclamo o demanda, incluyendo honorarios razonables de abogados, hechos por cualquier tercero a causa o como resultado de tu incumplimiento de las Condiciones de Servicio o de los documentos que incorporan como referencia, o la violación de cualquier ley o de los derechos de un tercero.<br><br>

                                    <h6>Sección 14 – Divisibilidad</h6>
                                    En el caso de que se determine que cualquier disposición de estas Condiciones de Servicio sea ilegal, nula o inejecutable, dicha disposición será, no obstante, efectiva a obtener la máxima medida permitida por la ley aplicable, y la parte no exigible se considerará separada de estos Términos de Servicio, dicha determinación no afectará la validez de aplicabilidad de las demás disposiciones restantes.<br><br>

                                    <h6>Sección 15 – Rescisión</h6>
                                    Las obligaciones y responsabilidades de las partes que hayan incurrido con anterioridad a la fecha de terminación sobrevivirán a la terminación de este acuerdo a todos los efectos.
                                    Estas Condiciones de servicio son efectivos a menos que y hasta que sea terminado por ti o nosotros. Puedes terminar estos Términos de Servicio en cualquier momento por avisarnos que ya no deseas utilizar nuestros servicios, o cuando dejes de usar nuestro sitio.
                                    Si a nuestro juicio, fallas, o se sospecha que haz fallado, en el cumplimiento de cualquier término o disposición de estas Condiciones de Servicio, también podemos terminar este acuerdo en cualquier momento sin previo aviso, y seguirás siendo responsable de todos los montos adeudados hasta incluida la fecha de terminación; y/o en consecuencia podemos negar el acceso a nuestros servicios (o cualquier parte del mismo).<br><br>

                                    <h6>Sección 16 – Acuerdo completo</h6>
                                    Nuestra falla para ejercer o hacer valer cualquier derecho o disposición de estas Condiciones de Servicio no constituirá una renuncia a tal derecho o disposición.
                                    Estas Condiciones del servicio y las políticas o reglas de operación publicadas por nosotros en este sitio o con respecto al servicio constituyen el acuerdo completo y el entendimiento entre tú y nosotros y rigen el uso del Servicio y reemplaza cualquier acuerdo, comunicaciones y propuestas anteriores o contemporáneas, ya sea oral o escrita, entre tu y nosotros (incluyendo, pero no limitado a, cualquier versión previa de los Términos de Servicio).
                                    Cualquier ambigüedad en la interpretación de estas Condiciones del servicio no se interpretarán en contra del grupo de redacción.<br><br>

                                    <h6>Sección 17 – Cambios en los términos de servicio</h6>
                                    Puedes revisar la versión más actualizada de los Términos de Servicio en cualquier momento en esta página.
                                    Nos reservamos el derecho, a nuestra sola discreción, de actualizar, modificar o reemplazar cualquier parte de estas Condiciones del servicio mediante la publicación de las actualizaciones y los cambios en nuestro sitio web. Es tu responsabilidad revisar nuestro sitio web periódicamente para verificar los cambios. El uso continuo de o el acceso a nuestro sitio Web o el Servicio después de la publicación de cualquier cambio en estas Condiciones de servicio implica la aceptación de dichos cambios.<br><br>

                                    <h6>Sección 18 – Información de contacto</h6>
                                    Preguntas acerca de los Términos de Servicio deben ser enviadas a atencionalcliente.asuaveta@gmail.com.
                                    Última actualización de este documento de términos y condiciones: 21/08/2021
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <!--Fin de términos y condiciones-->
                    <?php endif ?>


                    <?php if (isset($_GET['privacidad'])) : ?>
                        <!--Términos y condiciones-->
                        <div class="card-body">
                            <div class="row">
                                <div class="modal-body text-justify">
                                    <strong>AVISO DE PRIVACIDAD INTEGRAL</strong><br>
                                    Última actualización 21 de agosto de 2021 <br><br>

                                    <h6>Aviso de privacidad integral</h6>
                                    ASUAVETA mejor conocido como Acueducto Público Rural La Veta, con sede principal en Vda La Veta, Cocorná, Antioquia, Colombia y portal de internet Sitio web ASUAVETA, es el responsable del uso y protección de sus datos personales, y al respecto le informamos lo siguiente:<br><br>
                                    <h6>¿Para qué fines utilizaremos sus datos personales?</h6>
                                    Los datos personales que recabamos de usted, los utilizaremos para las siguientes finalidades que son necesarias para el servicio que solicita:<br>
                                    -Respuesta a mensajes del formulario de contacto<br>
                                    -Prestación de cualquier servicio solicitado<br>
                                    -Servicio de atención vía telefónica<br><br>

                                    <h6>¿Qué datos personales utilizaremos para estos fines?</h6>
                                    Para llevar a cabo las finalidades descritas en el presente aviso de privacidad, utilizaremos los siguientes datos personales:<br>
                                    Datos de identificación y contacto, Datos biométricos, Datos laborales, Datos migratorios, Datos patrimoniales y/o financieros.<br><br>

                                    <h6>¿Cómo puede acceder, rectificar o cancelar sus datos personales, u oponerse a su uso o ejercer la revocación de consentimiento?</h6>
                                    Usted tiene derecho a conocer qué datos personales tenemos de usted, para qué los utilizamos y las condiciones del uso que les damos (Acceso). Asimismo, es su derecho solicitar la corrección de su información personal en caso de que esté desactualizada, sea inexacta o incompleta (Rectificación); que la eliminemos de nuestros registros o bases de datos cuando considere que la misma no está siendo utilizada adecuadamente (Cancelación); así como oponerse al uso de sus datos personales para fines específicos (Oposición). Estos derechos se conocen como derechos ARCO.
                                    Para el ejercicio de cualquiera de los derechos ARCO, debe enviar una petición vía correo electrónico a atencionalcliente.asuaveta@gmail.com y deberá contener:<br>
                                    • Nombre completo del titular.<br>
                                    • Domicilio.<br>
                                    • Teléfono.<br>
                                    • Correo electrónico usado en este sitio web.<br>
                                    • Copia de una identificación oficial adjunta.<br>
                                    • Asunto «Derechos ARCO»<br><br>
                                    <h6>Descripción el objeto del escrito</h6> Los cuales pueden ser de manera enunciativa más no limitativa los siguientes:<br>Revocación del consentimiento para tratar sus datos personales; y/o Notificación del uso indebido del tratamiento de sus datos personales; y/o Ejercitar sus Derechos ARCO, con una descripción clara y precisa de los datos a Acceder, Rectificar, Cancelar o bien, Oponerse. En caso de Rectificación de datos personales, deberá indicar la modificación exacta y anexar la documentación soporte; es importante en caso de revocación del consentimiento, que tenga en cuenta que no en todos los casos podremos atender su solicitud o concluir el uso de forma inmediata, ya que es posible que por alguna obligación legal requiramos seguir tratando sus datos personales. Asimismo, usted deberá considerar que para ciertos fines, la revocación de su consentimiento implicará que no le podamos seguir prestando el servicio que nos solicitó, o la conclusión de su relación con nosotros.<br><br>
                                    <h6>¿En cuántos días le daremos respuesta a su solicitud?</h6>
                                    20 días hábiles<br><br>
                                    <h6>¿Por qué medio le comunicaremos la respuesta a su solicitud?</h6>
                                    Al mismo correo electrónico de donde se envió la petición.<br><br>

                                    <h6>El uso de tecnologías de rastreo en nuestro portal de internet</h6>
                                    Le informamos que en nuestro sitio de internet es posible que utilicemos cookies, web beacons u otras tecnologías, a través de las cuales es posible monitorear su comportamiento como usuario de internet, así como brindarle un mejor servicio y experiencia al navegar en nuestra página. Los datos personales que obtenemos de estas tecnologías de rastreo son los siguientes:
                                    Identificadores, nombre de usuario y contraseñas de sesión
                                    Estas cookies, web beacons y otras tecnologías pueden ser deshabilitadas. Para conocer cómo hacerlo, consulte el menú de ayuda de su navegador. Tenga en cuenta que, en caso de desactivar las cookies, es posible que no pueda acceder a ciertas funciones personalizadas en nuestros sitio web.<br><br>

                                    <h6>¿Cómo puede conocer los cambios en este aviso de privacidad?</h6>
                                    El presente aviso de privacidad puede sufrir modificaciones, cambios o actualizaciones derivadas de nuevos requerimientos legales; de nuestras propias necesidades por los productos o servicios que ofrecemos; de nuestras prácticas de privacidad; de cambios en nuestro modelo de negocio, o por otras causas. Nos comprometemos a mantener actualizado este aviso de privacidad sobre los cambios que pueda sufrir y siempre podrá consultar las actualizaciones que existan en el sitio web ASUAVETA.
                                    Última actualización de este aviso de privacidad: 21/08/2021
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <!--Fin de términos y condiciones-->
                    <?php endif ?>
                    <!--Más contenido aquí -->





                </div>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>