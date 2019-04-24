<?php
require_once("core/configuracion.php");
require_once("core/baseDatos.php");
require_once("core/funcionesBase.php");
include_once("core/question.php");
include_once("core/new_question.php");

$objBD = new baseDatos($config['host'],$config['baseDatos'],$config['nombreUsuario'],$config['clave']);

if(isset($_GET['correcta'])){
    $puntaje_actual = $objBD->leer("perfil_usuario","puntaje",array("id_usuario" => $_GET['id_usuario']))[0];
    if($puntaje_actual['puntaje'] < $_GET['puntaje']){
        $objBD->consulta_personalizada("Update perfil_usuario SET puntaje = ".$_GET['puntaje']." WHERE id_usuario = ".$_GET['id_usuario']);
    }
}
elseif(isset($_GET['incorrecta'])){
    $puntaje_actual = $objBD->leer("perfil_usuario","puntaje",array("id_usuario" => $_GET['id_usuario']))[0];
    if($puntaje_actual['puntaje'] < $_GET['puntaje']){
        $objBD->consulta_personalizada("Update perfil_usuario SET puntaje = ".$_GET['puntaje']." WHERE id_usuario = ".$_GET['id_usuario']);
    }
    session_unset();
    $q->resetAllQuestions();
}
?>