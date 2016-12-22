<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();



$trimestre=$_POST['trimestre'];
$materia=$_POST['materia'];
$curso=$_POST['curso'];
$alumno=$_POST['alumno'];
$pesoPBasico=0;
$pesoPIntermedio=0;
$pesoPAvanzado=0;
$nombreTablaInstrumentos=$materia."Instrumentos".$curso;
$nombreTablaExamenes=$materia."notas".$curso;
$nombreTablaEstandares=$materia."organizacionestandares".$curso;
$listaEstandares="estandares".$materia;
$nombreTablaCompetencias="competencias".$materia;
$prioridad=mysqli_query($link,"SELECT * FROM prioridades");
//variables para medir competencias
$CM=array();
$CL=array();
$CD=array();
$SI=array();
$CEC=array();
$CSC=array();
$AA=array();
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

$sql=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE trimestre='$trimestre' GROUP BY idestandar")or die ("Error: ".mysqli_error($link));
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
echo "Para este trimestre hay asignados ".$nestandarB." estándares básicos (peso ".$pesoPBasico.", les corresponde a cada uno un multiplicador de ".number_format($multBasico,4)."), ".$nestandarI." estándares intermedios (peso ".$pesoPIntermedio.", les corresponde a cada uno un multiplicador de ".number_format($multIntermedio,4)."),  y ".$nestandarA." avanzados (peso ".$pesoPAvanzado."), les corresponde a cada uno un multiplicador de ".number_format($multAvanzado,4)."";
//echo $nombreTablaInstrumentos."<br>".$nombreTablaExamenes;
//echo $grupo.$materia.$trimestre.$curso;
$cuenta=0;
$sql=mysqli_query($link,"SELECT * FROM matriculas WHERE alumno='$alumno' ")or die (mysqli_error($link));
while($dameNombre=mysqli_fetch_array($sql)){
$nombre=$dameNombre['nombre'];
$apellidos=$dameNombre['apellidos'];
}

