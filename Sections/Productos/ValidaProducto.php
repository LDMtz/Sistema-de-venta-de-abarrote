<?php 
    include("../../Conexion.php");

    $response = array();
    //Si el post contiene algo
    if($_POST){
        $CodigoBarras=(isset($_POST['CodigoBarras']))?$_POST['CodigoBarras']:"";
        if($CodigoBarras){
            
            //Primero comprueba que no tenga ningun descuento activo
            $query = "SELECT Nombre, CodigoBarras, Descripcion
            FROM Productos
            WHERE CodigoBarras = '$CodigoBarras'
            AND EXISTS (
                SELECT 1
                FROM Producto_Descuento
                WHERE Producto_Descuento.IdProducto = Productos.IdProducto
            )";
            $consultaDescuentoPrevio=mysqli_query($conexion,$query);
            
            //Si tiene un descuento activo
            if($consultaDescuentoPrevio && mysqli_num_rows($consultaDescuentoPrevio) > 0){
                while ($fila = mysqli_fetch_assoc($consultaDescuentoPrevio))
                    $productoConDescuento = $fila;

                $response['title'] = '¡Este producto ya tiene un descuento activo!';
                $response['success'] = false;
                $response['message'] = 'El producto con el código de barras '.$productoConDescuento['CodigoBarras'].' 
                "'.$productoConDescuento['Nombre'].' - '.$productoConDescuento['Descripcion'].'" ya tiene un descuento "Activo", por
                lo tanto no puedes asignarle otro descuento, si lo deseas puedes terminar el descuento relacionado a este producto
                y volverlo a empezar con el nuevo descuento.';

                
            }
            else{
                    //Si no tiene ningun descuento activo me trae los datos del producto
                $query = "SELECT
                    Productos.IdProducto,
                    Productos.Nombre, 
                    Productos.Foto, 
                    Productos.Descripcion, 
                    Productos.PrecioCompra, 
                    Productos.PrecioVenta, 
                    Productos.Existencias, 
                    CASE 
                        WHEN Productos.Estado = 1 THEN 'Activo' 
                        ELSE 'Inactivo' 
                    END AS Estado, 
                    Categorias.Nombre AS NombreCategoria, 
                    Proveedores.Nombre AS NombreProveedor
                FROM Productos
                INNER JOIN Categorias ON Productos.IdCategoria = Categorias.IdCategoria
                INNER JOIN Proveedores ON Productos.IdProveedor = Proveedores.IdProveedor
                WHERE Productos.CodigoBarras = '$CodigoBarras'";

                
                $resultado=mysqli_query($conexion,$query);

                if($resultado && mysqli_num_rows($resultado) > 0){
                    while ($fila = mysqli_fetch_assoc($resultado))
                        $producto = $fila;

                    $response['title'] = '¡Producto econtrado!';
                    $response['success'] = true;
                    $response['message'] = 'Se encontró el producto';

                    $html='
                    <h4>PRODUCTO:</h4>
                    <div class="card text-center">
                        <div class="text-center mb-1 mt-1">
                            <img src="Fotos/'.$producto['Foto'].'" class="rounded img-fluid" alt="fotoDelProducto" width="150">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <label class="col-sm-3 col-form-label">Nombre:</label>
                        <div class="col-sm-9 input-group-sm">
                            <input class="form-control" type="text" value="'.$producto['Nombre'].'" disabled readonly>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label class="col-sm-4 col-form-label">Descripción:</label>
                        <div class="col-sm-8 input-group-sm">
                            <input class="form-control" type="text" value="'.$producto['Descripcion'].'" disabled readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label">Categoría:</label>
                        <div class="col-sm-9 input-group-sm">
                            <input class="form-control" type="text" value="'.$producto['NombreCategoria'].'" disabled readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label">Proveedor:</label>
                        <div class="col-sm-9 input-group-sm">
                            <input class="form-control" type="text" value="'.$producto['NombreProveedor'].'" disabled readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label">Precio compra:</label>
                        <div class="col-sm-8 input-group-sm">
                            <input class="form-control" type="text" value="$'.$producto['PrecioCompra'].'" disabled readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label">Precio venta:</label>
                        <div class="col-sm-8 input-group-sm">
                            <input id="inputPrecioVenta" class="form-control" type="text" value="$'.$producto['PrecioVenta'].'" disabled readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label">Existencias:</label>
                        <div class="col-sm-9 input-group-sm">
                            <input class="form-control" type="text" value="'.$producto['Existencias'].'" disabled readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label">Estado:</label>
                        <div class="col-sm-9 input-group-sm">
                            <input class="form-control" type="text" value="'.$producto['Estado'].'" disabled readonly>
                        </div>
                    </div>

                    <input id="inputIdProducto" type="text" value="'.$producto['IdProducto'].'" disabled readonly hidden>
                    '
                    ;
                    $response['HTML'] = $html;
                }
                else{
                    $response['title'] = '¡Ocurrió un error con el código de barras!';
                    $response['success'] = false;
                    $response['message'] = 'Este codigo de barras no existe';
                }
                        
            }
        }
        else{
            $response['title'] = '¡Dejaste el código de barras vacio!';
            $response['success'] = false;
            $response['message'] = 'Debes ingresar un código de barras';
        }
    }

    mysqli_close($conexion);
    echo json_encode($response);
    
?>



