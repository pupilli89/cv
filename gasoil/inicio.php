<?php 
	
	session_start();

	if(isset($_SESSION['user'])){

	//Datos de fecha
	$versistema="Carga de gasoil v1.00";
	$meses=array('ENE','FEB','MAR','ABR', 'MAY','JUN','JUL','AGO','SEP', 'OCT','NOV','DIC');
	$dias=array('LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO','DOMINGO');
	$dia_sem_actual=$dias[(date("N")*1)-1];
	$fec_actual=date("d")."/".$meses[date("m")-1]."/".date("Y");


	//Fecha y hora actual para la base de datos
	$hora = new DateTime();
	$hora->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
	$prueba=$hora->format("H:i:s");
	$prueba2=$hora->format("Y-m-d");

	//Un dia mas
	$fecha = $hora;
	date_add($fecha, date_interval_create_from_date_string('-1 days'));
	$fecha_antes=date_format($fecha, 'Y-m-d');

	//12 horas mas
	$hour = $hora;
	date_add($hour, date_interval_create_from_date_string('-12 hour'));
	$hora_antes=date_format($hour, 'H:i:s');
 ?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $versistema;?></title>
		<?php require_once "scripts.php";?>
		<link rel="shortcut icon" type="image/x-icon" href="ima/favicon.ico" />
		<link href="css/fa/css/all.css" rel="stylesheet">
		<link href="css/inicio.css" rel="stylesheet">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
	<head>
		<div class="container-fluid cabe">
		<div class="row">
			<div class="col-4 my-2">
				<div class="titulo">
    				LINEA <?php echo $_SESSION["linea"]; ?> - BERNARDINO RIVIADAVIA S.A.T.A.
				</div>
			</div>
			<div class="col-3 my-2 text-center">   
				<div class="user">
    				<i class="fas fa-user"></i>
    				Usuario: <?php echo  $_SESSION["user"]; ?>   
				</div>
			</div> 
			<div class="col-2 my-2 text-center">
				<div class="fecha">
    				<?php echo $dia_sem_actual." ".$fec_actual; ?>
				</div>
			</div>
			<div class="col-3 my-2 text-center">
			<div class="logout">
						<span class="btn btn-primary btn-sm" onclick="salir();">
							<span class="fa fa-power-off"></span>
						</span> Salir del sistema
	            </div>
				</div>
			</div>
		</div>	
	</head><br>


	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card-sm text-center">
					<div class="card-body-sm" style=" background-image: url('ima/bk89.png')";>
						<div class="container">
							<div class="row">
								<div class="col-sm-12">
									<form id="frmnuevo" name="frmnuevo" style="font-family: 'Titillium Web', sans-serif;">
									  <div class="row">								  	
									    <div class="col">
									    	<input type="text" hidden="" id="gasolero"value="<?php echo  $_SESSION["user"]; ?>">
									    	<input type="text" hidden="" id="fecha" value="<?php echo $prueba2; ?>">
									    	<input type="text" hidden="" id="hora" value="<?php echo $prueba; ?>">
									    	<input type="text" hidden="" id="hora_antes" value="<?php echo $hora_antes; ?>">
									    	<input type="text" hidden="" id="fecha_antes" value="<?php echo $fecha_antes; ?>">	
									    	<input type="text" hidden="" id="fecha_antes" value="<?php echo $fecha_antes; ?>">	
											<input type="text" hidden="" id="demo" name="demo" value="">
									    	<input type="text" hidden="" id="idcarga" name="idcarga">
									      <label for="interno" class="col col-form-label">Interno</label>
									      <input type="number" class="form-control" id="interno"  min="101" max="154" tabindex="1" >
									    </div>
									    <div class="col">
									      <label for="cantidad" class="col col-form-label">Cantidad GasOil</label>
									      <input type="number" class="form-control" id="cant" min="0" max="999" oninput="validity.valid||(value='');" tabindex="2">
									    </div>										
									    <div class="col">
									      <label for="tipo" class="col col-form-label">Tipo GasOil</label>
									    	<select class="form-control" id="tipo" tabindex="3" >
											    <option></option>	
												<option value="0">No</option>						  
										  		<option>Diesel 500</option>
										  		<option>Diesel infinia</option>
										  </select>
									    </div>
									    <div class="col">
									      <label for="aditivo" class="col col-form-label">Aditivo</label>
									    	<select class="form-control" id="aditivo" tabindex="4">
											    <option></option>													
											    <option value="0">No</option>
										  		<option>Urea</option>
										  </select>
									    </div>
									    <div class="col">
									      <label for="cant_acei" class="col col-form-label">Cant aceite</label>
									      <input type="number" class="form-control" id="cant_acei"  min="0" max="99" oninput="validity.valid||(value='');" tabindex="5">
									    </div>
									  	<div class="col">
									      <label for="aceite" class="col col-form-label">Tipo Aceite</label>
									      <select class="form-control" id="aceite" tabindex="6" >
										    <option></option>	  
										    <option value="0">No</option>
											<option>Crb Turbo 15w-40</option>
											<option>80w-40</option>
										  </select>
									    </div>
									  </div><br>
									  <div class="row">
					                      <div class="col form-group text-center">
					                          <input type="button" class="btn btn-primary"id="btnInsertar" value="Guardar" tabindex="7"> 
					                           <a href="inicio.php" class="btn btn-secondary">Limpiar</a>
					                       </div>
										</div>
									</form>
								</div>
							</div>
						</div>	
						<hr>
						<div id="tablaDatatable"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Actualizar Interno</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="frmnuevoU">
						<input type="text" hidden="" id="idcarga" name="idcarga">
						<label>Cantidad</label>
						<input type="text" class="form-control input-sm" id="internoU" name="internoU" min="101" max="154">
						<label>Tipo GasOil</label>
							<select class="form-control" id="tipoU" name="tipoU">
							    <option></option>	
						 	    <option value="0">No</option>						  
								<option>Diesel 500</option>
								<option>Diesel infinia</option>
							</select>
						<label>Aditivo</label>
							<select class="form-control" id="aditivoU" name="aditivoU">
							    <option></option>	
							    <option value="0">No</option>
								<option>Urea</option>
							</select>
						<label>Cant Aceit</label>
						<input type="text" class="form-control input-sm" id="cantgasoilU" name="cantgasoilU">
						<label>Tipo Aceite</label>
							<select class="form-control" id="aceiteU" name="aceiteU">
							    <option></option>	
							    <option value="0">No</option>
								<option>Crb Turbo 15w-40</option>
								<option>80w-40</option>
							</select>						
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-warning" id="btnActualizar" data-dismiss="modal">Actualizar</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
	<?php

	} else {
		header("location:index.php");
		}
	 ?>

