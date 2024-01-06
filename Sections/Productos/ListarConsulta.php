<?php
    include("../../Conexion.php");
        $listaProductos = [];

        //Si me pide una consulta especifica
        if (isset($_POST['tipo_dato'])){
            $tipo_dato=(isset($_POST['tipo_dato']))?$_POST['tipo_dato']:"";
            $dato=(isset($_POST['dato']))?$_POST['dato']:"";

            //Cargando las categorias en una lista para el combo box
            $query="SELECT IdCategoria,Nombre FROM Categorias";
            $resultado=mysqli_query($conexion,$query);
            if($resultado)
                while ($fila = mysqli_fetch_assoc($resultado))
                    $listaCategorias[] = $fila;

            //Cargando los proveedores en una lista para el combo box
            $query="SELECT IdProveedor,Nombre FROM Proveedores";
            $resultado=mysqli_query($conexion,$query);
            if($resultado)
                while ($fila = mysqli_fetch_assoc($resultado))
                    $listaProveedores[] = $fila;

            //Consulta predefinida
            $query = "SELECT * FROM Productos WHERE $tipo_dato LIKE '%$dato%'";

            //Si se selecciono el modo de busqueda mediante el IdProveedor o IdCategoria se cambia el query
            if($tipo_dato == 'IdProveedor'){
                $query = "SELECT Productos.* FROM Productos JOIN Proveedores 
                ON Productos.IdProveedor = Proveedores.IdProveedor 
                WHERE Proveedores.Nombre LIKE '%$dato%';";
            }
            if($tipo_dato == 'IdCategoria'){
                $query = "SELECT Productos.* FROM Productos JOIN Categorias 
                ON Productos.IdCategoria = Categorias.IdCategoria 
                WHERE Categorias.Nombre LIKE '%$dato%';";
            }

            //Realizando la consulta
            $resultado=mysqli_query($conexion,$query);
            if($resultado)
            while ($fila = mysqli_fetch_assoc($resultado))
                $listaProductos[] = $fila;

        }
    mysqli_close($conexion);
    if (empty($listaProductos)) {
        // Si no se encontraron productoz, imprimir un mensaje
        echo "No se encontraron productos";
        return 0;
    }  
?>

<?php foreach ($listaProductos as $registro){?>
    <tr class="">
        <td scope="row"><?php echo $registro['IdProducto']?></td>
        <td>
            <img width="50" 
            src="<?php echo 'Fotos/'.$registro['Foto']?>" 
            class="img-fluid rounded" 
            alt="FotoEmpleado">
        </td>
        <td><?php echo $registro['CodigoBarras']?></td>
        <td><?php echo $registro['Nombre']?></td>
        <td><?php echo $registro['Descripcion']?></td>
        <td><?php echo $registro['Existencias']?></td>
        <td><?php echo $registro['PrecioCompra']?></td>
        <td><?php echo $registro['PrecioVenta']?></td>
        <td><?php foreach ($listaCategorias as $categoria) {
            if ($registro['IdCategoria'] == $categoria['IdCategoria']) {
                echo $categoria['Nombre'];
                break;
            }
            }?>
        </td>
        <td><?php foreach ($listaProveedores as $proveedor) {
            if ($registro['IdProveedor'] == $proveedor['IdProveedor']) {
                echo $proveedor['Nombre'];
                break;
            }
            }?>
        </td>
        <td><?php echo ($registro['Estado'] == 1) ? 'Activo' : 'Inactivo'; ?></td>
        <td><?php echo $registro['FechaRegistro']?></td>
        <td>
            <div class="btn-group btn-group-horizontal" role="group">
                <a name="" id="" class="btn btn-primary" role="button" 
                onclick="modificaProducto('<?php echo $registro['IdProducto'];?>');">Editar</a>

                <a name="" id="" class="btn btn-danger" role="button" 
                onclick="eliminaProducto('<?php echo $registro['IdProducto'];?>');">Eliminar</a>
            </div>
        </td>
    </tr>
<?php }?>