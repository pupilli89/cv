<?php 


	session_start();
	require_once "conexion.php";

	$conexion=conexion();

		
		$usuario=mysqli_real_escape_string($conexion,$_POST["usuario"]);
    	$pass=mysqli_real_escape_string($conexion,$_POST["password"]);

		$sql="SELECT * from usuarios where usu_nombre='$usuario' and usu_clave='$pass' and usu_inspector='4'";
		$result=mysqli_query($conexion,$sql);

		if(mysqli_num_rows($result) > 0){
			$reng=mysqli_fetch_array($result);
			$_SESSION['user']=$usuario;
			$_SESSION["linea"]=$reng["usu_linea"];
			echo 1;
		}else{
			echo 0;
		}
 ?>