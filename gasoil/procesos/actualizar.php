<?php 


	function conexion()
	{
		return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
	}
		$conexion=conexion();

		$idcarga=$_POST['idcarga'];
		$interno=$_POST['interno'];
		$tipo=$_POST['tipo'];
		$aditivo=$_POST['aditivo'];
		$cant=$_POST['cant'];
		$aceite=$_POST['aceite'];

					$sql="UPDATE carga set cant='$interno',
										tipo='$tipo',
										aditivo='$aditivo',
										aceite='$aceite',
										cant_acei='$cant'
						where idcarga='$idcarga'";

		echo $result=mysqli_query($conexion,$sql);


	
 ?>