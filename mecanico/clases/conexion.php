

 <?php 

	class conectar{
		public function conexion(){
			$conexion=mysqli_connect('127.0.0.1',
										'planero',
										'sys05510245',
										'planillas63');

										mysqli_query($conexion,"SET NAMES 'utf8'");
			return $conexion;
		}
	}
	

 ?>