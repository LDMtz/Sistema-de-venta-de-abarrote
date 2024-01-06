
<?php
    //session_start(); //Borrar

    include("../../Conexion.php");

    if (isset($_SESSION['carritoV'])){
        $Num = 0;
        $descuentoCarritoV = 0;
        $totalCarritoV = 0;

        foreach ($_SESSION['carritoV'] as $producto){
            $idProducto = $producto['Id'];
            $cantidad = $producto['Cantidad'];
            $Num = $Num + 1;
    
            $query = "SELECT
            P.Foto,
            P.Nombre,
            P.Descripcion,
            P.Existencias,
            P.PrecioVenta,
            CASE WHEN D.Descuento IS NOT NULL THEN D.Descuento ELSE 0 END AS Descuento
            FROM Productos AS P
            LEFT JOIN Producto_Descuento AS D ON P.IdProducto = D.IdProducto
            WHERE P.IdProducto = '$idProducto'";
    
            $resultado=mysqli_query($conexion,$query);
            if($resultado)
            while ($fila = mysqli_fetch_assoc($resultado)){
                
                $descuentoUnitario = $fila['Descuento'];
                $descuentoAcumulado = number_format($descuentoUnitario * $cantidad, 2);

                // Calcula el subtotal
                $subtotal = number_format(($fila['PrecioVenta']*$cantidad) - $descuentoAcumulado, 2);

                $descuentoCarritoV += $descuentoAcumulado;
                $totalCarritoV += $subtotal;

                $_SESSION['descuentoCarritoV'] = number_format($descuentoCarritoV,2);
                $_SESSION['totalCarritoV'] = number_format($totalCarritoV,2) ;

                // Agrega la información al array
                $fila['Id'] = $idProducto;
                $fila['Num'] = $Num;
                $fila['Cantidad'] = $cantidad;
                $fila['DescuentoAcumulado'] = $descuentoAcumulado;
                $fila['Subtotal'] = $subtotal;
                $dataProductos[] = $fila;
            }
    
        }
    }
    echo '<script>';
    echo '$(document).ready(function(){';
    echo '$("#inputTotal").val("$' . $_SESSION['totalCarritoV'] . '");'; // Actualiza el valor del input
    echo '$("#inputDescTotal").val("$' . $_SESSION['descuentoCarritoV'] . '");';
    echo '$("#totalPagar").val("$' . $_SESSION['totalCarritoV'] . '");'; // Actualiza el valor del input
    echo '});';
    echo '</script>';

    mysqli_close($conexion);
?>

<?php if (isset($_SESSION['carritoV']) && !empty($_SESSION['carritoV'])){?>
<?php foreach ($dataProductos as $registro){?>
    <tr class="container">
        <td scope="row" class="text-nowrap text-center align-middle"><?php echo $registro['Num']?></td>
        <td class="text-nowrap text-center align-middle">
            <img width="50" 
            src="<?php echo '../Productos/Fotos/'.$registro['Foto']?>" 
            class="img-fluid" 
            alt="FotoProd">
        </td>
        <td class="text-nowrap text-center align-middle"><?php echo $registro['Nombre'].' '.$registro['Descripcion']?></td>
        <td class="text-nowrap text-center align-middle"><?php echo $registro['Cantidad']?></td>
        <td class="text-nowrap text-center align-middle"><?php echo '$'.number_format($registro['PrecioVenta'],2)?></td>
        <td class="text-nowrap text-center align-middle"><?php echo '$'.$registro['DescuentoAcumulado']?></td>
        <td class="text-nowrap text-center align-middle"><?php echo '$'.$registro['Subtotal']?></td>
        <td class="text-nowrap text-center align-middle">
            <button class="btn btn-white align-middle" onclick="eliminarDelCarrito(<?php echo $registro['Id']; ?>);">
                <img src="../../Resources/Icons/borrar.svg" style="width: 20px; height: 20px;">
            </button>
        </td>
    </tr>
<?php }?>
<?php }?>
