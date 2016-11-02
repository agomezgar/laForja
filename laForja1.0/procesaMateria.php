<script src="./js/scriptComplementario.js" language="javascript"></script>
<?php
session_start();
 include('conectarse.php');

 if(isset($_POST["materia"]))
 {  
$curso= $_POST["curso"];
$_SESSION['curso']=$curso;
   $link=Conectarse();
$nombreMateria=$_POST["materia"];

$_SESSION['materia']=$nombreMateria;
$nombreProfesor=$_SESSION['profesor'];
$opcionesContenidos="";
$nombreTablaEstandares="estandares".$nombreMateria;
$_SESSION['tablaEstandares']=$nombreTablaEstandares;
//echo $_SESSION['tablaInstrumentos'];
$nombreTablaInstrumentos=$nombreMateria."Instrumentos".$curso;
$_SESSION['tablaInstrumentos']=$nombreTablaInstrumentos;
 $result = mysqli_query($link,"SELECT * FROM $nombreTablaEstandares where curso=$curso")or die ("No hay estandares registrados para esa materia");
//Comprobamos si existe la tabla de competencias de esa materia
$nombreCompetenciasMateria="competencias".$nombreMateria;
$sql=mysqli_query($link,"SELECT id FROM $nombreCompetenciasMateria");
if (empty($sql)){
$creaTabla="
CREATE TABLE `$nombreCompetenciasMateria` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `curso` int(2) NOT NULL,
  `contenido` int (3) NOT NULL,
`competencia` int (3) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
$resultado=mysqli_query($link,$creaTabla) or die(mysqli_error($link));
}else{
mysqli_query($link,"DELETE FROM $nombreCompetenciasMateria WHERE curso=$curso") or die (mysqli_error($link));
}
$totalFilas    =    mysqli_num_rows($result);  
if ($totalFilas>0){
//Incluimos al profesor que redacta la programación como profesor por defecto de esta materia

$sql = "INSERT INTO profesorespormateria (`nombre`, `materia`) VALUES ('$nombreProfesor','$nombreMateria')";   
mysqli_query($link,$sql) or die(mysqli_error($link)); 
 mysqli_free_result;
//Creamos tabla que relaciona contenidos e instrumentos
$tabla=$_SESSION['tablaInstrumentos'];
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
//Generamos la tabla de notas
$nombreTablaNotas=$nombreMateria."notas".$curso;
$vaciaTabla=mysqli_query($link,"DROP TABLE IF EXISTS $nombreTablaNotas")or die ("Error borrando la tabla previa");
$creaTablaNotas="
CREATE TABLE IF NOT EXISTS $nombreTablaNotas (
`id` int NOT NULL AUTO_INCREMENT,
`alumno` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
`instrumento` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nota` float(2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
$generaTabla=mysqli_query($link,$creaTablaNotas) or die (mysqli_error($link));
mysqli_free_result;
//Creamos la tabla de relación estándares-instrumentos

$nombreTablaEstandares2=$nombreMateria."organizacionestandares".$curso;
$vaciaTabla2=mysqli_query($link,"DROP TABLE IF EXISTS $nombreTablaEstandares2")or die ("Error borrando la tabla previa");
$creaOrganizaEstandares="
CREATE TABLE IF NOT EXISTS $nombreTablaEstandares2 (
`id` int NOT NULL AUTO_INCREMENT,
  `prioridad` int(2) NOT NULL,
`idestandar` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
`idinstrumento` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `trimestre` int(2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
$generaTabla=mysqli_query($link,$creaOrganizaEstandares) or die ("Error borrando la tabla de relación de estandares");
mysqli_free_result;
$buscaContenidos=mysqli_query($link,"SELECT DISTINCT bloque FROM $nombreTablaEstandares WHERE curso='$curso'")or die (mysqli_error($link));
 $nCont=0;
//echo"<form id=\"criterios\" name=\"criterios\" method=\"post\" action=\"grabaTabla.php\">";
echo"<h1>Seleccione instrumentos de evaluación para cada bloque de contenidos y trimestre</h1>";

while($encuentraContenidos = mysqli_fetch_array($buscaContenidos)) {
$nCont++;
$numeroInstrumentos="numeroInstrumentos".$nCont;
echo "<h2>".utf8_encode($encuentraContenidos[0])."</h2>";
echo "<table><tr><td>Seleccione trimestre <select id=\"trim".$nCont."\" class=\"trim\"><option value=\"\"></option>
<option value=\"1\">1</option>
<option value=\"2\">2</option>
<option value=\"3\">3</option></select></td>";
echo "<td>Seleccione nº de intrumentos <select name=\"".$nCont."\" class=\"nInst\"";

//onChange=generaTabla('$numeroInstrumentos','$nCont'".")
echo"><option value=\"\"></option>";
for ($i=1;$i<10;$i++){
echo "<option value=\"$i\">$i</option>";
}
echo"</select></td>";


echo"</tr></table><div id=\"Tabla".$nCont."\"></div>";


}
echo"<div id=\"Cuenta\"></div></div>";

echo"<br><br><input type=\"submit\" id=\"enviar\" name=\"btnSubmit\"value=\"Grabar criterios de evaluacion\" >";
}
else{
echo "No hay estandares de esa materia registrados para ese curso en particular";
}

 }

?>
