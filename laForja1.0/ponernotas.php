<?php session_start(); 
if (!isset ($_SESSION['identificado'])){echo "error; me has querido engañar";echo "<meta http-equiv=\"refresh\" content=\"5;URL=index.php\">";}
?>
<script src="./js/jquery-3.1.1.min.js"></script>
<script src="./scriptComplementario.js" language="javascript"></script>
<script>
$(document).ready(function(){
    $("#grupo").change(function(){
         $("#materia").prop("disabled", false);

    });


    $("#materia").change(function(){

$("#trimestre").prop("disabled", false);
profesor=$("#profesor").val();
materia=$("#materia").val();
  $.ajax({
      url:"verProfesor.php",
      type: "POST",
      data: {profesor:profesor,materia:materia},
      success: function(opciones){
        if (opciones==0){
alert("El profesor "+profesor+" no tiene permisos para esta materia.");
$("#trimestre").prop("disabled", true);
}else{
$("#trimestre").prop("disabled", false);
}
      }
  
    });
    });
  $("#trimestre").change(function(){
$("#instrumento").prop("disabled", false);
materia=$("#materia").val();
etapa=$("#grupo").val();
grupo=$("#grupo").find(":selected").text()
trimestre=$("#trimestre").val();
curso="";
switch (etapa) { 
	case '667': 
		curso=grupo.substring(0,1);
		break;
	case '31': 
		curso=parseInt(grupo.substring(0,1))+4;
		break;
	case '1153': 
		curso=parseInt(grupo.substring(0,1))+6;
		break;	
}


         $.ajax({
      url:"procesaInstrumento.php",
      type: "POST",
      data: {grupo: grupo,materia: materia, trimestre: trimestre,curso:curso},
      success: function(opciones){
        $("#instrumento").html(opciones);
      }
  
    });
    $("#instrumento").change(function(){
instrumento=$("#instrumento").val();
 $.ajax({
      url:"procesaExamen.php",
      type: "POST",
      data: {grupo: grupo,materia: materia, trimestre: trimestre,curso:curso,instrumento:instrumento},
      success: function(opciones){
        $("#tablaExamen").html(opciones);
      }
 });
    });
    });
$(document).on('click', '#grabar', function() {

 $.ajax({
      url:"grabaExamen.php",
      type: "POST",
      data: { grupo: grupo, alumno: alumno, nota: nota, nombreTablaExamenes: nombreTablaExamenes},
      success: function(opciones){
       alert(opciones);
      }

 });
 });
});
</script>
<?php require ('config.php'); ?>
<div id="elige">

<?php

//cargamos materias en select materia
   include('conectarse.php');
   $link=Conectarse();

$opcionesGrupos="";
 $result = mysqli_query($link,"SELECT DISTINCT grupo,etapa FROM matriculas ORDER BY grupo");
while($encuentraGrupos = mysqli_fetch_array($result)) {
$opcionesGrupos.='<option value="'.$encuentraGrupos["etapa"].'">'.utf8_encode($encuentraGrupos["grupo"]).'</option>';

}
$opcionesMateria="";
 $result = mysqli_query($link,"SELECT * FROM materias")or die (mysqli_error($link));
while($encuentraMaterias = mysqli_fetch_array($result)) {
$opcionesMateria.='<option value="'.$encuentraMaterias["codigo"].'">'.utf8_encode($encuentraMaterias["materia"]).'</option>';

}
?>
<input type="hidden" id="profesor" value="<?php echo $_SESSION['profesor'];?>">
<select name="grupo" id="grupo">
<option  value="" selected="selected">Seleccione grupo</option>
<?php echo $opcionesGrupos;?>
</select>
<select name="materia" id="materia" disabled="disabled">
<option value="">Seleccione materia</option>
<?php echo $opcionesMateria;?>
</select>
<select name="trimestre" id="trimestre" disabled="disabled">
<option value="">Seleccione trimestre</option>
<option value="1">1º</option>
<option value="2">2º</option>
<option value="3">3º</option>
</select>
<select name="instrumento" id="instrumento" disabled="disabled">
<option value="">Seleccione instrumento de evaluación</option>

</select>
</div>
<div id="tablaExamen">

</div>
