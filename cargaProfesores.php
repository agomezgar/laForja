<?php
session_start();
   include("conectarse.php");
   $link=Conectarse();
echo "Espacio reservado para asignar profesores a cada materia";
$buscaMaterias=mysqli_query($link,"SELECT * FROM materias")or die (mysqli_error($link));
$buscaProfesores=mysqli_query($link,"SELECT * FROM claves")or die (mysqli_error($link));
?>
<table>
<tr>
<td>
<?php
echo "<select id=\"asignaMateria\" >";
while($encuentraMaterias=mysqli_fetch_array($buscaMaterias)){
echo "<option value=\"".$encuentraMaterias['codigo']."\">".utf8_encode($encuentraMaterias['materia'])."</option>";
}
echo "</select>";

?>
</td>
<td>
<?php
echo "<select id=\"asignaProfesor\" multiple=\"multiple\">";
while($encuentraProfesores=mysqli_fetch_array($buscaProfesores)){
echo "<option value=\"".$encuentraProfesores['nombre']."\">".$encuentraProfesores['nombre']."</option>";
}
echo "</select>";

?>


</td>
</tr>
<tr><td>
<button type="button" id="grabaAsignaProfesores">Asignar profesores seleccionados a esta materia</button> 
</td>
</tr>

</table>


