<?php 
if (!file_exists("config.php")){
header ("Location: ./admin/");
}?>
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
function CleanFiles($dir)
{
    //Borrar los ficheros temporales
    $t = time();
    $h = opendir($dir);
    while($file=readdir($h))
    {
        if(substr($file,0,3)=='tmp' && substr($file,-4)=='.pdf')
        {
            $path = $dir.'/'.$file;
            if($t-filemtime($path)>3600)
                @unlink($path);
        }
    }
    closedir($h);
}
CleanFiles("evaluacion1");
CleanFiles("evaluacion2");
CleanFiles("evaluacion3");
CleanFiles("evaluacionextra");
?>

<html>
<head>
<meta charset="UTF-8">
<title>Proyecto Vulcano</title>
</head>

<body>

<form action="procesaclaves.php" method="post" name="claves">
  <label for="textfield">Nombre:</label>
  <input name="nombre" type="text" id="nombre"/>
  <label for="label"><?php echo utf8_encode("Contraseña: ");?></label>
  <input name="contra" type="password" id="contra"  />
  <p>&nbsp;</p>
  <p>
    <label>
    <input type="submit" name="Submit" value="ENVIAR" />
    </label>
  <p>&nbsp; </p>
</form>
</body>
</html>
