<?php
unset($_SESSION['user']);
$mensaje="";
$versistema="Mecanicos v1.01";

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $versistema;?></title>
	<?php require_once "scripts.php";?>

<style type="text/css">

.campos {
	border: 1px solid #cac2c2;
	padding: 7px 7px 7px 25px;
	width: 100%;
	box-sizing: border-box;
	margin-top:18px;
}
.input-icon{
  position: absolute;
  left: 4px;
  top: calc(50% - 0.2em + 10px); 
}
.input-wrapper{
  position: relative;
}
.etiq {
	font-size: smaller;
	color: #0E0E0E;
	display: block;
	font-weight: bold;
	width: 100%;
	margin-left: 10px;
	padding: 2px;
}
body {
	background-image: url("ima/bk89.png");
	background-color: #dce8e7;
	background-repeat:no-repeat;
	background-position: 0px -100px;
}
.fondo{
	background-color:whitesmoke;
	width: 350px;
	margin: 0px;
	padding: 65px 20px 65px 20px;
	border-radius: 20px 60px 20px 60px;
	top: 50%;
	left: 50%;
	transform: translate(-50%,-80%);
	position: absolute;

}
.bot5 {
	width: 100%;
	margin-top: 18px;
	padding: 6px;
	border: 1px solid #49a56e;
	font-weight: bolder;
	border-radius: 8px 4px 8px 4px;
	color:whitesmoke;
	background-color:#20c997;
}
.titulo {
	background-color: #0062a3;
	text-align: center;
	padding: 6px;
	color: whitesmoke;
	border-radius: 8px 4px 8px 4px;
	width: 100%;
	}
.minbus {
	float:right;
	height: 18px;
	width: 19px;
}

.abs-center {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
}
</style>	
</head>
<body>
<div class="container">
	  <div class="abs-center">
		<div class="row">
			<div class="panel fondo">
				<div class="titulo"><img src="ima/neti.png" class="minbus"><?php echo $versistema;?></div>
				<div class="panel panel-body" style="background-color:whitesmoke;">
					<div class="input-wrapper"><br>
						<input type="text" id="usuario" class="campos" name="">
						<label for="usuario" class="fa fa-user input-icon" style='color:#0062a3'></label>
					</div>
					<div class="input-wrapper">
						<label for="password" class="fa fa-lock input-icon" style='color:#0062a3'></label>	
						<input type="password" id="password" class="campos" name="">
					</div>
					<input name="ingresar" type="submit" class="bot5" id="entrarSistema" value="Ingresar"/>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#entrarSistema').click(function(){
			if($('#usuario').val()==""){
				alertify.alert("Debes agregar el usuario");
				return false;
			}else if($('#password').val()==""){
				alertify.alert("Debes agregar el password");
				return false;
			}

			cadena="usuario=" + $('#usuario').val() + 
					"&password=" + $('#password').val();

					$.ajax({
						type:"POST",
						url:"php/login.php",
						data:cadena,
						success:function(r){
							if(r==1){
								window.location="inicio.php";
							}else{
								alertify.alert("Error al iniciar","Verifique sus datos ");
							}
						}
					});
		});	
	});
</script>