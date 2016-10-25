<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();

$contenido=$_POST['contenido'];
$criterio=$_POST['criterio'];
$trimestre=$_POST['trimestre'];
$tabla=$_SESSION['tablaInstrumentos'];
$curso=$_SESSION['curso'];
$materia=$_SESSION['materia'];
$criterioTraducido=utf8_decode($criterio);

$sql = "INSERT INTO ".$tabla." (`contenido`, `instrumento`, `trimestre`) VALUES ('$contenido','$criterioTraducido','$trimestre')";
      
   
mysqli_query($link,$sql) or die(mysqli_error($link)); 
 
  
 mysqli_free_result;




echo "hecho...comprueba...";
echo "Curso: ".$curso;
//echo "<meta http-equiv=\"refresh\" content=\"0;URL=organizaEstandares.php\">";

?>
