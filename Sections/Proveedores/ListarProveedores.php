<?php 
    include("../../Conexion.php");

    $query="SELECT * FROM Proveedores";
    $resultado=mysqli_query($conexion,$query);
    $listaProveedores = array();

    if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaProveedores[] = $fila;// Agregar la fila actual al array $listaProveedores

    mysqli_close($conexion);
?>

    <?php foreach ($listaProveedores as $registro){?>
        <tr class="">
            <td scope="row"><?php echo $registro['IdProveedor']?></td>
            <td><?php echo $registro['Nombre']?></td>
            <td><?php echo $registro['Correo']?></td>
            <td><?php echo $registro['Telefono']?></td>
            <td><?php echo $registro['FechaRegistro']?></td>
            <td>
                <a name="" id="" class="btn btn-primary" role="button" 
                onclick="modificaProveedor('<?php echo $registro['IdProveedor'];?>');">Editar</a>

                <a name="" id="" class="btn btn-danger" role="button" 
                onclick="eliminaProveedor('<?php echo $registro['IdProveedor'];?>');">Eliminar</a>
            </td>
        </tr>
    <?php }?>