<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();

$curso=$_POST['curso'];
$materia=$_POST['materia'];
$trimestre=$_POST['trimestre'];
$bloqueActual='';
$criterioActual='';
//variables para medir competencias
$CM=array();
$CL=array();
$CD=array();
$SI=array();
$CEC=array();
$CSC=array();
$AA=array();

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
$prioridad=mysqli_query($link,"SELECT * FROM prioridades")or die ("Buscando error : ".mysqli_error($link));
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
$nombMateria=mysqli_query($link,"SELECT materia FROM materias WHERE codigo='$materia' and curso='$curso'")or die ("Buscando error : ".mysqli_error($link));
while ($nombremat=mysqli_fetch_array($nombMateria)){
$nombreMateria=utf8_encode($nombremat['materia']);
}
echo "<input type=\"submit\" id=\"pdfProgramacion\" value=\"GenerarPDF\">";
$cadena="Para este trimestre hay asignados ".$nestandarB." estándares básicos (peso ".$pesoPBasico.", les corresponde a cada uno un multiplicador de ".number_format($multBasico,4)."), ".$nestandarI." estándares intermedios (peso ".$pesoPIntermedio.", les corresponde a cada uno un multiplicador de ".number_format($multIntermedio,4)."),  y ".$nestandarA." avanzados (peso ".$pesoPAvanzado.", les corresponde a cada uno un multiplicador de ".number_format($multAvanzado,4).")";
echo "<h1>Programación Didáctica de la materia: ".$nombreMateria."</h1><br>";
echo $cadena;
/*Aquí vamos a 
empezar a programar para localizar el grado de implicación de cada 
competencia en el conjunto de la programación
*/



$buscaEstandarCompetencias=mysqli_query($link,"SELECT DISTINCT idestandar,prioridad FROM $nombreTablaOrganizacionEstandares")or die("Error cuadrando competencias: ".mysqli_error($link));
$numeroTotalEstandares=mysqli_num_rows($buscaEstandarCompetencias);
echo "<br>Numero total de Estandares: ".$numeroTotalEstandares."<br>";
while($encuentraEstComp=mysqli_fetch_array($buscaEstandarCompetencias)){
//echo "\nEstandar: ".$encuentraEstComp['idestandar'];
$EstandarActual=$encuentraEstComp['idestandar'];
//echo "Estandar: ".$EstandarActual;
$prioridadActual=$encuentraEstComp['prioridad'];
//echo " Prioridad: ".$prioridadActual."<br>";
$buscaComp=mysqli_query($link,"SELECT DISTINCT competencia FROM $nombreTablaCompetencias WHERE contenido=$EstandarActual");
while($encuentraComp=mysqli_fetch_array($buscaComp)){

switch ($encuentraComp['competencia']){
case 1:

$CM[]=$prioridadActual;
break;
case 2:
$CL[]=$prioridadActual;
break;
case 3:
$CD[]=$prioridadActual;
break;
case 4:
$SI[]=$prioridadActual;
break;
case 5:
$CEC[]=$prioridadActual;
break;
case 6:
$CSC[]=$prioridadActual;
break;

}
}
}
echo "Baremación de competencias: <br>";
echo "<table><tr><td>Competencia</td><td>Nº estándares</td><td>Baremación</td></tr>";


/*$notaBasica=0;
$notaIntermedia=0;
$notaAvanzada=0;
for ($i=0;$i<count($CM);$i++){
echo $CM[$i];
switch ($CM[$i]){
case 1:
$notaBasica++;
break;
case 2:
$notaIntermedia++;
break;
case 3:
$notaAvanzada++;
break;
}
}
$notaCompetencia=($notaBasica/count($CM))*$pesoPBasico+($notaIntermedia/count($CM))*$pesoPIntermedio+($notaAvanzada/count($CM))*$pesoPAvanzado;
echo " Nota total: ".$notaCompetencia."<br>";
*/
$numero=number_format((count($CM)/$numeroTotalEstandares)*100,2);

echo "<tr><td>Competencia Matemática</td><td>".count($CM)."</td><td>".$numero."%</td></tr>";
$numero=number_format((count($CL)/$numeroTotalEstandares)*100,2);

echo "<tr><td>Competencia Lingüística</td><td>".count($CL)."</td><td>".$numero."%</td></tr>";
$numero=number_format((count($CD)/$numeroTotalEstandares)*100,2);

echo "<tr><td>Competencia Digital</td><td>".count($CD)."</td><td>".$numero."%</td></tr>";
$numero=number_format((count($SI)/$numeroTotalEstandares)*100,2);
;
echo "<tr><td>Sentido de la iniciativa y espíritu emprendedor</td><td>".count($SI)."</td><td>".$numero."%</td></tr>";
$numero=number_format((count($CEC)/$numeroTotalEstandares)*100,2);

