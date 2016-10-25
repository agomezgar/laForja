<?php
 include('conectarse.php');

 if(isset($_POST["materia"]))
 {  
$curso= $_POST["curso"];
   $link=Conectarse();
$nombreMateria=$_POST["materia"];
$opcionesContenidos="";
$nombreTabla="estandares".$nombreMateria;
 $result = mysqli_query($link,"SELECT * FROM $nombreTabla where curso=$curso")or die ("No hay estandares registrados para esa materia");
$totalFilas    =    mysqli_num_rows($result);  
if ($totalFilas>0){
while($encuentraEstandares = mysqli_fetch_array($result)) {
    $opciones .="<p>".$encuentraEstandares['estandar']."</p>";
 }
     echo $opciones;
}
else{
echo "No hay estandares de esa materia registrados para ese curso en particular";
}

 }
?>
