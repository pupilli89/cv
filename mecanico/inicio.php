<?php

session_start();

if (isset($_SESSION['user'])) {

	//Datos de fecha
	$versistema = "Mecanicos v1.00";
	$meses = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
	$dias = array('LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO');
	$dia_sem_actual = $dias[(date("N") * 1) - 1];
	$fec_actual = date("d") . "/" . $meses[date("m") - 1] . "/" . date("Y");

	//Fecha y hora actual para la base de datos
	$hora = new DateTime();
	$hora->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
	$prueba = $hora->format("H:i:s");
	$prueba2 = $hora->format("Y-m-d");

	//Un dia mas
	$fecha = $hora;
	date_add($fecha, date_interval_create_from_date_string('-1 days'));
	$fecha_antes = date_format($fecha, 'Y-m-d');

	//12 horas mas
	$hour = $hora;
	date_add($hour, date_interval_create_from_date_string('-12 hour'));
	$hora_antes = date_format($hour, 'H:i:s');

	//Obtengo datos para llenar los select
	function conexion()
	{
		return $conexion = mysqli_connect('127.0.0.1', 'planero', 'sys05510245', 'planillas63');
	}
	$conexion = conexion();

	mysqli_query($conexion, "SET NAMES 'utf8'");

	$sql = "SELECT id_interno FROM internos";
	$result = mysqli_query($conexion, $sql);

	$sql1 = "SELECT item_check_descript FROM item_check";
	$result1 = mysqli_query($conexion, $sql1);

	// leo para el div

	$sql2 = "SELECT *  from orden_taller";

	$result2 = mysqli_query($conexion, $sql2);

	$sql4 = "SELECT *  from orden_taller";

	$result4 = mysqli_query($conexion, $sql4);

	// leo para el div

	$sql5 = "SELECT *  from usuarios where usu_inspector = 4 ";

	$result5 = mysqli_query($conexion, $sql5);

	// leo repa

	$sql6 = "SELECT *  from cod_reparacion";

	$result6 = mysqli_query($conexion, $sql6);

	// leo choferes

	$sql7 = "SELECT *  from choferes";

	$result7 = mysqli_query($conexion, $sql7);


	// leo usuarios 
	
	$sql8 = "SELECT *  from usuarios where usu_inspector = 4 ";

	$result8 = mysqli_query($conexion, $sql8);

	$sql9 = "SELECT *  from stock";

	$result9 = mysqli_query($conexion, $sql9);

?>


	<!DOCTYPE html>
	<html>

	<head>
		<title><?php echo $versistema; ?></title>
		<?php require_once "scripts.php"; ?>
		<link rel="shortcut icon" type="image/x-icon" href="ima/favicon.ico" />
		<link href="css/fa/css/all.css" rel="stylesheet">
		<link href="css/inicio.css" rel="stylesheet">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<style>
			.contenedor {
				position: relative;
				display: inline-block;
				text-align: center;
				border-radius: 1em;
				color: black;
				font-size: 20px;
				cursor: pointer;
			}
			.centrado {
				position: absolute;
				top: 45%;
				left: 50%;
				transform: translate(-50%, -50%);
			}
			.contenedor:hover {
				opacity: 0.5;
			}

			#nro_orden {
				width: 55px;
			}

			#nro_ordenh {
				width: 55px;
			}

			#fechach,
			#fechasch {
				width: 110px;
			}

			#fecha,
			#hora,
			#fechac,
			#horac {
				width: 110px;
			}

			.contenedor1 {
				position: relative;
				display: inline-block;
				text-align: center;
				border-radius: 1em;
				color: black;
				font-size: 20px;
				cursor: pointer;
			}

			.contenedor1:hover {
				opacity: 0.5;
			}

			.titu {

				font-size: 13px;
				text-align: center;
				align-items: center;
				justify-content: center;
				color: white;
			}

			.fecha,
			.user {
				font-size: 13px;
				color: white;
			}

			.stock,
			.cod_rep,
			.cod_des,
			.logout,
			.stockd {
				font-size: 13px;
				color: white;
			}

			input.transparent-input {
				background-color: rgba(0, 0, 0, 0) !important;
				border: none !important;
			}
		</style>
	</head>

	<body>

		<nav class="navbar navbar-expand-sm">
			<div class="container-fluid">
				<ul class="nav navbar-nav">
					<div class="titu">BERNARDINO RIVIADAVIA <br>
						LINEA <?php echo $_SESSION["linea"]; ?>
					</div>
				</ul>
				<ul class="nav navbar-nav mx-auto">
					<li class="nav-item">
						<a class="nav-link" onclick="stock();" style="cursor: pointer;">Stock <span class="fa fa-qrcode"></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="cod_rep();" style="cursor: pointer;">Tipo repaciones <span class="fa fa-wrench"></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="desperfecto();" style="cursor: pointer;">Desperfectos <span class="fa fa-chain-broken"></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="salir();" style="cursor: pointer;">Salir <span class="fa fa-power-off"></span></a>
					</li>
				</ul>
				<ul class="nav navbar-nav">
					<span class="navbar-text navbar-right">
						<div class="fecha">
							<?php echo $dia_sem_actual . " " . $fec_actual; ?>
						</div>
						<div class="user">
							<i class="fa fa-user-circle" aria-hidden="true"></i>
							Usuario:<?php echo  $_SESSION["user"]; ?>
						</div>
					</span>
				</ul>
			</div>
		</nav><br>
		<!-- Boton para generar la orden de trabajo -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<caption>
						<button class="btn btn-primary" data-toggle="modal" data-target="#miModal" style="cursor: pointer;">
							Generar nueva orden de trabajo
						</button>
					</caption>
				</div>
			</div>
		</div><br>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<h2>Unidades en taller</h2><br>
					<?php if (isset($result2)) {
						while ($mostrar = mysqli_fetch_row($result2)) {

							$datos = $mostrar[0] . "||" .
								$mostrar[1] . "||" .
								$mostrar[2] . "||" .
								$mostrar[3] . "||" .
								$mostrar[4] . "||" .
								$mostrar[5] . "||" .
								$mostrar[6] . "||" .
								$mostrar[7] . "||" .
								$mostrar[8] . "||" .
								$mostrar[9] . "||" .
								$mostrar[10];

							if ($mostrar[7] == 1) { ?>
								<div class="contenedor" onclick="openmodalcierre(<?php echo $mostrar[2] . "," . $mostrar[3] . "," . "'$mostrar[5]'" . "," . "'$mostrar[6]'" ?>)">
									<img src="ima/rojo2.svg" width="100" height="100" />
									<div class="centrado"><?php echo $mostrar[3] ?></div>
								</div>

							<?php }
							if ($mostrar[7] == 2) {  ?>
								<div class="contenedor" onclick="openmodalcierre(<?php echo $mostrar[2] . "," . $mostrar[3] . "," . "'$mostrar[5]'" . "," . "'$mostrar[6]'" ?>)">
									<img src="ima/amarillo.svg" width="100" height="100" />
									<div class="centrado"><?php echo $mostrar[3] ?></div>
								</div>
					<?php	}
						}
					}
					?>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<h2>Unidades Reparadas en el dia</h2><br>
					<?php if (isset($result4)) {
						while ($mostrar = mysqli_fetch_row($result4)) {

							$datos = $mostrar[0] . "||" .
								$mostrar[1] . "||" .
								$mostrar[2] . "||" .
								$mostrar[3] . "||" .
								$mostrar[4] . "||" .
								$mostrar[5] . "||" .
								$mostrar[6] . "||" .
								$mostrar[7] . "||" .
								$mostrar[8] . "||" .
								$mostrar[9] . "||" .
								$mostrar[10];


							if ($mostrar[7] == 0 && $mostrar[8] == $prueba2) { ?>
								<div class="contenedor1" onclick="openmodalchqueo(<?php echo $mostrar[3] . "," . $mostrar[2] . "," . "'$mostrar[0]'" . "," . "'$mostrar[8]'" . "," . "'$mostrar[4]'" . "," . "'$mostrar[12]'" . "," . "'$mostrar[5]'" . "," . "'$mostrar[6]'" . "," . "'$mostrar[11]'" . "," . "'$mostrar[11]'" . "," . "'$mostrar[10]'"  ?>)">
									<img src="ima/verde.svg" width="100" height="100" />
									<div class="centrado"><?php echo $mostrar[3] ?></div>
								</div>
					<?php }
						}
					}
					?>
				</div>
			</div>
		</div>

		<!--inicio modal para iniciar orden -->
		<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header text-center">
						<h6 class="modal-title w-25 font-weight-bold">Orden N°</h6>
						<label for="num_orden"></label>
						<h6 class="modal-title w-25 font-weight-bold">Fecha: </h6>
						<input class=" transparent-input" type="text" id="fecha" value="<?php echo $prueba2; ?>" disabled>
						<h6 class="modal-title w-25 font-weight-bold">Hora: </h6>
						<input class="transparent-input" type="text" id="hora" value="<?php echo $prueba; ?>" disabled>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body mx-3">
						<div class="md-form mb-1">
							<label for="interno">Interno</label>
							<select id="internomodal" class="form-control validate">
								<?php
								while ($row = mysqli_fetch_array($result)) {
									echo '<option value="' . $row['id_interno'] . '">' . $row['id_interno'] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="md-form mb-1">
							<label for="solicitantetaller">Solicitante de unidad en taller</label>
							<select id="solicitantetaller" class="form-control validate " title="Seleccione un solicitante" data-show-subtext="true" data-live-search="true">
								<?php
								while ($row = mysqli_fetch_array($result7)) {
									echo '<option value="' . $row['chof_nombre'] . '">' . $row['chof_nombre'] . '</option>';
								}
								while ($row1 = mysqli_fetch_array($result5)) {
									echo '<option value="' . $row1['usu_nombre'] . '">' . $row1['usu_nom_comp'] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="md-form mb-1">
							<label for="solicitante">Solicitante de orden</label>
							<input type="text" id="solicitante" class="form-control validate" disabled value="<?php echo  $_SESSION["user"]; ?>">
						</div>
						<div class="md-form mb-1">
							<label for="cod_desp">Codigo de desperfecto</label>
							<select id="cod_desp" class="selectpicker form-control" multiple title="Seleccione todas las fallas" data-show-subtext="true" data-live-search="true">
								<?php
								while ($row1 = mysqli_fetch_array($result1)) {
									echo '<option value="' . $row1['item_check_descript'] . '">' . $row1['item_check_descript'] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="md-form mb-3">
							<label for="cod_desp">Agregar un adicional</label>
							<textarea type="text" id="form8" class="md-textarea form-control"></textarea>
						</div>
						<div class="md-form mb-3">
							<label for="flexCheckChecked">Boquear unidad</label>
							<input type="checkbox" id="flexCheckChecked" checked>
						</div>
					</div>
					<div class="modal-footer d-flex justify-content-center">
						<button type="button" class="btn btn-outline-info waves-effect" id="guardarnuevo" data-dismiss="modal">Generar orden de trabajo</button>
						<button type="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<!--cierro modal para iniciar orden -->

		<!--inicio modal para cerrar orden -->
		<div class="modal fade" id="miModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header text-center">
						<h7 class="modal-title w-20 font-weight-bold">Orden N°</h7>
						<input class="form-control transparent-input" type="text" id="nro_orden" disabled>
						<h7 class="modal-title w-20 font-weight-bold">Fecha</h7>
						<input class="form-control transparent-input" type="text" id="fechac" value="<?php echo $prueba2; ?>" disabled>
						<h7 class="modal-title w-20 font-weight-bold">Hora</h7>
						<input class="form-control transparent-input" type="text" id="horac" value="<?php echo $prueba; ?>" disabled>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body mx-3">
						<div class="md-form mb-1">
							<label for="internoc">Interno</label>
							<input type="text" id="internoc" class="form-control validate" disabled>
						</div>
						<div class="md-form mb-1">
							<label for="solicitantec">Tecnico/Mecanico</label>
							<select id="solicitantec" class="selectpicker form-control" multiple title="Seleccione todos los mecanicos">

								<?php
								while ($row1 = mysqli_fetch_array($result8)) {
									echo '<option value="' . $row1['usu_nombre'] . '">' . $row1['usu_nombre'] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="md-form mb-1">
							<label for="codc">Desperfectos</label>
							<input type="text" id="codc" class="form-control validate" disabled>
						</div>
						<div class="md-form mb-3">
							<label for="codc">Agregue un adicional</label>
							<textarea type="text" id="form8c" class="md-textarea form-control" disabled></textarea>
						</div>
						<div class="md-form mb-3">
							<label for="repac">Reparacion</label>
							<select id="repac" class="selectpicker form-control" multiple title="Seleccione todas las repaciones" data-show-subtext="true" data-live-search="true">
								<?php
								while ($row1 = mysqli_fetch_array($result6)) {
									echo '<option value="' . $row1['definicion'] . '">' . $row1['definicion'] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="md-form mb-1">
							<label for="insum">Insumos</label>
							<select id="insum" class="selectpicker form-control" multiple title="Seleccione todos materiales" data-show-subtext="true" data-live-search="true">
								<?php
								while ($row1 = mysqli_fetch_array($result9)) {
									echo '<option value="' . $row1['descrip'] . '">' . $row1['descrip'] . '</option>';
								}
								?>
							</select>
						</div><br>
						<div class="md-form mb-3">
							<label for="flexCheckCheckedc">Desbloquear unidad</label>
							<input type="checkbox" value="0" id="flexCheckCheckedc" checked>
						</div>
					</div>
					<div class="modal-footer d-flex justify-content-center">
						<button type="button" class="btn btn-outline-info waves-effect" id="cierreorden" data-dismiss="modal">Cerrar orden de trabajo</button>
						<button type="button" class="btn btn-outline-info waves-effect" data-dismiss="modal" id="borrar">Eliminar</button>
						<button type="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<!--cierro modal para cerrar orden -->

		<!--inicio modal para chequeo -->
		<div class="modal fade" id="miModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header text-center">
						<h6 class="modal-title w-15 font-weight-bold">Orden N°</h6>
						<input class="form-control transparent-input" type="text" id="nro_ordenh" disabled>
						<h6 class="modal-title w-15 font-weight-bold">Ingreso</h6>
						<input class="form-control transparent-input" type="text" id="fechach" disabled>
						<h6 class="modal-title w-15 font-weight-bold">Egreso</h6>
						<input class="form-control transparent-input" type="text" id="fechasch" disabled>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body mx-3">
						<div class="md-form mb-1">
							<label for="internoc">Interno</label>
							<input type="text" id="internoch" class="form-control validate" disabled>
						</div>
						<div class="md-form mb-1">
							<label for="pedidot">Pedido de taller</label>
							<input type="text" id="pedidot" class="form-control validate" disabled>
						</div>
						<div class="md-form mb-1">
							<label for="solicitantec">Pedido de orden</label>
							<input type="text" id="solicitantech" class="form-control validate" disabled>
						</div>
						<div class="md-form mb-1">
							<label for="codc">Desperfectos</label>
							<input type="text" id="codch" class="form-control validate" disabled>
						</div>
						<div class="md-form mb-3">
							<label for="repac">Problema</label>
							<textarea type="text" id="form8ch" class="md-textarea form-control" disabled></textarea>
						</div>
						<div class="md-form mb-3">
							<label for="repac">Reparacion</label>
							<textarea type="text" id="repach" class="md-textarea form-control" disabled></textarea>
						</div>
						<div class="md-form mb-1">
							<label for="insum">Insumos</label>
							<input type="text" id="insumh" class="form-control validate" disabled>
						</div>
						<div class="md-form mb-1">
							<label for="insum">Tecnico salida</label>
							<input type="text" id="tecns" class="form-control validate" disabled>
						</div>
					</div>
					<div class="modal-footer d-flex justify-content-center">
						<button type="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<!--cierro modal para chequeo -->

	</body>

	</html>
<?php

} else {
	header("location:index.php");
}
?>


<script type="text/javascript">
	$(document).ready(function() {

		$('select').selectpicker(); // funcion para seleccion multiple


		$('#guardarnuevo').click(function() { //Inicio funcion para agregar internos


			if (document.getElementById('flexCheckChecked').checked) {
				document.getElementById('flexCheckChecked').value = 1;
			} else {
				document.getElementById('flexCheckChecked').value = 2;
			}

			if ($('#solicitantetaller').val() == "") {
				alertify.alert("Debes agregar un solicitante");
				return false;
			}
			if ($('#form8').val() == "") {
				alertify.alert("Debes agregar una descripcion");
				return false;
			}

			if ($('#cod_desp').val() == "") {
				alertify.alert("Debes agregar un desperfecto");
				return false;
			}

			cadena = "hora=" + $('#hora').val() +
				"&fecha=" + $('#fecha').val() +
				"&interno=" + $('#internomodal').val() +
				"&solicitante=" + $('#solicitante').val() +
				"&solicitantetaller=" + $('#solicitantetaller').val() +
				"&cod_desp=" + $('#cod_desp').val() +
				"&descrip=" + $('#form8').val() +
				"&bloqueo=" + $('#flexCheckChecked').val();
			$.ajax({
				type: "POST",
				url: "procesos/agregar.php",
				data: cadena,
				success: function(r) {
					if (r == 2) {
						alertify.alert('Repetidos', 'El interno ya se encuentra en taller', function() {});
					} else if (r == 1) {
						alertify.success("Agregado con exito");
						setTimeout(() => {
							window.location = "inicio.php";
						}, 2000);

					} else {
						alertify.alert("Error al iniciar", "Verifique sus datos ");
					}
				}
			});
		}); //cierro funcion para agregar internos

		$('#cierreorden').click(function() { //Inicio funcion para cerrar orden

			if ($('#repac').val() == "") {
				alertify.alert("Debes agregar una descripcion");
				return false;
			}

			cadena = "horac=" + $('#horac').val() +
				"&fechac=" + $('#fechac').val() +
				"&nro_orden=" + $('#nro_orden').val() +
				"&solicitantec=" + $('#solicitantec').val() +
				"&repac=" + $('#repac').val() +
				"&insum=" + $('#insum').val() +
				"&bloqueoc=" + $('#flexCheckCheckedc').val();
			$.ajax({
				type: "POST",
				url: "procesos/actualizar.php",
				data: cadena,
				success: function(r) {
					if (r == 1) {
						alertify.success("Cerrado con exito");
						setTimeout(() => {
							window.location = "inicio.php";
						}, 2000);

					} else {
						alertify.alert("Error al iniciar", "Verifique sus datos ");
					}
				}
			});
		});


		$('#borrar').click(function() { //inicio funcion para borrar
			alertify.confirm('Eliminar orden de trabajo', '¿Seguro de eliminar esta orden de trabajo?', function() {
				cadena = "nro_orden=" + $('#nro_orden').val();
				$.ajax({
					type: "POST",
					url: "procesos/eliminar.php",
					data: cadena,
					success: function(r) {
						if (r == 1) {
							alertify.success("Borrado con exito");
							setTimeout(() => {
								window.location = "inicio.php";
							}, 2000);
						} else {
							alertify.alert("Error al borrar", "Verifique sus datos ");
						}
					}
				});
			}, function() {});
		}); //cierre funcion para borrar 

	}); //cierre del document ready


	function openmodalcierre(nro_orden, interno, cod, desc) {

		$('.selectpicker').selectpicker('deselectAll');
		$("#solicitantec").selectpicker("refresh");
		$('#miModal2').modal('show');
		$('#internoc').val(interno);
		$('#nro_orden').val(nro_orden);
		$('#codc').val(cod);
		$('#form8c').val(desc);

	}

	function openmodalchqueo(interno, numeroorden, fechaingreso, fechasal, solicitante, genorden, cod, desrep, insumos, desrepf, repa) {

		$('#miModal3').modal('show');
		$('#internoch').val(interno);
		$('#nro_ordenh').val(numeroorden);
		$('#fechach').val(fechaingreso);
		$('#fechasch').val(fechasal);
		$('#solicitantech').val(solicitante);
		$('#pedidot').val(genorden);
		$('#codch').val(cod);
		$('#form8ch').val(desrep);
		$('#repach').val(desrepf);
		$('#insumh').val(insumos);
		$('#tecns').val(repa);
	}

	function salir() {
		window.location = "index.php";
	}

	function desperfecto() {
		window.location = "cod_desperfecto.php";
	}

	function cod_rep() {
		window.location = "cod_reparacion.php";
	}

	function stock() {
		window.location = "stock.php";
	}

</script>