<?php 

	class crud{

		/*public function agregar($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="INSERT into carga (gasolero,fecha,interno,agrego,tipo,aditivo,cant,aceite,tipo_acei,cant_acei)
									values ('$datos[0]',
											'$datos[1]',
											'$datos[2]',
											'$datos[3]',
											'$datos[4]',
											'$datos[5]',
											'$datos[6]',
											'$datos[7]',
											'$datos[8]',
											'$datos[9]')";
			return mysqli_query($conexion,$sql);
		}*/

		public function eliminar($nro_orden){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="DELETE from carga where idcarga='$idcarga'";
			return mysqli_query($conexion,$sql);
			}
	


		public function actualizar($datos){
			$obj= new conectar();
			$conexion=$obj->conexion();

			$sql="UPDATE carga set interno='$datos[1]',
										agrego='$datos[2]',
										tipo='$datos[3]'
						where idcarga='$datos[0]'";
			return mysqli_query($conexion,$sql);
			}
	
	}
 ?>