<?php
    include("../../Conexion.php");
        $listaEmpleados = [];

        //Si me pide una consulta especifica
        if (isset($_POST['tipo_dato'])){
            $tipo_dato=(isset($_POST['tipo_dato']))?$_POST['tipo_dato']:"";
            $dato=(isset($_POST['dato']))?$_POST['dato']:"";

            $query = "SELECT * FROM Empleados WHERE $tipo_dato LIKE '%$dato%'";

            //Si se selecciono el modo de busqueda IdRol
            if($tipo_dato == 'IdRol'){
                $query = "SELECT Empleados.* FROM Empleados JOIN Rol
                ON Empleados.IdRol = Rol.IdRol 
                WHERE Rol.NombreRol LIKE '%$dato%';";
            }

            //Buscando la foto relacionada con el Empleado para borrarla tambien
            $resultado=mysqli_query($conexion,$query);

            if($resultado)
            while ($fila = mysqli_fetch_assoc($resultado))
                $listaEmpleados[] = $fila;
        }
    mysqli_close($conexion);
    if (empty($listaEmpleados)) {
        // Si no se encontraron empleados, imprimir un mensaje
        echo "No se encontraron empleados.";
    }  
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
        <td><?php echo ($registro['Estado'] == 1) ? 'Activo' : 'Inactivo'; ?></td>
        <td><?php echo $registro['FechaRegistro']?></td>
        <td>
            <a name="" id="" class="btn btn-primary" role="button" 
            onclick="modificaEmpleado('<?php echo $registro['IdEmpleado'];?>');">Editar</a>

            <a name="" id="" class="btn btn-danger" role="button" 
            onclick="eliminaEmpleado('<?php echo $registro['IdEmpleado'];?>');">Eliminar</a>
        </td>
    </tr>
<?php }?>