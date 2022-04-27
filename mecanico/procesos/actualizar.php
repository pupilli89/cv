<?php 


	function conexion()
	{
		return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
	}
		$conexion=conexion();

		$horac=$_POST['horac'];
		$fechac=$_POST['fechac'];
		$nro_orden=$_POST['nro_orden'];
		$solicitantec=$_POST['solicitantec'];
		$insum=$_POST['insum'];
		$repac=$_POST['repac'];
		$bloqueoc=$_POST['bloqueoc'];

					$sql="UPDATE orden_taller set fecha_sal='$fechac',
										hora_sal='$horac',
										sol_salida='$solicitantec',
										insumos='$insum',
										repa='$repac',
										bloqueo='$bloqueoc'
						where nro_orden='$nro_orden'";

		echo $result=mysqli_query($conexion,$sql);


	
 ?>