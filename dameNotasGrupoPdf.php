<?php
require(dirname(__FILE__).'/fpdf/fpdf.php');
session_start();

   include("conectarse.php");
   $link=Conectarse();


$pdf = new FPDF();

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
$nombreTablaCompetencias="competencias".$materia;
$listaEstandares="estandares".$materia;
$nombMateria=mysqli_query($link,"SELECT materia FROM materias WHERE codigo='$materia' and curso='$curso'");
while ($nombremat=mysqli_fetch_array($nombMateria)){
$nombreMateria=$nombremat['materia'];
}
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
$sql=mysqli_query($link,"SELECT prioridad FROM $nombreTablaEstandares WHERE trimestre='$trimestre' GROUP BY idestandar,prioridad")or die ("Error calculando prioridades: ".mysqli_error($link));
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

$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(0,10,"Grupo: ".$grupo."\nNotas para la materia: ".$nombreMateria."\nTrimestre: ".$trimestre);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,10,"Alumno",1);
$pdf->Cell(20,10,"Nota final",1);
$pdf->Cell(15,10,"CM",1);
$pdf->Cell(15,10,"CL",1);
$pdf->Cell(15,10,"CD",1);
$pdf->Cell(15,10,"SI",1);
$pdf->Cell(15,10,"CEC",1);
$pdf->Cell(15,10,"CSC",1);
$pdf->Cell(15,10,"AA",1);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$cadena="Para este trimestre hay asignados ".$nestandarB." estándares básicos (peso ".$pesoPBasico.", les corresponde a cada uno un multiplicador de ".number_format($multBasico,4)."), ".$nestandarI." estándares intermedios (peso ".$pesoPIntermedio.", les corresponde a cada uno un multiplicador de ".number_format($multIntermedio,4)."),  y ".$nestandarA." avanzados (peso ".$pesoPAvanzado.", les corresponde a cada uno un multiplicador de ".number_format($multAvanzado,4).")";

