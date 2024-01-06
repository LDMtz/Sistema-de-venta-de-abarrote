<?php 
    include("../../Conexion.php");

    $query="SELECT
    Productos.Foto,
    Productos.CodigoBarras, 
    Productos.Nombre, 
    Productos.Descripcion, 
    Productos.PrecioVenta,
    Producto_Descuento.IdDescuento AS IdDescuento, 
    Producto_Descuento.Descuento AS Descuento, 
    Producto_Descuento.FechaInicio AS FechaInicio
    FROM Productos
    INNER JOIN Producto_Descuento ON Productos.IdProducto = Producto_Descuento.IdProducto;";

    $resultado=mysqli_query($conexion,$query);

    $listaDescuentos = array();

    if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaDescuentos[] = $fila;// Agregar la fila actual al array $listaDescuentos

    mysqli_close($conexion);
?>

<?php foreach ($listaDescuentos as $registro){?>
    <tr class="">
        <td scope="row"><?php echo $registro['IdDescuento']?></td>
        <td>
            <img width="50" 
            src="<?php echo 'Fotos/'.$registro['Foto']?>" 
            class="img-fluid rounded" 
            alt="FotoProducto">
        </td>
        <td><?php echo $registro['CodigoBarras']?></td>
        <td><?php echo $registro['Nombre']?></td>
        <td><?php echo $registro['Descripcion']?></td>
        <td><?php echo '$'.($registro['PrecioVenta'])?></td>
        <td><?php 
            echo('$'.(doubleval($registro['PrecioVenta']) - doubleval($registro['Descuento'])));
        ?></td>
        <td><?php echo '$'.$registro['Descuento']?></td>
        <td><?php echo $registro['FechaInicio']?></td>
        <td>
            <a name="" id="" class="btn btn-danger" role="button" 
            onclick="terminarDescuento('<?php echo $registro['IdDescuento'];?>');">Terminar</a>
        </td>
    </tr>
<?php }?>