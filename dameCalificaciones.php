<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();

$grupo=utf8_decode($_POST['grupo']);

$trimestre=$_POST['trimestre'];
$materia=$_POST['materia'];
$curso=$_POST['curso'];
$pesoPBasico=0;
$pesoPIntermedio=0;
$pesoPAvanzado=0;
$nombreTablaInstrumentos=$materia."Instrumentos".$curso;
$nombreTablaExamenes=$materia."notas".$curso;
$nombreTablaEstandares=$materia."organizacionestandares".$curso;
$listaEstandares="estandares".$materia;
//echo $nombreTablaEstandares;
//Cargamos peso de prioridades
$prioridad=mysqli_query($link,"SELECT * FROM prioridades");
while($cargaPrioridad=mysqli_fetch_array($prioridad)){
if ($cargaPrioridad['prioridad']=="1"){
$pesoPBasico=($cargaPrioridad['peso'])/100;
}
if ($cargaPrioridad['prioridad']=="2"){
$pesoPIntermedio=($cargaPrioridad['peso'])/100;
}
if ($cargaPrioridad['prioridad']=="3"){
$pesoPAvanzado=($cargaPrioridad['peso'])/100;
}
}
//Contamos los estandares
$sql=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE trimestre='$trimestre' GROUP BY idestandar")or die (mysqli_error($link));
//Ponemos a 0 la cuenta de estándares B,A,I;
$nestandarB=0;
$nestandarA=0;
$nestandarI=0;
while ($buscaEstandares=mysqli_fetch_array($sql)){
//echo $buscaEstandares['prioridad'];
//Contamos el nº de estandares de cada y les asignamos peso, asi como el nº de instrumentos asignado
if ($buscaEstandares['prioridad']=="1"){
$nestandarB++;

}
if ($buscaEstandares['prioridad']=="2"){
$nestandarI++;
}
if ($buscaEstandares['prioridad']=="3"){
$nestandarA++;
}
}
$multBasico=($pesoPBasico/$nestandarB);
$multIntermedio=$pesoPIntermedio/$nestandarI;
$multAvanzado=$pesoPAvanzado/$nestandarA;
echo "Para este trimestre hay asignados ".$nestandarB." estándares básicos (peso ".$pesoPBasico.", les corresponde a cada uno un multiplicador de ".$multBasico."), ".$nestandarI." estándares intermedios (peso ".$pesoPIntermedio.", les corresponde a cada uno un multiplicador de ".$multIntermedio."),  y ".$nestandarA." avanzados (peso ".$pesoPAvanzado."), les corresponde a cada uno un multiplicador de ".$multAvanzado."";
//Preparamos los datos del alumno
$alumno=mysqli_query($link,"SELECT * FROM matriculas WHERE grupo='$grupo' ORDER BY apellidos")or die (mysqli_error($link));
while($encuentraAlumno=mysqli_fetch_array($alumno)){
$idAlumno=$encuentraAlumno['alumno'];
echo "<fieldset><legend><b>".utf8_encode($encuentraAlumno['apellidos']).", ".utf8_encode($encuentraAlumno['nombre'])."</b></legend>";
$notaAcumulada=0;

$buscaInstrumentos=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE trimestre='$trimestre'");
while ($encuentraInstrumentos=mysqli_fetch_array($buscaInstrumentos)){
$inst=$encuentraInstrumentos['id'];
$nombre=$encuentraInstrumentos['instrumento'];

$buscaNotas=mysqli_query($link,"SELECT * FROM $nombreTablaExamenes WHERE alumno=$idAlumno AND instrumento=$inst")or die (mysqli_error($link));
$nota=0;
$cuenta=0;
$notaFinal=0;
if (mysqli_num_rows($buscaNotas)>1){
while($encuentraNotas=mysqli_fetch_array($buscaNotas)){
$nota=$nota+$encuentraNotas['nota'];
$cuenta++;
}
echo "Instrumento: ".utf8_encode($nombre)." (Varias notas) Media: ".$nota/$cuenta."<br>";

}
if (mysqli_num_rows($buscaNotas)==1){
while($encuentraNotas=mysqli_fetch_array($buscaNotas)){
$nota=$encuentraNotas['nota'];

}
echo "Instrumento: ".utf8_encode($nombre)." Nota: ".$nota."<br>";

}
}
$sql=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE trimestre='$trimestre' GROUP BY idestandar ")or die (mysqli_error($link));
while($buscaSql=mysqli_fetch_array($sql)){
$notaEstandar=0;
$numeroInstrumentos=0;

$idEstandarAplicada=$buscaSql['prioridad'];
$est=mysqli_query($link,"SELECT estandar FROM $listaEstandares WHERE id=".$buscaSql['idestandar'])or die (mysqli_error($link));
while($dameEst=mysqli_fetch_array($est)){
echo "<fieldset>".utf8_encode($dameEst[0])."<br>";
$listaInst=mysqli_query($link,"SELECT DISTINCT * FROM $nombreTablaEstandares WHERE idestandar=".$buscaSql['idestandar']." AND trimestre=".$trimestre) or die(mysqli_error($link));
while($encEst=mysqli_fetch_array($listaInst)){
$buscInst=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE id=".$encEst['idinstrumento']);
while($encInst=mysqli_fetch_array($buscInst)){
echo "Instrumento de evaluación: ".utf8_encode($encInst['instrumento'])."<br>";
//echo $encuentraAlumno['alumno'];
$buscaExamenes=mysqli_query($link,"SELECT * FROM $nombreTablaExamenes WHERE alumno=".$encuentraAlumno['alumno']." AND instrumento=".$encEst['idinstrumento']);
$notaInstrumento=0;
$numeroInstrumentos++;
if (mysqli_num_rows($buscaExamenes)>1){
$cuentaInt=0;
$notaInt=0;


while($encuentraEx=mysqli_fetch_array($buscaExamenes)){
$notaInt= $notaInt+$encuentraEx['nota'];
$cuentaInt++;
}
$notaInstrumento=$notaInt/$cuentaInt;
echo "Nota media (hay varias): ".$notaInstrumento."<br>";
$notaEstandar=$notaEstandar+$notaInstrumento;
}else{
while($encuentraEx=mysqli_fetch_array($buscaExamenes)){
$notaInstrumento= $encuentraEx['nota'];
echo "Nota: ".$notaInstrumento."<br>";
$notaEstandar=$notaEstandar+$notaInstrumento;
}

}

}

}
echo "<br>Numero de Instrumentos: ".$numeroInstrumentos." Nota media: ".$notaEstandar/$numeroInstrumentos."<br>";
if ($idEstandarAplicada=="1"){
echo "<br>Prioridad de estandar: Básico";
echo "<br>Aportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multBasico;
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multBasico;
}
if ($idEstandarAplicada=="2"){
echo "<br>Prioridad de estandar: Intermedio";
echo "<br>Aportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multIntermedio;
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multIntermedio;
}
if ($idEstandarAplicada=="3"){
echo "<br>Prioridad de estandar: Avanzado";
echo "<br>Aportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multAvanzado;
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multAvanzado;
}

echo "</fieldset>";
}

}
echo "<h1>Nota final: ".$notaAcumulada."</h1>";
echo "</fieldset>";
}



?>
