<?php
session_start();
  include("conectarse.php");
   $link=Conectarse();
 $trimestre=$_POST["trimestre"];
$materia=$_POST["materia"];
$curso=$_POST["curso"];
$nombreTablaInstrumentos=$materia."Instrumentos".$curso;
$nombreTablaExamenes=$materia."notas".$curso;
$nombreTablaEstandares=$materia."organizacionestandares".$curso;
$listaEstandares="estandares".$materia;
echo "<br><h2>Pinche en un instrumento si desea eliminarlo. Para añadir instrumentos, pulse el botón de abajo</h2>";
echo "<table id=\"datosInst\" border=\"1\"><tr><th>Bloque de contenidos</th><th>Instrumento</th></tr>";
//echo $listaEstandares;
$buscaInstrumentos=mysqli_query($link,"SELECT contenido FROM $nombreTablaInstrumentos WHERE trimestre=$trimestre GROUP BY contenido")or die (mysqli_error($link));
while($encInst=mysqli_fetch_array($buscaInstrumentos)){
$idcontenido=$encInst[0];
//echo "<td>".$idcontenido."</td>";
$buscaContenidos=mysqli_query($link,"SELECT bloque FROM $listaEstandares WHERE curso=$curso GROUP BY bloque ")or die (mysqli_error($link));
while($encuentraContenidos=mysqli_fetch_array($buscaContenidos)){
$bloque=$encuentraContenidos['bloque'];
$dameid=mysqli_query($link,"SELECT id FROM $listaEstandares WHERE bloque='$bloque' AND curso=$curso LIMIT 1");
while($idencontrada=mysqli_fetch_array($dameid)){
$idbloque=$idencontrada[0];

}
$contBloque=substr($idbloque,-3,1);
$cursoBloque=substr($idbloque,-4,1);
//echo "contBloque: ".$contBloque."idContenido: ".$idcontenido;
if (($contBloque==$idcontenido)&&($cursoBloque==$curso)){
echo "<tr><td>".utf8_encode($bloque)."</td>";
$buscaInstrumentos2=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE contenido=$idcontenido");
while($encuentra2=mysqli_fetch_array($buscaInstrumentos2)){
echo "<td  id=\"".$encuentra2['id']."\"class=\"".utf8_encode($encuentra2['instrumento'])."\">".utf8_encode($encuentra2['instrumento'])."</td>";
}
echo "</tr>";
echo "<tr><td id=\"grabarInst\"><button type=\"button\" class=\"$contBloque\">Añadir instrumentos para este bloque de contenidos</button></td></tr>";
}
}
}
echo "</table>";
?>

