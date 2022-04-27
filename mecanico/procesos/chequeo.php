<?php 

    require_once "../php/conexion.php";
    
	unset($_SESSION['user']);

	$conexion=conexion();

	$fechacarga=$_POST['fechacarga'];

	$sql="SELECT COUNT(interno) as total FROM carga where fecha_carga='$fechacarga'";
	
	$result=mysqli_query($conexion,$sql);

	$row = mysqli_fetch_assoc($result) ;

	$nom_rows= $row['total'];

		if($nom_rows ==1){

			$conexion1=conexion();

			$sql1 ="SET @ulimodia :=(SELECT max(fechacarga) from planillas63.fecha_carga);";
			$sql1 .="INSERT INTO planillas63.fecha_carga (fechacarga) values (DATE_ADD( @ulimodia ,INTERVAL 1 DAY));";

			/* execute multi query */
				if (mysqli_multi_query($conexion1, $sql1)) {
					do {
						if ($result = mysqli_store_result($conexion1)) {
							while ($row = mysqli_fetch_row($result)) {
							}
							mysqli_free_result($result);
						}
						if (mysqli_more_results($conexion1)) {
						}
					} while (mysqli_next_result($conexion1));
				}
				mysqli_close($conexion1);


			echo 1;

		}else{
			echo 0;
		}

 ?>