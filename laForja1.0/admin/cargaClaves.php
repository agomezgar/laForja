<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="procesaClaves.php">
  <label>USUARIO:
  <input name="usuario" type="text" id="usuario" />
  </label>
  <p>
      <label>CONTRASE&Ntilde;A:
    <input name="contra" type="password" id="contra" />
    </label>
  </p>
  <p>
      <label>Perfil:
    <select name="perfil" id="perfil">
<option  value="profesor" selected="selected">Profesor</option>
<option value="jefe">Jefe de Departamento</option>

</select>
    </label>
  </p>
  

  <p>
    <label>
    <input type="submit" name="Submit" value="ENVIAR" />
    </label>
  </p>
</form>
</body>
</html>