<script type="text/javascript">
	$(document).ready(function(){ //muestro la tabla
		$("#interno").focus();
		cargar_dia();  ///cargo en demo la fecha de carga
		$('#tablaDatatable').load('tabla.php');
		
	});


	//cargo automaticamente los valores en los select
	$( "#cant" ).change(function() {
		if($(cant).val() == "0"){
		  $("#tipo").val("0");
		  $("#tipo").prop('disabled', true);
		  $("#aditivo").val("0");
		  $('#aditivo').prop('disabled', true);
		  $("#cant_acei").focus();
		  
		}
		else{
			$("#tipo").val("0");
			$('#tipo').prop('disabled', false);
			$("#aditivo").val("0");
			$('#aditivo').prop('disabled', false);
			$("#tipo").focus();
		}

});

	$( "#cant_acei" ).change(function() {
		if($(cant_acei).val() == "0"){
		  $("#aceite").val("0");
		  $('#aceite').prop('disabled', true);
		  $("#btnInsertar").focus();

		}
		else{
		$("#aceite").val("0");
		$('#aceite').prop('disabled', false);
		$("#aceite").focus();
		}

});

	
</script>

 <script type="text/javascript">
	$(document).ready(function(){ //agrego nuevos internos
		$('#btnInsertar').click(function(){

			if($('#interno').val()=="" || $('#interno').val() < 101 || $('#interno').val() > 154){
				$("#interno").focus();
				alertify.alert("Datos","Debes agregar el interno valido");	
				$('#tipo').prop('disabled', false);
				$('#aditivo').prop('disabled', false);
				$('#aceite').prop('disabled', false);
				return false;
			}else if($('#cant').val()==""){
				$("#cant").focus();
				alertify.alert("Datos","Debes agregar la cantidad de GasOil");
				return false;
			}else if($('#tipo').val()==""){
				$("#tipo").focus();
				alertify.alert("Datos","Debes agregar el tipo de Gasoil");
				return false;
			}else if($('#aditivo').val()==""){
				$("#aditivo").focus();
				alertify.alert("Datos","Debes completar el aditivo");
				return false;
			}else if($('#cant_acei').val()==""){
				$("#cant_acei").focus();
				alertify.alert("Datos","Debes agregar si lleva aceite");
				return false;
			}else if($('#aceite').val()==""){
				$("#aceite").focus();
				alertify.alert("Datos","Debes agregar el tipo de aceite");
				return false;
			}

			cadena= "gasolero=" + $('#gasolero').val() +
					"&fecha=" + $('#fecha').val() +
					"&interno=" + $('#interno').val() +
					"&cant=" + $('#cant').val() + 					
					"&tipo=" + $('#tipo').val() + 
					"&aditivo=" + $('#aditivo').val() + 
					"&aceite=" + $('#aceite').val() + 
					"&hora=" + $('#hora').val() + 
					"&cant_gasoil=" + $('#cant_gasoil').val() + 
					"&fechacarga=" + $('#demo').val() + 
					"&cant_acei=" + $('#cant_acei').val();
					$.ajax({
						type:"POST",
						url:"procesos/agregar.php",
						data:cadena,
						success:function(r){
							if(r==3){
							alertify.alert('Dia Cerrado', 'Completó todos los internos el dia se cerrara', function(){location.href="index.php"; });
							}
							if(r==2){
							alertify.error("Interno repetido");
							$('#tablaDatatable').load('tabla.php');
							$('#interno').val('');
							$('#cant').val('');
							$('#tipo').prop('disabled', false);
							$('#tipo').val('');
							$('#aceite').prop('disabled', false);
							$('#aceite').val('');
							$('#aditivo').prop('disabled', false);
							$('#aditivo').val('');
							$('#cant_acei').val('');
							$("#interno").focus();							
							}
							if(r==1){	
							alertify.success("Agregado con exito");
							$('#tablaDatatable').load('tabla.php');
							$('#interno').val('');
							$('#cant').val('');
							$('#tipo').prop('disabled', false);
							$('#tipo').val('');
							$('#aceite').prop('disabled', false);
							$('#aceite').val('');
							$('#aditivo').prop('disabled', false);
							$('#aditivo').val('');
							$('#cant_acei').val('');
							$("#interno").focus();
							}else{
							alertify.error("Fallo al agregar");
							$('#tablaDatatable').load('tabla.php');
							}
						}
					});
				});	

		$('#btnActualizar').click(function(){
			
			actualizaDatos();
		});

	});

