<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();

$profesor=$_POST['profesor'];
$materia=$_POST['materia'];


$sql = "INSERT INTO profesorespormateria (`nombre`, `materia`) VALUES ('$profesor','$materia')";
      
   
mysqli_query($link,$sql) or die(mysqli_error($link)); 
 
  
 mysqli_free_result;




//echo "hecho...comprueba...";
//echo "Curso: ".$curso;
//echo "<meta http-equiv=\"refresh\" content=\"0;URL=organizaEstandares.php\">";

?>
