<?php 


	function conexion()
	{
		return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
	}
		$conexion=conexion();

		mysqli_query($conexion, "SET NAMES 'utf8'");

        $id=$_POST['id'];
		$familia=$_POST['familia'];
		$codigo=$_POST['codigo'];
		$descripcion=$_POST['descripcion'];


					$sql="UPDATE cod_reparacion set codigo='$codigo',
										familia='$familia',
										definicion='$descripcion'
						where id='$id'";

		echo $result=mysqli_query($conexion,$sql);


	
 ?>