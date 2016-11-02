<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<html>
<head>
   <title>CONEXIÓN</title>
</head>
<body>
<?php


function Conectarse()
{require('../config.php');
$conn = mysqli_connect($servidor, $usuario, $contra,$base);
//PONER FALSE,128 PROTEGE CONTRA ERRORES DATA LOCAL INSIDE
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
   
   return $conn;
}
echo "Probando función...";
$link=Conectarse();
echo "Cerrando conexión...";

mysqli_close($link); //cierra la conexion
?>
</body>
</html> 
</body>
</html>
