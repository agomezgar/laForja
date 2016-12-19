 <?php session_start(); 
if (!isset ($_SESSION['identificado'])){echo "error; me has querido engañar";echo "<meta http-equiv=\"refresh\" content=\"5;URL=index.php\">";}
?>
<script src="./js/jquery-3.1.1.min.js"></script>
<script src="./scriptComplementario.js" language="javascript"></script>
<script>
$(document).ready(function(){
    $("#grupo").change(function(){
         $("#alumno").prop("disabled", false);
grupo=$("#grupo option:selected").text();
//alert (grupo);
$.ajax({
      url:"cargaAlumnos.php",
      type: "POST",
      data: {grupo: grupo},
      success: function(opciones){
        $("#selectAlumnos").html(opciones);
      },
   error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
 });
    });


  $("#selectAlumnos").change(function(){

$("#materia").prop("disabled", false);
etapa=$("#grupo").val();
//alert(etapa);
grupo=$("#grupo").find(":selected").text()
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
      url:"cargaMaterias.php",
      type: "POST",
      data: {curso: curso},
      success: function(opciones){

        $("#materia").html(opciones);
      },
   error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

});
    $("#materia").change(function(){

$("#trimestre").prop("disabled", false);
profesor=$("#profesor").val();
materia=$("#materia").val();
etapa=$("#grupo").val();
curso="";
//valores 1,2,3,4 para ESO, 5,6 para Bachillerato, 7,8 para FPB
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
      url:"compruebaMateriaCurso.php",
      type: "POST",
      data: {materia: materia, curso:curso},
      success: function(opciones){
          if (opciones==0){
alert("No hay instrumentos de evaluación previstos para esta materia en este nivel.");
$("#trimestre").prop("disabled", true);
}else{
$("#trimestre").prop("disabled", false);
}
      },
   error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  
    });
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

materia=$("#materia").val();
etapa=$("#grupo").val();
grupo=$("#grupo").find(":selected").text()
trimestre=$("#trimestre").val();
alumno=$("#alumno").val();
curso="";
//valores 1,2,3,4 para ESO, 5,6 para Bachillerato, 7,8 para FPB
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
//alert(materia+", "+trimestre+", "+curso+", "+alumno);
         $.ajax({
      url:"dameNotasIndividual.php",
      type: "POST",
      data: {materia: materia, trimestre: trimestre,curso:curso, alumno: alumno},
      success: function(opciones){
        $("#tablaDatos").html(opciones);
      },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
     alert(errorThrown);
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
      },
 error: function(XMLHttpRequest, textStatus, errorThrown) {
     alert(errorThrown);
  }
 });
    });
    });
//Permitimos cambiar notas online
$(document).on('change', '.nota', function() {
valor=$(this).val();
idNota=$(this).attr('id');
if (($.isNumeric(valor))&&(valor<11)&&(valor>(-1))){
//alert($(this).attr('id'));
 $.ajax({
      url:"cambiaNotas.php",
      type: "POST",
      data: {idNota: idNota, valor: valor,materia: materia, curso: curso},
      success: function(opciones){
        //$("#tablaDatos").html(opciones);

      }
 });
         $.ajax({
      url:"dameNotasIndividual.php",
      type: "POST",
      data: {materia: materia, trimestre: trimestre,curso:curso, alumno: alumno},
      success: function(opciones){
        $("#tablaDatos").html(opciones);
      },
  error: function(XMLHttpRequest, textStatus, errorThrown) {
     alert(errorThrown);
  }
  
    });
}
else{
alert("Introduzca un valor de nota adecuado");
}
});
$(document).on('click', '#pdfIndividual', function() {
//alert("Materia: "+materia+", grupo: "+grupo+", curso: "+curso+", trimestre: "+trimestre+", alumno: "+alumno);
cadena='<form method="post" action="dameNotasIndividualpdf.php" target="_blank">';
cadena=cadena+'<input type="hidden" name="grupo" value="'+grupo+'">';
cadena=cadena+'<input type="hidden" name="materia" value="'+materia+'">';
cadena=cadena+'<input type="hidden" name="trimestre" value="'+trimestre+'">';
cadena=cadena+'<input type="hidden" name="curso" value="'+curso+'">';
cadena=cadena+'<input type="hidden" name="alumno" value="'+alumno+'">';
cadena=cadena+'</form>';
//alert(cadena);
$(cadena).appendTo('body').submit();
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
$opcionesAlumno="";
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
<div id="selectAlumnos">
<select name="alumno" id="alumno" disabled="disabled">
<option value="">Seleccione Alumno</option>

</select>
</div>
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

</div>
<div id="tablaDatos">

</div>
