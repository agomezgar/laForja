<?php session_start(); 
if (!isset ($_SESSION['identificado'])){echo "error; me has querido engañar";echo "<meta http-equiv=\"refresh\" content=\"5;URL=index.php\">";}
if ($_SESSION['perfil']=='profesor'){
echo "NO TIENE VD. ASIGNADOS PERMISOS DE JEFE DE DEPARTAMENTO";
echo "<meta http-equiv=\"refresh\" content=\"3;URL=index.php\">";
}
?>
<script src="./js/jquery-3.1.1.min.js"></script>
<script src="./scriptComplementario.js" language="javascript"></script>
<script>
$(document).ready(function(){
cuentaTotal=0;
    $("#curso").change(function(){
         $("#materia").prop("disabled", false);
    });


    $("#materia").change(function(){
           $.ajax({
      url:"procesaMateria.php",
      type: "POST",
      data: {materia: $("#materia").val(), curso: $("#curso").val()},
      success: function(opciones){
        $("#estandares").html(opciones);
      }
    });

    });
$(document).on('change', '.competencia', function() {
	if($(this).is(':checked')) { 
activado=1;
}else{
activado=0;
}
 contenido=$(this).attr('name');
competencia=$(this).val();
           $.ajax({
      url:"procesaCompetencia.php",
      type: "POST",
      data: {activado: activado, contenido: contenido, competencia: competencia},
      success: function(opciones){
  // $("#estandares").html(opciones);
      }
    });

 });
$(document).on('click', '.grabaInst', function() {
	nombreTrim="#trim"+$(this).attr('name');
contenido=$(this).attr('name');
if($(nombreTrim).val()==""){
alert("Seleccione trimestre, por favor");
}else{
trimestre=$(nombreTrim).val();
textos="#Tabla"+contenido+" input[type='text']";
//alert(textos);
//alert ($(textos).length);
          $.ajax({
      url:"borraInstrumento.php",
      type: "POST",
      data: {contenido: contenido},
      success: function(opciones){
  //$("#estandares").html(opciones);
      }
    });
for (i=0;i<$(textos).length;i++){
//alert ($(textos)[i].value);
instrumento=$(textos)[i].value;
           $.ajax({
      url:"grabaInstrumento.php",
      type: "POST",
      data: {contenido: contenido, criterio: instrumento, trimestre: trimestre},
      success: function(opciones){
  //$("#estandares").html(opciones);
      }
    });


}
alert("Instrumentos grabados");
nombreCapa="#Tabla"+contenido;
$(nombreCapa).find('input, textarea, button, select').attr('disabled','disabled');
}



 });
$(document).on('change', '.nInst', function() {
	contenido="Tabla"+$(this).attr('name');
nContenido=$(this).attr('name');
trimestre="trim"+$(this).attr('name');
//alert(contenido);
cuentaInstrumentosEvaluacion=0;
cadena="<table>";
numeroInst=$(this).val();
for (i=0;i<numeroInst;i++){
cuentaTotal++;
cuentaInstrumentosEvaluacion++;
 nombreCriterio="criterio["+cuentaTotal+"]";
 nombreContenido="contenido["+cuentaInstrumentosEvaluacion+"]";
nombreTrimestre="trimestre["+cuentaInstrumentosEvaluacion+"]";

cadena+="<tr><td>"+ "<input name=\""+nombreCriterio+"\" type=\"text\" value=\"Examen"+cuentaTotal+"\"/ ></td></tr>";
}
cadena+="</table><input type=\"submit\" name=\""+nContenido+"\" class=\"grabaInst\" value=\"Grabar\">";
$("#"+contenido).html(cadena);
//$(this).prop('disabled', true);
 });
$(document).on('click', '#enviar', function() {
$("#cuerpo").load("organizaEstandares.php");

});
});
</script>
<?php require ('config.php'); ?>


<?php

//cargamos materias en select materia
   include('conectarse.php');
   $link=Conectarse();

$opcionesCurso="";
 $result = mysqli_query($link,"SELECT * FROM materias")or die (mysqli_error($link));
while($encuentraMaterias = mysqli_fetch_array($result)) {
$opcionesCurso.='<option value="'.$encuentraMaterias["codigo"].'">'.utf8_encode($encuentraMaterias["materia"]).'</option>';

}
//echo $_SESSION['identificado'];
?>
<div id="otrasopciones">
<button type="button" id="cargaProfesores" value="cargaProfesores.php">Asignar profesores</button>
</div>
<table>
<tr>
<td>
<select name="curso" id="curso">
<option  value="" selected="selected">Seleccione curso</option>
<option value="1">1º</option>
<option value="2">2º</option>
<option value="3">3º</option>
<option value="4">4º</option>
</select>
</td>
<td>
<select name="materia" id="materia" disabled="disabled">
<option value="">Seleccione materia</option>
<?php
echo $opcionesCurso;
?>
</select>
</td>
</tr>

</table>


<div id="estandares">

</div>

