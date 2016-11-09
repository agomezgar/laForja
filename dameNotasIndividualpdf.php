<?php
require(dirname(__FILE__).'/fpdf/fpdf.php');
session_start();

   include("conectarse.php");
   $link=Conectarse();


$pdf = new FPDF();

$grupo=utf8_decode($_POST['grupo']);
$alumno=$_POST['alumno'];
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
$sql=mysqli_query($link,"SELECT idestandar,prioridad FROM $nombreTablaEstandares WHERE trimestre='$trimestre' GROUP BY idestandar,prioridad")or die ("Error 1: ".mysqli_error($link));
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
$pdf->SetFont('Arial','B',16);
$pdf->MultiCell(0,10,"Grupo: ".$grupo);
$pdf->SetFont('Arial','B',10);
$cadena="Para este trimestre hay asignados ".$nestandarB." estándares básicos (peso ".$pesoPBasico.", les corresponde a cada uno un multiplicador de ".number_format($multBasico,4)."), ".$nestandarI." estándares intermedios (peso ".$pesoPIntermedio.", les corresponde a cada uno un multiplicador de ".number_format($multIntermedio,4)."),  y ".$nestandarA." avanzados (peso ".$pesoPAvanzado.", les corresponde a cada uno un multiplicador de ".number_format($multAvanzado,4).")";


$ponAlumno=false;
$idAlumno=$alumno;
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
$pdf->SetFont('Arial','B',16);
$buscaAlumno=mysqli_query($link,"SELECT * FROM matriculas WHERE alumno=$idAlumno");
while($encuentraAlumno=mysqli_fetch_array($buscaAlumno)){
$pdf->Multicell(0,10,'Alumno: '.$encuentraAlumno['apellidos'].", ".$encuentraAlumno['nombre']);
}
$buscaInstrumentos=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE trimestre='$trimestre'");
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(0,5,utf8_decode($cadena));

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
if (mysqli_num_rows($buscaNotas)>1){
while($encuentraNotas=mysqli_fetch_array($buscaNotas)){
$nota=$nota+$encuentraNotas['nota'];
$cuenta++;
}
//echo "Instrumento: ".utf8_encode($nombre)." (Varias notas) Media: ".$nota/$cuenta."<br>";
$textoNotas=$textoNotas.'Instrumento: '.utf8_encode($nombre).' (varias notas) Media: '.number_format($nota/$cuenta,2)."\n";
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
$altura+=5;
}
$pdf->MultiCell(0,5,utf8_decode($textoNotas),1);
}

//BUSCAMOS ESTANDARES Y NOTAS CORRESPONDIENTES
$sql=mysqli_query($link,"SELECT idestandar,prioridad FROM $nombreTablaEstandares WHERE trimestre='$trimestre' GROUP BY idestandar,prioridad")or die (mysqli_error($link));
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
while($encEst=mysqli_fetch_array($listaInst)){
$buscInst=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE id=".$encEst['idinstrumento']);
while($encInst=mysqli_fetch_array($buscInst)){
//echo "Instrumento de evaluación: ".utf8_encode($encInst['instrumento'])."<br>";
$cadenaEstandar=$cadenaEstandar."Instrumento de evaluación: ".utf8_encode($encInst['instrumento'])."\t";
//echo $encuentraAlumno['alumno'];
$buscaExamenes=mysqli_query($link,"SELECT * FROM $nombreTablaExamenes WHERE alumno=".$idAlumno." AND instrumento=".$encEst['idinstrumento']);
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
$cadenaEstandar=$cadenaEstandar."\nPrioridad de estandar: Intermedio"."\nAportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multIntermedio;
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multIntermedio;
//echo "<br>Prioridad de estandar: Intermedio";
//echo "<br>Aportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multIntermedio;
//$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multIntermedio;
}
if ($idEstandarAplicada=="3"){"\nPrioridad de estandar: Avanzado"."\nAportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multAvanzado;
$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multAvanzado;
$cadenaEstandar=$cadenaEstandar."\nPrioridad de estandar: Avanzado"."\nAportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multAvanzado;
//echo "<br>Prioridad de estandar: Avanzado";
//echo "<br>Aportación a la nota: ".($notaEstandar/$numeroInstrumentos)*$multAvanzado;
//$notaAcumulada=$notaAcumulada+($notaEstandar/$numeroInstrumentos)*$multAvanzado;
}

//echo "</fieldset>";
//$pdf->MultiCell(0,10,'NOTA ACUMULADA: '.$notaAcumulada);
}
$pdf->MultiCell(0,5,utf8_decode($cadenaEstandar),1);

}
$pdf->SetFont('Arial','B',16);
$pdf->MultiCell(0,10,'NOTA TOTAL: '.number_format($notaAcumulada,2));


}
$pdf->Output();


?>
