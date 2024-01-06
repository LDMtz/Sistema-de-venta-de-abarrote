<?php
include("../../Conexion.php");

    $response = array();

    $tipo_dato=(isset($_POST['selectBuscarPor']))?$_POST['selectBuscarPor']:"";
    $dato=(isset($_POST['datoBusquedaProducto']))?$_POST['datoBusquedaProducto']:"";

    if ($dato != ""){

        //Consulta predefinida
        $query = "SELECT Productos.*, COALESCE(Descuento.Descuento, 0) AS DescuentoProducto
        FROM Productos
        LEFT JOIN Producto_Descuento AS Descuento ON Productos.IdProducto = Descuento.IdProducto
        WHERE $tipo_dato LIKE '%$dato%' AND Productos.Estado = 1";
    
        //Si se selecciono el modo de busqueda mediante el IdProveedor o IdCategoria se cambia el query
        if($tipo_dato == 'Proveedor'){
            $query = "SELECT Productos.*, COALESCE(Descuento.Descuento, 0) AS DescuentoProducto
            FROM Productos
            JOIN Proveedores ON Productos.IdProveedor = Proveedores.IdProveedor
            LEFT JOIN Producto_Descuento AS Descuento ON Productos.IdProducto = Descuento.IdProducto
            WHERE Proveedores.Nombre LIKE '%$dato%' AND Productos.Estado = 1";
        }
        if($tipo_dato == 'Categoria'){
            $query = "SELECT Productos.*, COALESCE(Descuento.Descuento, 0) AS DescuentoProducto
            FROM Productos
            JOIN Categorias ON Productos.IdCategoria = Categorias.IdCategoria
            LEFT JOIN Producto_Descuento AS Descuento ON Productos.IdProducto = Descuento.IdProducto
            WHERE Categorias.Nombre LIKE '%$dato%' AND Productos.Estado = 1";
        }
    
        //Realizando la consulta
        $resultado=mysqli_query($conexion,$query);
        
        if($resultado && mysqli_num_rows($resultado) > 0){
            $html = '<div class="row">'; // Variable para almacenar el HTML de las tarjetas
            
            while ($producto = mysqli_fetch_assoc($resultado)) {
                $dataPrecioVenta = number_format($producto['PrecioVenta'], 2, '.', '');
                $dataDescuento = number_format($producto['DescuentoProducto'], 2, '.', '');
                // Genera el HTML de la tarjeta para cada producto
                $html .= '
                <div class="col-md-4">
                    <div class="card text-dark bg-info mb-3 p-0 card-as-button" style="max-width: 18rem;" onclick="toggleSelection(this);" 
                        data-id="' . $producto['IdProducto'] . '" data-nombre="' . $producto['Nombre'] . '" data-precioventa="' . $dataPrecioVenta. '"
                        data-foto="' . $producto['Foto']. '" data-descuento="' . $dataDescuento. '" data-existencias="' . $producto['Existencias']. '">

                        <div class="card-header" style="background-color: rgb(49, 69, 151); color: white;">' . $producto['Nombre'] . '</div>
                        <div class="card-body">
                            <img src="../Productos/Fotos/' . $producto['Foto'] . '" class="card-img-top" style="width: 200px; height: 200px;">
                            <h6 class="card-title m-0">CB: ' . $producto['CodigoBarras'] . '</h6>
                            <p class="card-text m-0">Descripcion: ' . $producto['Descripcion'] . '</p>
                            <p class="card-text m-0">Existencias: ' . $producto['Existencias'] . '</p>
                        </div>
                    </div>
                </div>';
    
            }
            
            $response['title'] = '¡Lista de productos!';
            $response['success'] = true;
            $response['found'] = true;
            $response['message'] = 'Esta es la lista de todos los productos';
            $response['HTML'] = $html;
        }
        else{
            $response['title'] = '¡No se encontraron productos!';
            $response['success'] = true;
            $response['found'] = false;
            $response['message'] = 'No se encontro ningun producto con los datos proporcionados';
            $response['type'] = 'error';
        }
    }else{
        $response['title'] = '¡Error en la busqueda!';
        $response['success'] = false;
        $response['found'] = false;
        $response['message'] = 'Debes ingresar un dato valido para la busqueda';
        $response['type'] = 'error';
               
    }

    mysqli_close($conexion);
    echo json_encode($response);

?>