<?php
    include("../../Conexion.php");
        $listaProveedores = [];

        //Si me pide una consulta especifica
        if (isset($_POST['tipo_dato'])){
            $tipo_dato=(isset($_POST['tipo_dato']))?$_POST['tipo_dato']:"";
            $dato=(isset($_POST['dato']))?$_POST['dato']:"";

            $query = "SELECT * FROM Proveedores WHERE $tipo_dato LIKE '%$dato%'";
            $resultado=mysqli_query($conexion,$query);

            if($resultado)
            while ($fila = mysqli_fetch_assoc($resultado))
                $listaProveedores[] = $fila;
        }
    mysqli_close($conexion);
    if (empty($listaProveedores)) {
        // Si no se encontraron Proveedores, imprimir un mensaje
        echo "No se encontraron Proveedores.";
    }  
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