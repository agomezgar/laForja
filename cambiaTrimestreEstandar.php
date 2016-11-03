<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();

$curso=$_POST['curso'];
$materia=$_POST['materia'];
$trimestre=$_POST['trimestre'];
$estandar=$_POST['estandar'];


//$nombre=$_SESSION['profesor'];
$nombreTablaInstrumentos=$materia."Instrumentos".$curso;
$nombreTablaOrganizacionEstandares=$materia."organizacionestandares".$curso;
$nombreTablaEstandares="estandares".$materia;

//Buscamos el estandar a cambiar
$buscaEstandar=mysqli_query($link,"SELECT * FROM $nombreTablaOrganizacionEstandares WHERE idestandar=$estandar");
while ($encuentraEstandar=mysqli_fetch_array($buscaEstandar)){
$idInstrumento=$encuentraEstandar['idinstrumento'];
$prioridad=$encuentraEstandar['prioridad'];
$nombreInstrumento=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE id=$idInstrumento");
while($encNombInst=mysqli_fetch_array($nombreInstrumento)){
$textoInstrumento=$encNombInst['instrumento'];
$contenido=$encNombInst['contenido'];
$sql = "INSERT INTO $nombreTablaInstrumentos (contenido, instrumento, trimestre)
VALUES ('$contenido', '".utf8_encode($textoInstrumento)."', '$trimestre')";
if (mysqli_query($link,$sql)){

$nuevoIdInstrumento=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos ORDER BY id DESC LIMIT 1");
while($nuevaId=mysqli_fetch_array($nuevoIdInstrumento)){
echo "El instrumento ".utf8_encode($textoInstrumento)." correspondiente al contenido".$contenido."se ha añadido al trimestre ".$trimestre;
$nuevaIdInstrumento=$nuevaId['id'];
echo " con la id ". $nuevaIdInstrumento;
$borraEstandar="DELETE FROM $nombreTablaOrganizacionEstandares WHERE idestandar = '$estandar'";
mysqli_query($link,$borraEstandar) or die ("Error. No se ha podido mover el estandar de sitio");
$sumaEstandar="INSERT INTO $nombreTablaOrganizacionEstandares (prioridad, idestandar,idinstrumento, trimestre)
VALUES ('$prioridad', '$estandar', '$nuevaIdInstrumento','$trimestre')";
mysqli_query($link,$sumaEstandar) or die ("Error. No se ha podido mover el estandar al nuevo trimestre".mysqli_error($link));
}
}
}
}

?>
