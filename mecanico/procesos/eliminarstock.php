<?php 

		function conexion()
		{
			return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
		}
			$conexion=conexion();
	
			$idcarga=$_POST['idcarga'];


	$sql="DELETE from stock where id='$idcarga'";

	echo mysqli_query($conexion,$sql);

 ?>