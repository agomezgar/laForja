
<script src="./js/jquery-3.1.1.min.js"></script>
<script src="./scriptComplementario.js" language="javascript"></script>
<script>
$(document).ready(function(){

  $(":button").click(function(){ 
 //  alert ($(this).val());
valor=$(this).val();
//alert(valor);
//$("#cuerpo").load(valor);
           $.ajax({
      url:"asignaEstandares.php",
      type: "POST",
    data:{trimestre: valor},
      success: function(opciones){
        $("#asignaEstandares").html(opciones);
      }
    });
});
  $(".cierra").click(function(){ 
 //  alert ($(this).val());
//valor=$(this).val();
//alert(valor);
//$("#cuerpo").load(valor);
  window.location.href='seleccionar.php';
});
$(document).on('change', '[type=checkbox]', function() {
// code here
i=$(this).attr('class');
comprobado=$(this).prop('checked');
nombre=$(this).attr('name');
//alert(nombre);
$('.'+i).each(function(key,value){
switch(key) {
    case 0:
        estandar=$(value).val();
        break;
    case 1:
        trimestre=$(value).val();
        break;
    case 2:
        prioridad=$(value).val();
	if (prioridad==4){

alert("Marque LA prioridad del estandar, por favor");
$("input:checkbox."+i).prop('checked',false);

}
        break;
   

} 

    });
//alert("Comprobado: "+comprobado);
//alert("Id instrumento: "+nombre);
//alert("Id estandar: "+estandar);
//alert("Trimestre seleccionado: "+trimestre);
//alert("Prioridad: "+prioridad);
           $.ajax({
      url:"actualizaEstandares.php",
      type: "POST",
    data:{prioridad: prioridad, idestandar: estandar, idinstrumento: nombre, trimestre: trimestre,grabar: comprobado},
      success: function(opciones){
      // $("#asignaEstandares").html(opciones);
//alert ("Datos actualizados");

      }
    });
}); 
});
</script>
<?php require ('config.php'); ?>


<?php
session_start();
include("conectarse.php");
  $link=Conectarse();

?><h1>Seleccione Trimestre</h1>
<div id ="nTrimestre">
<table>
<tr>
 <td><button type="button" value="1">Trimestre 1</button> </td>
 <td><button type="button" value="2">Trimestre 2</button> </td>
 <td><button type="button" value="3">Trimestre 3</button> </td>
<td><button type="button" class="cierra" value="4">He acabado</button> </td>
</table>

</div>
<div id="asignaEstandares">

</div>

