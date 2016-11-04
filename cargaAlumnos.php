<?php
session_start();
  include("conectarse.php");
   $link=Conectarse();

$grupo=utf8_decode($_POST['grupo']);


$cadena="<select name=\"alumno\" id=\"alumno\"><option value=\"\">Seleccionar Alumno</option>";

$buscaAlumnos=mysqli_query($link,"SELECT * FROM matriculas WHERE grupo='$grupo' ORDER BY apellidos")or die (mysqli_error($link));
while($result=mysqli_fetch_array($buscaAlumnos)){
$cadena=$cadena.$result['apellidos'].", ";
$cadena=$cadena."<option value=\"".$result['alumno']."\">".utf8_encode($result['apellidos']).", ".utf8_encode($result['nombre'])."</option>";
}
$cadena=$cadena."</select>";
echo $cadena;
mysqli_free_result;

?>

