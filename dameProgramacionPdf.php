<?php
require(dirname(__FILE__).'/fpdf/fpdf.php');
header('Content-type: application/pdf');
session_start();
   include("conectarse.php");
$pdf = new FPDF();
$pdf->AddPage();

   $link=Conectarse();

$curso=$_POST['curso'];
$materia=$_POST['materia'];
$trimestre=$_POST['trimestre'];
$bloqueActual='';
$criterioActual='';


//$nombre=$_SESSION['profesor'];
$nombreTablaInstrumentos=$materia."Instrumentos".$curso;
$nombreTablaOrganizacionEstandares=$materia."organizacionestandares".$curso;
$nombreTablaEstandares="estandares".$materia;
$nombreTablaCompetencias="competencias".$materia;
switch ($trimestre) {
    case 1:
        $cadena="<option value=\"1\" selected=\"selected\">1º</option>
<option value=\"2\">2º</option>
<option value=\"3\">3º</option>";
        break;
    case 2:
        $cadena="<option value=\"1\" >1º</option>
<option value=\"2\"selected=\"selected\">2º</option>
<option value=\"3\">3º</option>";
        break;
    case 3:
        $cadena="<option value=\"1\" >1º</option>
<option value=\"2\">2º</option>
<option value=\"3\"selected=\"selected\">3º</option>";
        break;
}
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
$sql=mysqli_query($link,"SELECT idestandar,prioridad FROM $nombreTablaOrganizacionEstandares WHERE trimestre='$trimestre' GROUP BY idestandar,prioridad")or die ("Error 1: ".mysqli_error($link));
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
$nombMateria=mysqli_query($link,"SELECT materia FROM materias WHERE codigo='$materia' and curso='$curso'");
while ($nombremat=mysqli_fetch_array($nombMateria)){
$nombreMateria=utf8_encode($nombremat['materia']);
}


$pdf->SetFillColor(65,197,212);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(180,20,utf8_decode("Programación Didáctica de la materia: ".$nombreMateria),'BR',0,'C',true);
$pdf->SetFont('Arial','',10);
$pdf->Ln(25);
$cadena="Para este trimestre hay asignados ".$nestandarB." estándares básicos (peso ".$pesoPBasico.", les corresponde a cada uno un multiplicador de ".number_format($multBasico,4)."), ".$nestandarI." estándares intermedios (peso ".$pesoPIntermedio.", les corresponde a cada uno un multiplicador de ".number_format($multIntermedio,4)."),  y ".$nestandarA." avanzados (peso ".$pesoPAvanzado.", les corresponde a cada uno un multiplicador de ".number_format($multAvanzado,4).")";
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,5,utf8_decode($cadena));
$buscaEstandar=mysqli_query($link,"SELECT DISTINCT idestandar FROM $nombreTablaOrganizacionEstandares WHERE trimestre=$trimestre GROUP BY idestandar" );
while($encuentraEstandar=mysqli_fetch_array($buscaEstandar)){
$estandarActual=$encuentraEstandar['idestandar'];
$dameNumeroPrioridad=mysqli_query($link,"SELECT * FROM $nombreTablaOrganizacionEstandares WHERE idestandar=$estandarActual");
while ($numeroPrioridad=mysqli_fetch_array($dameNumeroPrioridad)){
$numero=$numeroPrioridad['prioridad'];
}
switch($numero){
case 1: 
	$prioridad=" (Básico): ";
	break;
case 2: 
	$prioridad=" (Intermedio): ";
	break;
case 1: 
	$prioridad=" (Avanzado): ";
	break;

}
$instrumentos=mysqli_query($link,"SELECT idinstrumento,prioridad FROM $nombreTablaOrganizacionEstandares WHERE idestandar=$estandarActual ORDER BY idinstrumento");
$numInstrumentos=mysqli_num_rows($instrumentos);
$datos=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE id=$estandarActual");
while ($dameDatos=mysqli_fetch_array($datos)){
if ($bloqueActual!=$dameDatos['bloque']){
$bloqueActual=$dameDatos['bloque'];
$numeroContenido=substr($estandarActual,-3,1);
$pdf->Ln(10);
//echo "<h2>Bloque ".utf8_encode($bloqueActual)."</h2><br>";
$pdf->SetFillColor(65,197,212);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',12);

$pdf->Cell(180,10,utf8_decode("Bloque de contenidos ").$bloqueActual,'BR',0,'C',true);
$listaInstrumentos=mysqli_query($link, "SELECT instrumento FROM $nombreTablaInstrumentos WHERE contenido=$numeroContenido");
$cadena="Instrumentos utilizados: \n";
//echo "Instrumentos utilizados: <br>";
while ($instObtenidos=mysqli_fetch_array($listaInstrumentos)){
//echo $instObtenidos['instrumento']."<br>";
$cadena=$cadena."- ".$instObtenidos['instrumento']."\n";
}
$pdf->Ln(20);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(0,5,$cadena,0,'L',0);
$pdf->Ln(10);
}
//Atento a si hay que cambiar esta llave
}

$buscaCriterio=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE id=$estandarActual");
while($encuentraCriterio=mysqli_fetch_array($buscaCriterio)){
$otroCriterio=$encuentraCriterio['criterio'];
if ($otroCriterio!=$criterioActual){
$criterioActual=$otroCriterio;
//echo "<h3>Criterio: ".utf8_encode($criterioActual)."</h3><br>";
$cadenaCriterio="Criterio: ".utf8_encode($criterioActual)."\n";
$pdf->SetFillColor(65,197,212);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','',12);

$pdf->MultiCell(180,5,utf8_decode($cadenaCriterio),0,'L',1);
$pdf->Ln(10);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,utf8_decode("Estándares relacionados: "),0,1,'L',0);
}
}

