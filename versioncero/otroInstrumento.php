<?php session_start(); 
if (!isset ($_SESSION['identificado'])){echo "error; me has querido engañar";echo "<meta http-equiv=\"refresh\" content=\"5;URL=index.php\">";}
?>
<script src="./js/jquery-3.1.1.min.js"></script>
<script src="./scriptComplementario.js" language="javascript"></script>
<script>
$(document).ready(function(){



    $("#materia").change(function(){


profesor=$("#profesor").val();
materia=$("#materia").val();
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
  $("#curso").change(function(){
materia=$("#materia").val();
curso=$("#curso").val();
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

<select name="materia" id="materia">
<option value="">Seleccione materia</option>
<?php echo $opcionesMateria;?>
</select>
<select name="curso" id="curso" disabled="disabled">
<option value="">Seleccione nivel</option>
<option value="1">1º ESO</option>
<option value="2">2º ESO</option>
<option value="3">3º ESO</option>
<option value="4">4º ESO</option>
<option value="5">1º BACH</option>
<option value="6">2º BACH</option>
<option value="7">1º FPB</option>
<option value="8">2º FBP</option>
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
