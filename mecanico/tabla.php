<?php 

require_once "php/conexion.php";

$conexion=conexion();

// lleno la tabla

$obj= new conectar();

$conexion1=$obj->conexion();

$sql1="SELECT *  from item_check";

$result=mysqli_query($conexion1,$sql1);

?>

<div>
	<table class="table table-hover table-condensed table-bordered table-sm" id="iddatatable" style="background-color: #E1F9F4 ">
		<thead style="background-color: #0062a3;color: white; font-weight: bold;">
			<tr>
				<td>ID</td>
				<td>Codigo de despercto</td>
				<td>Eliminar</td>	
			</tr>
		</thead>
		<tbody >
			<?php if(isset($result)){
			while ($mostrar=mysqli_fetch_row($result)) {

				$datos=$mostrar[0]."||".
					   $mostrar[1];
				?>
				<tr >
					<td><?php echo $mostrar[0] ?></td>
					<td><?php echo $mostrar[1] ?></td>		
	
					<td style="text-align: center;">
						<span class="btn btn-danger btn-sm" onclick="eliminarDatos('<?php echo $mostrar[0]; ?>')">
							<span class="fa fa-trash"></span>
						</span>
					</td>
				</tr>
			<?php 
			}}
			?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#iddatatable').DataTable();		
	} );


	$('#iddatatable').dataTable( {
		
	  "pageLength": 50,
	  "paging": false,
	  "order": [[ 2, "asc" ]],
	  "info": false,
	  "searching": true,
	   language: { 
		   	"emptyTable":"Sin coches",
			   search: 'Buscar'
				 }
	  	} );

		  function eliminarDatos(idcarga){
		alertify.confirm('Eliminar Codigo operacion', '¿Seguro de eliminar este codigo de operacion?', function(){ 

			$.ajax({
				type:"POST",
				data:"idcarga=" + idcarga,
				url:"procesos/eliminarcod.php",
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

</script>