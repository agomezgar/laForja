<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();

$contenido=$_POST['contenido'];

$tabla=$_SESSION['tablaInstrumentos'];
$curso=$_SESSION['curso'];
$materia=$_SESSION['materia'];
$criterioTraducido=utf8_encode($criterio);
$borra="DELETE FROM ".$tabla." WHERE contenido=$contenido";
mysqli_query($link,$borra);

?>
