<?php
session_start();
  include("conectarse.php");
   $link=Conectarse();
 $profesor=$_POST["profesor"];
$materia=$_POST["materia"];
$curso=$_POST["curso"];
$buscaProfe=mysqli_query($link,"SELECT * FROM profesorespormateria WHERE nombre='$profesor' AND materia='$materia'")or die (mysqli_error($link));
if( mysqli_num_rows($buscaProfe)>0){
echo "1";
}else{
echo "0";
}

?>

