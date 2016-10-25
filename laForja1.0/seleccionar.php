<?php session_start();
if (!isset ($_SESSION['identificado'])){echo "error; me has querido engañar";echo "<meta http-equiv=\"refresh\" content=\"5;URL=index.php\">";}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="./js/jquery-3.1.1.min.js"></script>
<script>
$(document).ready(function(){
perfil=$("#perfil").val();
if (perfil=="profesor"){
$( "#programar" ).prop( "disabled", true );
}

  $(":button").click(function(){ 
   //alert ($(this).val());
valor=$(this).val();
//alert(valor);
$("#cuerpo").load(valor);
});
     $("#enviaClaves").click(function(){ 
   //alert ($(this).val());
valor=$(this).val();
//alert(valor);
$("#cuerpo").load(valor);
});
$(document).on('click', '#cargaProfesores', function() {

$("#estandares").load("cargaProfesores.php");
});

$(document).on('click', '#grabaAsignaProfesores', function() {
materia=$("#asignaMateria").val();
profesor=$("#asignaProfesor :selected");
cadena="";
//alert ("Profesores "+profesor+" asignados a materia "+materia);
$(profesor).each(function(i, selected){ 
  

  $.ajax({
      url:"grabaProfesor.php",
      type: "POST",
      data: {profesor: $(selected).text(), materia: materia},
      success: function(opciones){
  //$("#estandares").html(opciones);
      }
    });

});
if ($("#asignaProfesor :selected").length==1){
alert("El profesor/ -a "+$("#asignaProfesor").val()+" ha sido asignado a la materia de "+materia);
}else{
alert("Los profesores "+$("#asignaProfesor").val()+" han sido asignados a la materia de "+materia);
}
});
$(document).on('click', '.enviaClaves', function() {
nombre=$("#nombre").val();
contra=$("#contra").val();
 $.ajax({
      url:"procesaclaves.php",
      type: "POST",
    data:{nombre:nombre, contra:contra},
      success: function(opciones){
      // $("#asignaEstandares").html(opciones);
//alert ("Datos actualizados");

valor=opciones;
if (valor==1){
alert ("¡Atención! Cualquier programación que realice para un curso y materia borrará toda la información anterior. Sea cauto");
 $("#cuerpo").load("programa.php");
}else{
//alert("Clave incorrecta");
$("#cuerpo").html("La clave introducida no es válida");
}
      }

    });
});
});
</script>
<title><?php echo "Profesor: ".$_SESSION['profesor'];?></title>
</head>
<body>
<?php

if (!file_exists("config.php")){
header ("Location: ./admin/");
}
?>
<div id="cabecera">
<input type="hidden" id="perfil" value="<?php echo $_SESSION['perfil'];?>">
<table>
<tr>
 <td><button type="button" id="programar" value="programa.php"onclick="alert('¡Cuidado! Cualquier información anterior relativa al curso y materia seleccionados se borrará. Sea cauto.')">Programar</button> </td>
 <td><button type="button" value="ponernotas.php">Poner notas</button> </td>
 <td><button type="button" value="vernotas.php">Ver notas por grupo</button> </td>
<td><button type="button" value="vernotasAlumno.php">Ver notas por alumno</button> </td>
<td><button type="button" value="otroInstrumento.php">Añadir instrumentos de evaluación</button> </td>
 <td><button type="button" value="vercalificaciones.php">Justificar calificaciones</button> </td>
</table>
</div>
<div id="cuerpo">

</div>
</body>

</html>
