<?php 
    include("../../Conexion.php");

    $query="SELECT * FROM Productos";
    $resultado=mysqli_query($conexion,$query);
    $listaProductos = array();
    if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaProductos[] = $fila;// Agregar la fila actual al array $listaProductos

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

    mysqli_close($conexion);
?>

    <?php foreach ($listaProductos as $registro){?>
        <tr class="">
            <td scope="row"><?php echo $registro['IdProducto']?></td>
            <td>
                <img width="50" 
                src="<?php echo 'Fotos/'.$registro['Foto']?>" 
                class="img-fluid rounded" 
                alt="FotoProducto">
            </td>
            <td><?php echo $registro['CodigoBarras']?></td>
            <td><?php echo $registro['Nombre']?></td>
            <td><?php echo $registro['Descripcion']?></td>
            <td class="text-center"><?php echo $registro['Existencias']?></td>
            <td><?php echo '$'.$registro['PrecioCompra']?></td>
            <td><?php echo '$'.$registro['PrecioVenta']?></td>
            <td><?php 
                    foreach($listaCategorias as $categoria){
                        if($registro['IdCategoria']==$categoria['IdCategoria']){
                            echo $categoria['Nombre'];
                            break;
                        }
                    }
                ?>
            </td>
            <td><?php 
                    foreach($listaProveedores as $proveedor){
                        if($registro['IdProveedor']==$proveedor['IdProveedor']){
                            echo $proveedor['Nombre'];
                            break;
                        }
                    }
                ?>
            </td>
            <td>
                <span class="badge <?php echo ($registro['Estado'] == 1) ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo ($registro['Estado'] == 1) ? 'Activo' : 'Inactivo'; ?>
                </span>
            </td>
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