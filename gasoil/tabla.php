<?php 

require_once "php/conexion.php";


$conexion=conexion();

// Cargo la fecha de carga 
$sql="SELECT fechacarga as total FROM fecha_carga ORDER BY id DESC LIMIT 1";
	
$result1=mysqli_query($conexion,$sql);

$row = mysqli_fetch_assoc($result1) ;
	
$nom_rows= $row['total'];


// lleno la tabla

$obj= new conectar();

$conexion1=$obj->conexion();

$sql1="SELECT *  from carga where fecha_carga = '$nom_rows'";

echo("EL DIA QUE SE ESTA CARGANDO ES: ");
echo $nom_rows;

$result=mysqli_query($conexion1,$sql1);

?>

<div>
	<table class="table table-hover table-condensed table-bordered table-sm" id="iddatatable" style="background-color: #E1F9F4 ">
		<thead style="background-color: #0062a3;color: white; font-weight: bold;">
			<tr>
				<td>Gasolero</td>
				<td>Fecha</td>
				<td>Interno</td>
				<td>Cantidad</td>				
				<td>Tipo</td>
				<td>Aditivo</td>
				<td>Cantidad</td>				
				<td>Aceite</td>
				<td>Modificar</td>
				<td>Borrar</td>
			</tr>
		</thead>
		<tbody >
			<?php if(isset($result)){
			while ($mostrar=mysqli_fetch_row($result)) {

				$datos=$mostrar[0]."||".
					   $mostrar[1]."||".
					   $mostrar[2]."||".
					   $mostrar[3]."||".
					   $mostrar[4]."||".
					   $mostrar[5]."||".
					   $mostrar[6]."||".
 					   $mostrar[7]."||".
					   $mostrar[8]."||".
					   $mostrar[9]."||".
					   $mostrar[10];
				?>
				<tr >
					<td><?php echo $mostrar[1] ?></td>
					<td><?php echo $mostrar[2] ?></td>
					<td><?php echo $mostrar[3] ?></td>
					<td><?php echo $mostrar[6] ?></td>
					<td><?php echo $mostrar[4] ?></td>
					<td><?php echo $mostrar[5] ?></td>
					<td><?php echo $mostrar[8] ?></td>
					<td><?php echo $mostrar[7] ?></td>		
	
					<td style="text-align: center;">
						<span class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditar" onclick="agregaform('<?php echo $datos ?>')">
							<span class="fa fa-pencil-square-o"></span>
						</span>
					</td>
					<td style="text-align: center;">
						<span class="btn btn-danger btn-sm" onclick="eliminarDatos('<?php echo $mostrar[0] ?>')">
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
		
	  "pageLength": 100,
	  "paging": false,
	  "order": [[ 2, "asc" ]],
	  "info": false,
	  "searching": false,
	   language: { 
		   	"emptyTable":"Sin coches",
				 }
	  	} );

</script>