$alumno=mysqli_query($link,"SELECT * FROM matriculas WHERE grupo='$grupo' ORDER BY apellidos")or die (mysqli_error($link));
while($encuentraAlumno=mysqli_fetch_array($alumno)){
//variables para medir competencias
$CM=array();
$CL=array();
$CD=array();
$SI=array();
$CEC=array();
$CSC=array();
$AA=array();
$ponAlumno=false;
$idAlumno=$encuentraAlumno['alumno'];
$buscaInstrumentos=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE trimestre='$trimestre'");
while ($encuentraInstrumentos=mysqli_fetch_array($buscaInstrumentos)){
$inst=$encuentraInstrumentos['id'];
$nombre=$encuentraInstrumentos['instrumento'];
$buscaNotas=mysqli_query($link,"SELECT * FROM $nombreTablaExamenes WHERE alumno=$idAlumno AND instrumento=$inst")or die (mysqli_error($link));
if (mysqli_num_rows($buscaNotas)>0){
$ponAlumno=true;
}
}
//echo "<fieldset><legend><b>".utf8_encode($encuentraAlumno['apellidos']).", ".utf8_encode($encuentraAlumno['nombre'])."</b></legend>";
if ($ponAlumno){
$notaAcumulada=0;
$pdf->SetFont('Arial','B',12);
//$pdf->Cell(0,10,'Alumno: '.$encuentraAlumno['apellidos'].", ".$encuentraAlumno['nombre']);
$nombreAlumno=$encuentraAlumno['apellidos'].", ".$encuentraAlumno['nombre'];
$buscaInstrumentos=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE trimestre='$trimestre'");
//$pdf->SetFont('Arial','',10);
//$pdf->MultiCell(0,5,utf8_decode($cadena));

$altura=40; 

while ($encuentraInstrumentos=mysqli_fetch_array($buscaInstrumentos)){
$inst=$encuentraInstrumentos['id'];
$nombre=$encuentraInstrumentos['instrumento'];

$buscaNotas=mysqli_query($link,"SELECT * FROM $nombreTablaExamenes WHERE alumno=$idAlumno AND instrumento=$inst")or die (mysqli_error($link));
$nota=0;
$cuenta=0;
$notaFinal=0;
$alturaInicial=20;
$textoNotas='';
$notaInstrumento=0;
if (mysqli_num_rows($buscaNotas)>1){
while($encuentraNotas=mysqli_fetch_array($buscaNotas)){
$nota=$nota+$encuentraNotas['nota'];
$cuenta++;
}
//echo "Instrumento: ".utf8_encode($nombre)." (Varias notas) Media: ".$nota/$cuenta."<br>";
$textoNotas=$textoNotas.'Instrumento: '.utf8_encode($nombre).' (varias notas) Media: '.number_format($nota/$cuenta,2)."\n";
$notaInstrumento=$nota/$cuenta;
//$pdf->Cell(0,$altura,'Instrumento: '.$nombre.' (varias notas) Media: '.$nota/$cuenta,1);
$altura+=5;
}
if (mysqli_num_rows($buscaNotas)==1){
while($encuentraNotas=mysqli_fetch_array($buscaNotas)){
$nota=$encuentraNotas['nota'];

}
//echo "Instrumento: ".utf8_encode($nombre)." Nota: ".$nota."<br>";
$textoNotas=$textoNotas.'Instrumento: '.utf8_encode($nombre).' Nota: '.number_format($nota,2)."\n";
//$pdf->Cell(0,$altura,'Instrumento: '.$nombre.' Nota: '.$nota/$cuenta,1);
$notaInstrumento=$nota;
$altura+=5;
}
//$pdf->MultiCell(0,5,utf8_decode($textoNotas),1);

}

//BUSCAMOS ESTANDARES Y NOTAS CORRESPONDIENTES
$sql=mysqli_query($link,"SELECT idestandar, prioridad FROM $nombreTablaEstandares WHERE trimestre='$trimestre' GROUP BY idestandar,prioridad")or die ("Error buscando estandares y sus notas: ".mysqli_error($link));
while($buscaSql=mysqli_fetch_array($sql)){
$notaEstandar=0;
$numeroInstrumentos=0;

$idEstandarAplicada=$buscaSql['prioridad'];
$est=mysqli_query($link,"SELECT estandar FROM $listaEstandares WHERE id=".$buscaSql['idestandar'])or die (mysqli_error($link));
$cadenaEstandar='';
while($dameEst=mysqli_fetch_array($est)){
$cadenaEstandar='';
//echo "<fieldset>".utf8_encode($dameEst[0])."<br>";
$cadenaEstandar=$cadenaEstandar.utf8_encode($dameEst[0])."\n";
$listaInst=mysqli_query($link,"SELECT DISTINCT * FROM $nombreTablaEstandares WHERE idestandar=".$buscaSql['idestandar']." AND trimestre=".$trimestre) or die(mysqli_error($link));
$estandarActual=$buscaSql['idestandar'];
while($encEst=mysqli_fetch_array($listaInst)){
$buscInst=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE id=".$encEst['idinstrumento']);
while($encInst=mysqli_fetch_array($buscInst)){
//echo "Instrumento de evaluación: ".utf8_encode($encInst['instrumento'])."<br>";
$cadenaEstandar=$cadenaEstandar."Instrumento de evaluación: ".utf8_encode($encInst['instrumento'])."\t";
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
//echo "Nota media (hay varias): ".$notaInstrumento."<br>";
$cadenaEstandar=$cadenaEstandar."Nota media (hay varias): ".number_format($notaInstrumento,2)."\n";
$notaEstandar=$notaEstandar+$notaInstrumento;
}else{
while($encuentraEx=mysqli_fetch_array($buscaExamenes)){
$notaInstrumento= $encuentraEx['nota'];
//echo "Nota: ".$notaInstrumento."<br>";
$cadenaEstandar=$cadenaEstandar."Nota: ".number_format($notaInstrumento,2)."\n";
$notaEstandar=$notaEstandar+$notaInstrumento;
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

}
//echo "<br>Numero de Instrumentos: ".$numeroInstrumentos." Nota media: ".$notaEstandar/$numeroInstrumentos."<br>";
$cadenaEstandar=$cadenaEstandar."\nNumero de Instrumentos: ".$numeroInstrumentos." Nota media: ".number_format($notaEstandar/$numeroInstrumentos,2)."\n";
if ($idEstandarAplicada=="1"){
$cadenaEstandar=$cadenaEstandar."\nPrioridad de estandar: Básico"."\nAportación a la nota: ".number_format(($notaEstandar/$numeroInstrumentos)*$multBasico,4);
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multBasico;
//echo "<br>Prioridad de estandar: Básico";
//echo "<br>Aportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multBasico;
//$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multBasico;
}
if ($idEstandarAplicada=="2"){
$cadenaEstandar=$cadenaEstandar."\nPrioridad de estandar: Intermedio"."\nAportación a la nota: ".number_format(($notaEstandar/$numeroInstrumentos)*$multIntermedio,4);
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multIntermedio;
//echo "<br>Prioridad de estandar: Intermedio";
//echo "<br>Aportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multIntermedio;
//$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multIntermedio;
}
if ($idEstandarAplicada=="3"){"\nPrioridad de estandar: Avanzado"."\nAportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multAvanzado;
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multAvanzado;
$cadenaEstandar=$cadenaEstandar."\nPrioridad de estandar: Avanzado"."\nAportación a la nota: ".number_format(($notaEstandar/$numeroInstrumentos)*$multAvanzado,4);
//echo "<br>Prioridad de estandar: Avanzado";
//echo "<br>Aportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multAvanzado;
//$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multAvanzado;
}

//echo "</fieldset>";
//$pdf->MultiCell(0,10,'NOTA ACUMULADA: '.$notaAcumulada);
}
//$pdf->MultiCell(0,5,utf8_decode($cadenaEstandar),1);

}
$pdf->SetFont('Arial','',10);
$pdf->Cell(50,10,$nombreAlumno,1);
$pdf->Cell(20,10,number_format($notaAcumulada,2),1);
//Calculamos la nota en cada competencia
if(empty($CM)){
$pdf->Cell(15,10,"No",1);
}else{
$notaCompet=0;
for ($i=0;$i<count($CM);$i++){
$notaCompet=$notaCompet+(float)$CM[$i];
}
$pdf->Cell(15,10,number_format(($notaCompet/count($CM)),2),1);
}
if(empty($CL)){
$pdf->Cell(15,10,"No",1);
}else{
$notaCompet=0;
for ($i=0;$i<count($CL);$i++){
$notaCompet=$notaCompet+(float)$CL[$i];
}
$pdf->Cell(15,10,number_format(($notaCompet/count($CL)),2),1);
}
if(empty($CD)){
$pdf->Cell(15,10,"No",1);
}else{
$notaCompet=0;
for ($i=0;$i<count($CD);$i++){
$notaCompet=$notaCompet+(float)$CD[$i];
}
$pdf->Cell(15,10,number_format(($notaCompet/count($CD)),2),1);
}
if(empty($SI)){
$pdf->Cell(15,10,"No",1);
}else{
$notaCompet=0;
for ($i=0;$i<count($SI);$i++){
$notaCompet=$notaCompet+(float)$SI[$i];
}
$pdf->Cell(15,10,number_format(($notaCompet/count($SI)),2),1);
}
if(empty($CEC)){
$pdf->Cell(15,10,"No",1);
}else{
$notaCompet=0;
for ($i=0;$i<count($CEC);$i++){
$notaCompet=$notaCompet+(float)$CEC[$i];
}
$pdf->Cell(15,10,number_format(($notaCompet/count($CEC)),2),1);
}
if(empty($CSC)){
$pdf->Cell(15,10,"No",1);
}else{
$notaCompet=0;
for ($i=0;$i<count($CSC);$i++){
$notaCompet=$notaCompet+(float)$CSC[$i];
}
$pdf->Cell(15,10,number_format(($notaCompet/count($CSC)),2),1);
}
if(empty($AA)){
$pdf->Cell(15,10,"No",1);
}else{
$notaCompet=0;
for ($i=0;$i<count($AA);$i++){
$notaCompet=$notaCompet+(float)$AA[$i];
}
$pdf->Cell(15,10,number_format(($notaCompet/count($AA)),2),1);
}
//$pdf->Cell(15,10,"CM",1);

$pdf->Ln();
}

}
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$cadena="Competencias: CM: Competencia Matemática, CL: Competencia Lingüística, CD: Competencia Digital, SI: Sentido de la Iniciativa y Espíritu ";
$pdf->Cell(0,5,utf8_decode($cadena));
$cadena="Emprendedor, CEC: Conciencia y Espresiones Culturales, CSC: Competencias Sociales y Cívicas, AA: Aprender a aprender";
$pdf->Ln();
$pdf->Cell(0,5,utf8_decode($cadena));
$pdf->Output();


?>
