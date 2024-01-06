<?php
include("../../Conexion.php");

    $response = array();
            //Primero comprueba que no tenga ningun descuento activo
    $query = "SELECT * FROM Clientes";

    $resultado=mysqli_query($conexion,$query);
            
    //Si tiene un descuento activo
    if($resultado && mysqli_num_rows($resultado) > 0){
        $html = '<div class="row">'; // Variable para almacenar el HTML de las tarjetas

        while ($cliente = mysqli_fetch_assoc($resultado)) {
            // Genera el HTML de la tarjeta para cada cliente
            $html .= '
            <div class="col-md-4">
                <div class="card text-dark bg-info mb-3 p-0 card-as-button" style="max-width: 18rem;" data-nombre="' . $cliente['Nombre'] . '" data-id="' . $cliente['IdCliente'] . '" onclick="toggleSelection(this);">
                    <div class="card-header" style="background-color: rgb(49, 69, 151); color: white;">' . $cliente['Nombre'] . '</div>
                    <div class="card-body">
                        <h5 class="card-title m-0">Id Cliente: ' . $cliente['IdCliente'] . '</h5>
                        <p class="card-text m-0">Correo: ' . $cliente['Correo'] . '</p>
                        <p class="card-text m-0">Teléfono: ' . $cliente['Telefono'] . '</p>
                        <p class="card-text m-0">Fecha: ' . $cliente['FechaRegistro'] . '</p>
                    </div>
                </div>
            </div>';

        }
        
        $html .= '
        <div class="col-md-4">
            <div class="card text-dark bg-warning mb-3 p-0 card-as-button" style="max-width: 18rem;" data-nombre="Publico General" data-id="-1" onclick="toggleSelection(this);">
                <div class="card-header" style="background-color: rgb(215, 160, 0); color: white;">Publico general</div>
                <div class="card-body">
                    <h5 class="card-title m-0">Venta sin cliente</h5>
                    <p class="card-text m-0">Correo: NA</p>
                    <p class="card-text m-0">Teléfono: NA</p>
                    <p class="card-text m-0">Fecha: NA</p>
                </div>
            </div>
        </div>

        </div>';

        $response['title'] = '¡Lista de clientes!';
        $response['success'] = true;
        $response['message'] = 'Esta es la lista de todos los clientes';
        $response['type'] = 'success';
        $response['HTML'] = $html;
    }
    else{
        $response['title'] = '¡Algo salió mal!';
        $response['success'] = false;
        $response['message'] = 'Ocurrió un error al cargar los clientes';
        $response['type'] = 'error';
    }

    mysqli_close($conexion);
    echo json_encode($response);

?>