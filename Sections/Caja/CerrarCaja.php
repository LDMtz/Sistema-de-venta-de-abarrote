<?php 
    session_start();
?>
<?php 
    include("../../Conexion.php");

    $response = array();
    if(isset($_POST['IdCaja'])){
        $IdCaja=(isset($_POST['IdCaja']))?$_POST['IdCaja']:"";
        $MontoCierre = (isset($_POST['MontoActual'])) ? doubleval(str_replace('$', '', $_POST['MontoActual'])) : 0.0;

        date_default_timezone_set('America/Mazatlan');
        $fechaActual = date("Y-m-d H:i:s");

        $query = "UPDATE Caja SET 
        Estado=0,
        MontoActual=0,
        FechaHoraCierre='$fechaActual',
        EmpleadoCierre='{$_SESSION['IdEmpleado']}',
        MontoCierre='$MontoCierre'
        WHERE IdCaja ='$IdCaja'";
        mysqli_query($conexion,$query);

        $_SESSION['IdCaja'] = "-1";

        //PENDIENTE VER SI LO DEJO O LO QUITO
        $query = "TRUNCATE TABLE Movimiento_Caja";
        mysqli_query($conexion,$query);

        $query = "SELECT 
                    Caja.IdCaja,
                    EmpApertura.Nombre AS NombreEmpApertura,
                    Caja.FechaHoraApertura,
                    Caja.MontoApertura,
                    EmpCierre.Nombre AS NombreEmpCierre,
                    Caja.FechaHoraCierre,
                    Caja.MontoCierre
                FROM 
                    Caja
                INNER JOIN Empleados AS EmpApertura ON Caja.EmpleadoApertura = EmpApertura.IdEmpleado
                LEFT JOIN Empleados AS EmpCierre ON Caja.EmpleadoCierre = EmpCierre.IdEmpleado
                WHERE Caja.IdCaja ='$IdCaja'";
        $resultado = mysqli_query($conexion,$query);

        if($resultado){
            $datosCajaCerrada = array();
            while ($fila = mysqli_fetch_assoc($resultado))
                $datosCajaCerrada = $fila;
        }

        $dateTime = new DateTime($datosCajaCerrada['FechaHoraApertura']);
        $fechaApertura = $dateTime->format("Y-m-d");
        $horaApertura = $dateTime->format("H:i");

        $dateTime = new DateTime($datosCajaCerrada['FechaHoraCierre']);
        $fechaCierre = $dateTime->format("Y-m-d");
        $horaCierre = $dateTime->format("H:i");

        $response['IdCaja'] = $datosCajaCerrada['IdCaja'];
        $response['NombreEmpApertura'] = $datosCajaCerrada['NombreEmpApertura'];
        $response['FechaApertura'] = $fechaApertura;
        $response['HoraApertura'] = $horaApertura;
        $response['MontoApertura'] = $datosCajaCerrada['MontoApertura'];
        $response['NombreEmpCierre'] = $datosCajaCerrada['NombreEmpCierre'];
        $response['FechaCierre'] = $fechaCierre;
        $response['HoraCierre'] = $horaCierre;
        $response['MontoCierre'] = $datosCajaCerrada['MontoCierre'];

        $response['success'] = true;
        $response['title'] = '¡Caja cerrada';
        $response['message'] = 'Haz cerrado la caja correctamente';
        $response['type'] = 'success';
    }else{
        $response['success'] = false;
        $response['title'] = '¡Hubo un error';
        $response['message'] = 'Se presento un error al intentar cerrar la caja';
        $response['type'] = 'error';
    }

    echo json_encode($response);
    mysqli_close($conexion);
?>