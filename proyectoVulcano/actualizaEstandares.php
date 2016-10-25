<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();
$grabar=$_POST['grabar'];
$prioridad=$_POST['prioridad'];
$idestandar=$_POST['idestandar'];
$idinstrumento=$_POST['idinstrumento'];
$trimestre=$_POST['trimestre'];
$materia=$_SESSION['materia'];
$curso=$_SESSION['curso'];
$nombreTabla=$materia."organizacionestandares".$curso;
if ($prioridad=="4"){
die;
}
echo "Queremos asignar el instrumento ".$idinstrumento." al estandar ".$idestandar." con la prioridad ".$prioridad." para el trimestre ".$trimestre."...";
echo $grabar;
if ($grabar=="true"){
$sql = "INSERT INTO $nombreTabla ( `prioridad`, `idestandar`, `idinstrumento`, `trimestre`) VALUES ($prioridad,$idestandar,$idinstrumento,$trimestre)";
mysqli_query($link,$sql) or die(mysqli_error($link)); 
 }else{
$sql = "DELETE FROM $nombreTabla WHERE `idestandar`='$idestandar' AND `idinstrumento`='$idinstrumento'";
mysqli_query($link,$sql) or die(mysqli_error($link));
}
  
 mysqli_free_result;

?>
