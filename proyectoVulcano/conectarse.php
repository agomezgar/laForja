
<?php


function Conectarse()
{require('config.php');
$conn = mysqli_connect($servidor, $usuario, $contra,$base);
//PONER FALSE,128 PROTEGE CONTRA ERRORES DATA LOCAL INSIDE
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

   
   return $conn;
}

$link=Conectarse();

mysqli_close($link); //cierra la conexion
?>