$pdf->SetFont('Arial','',10);
$pdf->Ln(5);
$cadena2="";
$buscaNombreEst=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE id=$estandarActual");
while ($x=mysqli_fetch_array($buscaNombreEst)){
$cadenaEstandar=utf8_encode($x['estandar']);
}
//echo "<h4>Estandar ".$cadenaEstandar.$prioridad."</h4><br>Instrumentos utilizados para ponderarlo: <br>";
$cadena2=$cadena2."Estandar: ".$cadenaEstandar.$prioridad."\nInstrumentos utilizados para ponderarlo: \n";
foreach($instrumentos as $key=>$value){
$valor=$value['idinstrumento'];
$valorPrioridad=$value['prioridad'];
if ($valorPrioridad=="1"){
$mult=$multBasico;
}
if ($valorPrioridad=="2"){
$mult=$multIntermedio;
}
if ($valorPrioridad=="3"){
$mult=$multAvanzado;
}
$buscaInstrumento=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE id=$valor");
while ($dameInstrumento=mysqli_fetch_array($buscaInstrumento)){
//echo "· ".$dameInstrumento['instrumento']."(Peso en nota final: ".number_format($mult/$numInstrumentos,4).")<br>";
$cadena2=$cadena2."· ".utf8_encode($dameInstrumento['instrumento'])."(Peso en nota final: ".number_format($mult/$numInstrumentos,4).")\n";
}


}


//echo "<br>Competencias trabajadas: <br>";


$competenciasTrabajadas=mysqli_query($link, "SELECT competencia FROM $nombreTablaCompetencias WHERE contenido=$estandarActual");
$cadena2=$cadena2."Competencias trabajadas: \n";
foreach ($competenciasTrabajadas as $key=>$value){
$competenciaPertinente=$value['competencia'];
$buscaTexto=mysqli_query($link,"SELECT competencia FROM competencias WHERE id=$competenciaPertinente");
while ($dameTexto=mysqli_fetch_array($buscaTexto)){
//echo "- ".utf8_encode($dameTexto['competencia'])."<br>";
$cadena2=$cadena2."- ".utf8_encode($dameTexto['competencia'])."\t";
}
}
$pdf->MultiCell(0,5,utf8_decode($cadena2),1,'L',0);
$pdf->Ln(10);
}
$pdf->Output();
?>
