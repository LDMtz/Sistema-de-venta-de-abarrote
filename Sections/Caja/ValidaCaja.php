<?php 
    session_start();

    include("../../Conexion.php");
    $response = array();
    //Si el post contiene algo
    if($_POST){
        $query = "SELECT
                    Caja.IdCaja,
                    Empleados.Nombre AS NombreEmpApertura,
                    Caja.FechaHoraApertura,
                    Caja.MontoActual,
                    Caja.MontoApertura
                FROM
                    Caja
                INNER JOIN
                    Empleados ON Caja.EmpleadoApertura = Empleados.IdEmpleado
                WHERE
                    Caja.Estado = 1";
        $consultaCaja=mysqli_query($conexion,$query);

        if($consultaCaja && mysqli_num_rows($consultaCaja) > 0){
            while ($fila = mysqli_fetch_assoc($consultaCaja))
                $datosCaja = $fila;

                $dateTime = new DateTime($datosCaja['FechaHoraApertura']);
                // Extraer la fecha en formato Y-m-d
                $fecha = $dateTime->format("Y-m-d");
                // Extraer la hora en formato H:i:s
                $hora = $dateTime->format("H:i");

            $html='
            <h3 class="mt-1">Datos de la caja activa:</h3>
            <div class="container">
                <div class="container mt-2 form-group d-flex align-items-center justify-content-center">
                    <textarea class="w-75 form-control txtAreaCaja text-center " id="montoActual" rows="1" style="font-size: 45px;"readonly>$'.$datosCaja['MontoActual'].'</textarea>
                </div>
                <p class="fw-bold text-center" style="font-size: 20px;">Monto en caja</p>
                <hr>

                <div class="row mt-2">
                    <label class="col-sm-3 col-form-label">Id de Caja:</label>
                    <div class="col-sm-9 input-group-sm">
                        <input id="InputIdCaja" class="form-control" type="text" value="'.$datosCaja['IdCaja'].'" disabled readonly>
                    </div>
                </div>
                
                <div class="row">
                    <label class="col-sm-5 col-form-label">Empleado que abrió:</label>
                    <div class="col-sm-7 input-group-sm">
                        <input class="form-control" type="text" value="'.$datosCaja['NombreEmpApertura'].'" disabled readonly>
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-4 col-form-label">Fecha de apertura:</label>
                    <div class="col-sm-8 input-group-sm">
                        <input class="form-control" type="text" value="'.$fecha.'" disabled readonly>
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-4 col-form-label">Hora de apertura:</label>
                    <div class="col-sm-8 input-group-sm">
                        <input class="form-control" type="text" value="'.$hora.'" disabled readonly>
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-5 col-form-label">Monto de apertura:</label>
                    <div class="col-sm-7 input-group-sm">
                        <input class="form-control" type="text" value="'.'$'.$datosCaja['MontoApertura'].'" disabled readonly>
                    </div>
                </div>

                
                <div class="d-flex justify-content-center mt-3 mb-3">
                    <button type="button" class="btn btn-danger" onclick="cerrarCaja()">Cerrar caja</button>
                </div>

            </div>
            '
            ;
            $response['success'] = true;
            $response['title'] = '¡Se encontró una caja activa!';
            $response['message'] = 'Se logró encontrar una caja';
            $response['type'] = 'success';
            $response['html'] = $html;
        }
        else{
            $response['success'] = false;
            $response['title'] = '¡No existe una caja activa!';
            $response['message'] = 'No se encontró ninguna caja activa y es necesario que abras una para realizar ciertos procesos.';
            $response['type'] = 'warning';
            $response['html'] = '
                                <div class="text-center">
                                    <h3 class="mt-3">No hay una caja activa</h3>
                                </div>
                                <div class="d-flex justify-content-center mt-3 mb-3">
                                    <button type="button" class="btn btn-success" onclick="abrirCajaInputs(\''.$_SESSION['Nombre'].'\');">Abrir caja</button>
                                </div>
                                ';
        }
            
    }
    echo json_encode($response);
    mysqli_close($conexion);
    
?>