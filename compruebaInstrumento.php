<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();

$contenido=$_POST['contenido'];
$criterio=$_POST['criterio'];
$trimestre=$_POST['trimestre'];

$curso=$_SESSION['curso'];
$materia=$_SESSION['materia'];
$tabla=$materia."Instrumentos".$curso;
$criterioTraducido=utf8_decode($criterio);

$sql = mysqli_query($link,"SELECT * FROM $tabla WHERE instrumento='$criterio' AND trimestre=$trimestre") or die (mysqli_error($link));
      
   
if (mysqli_num_rows($sql)>0){
echo "no";
}else{
echo "si";
}
  
 mysqli_free_result;




//echo "<meta http-equiv=\"refresh\" content=\"0;URL=organizaEstandares.php\">";

?>
