
<?php

/*
 *    
 *      Copyright 2016 Antonio Gomez Garcia <agomeztron@yahoo.es>
 *      
 * Este programa es software libre; lo puedes redistribuir y/o modificar
 * bajo los terminos de la licencia publica GNU, publicada por la Free 
 * Software Foundation; ya sea la version 2 de la licencia, o cualquier 
 * version posterior.
 * 
 * Este programa se esta distribuyendo con la esperanza de que sea util 
 * a la comunidad, pero SIN NINGUNA GARANTIA, ¡RECLAMACIONES, AL MAESTRO 
 * ARMERO!, que decian en la mili. Si te quedas con la duda, examina los
 * terminos de la licencia GNU
 * 
 * Deberias haber recibido una copia de la Licencia Publica General GNU 
 * junto con esta aplicacion. Si no es asi, y te da pereza tirar de In-
 * ternet, escribe a: Free Software Foundation, Inc., 51 Franklin Street
 * , Fifth Floor, Boston, MA 02110-1301,USA.
 * 
 */
?>

 <?php 


   include("conectarse.php");
   $link=Conectarse();
   $nombre=$_POST['nombre'];
   $contra=md5($_POST['contra']);

	$result = mysqli_query($link,"SELECT * FROM claves WHERE nombre='$nombre' AND contra='$contra'")or die (mysqli_error($link));
$row = mysqli_fetch_array($result);

if ((!isset($row[0]))) {


echo "El Usuario con Nombre <B>".$_POST['nombre']."</B> no est&aacute; registrado en nuestra base de datos o no ha introducido adecuadamente su clave."; mysqli_close();
} else{
session_start(); // start session.

	$_SESSION["perfil"] = $row["perfil"]; 

        $_SESSION["identificado"] = "SI";
	$_SESSION["profesor"] = $_POST['nombre']; 
echo "<meta http-equiv=\"refresh\" content=\"5;URL=seleccionar.php\">";
}
  ?>

  



</body>
</html>
