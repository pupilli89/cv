<?php 
	
	require_once "../php/conexion.php";
	require_once "../clases/crud.php";

	$obj= new crud();

	echo $obj->eliminar($_POST['idcarga']);

 ?>