echo "<h2>Alumno: ".utf8_encode($apellidos).", ".utf8_encode($nombre)."</h2>";
echo "<input type=\"submit\" id=\"pdfIndividual\" value=\"GenerarPDF\"><br><br>";
//AQUÍ EMPIEZA LA RUTINA DE CONTABILIZACIÓN DE NOTAS
$sql=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE trimestre='$trimestre' GROUP BY idestandar")or die (mysqli_error($link));
while($buscaSql=mysqli_fetch_array($sql)){
$notaEstandar=0;
$numeroInstrumentos=0;

$idEstandarAplicada=$buscaSql['prioridad'];
$est=mysqli_query($link,"SELECT estandar FROM $listaEstandares WHERE id=".$buscaSql['idestandar'])or die (mysqli_error($link));
$estandarActual=$buscaSql['idestandar'];
while($dameEst=mysqli_fetch_array($est)){

$listaInst=mysqli_query($link,"SELECT DISTINCT * FROM $nombreTablaEstandares WHERE idestandar=".$buscaSql['idestandar']." AND trimestre=".$trimestre) or die(mysqli_error($link));
while($encEst=mysqli_fetch_array($listaInst)){
$buscInst=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE id=".$encEst['idinstrumento']);
while($encInst=mysqli_fetch_array($buscInst)){

//echo $encuentraAlumno['alumno'];
$buscaExamenes=mysqli_query($link,"SELECT * FROM $nombreTablaExamenes WHERE alumno=".$alumno." AND instrumento=".$encEst['idinstrumento']);
$notaInstrumento=0;
$numeroInstrumentos++;
$notaComp=0;
if (mysqli_num_rows($buscaExamenes)>1){
$cuentaInt=0;
$notaInt=0;


while($encuentraEx=mysqli_fetch_array($buscaExamenes)){
$notaInt= $notaInt+$encuentraEx['nota'];
$cuentaInt++;
}
$notaInstrumento=$notaInt/$cuentaInt;
$notaComp=$notaInstrumento;
$notaEstandar=$notaEstandar+$notaInstrumento;
}else{
while($encuentraEx=mysqli_fetch_array($buscaExamenes)){
$notaInstrumento= $encuentraEx['nota'];
$notaComp=$notaInstrumento;
$notaEstandar=$notaEstandar+$notaInstrumento;
}

}
//ASIGNAMOS LA NOTA DE LOS INSTRUMENTOS UTILIZADOS TAMBIÉN A LAS COMPETENCIAS PERTINENTES PARA ESE ESTÁNDAR
$buscaComp=mysqli_query($link,"SELECT competencia FROM $nombreTablaCompetencias WHERE contenido=$estandarActual");
while($encuentraComp=mysqli_fetch_array($buscaComp)){
switch ($encuentraComp['competencia']){
case 1:
$CM[]=$notaInstrumento;
break;
case 2:
$CL[]=$notaInstrumento;
break;
case 3:
$CD[]=$notaInstrumento;
break;
case 4:
$SI[]=$notaInstrumento;
break;
case 5:
$CEC[]=$notaInstrumento;
break;
case 6:
$CSC[]=$notaInstrumento;
break;
case 7:
$AA[]=$notaInstrumento;
break;
}
}
}

}

if ($idEstandarAplicada=="1"){

$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multBasico;
}
if ($idEstandarAplicada=="2"){

$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multIntermedio;
}
if ($idEstandarAplicada=="3"){

$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multAvanzado;
}


}

}
echo"<table border=\"1\"><tr><td><h3>NOTA FINAL</h3></td><td>CM</td><td>CL</td><td>CD</td><td>SI</td><td>CEC</td><td>
CSC</td><td>AA</td></tr>";
echo "<tr><td><h3>".number_format($notaAcumulada,2)."</h3></td>";
//AQUÍ ACABA LA RUTINA DE CONTABILIZACIÓN DE NOTAS
//AQUÍ EMPIEZA LA RUTINA DE CONTABILIZACIÓN DE NOTAS POR COMPETENCIAS
//$cadenaCompetencias="\n\nNOTAS POR COMPETENCIA TRABAJADA: ";
//$cadenaCompetencias=$cadenaCompetencias."\nCompetencia Lingüística: ";
$notaCompet=0;
if(empty($CM)){
//$cadenaCompetencias=$cadenaCompetencias."No se ha trabajado esta competencia en esta materia para este trimestre";
echo "<td>No</td>";
}else{
for ($i=0;$i<count($CM);$i++){
$notaCompet=$notaCompet+(float)$CM[$i];
}
echo"<td>".number_format(($notaCompet/count($CM)),2)."</td>";
}
$notaCompet=0;
if(empty($CL)){
//$cadenaCompetencias=$cadenaCompetencias."No se ha trabajado esta competencia en esta materia para este trimestre";
echo "<td>No</td>";
}else{
for ($i=0;$i<count($CL);$i++){
$notaCompet=$notaCompet+(float)$CL[$i];
}
echo"<td>".number_format(($notaCompet/count($CL)),2)."</td>";
}
$notaCompet=0;
if(empty($CD)){
//$cadenaCompetencias=$cadenaCompetencias."No se ha trabajado esta competencia en esta materia para este trimestre";
echo "<td>No</td>";
}else{
for ($i=0;$i<count($CD);$i++){
$notaCompet=$notaCompet+(float)$CD[$i];
}
echo"<td>".number_format(($notaCompet/count($CD)),2)."</td>";
}
$notaCompet=0;
if(empty($SI)){
//$cadenaCompetencias=$cadenaCompetencias."No se ha trabajado esta competencia en esta materia para este trimestre";
echo "<td>No</td>";
}else{
for ($i=0;$i<count($SI);$i++){
$notaCompet=$notaCompet+(float)$SI[$i];
}
echo"<td>".number_format(($notaCompet/count($SI)),2)."</td>";
}
$notaCompet=0;
if(empty($CEC)){
//$cadenaCompetencias=$cadenaCompetencias."No se ha trabajado esta competencia en esta materia para este trimestre";
echo "<td>No</td>";
}else{
for ($i=0;$i<count($CEC);$i++){
$notaCompet=$notaCompet+(float)$CEC[$i];
}
echo"<td>".number_format(($notaCompet/count($CEC)),2)."</td>";
}
$notaCompet=0;
if(empty($CSC)){
//$cadenaCompetencias=$cadenaCompetencias."No se ha trabajado esta competencia en esta materia para este trimestre";
echo "<td>No</td>";
}else{
for ($i=0;$i<count($CSC);$i++){
$notaCompet=$notaCompet+(float)$CSC[$i];
}
echo"<td>".number_format(($notaCompet/count($CSC)),2)."</td>";
}
$notaCompet=0;
if(empty($AA)){
//$cadenaCompetencias=$cadenaCompetencias."No se ha trabajado esta competencia en esta materia para este trimestre";
echo "<td>No</td>";
}else{
for ($i=0;$i<count($AA);$i++){
$notaCompet=$notaCompet+(float)$AA[$i];
}
echo"<td>".number_format(($notaCompet/count($AA)),2)."</td>";
}
echo "</tr></table>";
//AQUÍ ACABA LA RUTINA DE CONTABILIZACIÓN DE NOTAS POR COMPETENCIAS
$notaAcumulada=0;
//echo"<form id=\"notas\" name=\"notas\" method=\"post\" action=\"grabaExamen.php\">";
$cuentaInstrumentos=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE trimestre='$trimestre'")or die(mysqli_error($link));
echo "<table border=\"1\"><tr><th>Instrumento de evaluación</th><th>Nota</th></tr>";
$numeroInstrumentos=mysqli_num_rows($cuentaInstrumentos);
//echo $numeroInstrumentos;
while($encuentraInst=mysqli_fetch_array($cuentaInstrumentos)){
$idInst=$encuentraInst['id'];
$nombreInst=$encuentraInst['instrumento'];
//echo "<p>".$idInst.", ".$nombreInst."</p>";
$buscaNotas=mysqli_query($link,"SELECT * FROM $nombreTablaExamenes WHERE instrumento='$idInst' AND alumno='$alumno'");
if (mysqli_num_rows($buscaNotas)>1){
echo "<td> ".utf8_encode($nombreInst)."</td>";
while($encuentraNotas=mysqli_fetch_array($buscaNotas)){
echo"<td><input type=\"text\" class=\"nota\" id=\"".$encuentraNotas['id']."\"value=\"".$encuentraNotas['nota']." \">";
}
echo "</td></tr>";
}else{
while($encuentraNotas=mysqli_fetch_array($buscaNotas)){
echo "<td> ".utf8_encode($nombreInst)."</td><td><input type=\"text\" class=\"nota\" id=\"".$encuentraNotas['id']."\"value=\"".$encuentraNotas['nota']." \"></td></tr>";
}
}


}
echo "</table>";
$sql=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE trimestre='$trimestre' GROUP BY idestandar")or die (mysqli_error($link));
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
$buscaExamenes=mysqli_query($link,"SELECT * FROM $nombreTablaExamenes WHERE alumno=".$alumno." AND instrumento=".$encEst['idinstrumento']);
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
echo "Nota media (hay varias): ".number_format($notaInstrumento,2)."<br>";
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

