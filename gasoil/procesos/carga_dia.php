<?php 
	
	function conexion()
	{
		return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
    }
    $conexion=conexion();


    $sql="SELECT fechacarga FROM fecha_carga ORDER BY id DESC LIMIT 1";
		
		$result=mysqli_query($conexion,$sql);
		
	while ($mostrar=mysqli_fetch_row($result)) {

		$arr[] =$mostrar;
	}

	echo json_encode($arr);


    ?>