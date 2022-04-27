<?php 
	
	function conexion()
	{
		return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
	}
		$conexion=conexion();

		$nuevo=$_POST['nuevo'];

			$sql="INSERT into item_check (item_check_descript)
										values ('$nuevo')";

			echo $result=mysqli_query($conexion,$sql);
		

 ?>