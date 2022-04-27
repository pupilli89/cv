

 <?php 

	class conectar{
		public function conexion(){
			$conexion=mysqli_connect('127.0.0.1',
										'planero',
										'sys05510245',
										'planillas63');
			return $conexion;
		}
	}


 ?>