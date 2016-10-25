<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Procesando &iacute;tems</title>
</head>

<body>
<?php
   include("conectarse.php");
   $link=Conectarse();
   $usuario=$_POST['usuario'];
   $contra=$_POST['contra'];
   $item1=$_POST['item1'];
    $item2=$_POST['item2'];
	 $item3=$_POST['item3'];
	  $item4=$_POST['item4'];
	   $item5=$_POST['item5'];
	    $item6=$_POST['item6'];
		 $item7=$_POST['item7'];
		 echo $item1;
		 echo $item2;
 
   
   mysql_query("Update tablaitems set item1='$item1',item2='$item2',item3='$item3',item4='$item4',item5='$item5',item6='$item6',item7='$item7' where id=1",$link);
   echo "<meta http-equiv=\"refresh\" content=\"0;URL=elige.php\">";
   ?>
</body>
</html>