echo "<br>Numero de Instrumentos: ".$numeroInstrumentos." Nota media: ".number_format($notaEstandar/$numeroInstrumentos,2)."<br>";
if ($idEstandarAplicada=="1"){
echo "<br>Prioridad de estandar: Básico";
echo "<br>Aportación a la nota: ".number_format(($notaEstandar/$numeroInstrumentos)*$multBasico,4);
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multBasico;
}
if ($idEstandarAplicada=="2"){
echo "<br>Prioridad de estandar: Intermedio";
echo "<br>Aportación a la nota: ".number_format(($notaEstandar/$numeroInstrumentos)*$multIntermedio,4);
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multIntermedio;
}
if ($idEstandarAplicada=="3"){
echo "<br>Prioridad de estandar: Avanzado";
echo "<br>Aportación a la nota: ".number_format(($notaEstandar/$numeroInstrumentos)*$multAvanzado,4);
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multAvanzado;
}
$codigoEstandar=$buscaSql['idestandar'];
echo "<br>Competencias pertinentes: <br><ul>";
$buscaComp=mysqli_query($link,"SELECT * FROM $nombreTablaCompetencias WHERE contenido=$codigoEstandar");
while($encComp=mysqli_fetcH_array($buscaComp)){
$compActual=$encComp['competencia'];
$competencia=mysqli_query($link,"SELECT competencia FROM competencias WHERE id=$compActual");
echo "<li>".utf8_encode(mysqli_fetch_array($competencia)[0])."</li>";
}
echo "</ul>";
echo "</fieldset>";
}

}
echo "<h1>Nota final: ".number_format($notaAcumulada,2)."</h1>";
echo "<input type=\"hidden\" name=\"notaAcumulada\" id=\"notaAcumulada\" value=\".$notaAcumulada.\"/>"; 
echo "</fieldset>";
?>
