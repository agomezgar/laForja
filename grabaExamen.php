<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();


$alumno=$_POST['alumno'];
$instrumento=$_POST['instrumento'];
$nota=$_POST['nota'];
$nombreTablaExamenes=$_POST['nombreTablaExamenes'];
//echo $nombreTablaExamenes[0];

foreach ($nota as $key=>$n){
if (!is_numeric($nota[$key])){
if($nota[$key]==""){
continue;
}
die ("Sólo se admiten notas numéricas");
}
if ($nota[$key]>10){
die("No se pueden poner notas superiores a 10");
}
}
foreach ($nota as $key=>$n){
if ($nota[$key]==""){
continue;
}

$sql = "INSERT INTO $nombreTablaExamenes[$key] ( `alumno`, `instrumento`, `nota`) VALUES ($alumno[$key],$instrumento[$key],$nota[$key])";
mysqli_query($link,$sql) or die(mysqli_error($link)); 
}
echo "<meta http-equiv=\"refresh\" content=\"0;URL=seleccionar.php\">";
?>
