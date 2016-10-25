<?php 
if (file_exists("../config.php")){
header ("Location: elige.php");
}?>

<!DOCTYPE html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Administración </title>
</head>

<body>
<form id="form1" name="form1" method="post" action="grabaconfig.php">
  <label>Servidor:
  <input name="servidor" type="text" id="servidor" value="normalmente, es localhost" size="50%" />
  </label>
  <p>Nombre de base:
    <label>
    <input name="base" type="text" id="base" value="Introduce el nombre de tu base de datos" size="50%" />
    </label>
</p>
  <p>Nombre de usuario:
    <label>
    <input name="usuario" type="text" id="usuario" value="Introduce el nombre de usuario de la base" size="50%" />
    </label>
</p>
  <p>Contrase&ntilde;a:
    <label>
    <input name="contra" type="password" id="contra" />
    </label>
  </p>
  <p>Nombre del centro: 
    <label>
    <input name="nombrecentro" type="text" id="nombrecentro" value="Introducir nombre que queremos que aparezca en los informes" size="50%" />
    </label>
  </p>
  <p>Direcci&oacute;n: 
    <label>
    <input name="direccion" type="text" id="direccion" />
    </label>
  </p>
<p>Curso:
    <label>
    <input name="curso" type="text" id="curso" />
    </label>
</p>
  <p>
    <label>
    <input type="submit" name="Submit" value="Grabar datos" />
    </label>
  </p>
</form>
</body>
</html>
