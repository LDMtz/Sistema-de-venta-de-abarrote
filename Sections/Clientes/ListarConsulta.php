<?php
    include("../../Conexion.php");
        $listaClientes = [];

        //Si me pide una consulta especifica
        if (isset($_POST['tipo_dato'])){
            $tipo_dato=(isset($_POST['tipo_dato']))?$_POST['tipo_dato']:"";
            $dato=(isset($_POST['dato']))?$_POST['dato']:"";

            $query = "SELECT * FROM Clientes WHERE $tipo_dato LIKE '%$dato%'";
            $resultado=mysqli_query($conexion,$query);

            if($resultado)
            while ($fila = mysqli_fetch_assoc($resultado))
                $listaClientes[] = $fila;
        }
    mysqli_close($conexion);
    if (empty($listaClientes)) {
        // Si no se encontraron Clientes, imprimir un mensaje
        echo "No se encontraron Clientes.";
    }  
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