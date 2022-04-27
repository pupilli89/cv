<?php 
	
	function conexion()
	{
		return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
	}
		$conexion=conexion();

		$fechacarga=$_POST['fechacarga'];
		$gasolero=$_POST['gasolero'];
		$fecha=$_POST['fecha'];
		$interno=$_POST['interno'];
		$tipo=$_POST['tipo'];
		$aditivo=$_POST['aditivo'];
		$cant=$_POST['cant'];
		$aceite=$_POST['aceite'];
		$cant_acei=$_POST['cant_acei'];
		$hora=$_POST['hora'];
		$cant_gasoil=$_POST['cant_gasoil'];

		if(chequeo($fechacarga,$conexion)==1){
			echo 3;}
			
		else if(buscaRepetido($interno,$conexion,$fechacarga)==1){
			echo 2;}
			
		else{
		$sql="INSERT into carga (gasolero,fecha,interno,tipo,aditivo,cant,aceite,cant_acei,hora,fecha_carga)
									values ('$gasolero',
											'$fecha',
											'$interno',
											'$tipo',
											'$aditivo',
											'$cant',
											'$aceite',
											'$cant_acei',
											'$hora',
											'$fechacarga')";

		echo $result=mysqli_query($conexion,$sql);

		}

		
	function buscaRepetido($interno,$conexion,$fechacarga){

		$sql="SELECT * from carga where interno='$interno' and fecha_carga='$fechacarga'";
		
		$result=mysqli_query($conexion,$sql);
		
			if(mysqli_num_rows($result) > 0){
				return 1;
			}else{
				return 0;
			}
	}


	function chequeo($fechacarga,$conexion){
	
		$sql="SELECT COUNT(interno) as total FROM carga where fecha_carga='$fechacarga'";
		
		$result=mysqli_query($conexion,$sql);
	
		$row = mysqli_fetch_assoc($result) ;
	
		$nom_rows= $row['total'];
	
			if($nom_rows == 54){
	
				$conexion1=conexion();
	
				$sql1 ="SET @ulimodia :=(SELECT max(fechacarga) from planillas63.fecha_carga);";
				$sql1 .="INSERT INTO planillas63.fecha_carga (fechacarga) values (DATE_ADD( @ulimodia ,INTERVAL 1 DAY));";
	
				/* execute multi query */
					if (mysqli_multi_query($conexion1, $sql1)) {
						do {
							if ($result1 = mysqli_store_result($conexion1)) {
								while ($row = mysqli_fetch_row($result1)) {
								}
								mysqli_free_result($result1);
							}
							if (mysqli_more_results($conexion1)) {
							}
						} while (mysqli_next_result($conexion1));
					}
					mysqli_close($conexion1);

				return 1;
			}
			return 0;
		}

 ?>

