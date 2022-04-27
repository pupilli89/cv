<?php 
	
	function conexion()
	{
		return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
	}
		$conexion=conexion();

		$hora=$_POST['hora'];
		$fecha=$_POST['fecha'];
		$interno=$_POST['interno'];
		$solicitante=$_POST['solicitante'];
		$solicitantetaller=$_POST['solicitantetaller'];
		$cod_desp=$_POST['cod_desp'];
		$descrip=$_POST['descrip'];
		$bloqueo=$_POST['bloqueo'];

		if(buscaRepetido($interno,$conexion)==1){
			echo 2;}	

		else {

			$sql="INSERT into orden_taller (fecha_ingreso,hora_ingreso,interno,solicitante,cod_desper,descrip,bloqueo,pedidopor)
										values ('$fecha',
												'$hora',
												'$interno',
												'$solicitante',
												'$cod_desp',
												'$descrip',
												'$bloqueo',
												'$solicitantetaller')";
			mysqli_query($conexion, "SET NAMES 'utf8'");
			echo $result=mysqli_query($conexion,$sql);
		}
			


function buscaRepetido($interno, $conexion)
{

	$sql1 = "SELECT * from orden_taller where interno='$interno' and bloqueo='1'";

	$result1 = mysqli_query($conexion, $sql1);

	if (mysqli_num_rows($result1) > 0) {
		return 1;
	} else {
		return 0;
	}
}
 ?>



