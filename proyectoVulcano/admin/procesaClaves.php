<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
 <html>
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Procesando clave enviada</title>
</head>

<body>
<?php
   include("conectarse.php");
   $link=Conectarse();
   $usuario=$_POST['usuario'];
   $contra=md5($_POST['contra']);
   $perfil=$_POST['perfil'];
echo $tutoria;

   mysqli_query($link,"insert into claves (nombre,contra,perfil) values('".$usuario."','".$contra."','".$perfil."')")or die (mysqli_error($link));
   echo "<meta http-equiv=\"refresh\" content=\"0;URL=elige.php\">";
   ?>
</body>
</html>
