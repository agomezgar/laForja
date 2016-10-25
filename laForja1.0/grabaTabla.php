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
//echo $tabla;
$vaciaTabla=mysqli_query($link,"DROP TABLE IF EXISTS $tabla")or die ("Error borrando la tabla previa");
$creaTabla="
CREATE TABLE IF NOT EXISTS $tabla (
`id` int NOT NULL AUTO_INCREMENT,
  `contenido` int(3) NOT NULL,
  `instrumento` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `trimestre` int(2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
$generaTabla=mysqli_query($link,$creaTabla) or die (mysqli_error($link));
foreach ($criterio as $key=>$n){

echo "<p>".$contenido[$key]." ".$criterio[$key]." ".$trimestre[$key]." ";
$criterioTraducido=utf8_decode($criterio[$key]);
$sql = "INSERT INTO ".$tabla." ( `contenido`, `instrumento`, `trimestre`) VALUES ('$contenido[$key]','$criterioTraducido','$trimestre[$key]')";
      
   
mysqli_query($link,$sql) or die(mysqli_error($link)); 
 
  
 mysqli_free_result;
}
$nombreTablaEstandares=$materia."organizacionestandares".$curso;
$vaciaTabla=mysqli_query($link,"DROP TABLE IF EXISTS $nombreTablaEstandares")or die ("Error borrando la tabla previa");
$creaOrganizaEstandares="
CREATE TABLE IF NOT EXISTS $nombreTablaEstandares (
`id` int NOT NULL AUTO_INCREMENT,
  `prioridad` int(2) NOT NULL,
`idestandar` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
`idinstrumento` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `trimestre` int(2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
$generaTabla=mysqli_query($link,$creaOrganizaEstandares) or die (mysqli_error($link));
mysqli_free_result;
$nombreTablaNotas=$materia."notas".$curso;
$vaciaTabla=mysqli_query($link,"DROP TABLE IF EXISTS $nombreTablaNotas")or die ("Error borrando la tabla previa");
$creaTablaNotas="
CREATE TABLE IF NOT EXISTS $nombreTablaNotas (
`id` int NOT NULL AUTO_INCREMENT,
`alumno` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
`instrumento` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nota` int(2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
$generaTabla=mysqli_query($link,$creaTablaNotas) or die (mysqli_error($link));
mysqli_free_result;
echo "hecho...comprueba...";
echo "Curso: ".$curso;
echo "<meta http-equiv=\"refresh\" content=\"0;URL=organizaEstandares.php\">";

?>
