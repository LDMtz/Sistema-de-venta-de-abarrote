<?php 
    include("../../Conexion.php");

    $query="SELECT * FROM Empleados";
    $resultado=mysqli_query($conexion,$query);
    $listaEmpleados = array();

    if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaEmpleados[] = $fila;// Agregar la fila actual al array $listaEmpleados

    mysqli_close($conexion);
?>

<?php foreach ($listaEmpleados as $registro){?>
    <tr class="">
        <td scope="row"><?php echo $registro['IdEmpleado']?></td>
        <td>
            <img width="50" 
            src="<?php echo 'Fotos/'.$registro['Foto']?>" 
            class="img-fluid rounded" 
            alt="FotoEmpleado">
        </td>
        <td><?php echo $registro['Nombre']?></td>
        <td><?php echo $registro['Correo']?></td>
        <td><?php echo $registro['Telefono']?></td>
        <td><?php echo ($registro['IdRol'] == 1) ? 'Administrador' : 'Cajero'; ?></td>
        <td>
            <span class="badge <?php echo ($registro['Estado'] == 1) ? 'bg-success' : 'bg-danger'; ?>">
                <?php echo ($registro['Estado'] == 1) ? 'Activo' : 'Inactivo'; ?>
            </span>
        </td>
        <td><?php echo $registro['FechaRegistro']?></td>
        <td>
            <a name="" id="" class="btn btn-primary" role="button" 
            onclick="modificaEmpleado('<?php echo $registro['IdEmpleado'];?>');">Editar</a>

            <a name="" id="" class="btn btn-danger" role="button" 
            onclick="eliminaEmpleado('<?php echo $registro['IdEmpleado'];?>');">Eliminar</a>
        </td>
    </tr>
<?php }?>