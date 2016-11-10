<?php session_start(); 
if (!isset ($_SESSION['identificado'])){echo "error; me has querido engañar";echo "<meta http-equiv=\"refresh\" content=\"5;URL=index.php\">";}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="./js/jquery-3.1.1.min.js"></script>
<script src="./scriptComplementario.js" language="javascript"></script>
<script>
$(document).ready(function(){
$("#curso").change(function(){
   $("#materia").prop("disabled", false);
curso=$("#curso").val();
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
profesor=$("#profesor").val();
materia=$("#materia").val();
curso=$("#curso").val();

  $.ajax({
      url:"verProfesor.php",
      type: "POST",
      data: {profesor:profesor,materia:materia},
      success: function(opciones){
        if (opciones==0){
alert("El profesor "+profesor+" no tiene permisos para esta materia.");
$("#curso").prop("disabled", true);
}else{
$("#curso").prop("disabled", false);
}
      }
  
    });
$.ajax({
      url:"compruebaMateriaCurso.php",
      type: "POST",
      data: {materia:materia,curso:curso},
      success: function(opciones){
        if (opciones==0){
alert("No hay programación preparada para esta materia o curso");
$("#trimestre").prop("disabled", true);
}else{
$("#trimestre").prop("disabled", false);
}
      }
  
    });

    });
  $("#trimestre").change(function(){
materia=$("#materia").val();
curso=$("#curso").val();
trimestre=$("#trimestre").val();
  $.ajax({
      url:"verInstrumento.php",
      type: "POST",
      data: {materia: materia, curso: curso, trimestre: trimestre},
      success: function(opciones){
$("#tablaDatos").html(opciones);
      },
   error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  
    });
    });
 
$(document).on('click', '#datosInst td', function() {
$(this).unbind('click');
 instrumento=$(this).attr('id');
clase=$(this).attr('class');
if(!($(this).is("#grabarInst"))){
      if (confirm('¿Desea vd. borrar '+clase+"?")){
  $.ajax({
      url:"eliminaInstrumento.php",
      type: "POST",
      data: {instrumento:instrumento,materia:materia,curso:curso},
      success: function(opciones){
        alert ("instrumento "+instrumento+" borrado");
$("#tablaDatos").html(opciones);
      },
   error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  
    });
  $.ajax({
      url:"verInstrumento.php",
      type: "POST",
      data: {materia: materia, curso: curso, trimestre: trimestre},
      success: function(opciones){
$("#tablaDatos").html(opciones);
      },
   error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  
    });
}else{
//alert("Instrumento conservado");
}
 }
});
$(document).on('click', '#datosInst :button', function() {
$(this).unbind('click');
contenido=$(this).attr('class');
materia=$("#materia").val();
curso=$("#curso").val();
nuevo=true;
trimestre=$("#trimestre").val();
instrumento=prompt("Introduzca instrumento de evaluación", "Instrumento");
//$(this).prop('disabled','true');
//alert(instrumento);
if (!instrumento.trim()){
alert("Debe especificar un nombre para el nuevo instrumento de evaluación");
}else{
       $.ajax({
      url:"compruebaInstrumento.php",
      type: "POST",
      async: false,
      data: {contenido: contenido, criterio: instrumento, trimestre: trimestre},
      success: function(opciones){
//alert(opciones);
if ($.trim(opciones)=='no'){
alert("Ya hay un instrumento con el nombre "+instrumento);
nuevo=false;
}
}
 });if (nuevo){
$.ajax({
      url:"asignaEstandaresInstrumentoIndividual.php",
      type: "POST",
      data: {trimestre: trimestre, materia: materia, curso: curso, contenido:contenido,instrumento:instrumento},
      success: function(opciones){
$("#tablaDatos").html(opciones);
      },
   error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  
    });
}}
});
$(document).on('change', '[type=checkbox]', function() {
// code here
comprobado=$(this).prop('checked');
instrumento=$(this).attr('name');
trimestre=$("#trimestre").val();
estandar=$(this).attr('class');
materia=$("#materia").val();
curso=$("#curso").val();
prioridad=$(this).attr('id');
//alert("Comprobado: "+comprobado);
//alert("Id instrumento: "+instrumento);
//alert("Id estandar: "+estandar);
//alert("Trimestre seleccionado: "+trimestre);
//alert("Prioridad: "+prioridad);
//alert("Materia: "+materia);
//alert("Curso: "+curso);
           $.ajax({
      url:"actualizaEstandaresB.php",
      type: "POST",
    data:{grabar: comprobado, prioridad: prioridad, idestandar: estandar, idinstrumento: instrumento, trimestre: trimestre, materia: materia, curso: curso},
      success: function(opciones){
     // $("#tablaDatos").html(opciones);
//alert ("Datos actualizados");
      },
   error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });
//alert("acabe");
}); 
$(document).on('click', '#nuevoInstrumentoGrabado', function() {
window.location.href='seleccionar.php';
});
});
</script>
<?php require ('config.php'); ?>
<div id="elige">

<?php
//cargamos materias en select materia
   include('conectarse.php');
   $link=Conectarse();
$opcionesMateria="";
 $result = mysqli_query($link,"SELECT * FROM materias")or die (mysqli_error($link));
while($encuentraMaterias = mysqli_fetch_array($result)) {
$opcionesMateria.='<option value="'.$encuentraMaterias["codigo"].'">'.utf8_encode($encuentraMaterias["materia"]).'</option>';
}
?>
<input type="hidden" id="profesor" value="<?php echo $_SESSION['profesor'];?>">
<select name="curso" id="curso">
<option  value="" selected="selected">Seleccione nivel</option>
<option  value="1" >1ºESO</option>
<option  value="2" >2ºESO</option>
<option  value="3" >3ºESO</option>
<option  value="4" >4ºESO</option>
<option  value="5" >1ºBACH</option>
<option  value="6" >2ºBACH</option>
<option  value="7" >1ºFPB</option>
<option  value="8" >2ºFPB</option>
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

</div>
<div id="tablaDatos">

</div>
