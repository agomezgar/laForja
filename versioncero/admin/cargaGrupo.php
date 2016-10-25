<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Document</title>
</head>

<body>
<form action="procesaCsv.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <label>INSERTAR ARCHIVO CSV CORRESPONDIENTE A DATOS DE ALUMNOS (por defecto, datAlumnos.csv):<p>
  <input name="tablacsv" type="file" id="tablacsv" />
  </label>
  <p>
    <label>
    <input type="submit" name="Submit" value="ENVIAR" />
    </label>
  </p>
</form>

</body>
</html>