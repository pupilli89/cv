<?php 
	
	function conexion()
	{
		return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
	}
		$conexion=conexion();

		$familia=$_POST['familia'];
        $codigo=$_POST['codigo'];
        $repa=$_POST['repa'];


if (buscaRepetido($codigo, $conexion) == 1) {
	echo 2;
} else {


	$sql = "INSERT into cod_reparacion (codigo,familia,definicion)
										values ('$codigo',
												'$familia',
												'$repa')";
	mysqli_query($conexion, "SET NAMES 'utf8'");
	
	echo $result = mysqli_query($conexion, $sql);
}


function buscaRepetido($interno, $conexion)
{

	$sql1 = "SELECT * from cod_reparacion where codigo='$interno'";

	$result1 = mysqli_query($conexion, $sql1);

	if (mysqli_num_rows($result1) > 0) {
		return 1;
	} else {
		return 0;
	}
}


 ?>