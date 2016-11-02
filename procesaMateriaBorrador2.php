<?php
 include('conectarse.php');

 if(isset($_POST["materia"]))
 {  
$curso= $_POST["curso"];
   $link=Conectarse();
$nombreMateria=$_POST["materia"];
$opcionesContenidos="";
$nombreTablaEstandares="estandares".$nombreMateria;
$nombreTablaInstrumentos=$materia."Instrumentos".$curso;
 $result = mysqli_query($link,"SELECT * FROM $nombreTablaEstandares where curso=$curso")or die ("No hay estandares registrados para esa materia");
$totalFilas    =    mysqli_num_rows($result);  
if ($totalFilas>0){
$vaciaTabla=mysqli_query($link,"DROP TABLE IF EXISTS $nombreTablaInstrumentos")or die ("Error borrando la tabla previa");
$creaTabla="
CREATE TABLE IF NOT EXISTS $nombreTablaInstrumentos (
`id` int NOT NULL AUTO_INCREMENT,
  `contenido` int(3) NOT NULL,
  `instrumento` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `trimestre` int(2) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
$generaTabla=mysqli_query($link,$creaTabla) or die (mysqli_error($link));
}
else{
echo "No hay estandares de esa materia registrados para ese curso en particular";
}

 }
?>
