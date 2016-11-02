<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<?php
   include("conectarse.php");
   $link=Conectarse();


//copiamos el archivo a la carpeta temporal
  //    Script Que copia el archivo temporal subido al servidor en un directorio.
$tipo = $_FILES['tablacsv']['type'];

//    Definimos Directorio donde se guarda el archivo
$dir = '../archivos/';


echo "Copiando archivos...";
if (!copy($_FILES['tablacsv']['tmp_name'], $dir.$_FILES['tablacsv']['name']))
echo '<script> alert("'.$id_error_upload.'");</script>';

//una vez transferido, lo abrimos e insertamos en la base de datos la información
//abro el archivo
echo "Moviendo archivos...";
move_uploaded_file($_FILES['tablacsv']['tmp_name'],$dir.$_FILES['tablacsv']['name']);
$arch=$dir.$_FILES['tablacsv']['name'];

	$carga="LOAD DATA LOCAL INFILE '$arch' INTO TABLE matriculas CHARACTER SET latin1 FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' IGNORE 1 LINES";
echo "Grabando archivos...";
mysqli_query($link,$carga) or die (mysql_error());

	   $gruposinstituto = mysqli_query($link,"SELECT DISTINCT grupo FROM matriculas ");

while($row = mysqli_fetch_array($gruposinstituto)) {
echo $row['grupo'];
mysqli_query($link,"insert into gruposinf (nombre) values ('".$row['grupo']."')");
$compruebagrupo=mysqli_query($cadenaComprueba);
//$compruebagrupo=mysqli_query("SELECT * FROM gruposinf WHERE nombre=$grupoclase");

	}
echo "<meta http-equiv=\"refresh\" content=\"0;URL=elige.php\">";
	



?>

        <?php
        // put your code here
        ?>
    </body>
</html>
