<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();
$idNota=$_POST['idNota'];
$valor=$_POST['valor'];
$materia=$_POST['materia'];
$curso=$_POST['curso'];
$tabla=$materia."notas".$curso;
//echo $tabla;
$sql = "UPDATE ".$tabla." SET nota=".$valor." WHERE id=".$idNota;
mysqli_query($link,$sql) or die (mysqli_error($link));
mysqli_free_result();
?>
