<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();

$grupo=utf8_decode($_POST['grupo']);

$trimestre=$_POST['trimestre'];
$materia=$_POST['materia'];
$curso=$_POST['curso'];
$instrumento=$_POST['instrumento'];
$nombreTablaInstrumentos=$materia."Instrumentos".$curso;
$nombreTablaExamenes=$materia."notas".$curso;

//echo $grupo.$materia.$trimestre.$curso;
$cuenta=0;
$sql=mysqli_query($link,"SELECT * FROM matriculas WHERE grupo='$grupo' ORDER BY apellidos")or die (mysqli_error($link));
echo"<form id=\"notas\" name=\"notas\" method=\"post\" action=\"grabaExamen.php\">";
echo "<table>";
while($encuentraAlumnos = mysqli_fetch_array($sql)) {
$alumno=$encuentraAlumnos['alumno'];
echo "<tr><td>".utf8_encode($encuentraAlumnos['apellidos']).", ".utf8_encode($encuentraAlumnos['nombre'])."</td><td>
<input type=\"text\" name=\"nota[$cuenta]\" value=\"\"><input type=\"hidden\" name=\"alumno[$cuenta]\" class=\"nota\" value=\"$alumno\"><input type=\"hidden\" name=\"instrumento[$cuenta]\" value=\"$instrumento\"><input type=\"hidden\" name=\"nombreTablaExamenes[$cuenta]\" value=\"$nombreTablaExamenes\"></td></tr>";
$cuenta++;
}
echo "</table> <input type=\"submit\" id=\"grabar\" value=\"Grabar\">";



?>
