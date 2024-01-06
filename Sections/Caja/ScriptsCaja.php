<script>

    function validarCaja(){
        $.ajax({
            data: {datoVacio : null},
            url: 'ValidaCaja.php',
            type: 'POST',
            success: function(response) {
                //console.log(response);
                var jsonResponse = JSON.parse(response);
                var jsonHTML = jsonResponse.html;
                    if (jsonResponse.success) {
                        $("#datosCaja").html(jsonHTML);
                        
                    } else {
                        // Hubo algun error
                        swal(jsonResponse.title, jsonResponse.message, jsonResponse.type);
                        $("#datosCaja").html(jsonHTML);
                    }
            },
            error: function(error) {
                swal('¡Error!', error, 'error'); // Maneja los errores del ajax
            }
        });
    }

    function abrirCajaInputs(NombreEmpleado){
        swal({
            title: "ABRIR CAJA",
            content: {
            element: "div",
            attributes: {
                innerHTML: `
                    <label for="" class="mt-3 text-dark d-flex justify-content-start">Usuario que abre:</label>
                    <input id="" class="form-control border border-secondary" value="${NombreEmpleado}" type="text" disabled readonly>
                    <hr>
                    <div class="d-flex justify-content-start">
                        <label for="" class="mt-3 text-dark d-flex justify-content-start">Monto de apertura:</label>
                        <input id="montoApertura" class="form-control border border-info" placeholder="$" type="number" step="0.01">
                    </div>  
                `,
                },
            },
            buttons: {
                abrirCaja: {
                    text: "Abrir Caja",
                    value: "abrirCaja", // Puedes utilizar este valor en el evento then para identificar el botón presionado
                    closeModal: true, // Cierra automáticamente el modal al hacer clic en el botón
                    className: 'btn btn-success',  
                },
            },
        })
        .then((value) => {
            if (value === "abrirCaja") {
                const montoApertura = document.getElementById('montoApertura').value;
                console.log(montoApertura);
                $.ajax({
                    data: {monto_apertura: montoApertura},
                    url: 'AbrirCaja.php',
                    type: 'POST',
                    success: function(response) {
                        var jsonResponse = JSON.parse(response);
                        swal(jsonResponse.title, jsonResponse.message, jsonResponse.type);
                        setTimeout(function(){
                            location.reload();
                        }, 1200);
                    },
                    error: function(error) {
                        swal('¡Error!', error, 'error'); // Maneja los errores del ajax
                    }
                });
            }
        });
    }

    function cerrarCaja(){
        var inputIdCajaValue = document.getElementById("InputIdCaja").value;
        var inputMontoActualValue = document.getElementById("montoActual").value;
        $.ajax({
            data: {IdCaja: inputIdCajaValue, MontoActual:inputMontoActualValue},
            url: 'CerrarCaja.php',
            type: 'POST',
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    swal(jsonResponse.title, jsonResponse.message, jsonResponse.type);
                    setTimeout(function(){
                        const modalContent = `
                        <div class="row mb-2">
                            <label for="IdCaja" class="col-sm-5 col-form-label text-dark">ID de Caja:</label>
                            <div class="col-sm-7">
                                <input id="IdCaja" class="form-control form-control-sm border border-success" value="${jsonResponse.IdCaja}" type="text" disabled readonly>
                            </div>
                        </div>

                        <hr>
                        <h6>Detalles de apertura</h6>

                        <div class="row mb-2">
                            <label for="NombreEmpApertura" class="col-sm-5 col-form-label text-dark">Empleado apertura:</label>
                            <div class="col-sm-7">
                                <input id="NombreEmpApertura" class="form-control form-control-sm border border-success" value="${jsonResponse.NombreEmpApertura}" type="text" disabled readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="FechaApertura" class="col-sm-5 col-form-label text-dark">Fecha de Apertura:</label>
                            <div class="col-sm-7">
                                <input id="FechaApertura" class="form-control form-control-sm border border-success" value="${jsonResponse.FechaApertura}" type="text" disabled readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="HoraApertura" class="col-sm-5 col-form-label text-dark">Hora de Apertura:</label>
                            <div class="col-sm-7">
                                <input id="HoraApertura" class="form-control form-control-sm border border-success" value="${jsonResponse.HoraApertura}" type="text" disabled readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="MontoApertura" class="col-sm-5 col-form-label text-dark">Monto de Apertura:</label>
                            <div class="col-sm-7">
                                <input id="MontoApertura" class="form-control form-control-sm border border-success" value="$${jsonResponse.MontoApertura}" type="text" disabled readonly>
                            </div>
                        </div>
                        
                        <hr>
                        <h6>Detalles del cierre</h6>
                        <div class="row mb-2">
                            <label for="NombreEmpCierre" class="col-sm-5 col-form-label text-dark">Empleado cierre:</label>
                            <div class="col-sm-7">
                                <input id="NombreEmpCierre" class="form-control form-control-sm border border-success" value="${jsonResponse.NombreEmpCierre}" type="text" disabled readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="FechaCierre" class="col-sm-5 col-form-label text-dark">Fecha de Cierre:</label>
                            <div class="col-sm-7">
                                <input id="FechaCierre" class="form-control form-control-sm border border-success" value="${jsonResponse.FechaCierre}" type="text" disabled readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="HoraCierre" class="col-sm-5 col-form-label text-dark">Hora de Cierre:</label>
                            <div class="col-sm-7">
                                <input id="HoraCierre" class="form-control form-control-sm border border-success" value="${jsonResponse.HoraCierre}" type="text" disabled readonly>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="MontoCierre" class="col-sm-5 col-form-label text-dark">Monto de Cierre:</label>
                            <div class="col-sm-7">
                                <input id="MontoCierre" class="form-control form-control-sm border border-success" value="$${jsonResponse.MontoCierre}" type="text" disabled readonly>
                            </div>
                        </div>
                    `;
                                swal({
                                title: "Detalles de la caja",
                                content: {
                                    element: "div",
                                    attributes: {
                                        innerHTML: modalContent
                                    }
                                },
                                buttons: {
                                    cerrar: {
                                        text: "Ok",
                                        value: "eventOk",
                                        closeModal: true,
                                        className: 'btn btn-success'
                                    }
                                }
                            }).then((value) => {
                                if (value === "eventOk") {
                                    location.reload();
                                }
                            });
                        }, 1100);


                }else{
                    swal(jsonResponse.title, jsonResponse.message, jsonResponse.type);
                }
            },
            error: function(error) {
                swal('¡Error!', error, 'error'); // Maneja los errores del ajax
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const radioButtons = document.querySelectorAll('input[name="radioGroup"]');

        radioButtons.forEach(function (radioButton) {
            radioButton.addEventListener('change', function () {
                // Obtén el ID del radio button seleccionado
                const selectedId = this.id;

                // Ejecuta la función correspondiente al radio button seleccionado
                switch (selectedId) {
                    case 'radioMovimientos':
                        // Llama a la función para Movimientos de la caja actual
                        realizarMovimientos();
                        break;
                    case 'radioHistorial':
                        // Llama a la función para Historial de cajas
                        mostrarHistorial();
                        break;
                    // Agrega más casos según sea necesario
                }
            });
        });

        // Funciones a ejecutar según el radio button seleccionado
        function realizarMovimientos() {
            $("#tablaCaja").load("ListarMovCajaActual.php");
        }

        function mostrarHistorial() {
            $("#tablaCaja").load("ListarHistorialCajas.php");
        }
    });
</script>

