<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="./js/jquery-3.1.1.min.js"></script>
<script src="./scriptComplementario.js" language="javascript"></script>
<script>
$(document).ready(function(){
 
});
</script>
<?php require ('config.php'); ?>
</head>
<body>

<?php
session_start();
include("conectarse.php");
  $link=Conectarse();
$trimestre=$_POST['trimestre'];
$nombreTablaInstrumentos=$_SESSION['tablaInstrumentos'];
$nombreTablaEstandares= $_SESSION['tablaEstandares'];
$curso= $_SESSION['curso'];
//echo $trimestre;
//echo $nombreTablaEstandares;
if ($trimestre=="4"){echo "<meta http-equiv=\"refresh\" content=\"0;URL=seleccionar.php\">";}
?>
<table border="1">
<tr><td>Bloque</td><td>Trimestre</td><td>Estandar</td><td>Prioridad</td><td>Instrumento de evaluación</td><td>Competencias afectadas</td></tr>
<?php

$buscaContenidos=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE curso='$curso'");
$cuentaContenidos=0;
while($encuentraContenidos = mysqli_fetch_array($buscaContenidos)) {
$id=$encuentraContenidos['id'];
$bloque=$encuentraContenidos['bloque'];
$estandar=$encuentraContenidos['estandar'];
$contenidoSel = substr($id, -3, 1);
$buscaContenidosporTrimestre=mysqli_query($link,"SELECT DISTINCT contenido FROM $nombreTablaInstrumentos WHERE trimestre='$trimestre'");
while($encuentraContenidosporTrimestre = mysqli_fetch_array($buscaContenidosporTrimestre)) {
if ($encuentraContenidosporTrimestre[0]==$contenidoSel){
$cuentaContenidos++;
switch ($trimestre) {
    case 1:
	$cadena="<select id=\"nTrim[$cuentaContenidos]\" class=\"$cuentaContenidos\">
<option value=\"\"></option>
<option value=1 selected='selected'>1</option>
<option value=2>2</option>
<option value=3>3</option></select>";
  
        break;
    case 2:
	$cadena="<select id=\"nTrim[$cuentaContenidos]\" class=\"$cuentaContenidos\">
<option value=\"\"></option>
<option value=1>1</option>
<option value=2 selected='selected'>2</option>
<option value=3>3</option></select>";
        break;
    case 3:
	$cadena="<select id=\"nTrim[$cuentaContenidos]\" class=\"$cuentaContenidos\">
<option value=\"\"></option>
<option value=1>1</option>
<option value=2>2</option>
<option value=3 selected='selected'>3</option></select>";
        break;
}

echo "<tr><td><input type=\"hidden\" class=\"$cuentaContenidos\" name=\"idEst[$cuentaContenidos]\" value=\"$id\">".utf8_encode($bloque)."</td><td>$cadena
</td>


<td>".utf8_encode($estandar)."</td>
<td>
<select id=\"priorEst[$cuentaContenidos]\" class=\"$cuentaContenidos\">
<option value=4 selected='selected'></option>
<option value=1 >Básico</option>
<option value=2>Intermedio</option>
<option value=3 >Avanzado</option></select>
</td>
<td>";
$buscaInstrumentos=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE trimestre=$trimestre AND contenido=".$encuentraContenidosporTrimestre['contenido']);
$cont=1; 
while($encuentraInstrumentos = mysqli_fetch_array($buscaInstrumentos)) {
echo"<p> <input type=\"checkbox\" id=\"instru\" name=\"".$encuentraInstrumentos['id']."\" class=\"$cuentaContenidos\">".utf8_encode($encuentraInstrumentos['instrumento'])."</p>";
$cont++;
}
echo "</td><td>";
//Busca competencias
$comp=mysqli_query($link,"SELECT * FROM competencias")or die (mysqli_error($link));
while($compet=mysqli_fetch_array($comp)){
echo "<input type=\"checkbox\" name=\"$id\" class=\"competencia\" value=\"".$compet['id']."\">".$compet['codigo']."<br>";
//echo $compet['competencia'];
}
echo "</td></tr>";}
}
}
?>
</table>

</body>
</html>
