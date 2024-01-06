<?php  
    session_start();

    include("../../Conexion.php");

    $response = array();

    $IdProducto=(isset($_POST['IdProducto']))?$_POST['IdProducto']:"";
    $Cantidad=(isset($_POST['Cantidad']))?$_POST['Cantidad']:"";
    $Existencias=(isset($_POST['Existencias']))?$_POST['Existencias']:"";
    //$PrecioVenta = '';
    //$Descuento = '';
    //$Subtotal = '';

    $query = "SELECT
        P.PrecioVenta,
        COALESCE(D.Descuento, 0) AS Descuento
    FROM
        Productos P
    LEFT JOIN
        Producto_Descuento D ON P.IdProducto = D.IdProducto
    WHERE
        P.IdProducto ='$IdProducto'";
    $resultado=mysqli_query($conexion,$query);
    if($resultado){
        while ($fila = mysqli_fetch_assoc($resultado)){
            $PrecioVenta = $fila['PrecioVenta'];
            $Descuento = $fila['Descuento'];
            $Subtotal = number_format(($PrecioVenta * $Cantidad) - ($Descuento * $Cantidad), 2);
        }
    }

    mysqli_close($conexion);

    //Asegurarse de que exista
    if (!isset($_SESSION['carritoV'])) {
        $_SESSION['carritoV'] = array();
    }

    //Valida que el producto no este en el carrito
    $productoEncontrado = false;
    foreach ($_SESSION['carritoV'] as &$producto) {
        if ($producto['Id'] == $IdProducto) {
            // Verificar si la cantidad acumulada supera las existencias disponibles
            $nuevaCantidad = $producto['Cantidad'] + $Cantidad;
            if ($nuevaCantidad <= $Existencias) {
                $producto['Cantidad'] = $nuevaCantidad;
                $producto['PrecioUnitario'] = $PrecioVenta;
                $producto['DescuentoUnitario'] = $Descuento;
                $producto['Subtotal'] = number_format(($PrecioVenta * $nuevaCantidad) - ($Descuento * $nuevaCantidad), 2);;

                //Mensaje de exito
                $response['title'] = '¡Producto agregado al carrtio!';
                $response['success'] = true;
                $response['message'] = 'El producto fue guardado correctamente en el carrito';
                $response['type'] = 'success';
                //Mandar mensaje de que se pudo agregar el producto correctamente
            } else {
                // Si la cantidad supera las existencias, establecer la cantidad al máximo
                $producto['Cantidad'] = $Existencias;
                $producto['PrecioUnitario'] = $PrecioVenta;
                $producto['DescuentoUnitario'] = $Descuento;
                $producto['Subtotal'] = number_format(($PrecioVenta * $Existencias) - ($Descuento * $Existencias), 2);;
                
                //MANDAR EL ERROR DE QUE SOLO SE PUDIERON AGREGAR LA CANTIDAD MAXIMA AL CARRITO
                $response['title'] = '¡Sobrepasaste las existencias!';
                $response['success'] = true;
                $response['message'] = 'El producto que acabas de guardar ya existia en el carrito, y al acumular todos los productos sobrepasaste las existencias totales, por lo tanto solo se acumularon '.$Existencias. ' unidades en el carrito, lo cual la cantidad maxima disponibles.';
                $response['type'] = 'warning';

            }
            $productoEncontrado = true;
            break;
        }
    }

    //Si no hay un producto igual en el carrito
    if (!$productoEncontrado) {
        $nuevoProducto = array(
            'Id' => $IdProducto,
            'Cantidad' => $Cantidad,
            'PrecioUnitario' => $PrecioVenta,
            'DescuentoUnitario' => $Descuento,
            'Subtotal' => $Subtotal
        );
        $_SESSION['carritoV'][] = $nuevoProducto;

        $response['title'] = '¡Producto agregado al carrito!';
        $response['success'] = true;
        $response['message'] = 'El producto fue guardado correctamente en el carrito';
        $response['type'] = 'success';
    }

    echo json_encode($response);

?>