echo "<tr><td>Conciencia y Expresiones Culturales</td><td>".count($CEC)."</td><td>".$numero."%</td></tr>";
$numero=number_format((count($CSC)/$numeroTotalEstandares)*100,2);

echo "<tr><td>Competencias Sociales y Cívicas</td><td>".count($CSC)."</td><td>".$numero."%</td></tr>";
echo"</table>";
/*Aquí acaba el algoritmo de 
localización, priorización y 
baremación de competencias
*/
$buscaEstandar=mysqli_query($link,"SELECT DISTINCT idestandar FROM $nombreTablaOrganizacionEstandares WHERE trimestre=$trimestre GROUP BY idestandar" )or die ("Buscando error : ".mysqli_error($link));
while($encuentraEstandar=mysqli_fetch_array($buscaEstandar)){
$estandarActual=$encuentraEstandar['idestandar'];
$dameNumeroPrioridad=mysqli_query($link,"SELECT * FROM $nombreTablaOrganizacionEstandares WHERE idestandar=$estandarActual")or die ("Buscando error : ".mysqli_error($link));
while ($numeroPrioridad=mysqli_fetch_array($dameNumeroPrioridad)){
$numero=$numeroPrioridad['prioridad'];
}
switch($numero){
case 1: 
	$prioridad=" <i>(Básico)</i>: ";
	break;
case 2: 
	$prioridad=" <i>(Intermedio)</i>: ";
	break;
case 1: 
	$prioridad=" <i>(Avanzado)</i>: ";
	break;

}
$instrumentos=mysqli_query($link,"SELECT idinstrumento,prioridad FROM $nombreTablaOrganizacionEstandares WHERE idestandar=$estandarActual ORDER BY idinstrumento")or die ("Buscando error : ".mysqli_error($link));
$numInstrumentos=mysqli_num_rows($instrumentos);
$datos=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE id=$estandarActual")or die ("Buscando error : ".mysqli_error($link));
while ($dameDatos=mysqli_fetch_array($datos)){
if ($bloqueActual!=$dameDatos['bloque']){
$bloqueActual=$dameDatos['bloque'];
$numeroContenido=substr($estandarActual,-3,1);
echo "<h2>Bloque ".utf8_encode($bloqueActual)."</h2><br>";
$listaInstrumentos=mysqli_query($link, "SELECT instrumento FROM $nombreTablaInstrumentos WHERE contenido=$numeroContenido")or die ("Buscando error : ".mysqli_error($link));
echo "Instrumentos utilizados: <br>";
while ($instObtenidos=mysqli_fetch_array($listaInstrumentos)){
echo utf8_encode($instObtenidos['instrumento'])."<br>";

}

}
//Atento a si hay que cambiar esta llave
}

$buscaCriterio=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE id=$estandarActual")or die ("Buscando error : ".mysqli_error($link));
while($encuentraCriterio=mysqli_fetch_array($buscaCriterio)){
$otroCriterio=$encuentraCriterio['criterio'];
if ($otroCriterio!=$criterioActual){
$criterioActual=$otroCriterio;
echo "<h3>Criterio: ".utf8_encode($criterioActual)."</h3><br>";
}
}
//echo "estandarActual";
$buscaNombreEst=mysqli_query($link,"SELECT * FROM $nombreTablaEstandares WHERE id=$estandarActual")or die ("Buscando error : ".mysqli_error($link));
while ($x=mysqli_fetch_array($buscaNombreEst)){
$cadenaEstandar=utf8_encode($x['estandar']);
}
echo "<h4>Estandar ".$cadenaEstandar.$prioridad."</h4><br>Instrumentos utilizados para ponderarlo: <br>";
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
$buscaInstrumento=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE id=$valor")or die ("Buscando error : ".mysqli_error($link));
while ($dameInstrumento=mysqli_fetch_array($buscaInstrumento)){
echo "· ".utf8_encode($dameInstrumento['instrumento'])."(Peso en nota final: ".number_format($mult/$numInstrumentos,4).")<br>";
}


}
echo "<br>Competencias trabajadas: <br>";


$competenciasTrabajadas=mysqli_query($link, "SELECT competencia FROM $nombreTablaCompetencias WHERE contenido=$estandarActual")or die ("Buscando error : ".mysqli_error($link));
foreach ($competenciasTrabajadas as $key=>$value){
$competenciaPertinente=$value['competencia'];
$buscaTexto=mysqli_query($link,"SELECT competencia FROM competencias WHERE id=$competenciaPertinente")or die ("Buscando error : ".mysqli_error($link));
while ($dameTexto=mysqli_fetch_array($buscaTexto)){
echo "- ".utf8_encode($dameTexto['competencia'])."<br>";
}
}

}
?>
