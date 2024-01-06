<?php 
    include("../../Conexion.php");

    $response = array();
    //Si el post contiene algo
    if($_POST){
        $CodigoBarras=(isset($_POST['CodigoBarras']))?$_POST['CodigoBarras']:"";
        if($CodigoBarras){
            //Primero comprueba que no tenga ningun descuento activo
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
            
            //Si tiene un descuento activo
            if($resultado && mysqli_num_rows($resultado) > 0){
                while ($fila = mysqli_fetch_assoc($resultado))
                    $producto = $fila;

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

                <div class="row">
                    <div class="col-sm-9 input-group-sm">
                        <input id="IdProducto" class="form-control" type="text" value="'.$producto['IdProducto'].'" disabled readonly hidden>
                    </div>
                </div>
                '
                ;

                $response['title'] = '¡Codigo de barras encontrado!';
                $response['success'] = true;
                $response['message'] = 'Se econtro el codigo de barras';
                $response['HTML'] = $html;
            }
            else{
                    $response['title'] = '¡Ocurrió un error con el código de barras!';
                    $response['success'] = false;
                    $response['message'] = 'Este codigo de barras no existe';
                        
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
