<?php 
    session_start();
    $response = array();

    if (isset($_SESSION['carritoV']) && isset($_POST['Id'])) {
        $idProductoEliminar = $_POST['Id'];

        // Encuentra el índice del producto en el carrito
        $indiceEliminar = -1;
        foreach ($_SESSION['carritoV'] as $indice => $producto) {
            if ($producto['Id'] == $idProductoEliminar) {
                $indiceEliminar = $indice;
                break;
            }
        }

        // Si se encuentra el producto, elimínalo del carrito
        if ($indiceEliminar != -1) {
            unset($_SESSION['carritoV'][$indiceEliminar]);

            // Reindexa el array para evitar problemas con la iteración
            $_SESSION['carritoV'] = array_values($_SESSION['carritoV']);

            $response['title'] = 'Producto eliminado del carrito!';
            $response['success'] = true;
            $response['message'] = 'Se elimino producto del carrito';
            $response['type'] = 'success';
        } else {
            $response['title'] = '¡Error!';
            $response['success'] = true;
            $response['message'] = 'No se pudo ecnontrar el producto en el carrito';
            $response['type'] = 'error';
        }
    } else {
        $response['title'] = '¡Error!';
        $response['success'] = false;
        $response['message'] = 'No se pudo eliminar el producto del carrito';
        $response['type'] = 'error';
    }

    echo json_encode($response);
    //echo json_encode($response);
?>