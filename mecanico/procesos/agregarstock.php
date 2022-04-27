<?php 
	
	function conexion()
	{
		return $conexion=mysqli_connect('127.0.0.1','planero','sys05510245','planillas63');
	}
		$conexion=conexion();

		$codigo=$_POST['codigo'];
		$Descripcion=$_POST['Descripcion'];
		$Cantidad=$_POST['Cantidad'];
		$chas=$_POST['chas'];
		$precio=$_POST['precio'];
		$Proveedor=$_POST['Proveedor'];
		$nro=$_POST['nro'];
		$Despachante=$_POST['Despachante'];
        $Fecha=$_POST['Fecha'];
        $fam=$_POST['fam'];



			$sql="INSERT into stock (codigo,fam,descrip,cant,precio,chass,nro_factura,despachante,fecha)
										values ('$codigo',
												'$fam',
                                                '$Descripcion',
                                                '$Cantidad',
                                                '$precio',
                                                '$chas',
                                                '$nro',
                                                '$Despachante',
                                                '$Fecha')";

			echo $result=mysqli_query($conexion,$sql);
		
			
 ?>



