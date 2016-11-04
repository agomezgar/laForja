<?php
session_start();
  include("conectarse.php");
   $link=Conectarse();

$materia=$_POST["materia"];
$curso=$_POST["curso"];
$tabla=$materia."organizacionestandares".$curso;
//echo $tabla;
$buscaMateria=mysqli_query($link,"SELECT idinstrumento FROM $tabla");
$row = mysqli_fetch_array($buscaMateria);
if( $row){
echo "1";
}else{
echo "0";
}

?>

