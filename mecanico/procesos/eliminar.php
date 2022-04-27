<?php 

		function conexion()
		{
			return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
		}
			$conexion=conexion();
	
			$nro_orden=$_POST['nro_orden'];


	$sql="DELETE from orden_taller where nro_orden='$nro_orden'";

	echo mysqli_query($conexion,$sql);

 ?>