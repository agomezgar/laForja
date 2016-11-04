<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();

$grupo=$_POST['grupo'];

$trimestre=$_POST['trimestre'];
$materia=$_POST['materia'];
$curso=$_POST['curso'];
$nombre=$_SESSION['profesor'];
$nombreTablaInstrumentos=$materia."Instrumentos".$curso;
echo $grupo.$materia.$trimestre.$curso;
$buscaProfe=mysqli_query($link,"SELECT * FROM profesorespormateria WHERE nombre=$nombre and materia=$materia");

$sql=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE trimestre='$trimestre'")or die (mysqli_error($link));
echo "<select><option value=\"\">Indique instrumento de evaluación</option>";
while($encuentraInstrumentos = mysqli_fetch_array($sql)) {
echo "<option value=\"".$encuentraInstrumentos['id']."\">".$encuentraInstrumentos['instrumento']."</option>";
}
echo "</select>";
?>
