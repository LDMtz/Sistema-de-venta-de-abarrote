<?php 
    include("../../Conexion.php");
    session_start();

    $response = array();
    //Insertando registro a la tabla Ventas
    $TipoDoc = $_POST['TipoDoc'];
    $Folio = $_POST['Folio'];
    $IdEmpleado = $_POST['IdEmpleado'];
    $IdCaja = $_POST['IdCaja'];
    $IdCliente = $_POST['IdCliente'];
    $MontoPago = $_POST['MontoPago'];

    if($IdCliente != '-1'){
        $query1 = "INSERT INTO Ventas (TipoDoc, Folio, IdEmpleado, IdCaja, IdCliente, MontoPago) 
        VALUES ('$TipoDoc','$Folio', '$IdEmpleado', '$IdCaja','$IdCliente','$MontoPago')";

    }else{
        $query1 = "INSERT INTO Ventas (TipoDoc, Folio, IdEmpleado, IdCaja, MontoPago) 
        VALUES ('$TipoDoc','$Folio', '$IdEmpleado', '$IdCaja', '$MontoPago')";
    }

    mysqli_query($conexion, $query1);

    //__________________________________________________
    //Recuperando el IdVenta
    $queryIdVenta = "SELECT IdVenta FROM Ventas WHERE Folio = '$Folio'";
    $resultado = mysqli_query($conexion, $queryIdVenta);
    if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
        $IdVenta = $fila['IdVenta'];
    }

    //________________________________________________
    // Insertando los registros a la tabla detalle venta
    if (isset($_SESSION['carritoV']) && !empty($_SESSION['carritoV']) && $IdVenta) {
        foreach ($_SESSION['carritoV'] as $producto) {
            $queryInsert = "INSERT INTO Detalle_Venta (IdVenta, IdProducto, Cantidad, PrecioUnitario, DescuentoUnitario, Subtotal) 
                            VALUES ($IdVenta, {$producto['Id']}, {$producto['Cantidad']}, {$producto['PrecioUnitario']}, {$producto['DescuentoUnitario']}, {$producto['Subtotal']})";
            // Ejecutar la consulta
            mysqli_query($conexion, $queryInsert);

            $queryExistencias = "SELECT Existencias FROM Productos WHERE IdProducto = {$producto['Id']}";
            $resultExistencias = mysqli_query($conexion, $queryExistencias);
            if ($row = mysqli_fetch_assoc($resultExistencias)) {
                $existenciasActuales = $row['Existencias'];
            } else {
                $existenciasActuales = 0;
            }

            $nuevaExistencia = $existenciasActuales - $producto['Cantidad'];
            $queryUpdate = "UPDATE Productos SET Existencias = '$nuevaExistencia' WHERE IdProducto = {$producto['Id']}";
            mysqli_query($conexion, $queryUpdate);

        }
        $response['title'] = '¡Venta realizada!';
        $response['success'] = true;
        $response['message'] = 'La venta ha sido realizada correctamente';
        $response['type'] = 'success';
    }


    mysqli_close($conexion);
    echo json_encode($response);

?>