</script>


<script type="text/javascript">

	function eliminarDatos(idcarga){
		alertify.confirm('Eliminar interno', '¿Seguro de eliminar este interno?', function(){ 

			$.ajax({
				type:"POST",
				data:"idcarga=" + idcarga,
				url:"procesos/eliminar.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tabla.php');
						alertify.success("Eliminado con exito");
					}else{
						alertify.error("No se pudo eliminar");
					}
				}
			});

		}
		, function(){

		});
	}
				
	function agregaform(datos){ //Funcion para obtener los datos en el formulario de act

		d=datos.split('||');

		$('#idcarga').val(d[0]);
		$('#internoU').val(d[6]);//ok
		$('#tipoU').val(d[4]);//ok
		$('#aditivoU').val(d[5]);//Ok
		$('#cantgasoilU').val(d[8]);//ok 
		$('#aceiteU').val(d[7]);//ok
			
	}

	function actualizaDatos(){

		id=$('#idcarga').val();
		interno=$('#internoU').val();
		tipo=$('#tipoU').val();
		aditivo=$('#aditivoU').val();
		cant=$('#cantgasoilU').val();
		aceite=$('#aceiteU').val();		

			cadena="idcarga=" + id +
					"&interno=" + interno +
					"&tipo=" + tipo +
					"&aditivo=" + aditivo +
					"&cant=" + cant +
					"&aceite=" + aceite;

					$.ajax({
						type:"POST",
						url:"procesos/actualizar.php",
						data:cadena,
						success:function(r){
							if(r==1){
							$('#tablaDatatable').load('tabla.php');
							alertify.success("Actualizacion correcta");
							}else{
							alertify.alert("Actualizar","Fallo la carga");
							}
						}
					});
		}

