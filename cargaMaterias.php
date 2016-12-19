<?php
session_start();
  include("conectarse.php");
   $link=Conectarse();


$curso=$_POST["curso"];
$opcionesCurso='<option value=\"\">Seleccione materia</option>';
//echo $tabla;
$buscaMateria=mysqli_query($link,"SELECT * FROM materias WHERE curso=$curso ORDER BY materia")or die (mysqli_error($link));
while($row = mysqli_fetch_array($buscaMateria)){
$opcionesCurso.='<option value="'.$row["codigo"].'">'.utf8_encode($row["materia"]).'</option>';
}
echo $opcionesCurso;

?>

