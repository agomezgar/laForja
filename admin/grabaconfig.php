<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php

$abro_fichero = fopen('../config.php','w');
$servidor=$_POST['servidor'];
$base=$_POST['base'];
$usuario=$_POST['usuario'];
$contra=$_POST['contra'];
$nombrecentro=$_POST['nombrecentro'];
$direccion=$_POST['direccion'];
$curso=$_POST['curso'];
	$salto = "\n";
		
	$linea_1 = '<?php'; 
	fputs($abro_fichero,$linea_1); 
	fputs($abro_fichero,$salto);

	$linea_2 = '$servidor = \''.$servidor.'\';'; 
	fputs($abro_fichero,$linea_2); 
	fputs($abro_fichero,$salto);
		$linea_3 = '$base = \''.$base.'\';'; 
	fputs($abro_fichero,$linea_3); 
	fputs($abro_fichero,$salto);
		$linea_4 = '$usuario = \''.$usuario.'\';'; 
	fputs($abro_fichero,$linea_4); 
	fputs($abro_fichero,$salto);
		$linea_5 = '$contra = \''.$contra.'\';'; 
	fputs($abro_fichero,$linea_5); 
	fputs($abro_fichero,$salto);
			$linea_6 = '$nombrecentro = \''.$nombrecentro.'\';'; 
	fputs($abro_fichero,$linea_6); 
			$linea_7 = '$direccion = \''.$direccion.'\';'; 
	fputs($abro_fichero,$linea_7); 
	fputs($abro_fichero,$salto);
		$linea_9 = '$curso = \''.$curso.'\';'; 
	fputs($abro_fichero,$linea_9); 
	
	fputs($abro_fichero,$salto);
	$linea_8 = '?>'; 
	fputs($abro_fichero,$linea_8); 
		fputs($abro_fichero,$salto);

	fclose($abro_fichero);
	
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=creatablas.php\">";
	?>
</body>
</html>