</script>

<script type="text/javascript">
	function salir(){

			cadena= "fechacarga=" + $('#demo').val();	

			$.ajax({
				type:"POST",
				data:cadena,
				url:"procesos/salir.php",
				success:function(r){
					if(r==1){
						alertify.confirm('Cerrar Session', '¿Seguro que desea salir?', function(){;
						location.href="index.php";
						}
						, function(){

						});
					}else{
						alertify.confirm('Cerrar Session', 'Faltan internos para cerrar el dia 	¿Seguro que desea salir?', function(){;
						location.href="index.php";
						}
						, function(){

						});
					}
				}
			});
		}

	//funcion para tab por intro	

	$('input,select').on('keypress', function(e){
	if (e.keyCode == 13) {
	// Obtenemos el número del atributo tabindex al que se le dio enter y le sumamos 1
	var TabIndexActual = $(this).attr('tabindex');
	var TabIndexSiguiente = parseInt(TabIndexActual) + 1;
	// Se determina si el tabindex existe en el formulario
	var CampoSiguiente = $('[tabindex='+TabIndexSiguiente+']');
	// Si se encuentra el campo entra al if
	if(CampoSiguiente.length > 0 )
	{
	CampoSiguiente.focus(); //Hcemos focus al campo encontrado
	return false; // retornamos false para detener alguna otra ejecucion en el campo
	}else{// Si no se encontro ningún elemento, se retorna false
	//$("#frmnuevo").submit();
	//return false;
	}
	}
	});

// cargo el dia de carga de la tabla dia de carga

	function cargar_dia(){

			$.ajax({
				type:"POST",
				url:"procesos/carga_dia.php",
				success:function(r){
					var fecha=r;
					var fecha2=JSON.parse(fecha);
					document.frmnuevo.demo.value =fecha2;
					
			}
		});
	}


/*	function chequeo(){

		cadena= "fecha=" + $('#fecha').val() +
					"&fechacarga=" + $('#demo').val();		

			$.ajax({
				type:"POST",
				data:cadena,
				url:"procesos/chequeo.php",
				success:function(r){
					if(r==1){
						alertify.confirm('Cerrar', '¿Seguro que desea salir?', function(){;
						location.href="index.php";
						}
						, function(){

						});
					}else{
						alertify.confirm('Cerrar Session', 'Faltan internos para cerrar el dia 	¿Seguro que desea salir?', function(){;
						location.href="index.php";
						}
						, function(){

						});
					}
				}
			});
		}*/


</script>




