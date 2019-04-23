<?php
//Archivo de configuracion global
$config = array();

//Ruta por defecto del sistema
$config['rutaBase'] = "estados_financieros";

//Datos de autenticación de la base de datos
$config['host'] = "localhost";
$config['nombreUsuario'] = "root"; //Usuario
$config['clave'] = strrev(base64_decode("bHFzeW0=")); //Contraseña
$config['baseDatos'] = "estados_financieros";

//Datos de rutas específicas
//Recursos
$config['recursos'] = "/".$config['rutaBase']."/assets/";
//CSS
$config['css'] = $config['recursos']."css/";
//JS
$config['js'] = $config['recursos']."js/";
//Imágenes
$config['img'] = $config['recursos']."img/";
//Subida de archivos
$config['upload'] = $config['recursos']."upload/";

//Carpetas del sistema
$config['core'] = "core/";
$config['home'] = "pages/";
?>