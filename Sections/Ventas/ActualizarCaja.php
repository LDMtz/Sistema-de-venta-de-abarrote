<?php 
    include("../../Conexion.php");
    $IdCaja = $_POST['IdCaja'];
    $IdEmpleado = $_POST['IdEmpleado'];
    $Total = $_POST['Total'];
    $TipoMov = $_POST['TipoMov'];

    $query = "SELECT MontoActual FROM Caja WHERE IdCaja = '$IdCaja'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado){
        $fila = mysqli_fetch_assoc($resultado);
        $montoActual = $fila['MontoActual'];
    }

    $montoActualizado = $montoActual + $Total;
    $montoActualizado = number_format($montoActualizado, 2, '.', '');

    $query = "UPDATE CAJA SET MontoActual='$montoActualizado' WHERE IdCaja = '$IdCaja'";
    mysqli_query($conexion, $query);

    $query = "INSERT INTO Movimiento_Caja (IdCaja, TipoMov,MontoMov,EmpleadoMov)
    VALUES ($IdCaja, $TipoMov, $Total, $IdEmpleado)";
    mysqli_query($conexion, $query);
    
    mysqli_close($conexion);
    echo json_encode($montoActualizado);
?>
