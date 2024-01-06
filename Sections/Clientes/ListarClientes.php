<?php 
    include("../../Conexion.php");

    $query="SELECT * FROM Clientes";
    $resultado=mysqli_query($conexion,$query);
    $listaClientes = array();

    if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaClientes[] = $fila;// Agregar la fila actual al array $listaClientes

    mysqli_close($conexion);
?>

    <?php foreach ($listaClientes as $registro){?>
        <tr class="">
            <td scope="row"><?php echo $registro['IdCliente']?></td>
            <td><?php echo $registro['Nombre']?></td>
            <td><?php echo $registro['Correo']?></td>
            <td><?php echo $registro['Telefono']?></td>
            <td><?php echo $registro['FechaRegistro']?></td>
            <td>
                <a name="" id="" class="btn btn-primary" role="button" 
                onclick="modificaCliente('<?php echo $registro['IdCliente'];?>');">Editar</a>

                <a name="" id="" class="btn btn-danger" role="button" 
                onclick="eliminaCliente('<?php echo $registro['IdCliente'];?>');">Eliminar</a>
            </td>
        </tr>
    <?php }?>