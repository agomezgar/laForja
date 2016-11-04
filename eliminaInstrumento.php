<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();

$instrumento=$_POST['instrumento'];
$materia=$_POST['materia'];
$curso=$_POST['curso'];
$tablaNotas=$materia."notas".$curso;
$tablaInstrumentos=$materia."Instrumentos".$curso;
$tablaEstandares=$materia."organizacionestandares".$curso;

$borra="DELETE FROM ".$tablaInstrumentos." WHERE id='$instrumento'";
mysqli_query($link,$borra)or die (mysqli_error($link));
$borra="DELETE FROM ".$tablaEstandares." WHERE idinstrumento='$instrumento'";
mysqli_query($link,$borra)or die (mysqli_error($link));
$borra="DELETE FROM ".$tablaNotas." WHERE instrumento='$instrumento'";
mysqli_query($link,$borra)or die (mysqli_error($link));
mysqli_free_result();
?>
