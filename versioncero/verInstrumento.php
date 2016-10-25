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
echo "<table border=\"1\"><tr><th>Bloque de contenidos</th><th>Instrumento</th></tr>";
//echo $listaEstandares;
$buscaInstrumentos=mysqli_query($link,"SELECT DISTINCT contenido FROM $nombreTablaInstrumentos WHERE trimestre=$trimestre")or die (mysqli_error($link));
while($encInst=mysqli_fetch_array($buscaInstrumentos)){
$idcontenido=$encInst[0];

//echo $idcontenido;
$buscaContenidos=mysqli_query($link,"SELECT DISTINCT bloque, id FROM $listaEstandares GROUP BY bloque");
while($encuentraContenidos=mysqli_fetch_array($buscaContenidos)){
$bloque=$encuentraContenidos['bloque'];
$idbloque=$encuentraContenidos['id'];
$contBloque=substr($idbloque,-3,1);
$cursoBloque=substr($idbloque,-4,1);
//echo "contBloque: ".$contBloque."idContenido: ".$idcontenido;

if (($contBloque==$idcontenido)&&($cursoBloque==$curso)){
echo "<tr><td>".utf8_encode($bloque)."</td>";
$buscaInstrumentos2=mysqli_query($link,"SELECT * FROM $nombreTablaInstrumentos WHERE contenido=$idcontenido");
while($encuentra2=mysqli_fetch_array($buscaInstrumentos2)){
echo "<td>".$encuentra2['instrumento']."</td>";
}
echo "</tr>";
}

}



}
echo "</table>";

?>

