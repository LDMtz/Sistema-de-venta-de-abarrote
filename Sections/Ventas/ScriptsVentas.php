<script>
    function toggleSelection(card) {
        // Obtener todas las tarjetas con la clase card-as-button
        var cards = document.querySelectorAll('.card-as-button');

        // Deseleccionar todas las tarjetas
        cards.forEach(function (card) {
            card.classList.remove('selected');
    });

    // Seleccionar la tarjeta clicada
    card.classList.add('selected');
  }

    function mostrarModalClientes(){
        $.ajax({
    // Opciones de la petición AJAX
            url: "CargarClientesModal.php",
            method: "POST",
            data: {},
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                var jsonHTML = jsonResponse.HTML;

                //console.log(typeof(jsonHTML));
                if (jsonResponse.success) {
                    swal({
                        title: "Lista de clientes",
                        text: "Selecciona el cliente ...",
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: jsonHTML
                            }
                        },
                        button: false, // No mostrar botón de cierre
                        closeOnClickOutside: false, // Evitar que la modal se cierre al hacer clic fuera
                        closeOnEsc: false, // Evitar que la modal se cierre al presionar la tecla Esc
                        className: "custom-modal-clientes",
                    });

                    var cards = document.querySelectorAll('.card-as-button');
                        cards.forEach(function (card) {
                            card.addEventListener('click', function () {
                                // Obtener el nombre del cliente desde el atributo data-nombre
                                var nombreCliente = card.getAttribute('data-nombre');
                                var idCliente = card.getAttribute('data-id');
                                // Asignar el valor al inputCliente
                                document.getElementById('inputCliente').value = nombreCliente;
                                document.getElementById('inputIDClienteHidden').value = idCliente;
                                // Cerrar la modal
                                swal.close();
                            });
                        });
                        
                    } else {
                        // Hubo algun error
                        swal(jsonResponse.title, jsonResponse.message, jsonResponse.type);
                    }
            },
            error: function(error) {
                swal('¡Error!', error, 'error'); // Maneja los errores del ajax
            }
        });

    }

    function mostrarModalProductos(){
        var selectBuscarPor = document.getElementById('selectBuscarPor').value;
        var datoBusquedaProducto = document.getElementById('datoBusquedaProducto').value;
        
        $.ajax({
            url: "CargarProductosModal.php",
            method: "POST",
            data: {selectBuscarPor:selectBuscarPor, datoBusquedaProducto:datoBusquedaProducto },
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                var jsonHTML = jsonResponse.HTML;

                //console.log(typeof(jsonHTML));
                if (jsonResponse.success) {
                    if(jsonResponse.found){
                        swal({
                        title: "Productos encotrados",
                        text: "Selecciona el producto ...",
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML: jsonHTML
                            }
                        },
                        button: false, // No mostrar botón de cierre
                        className: "custom-modal-clientes",
                        });

                        var cards = document.querySelectorAll('.card-as-button');
                        cards.forEach(function (card) {
                            card.addEventListener('click', function () {
                                // Obtener el nombre del producto desde el atributo data-nombre
                                var idProd = card.getAttribute('data-id');
                                var fotoProd = card.getAttribute('data-foto');
                                var nombreProd = card.getAttribute('data-nombre');
                                var precioventaProd = card.getAttribute('data-precioventa');
                                var descuentoProd = card.getAttribute('data-descuento');
                                var existenciasProd = card.getAttribute('data-existencias');

                                document.getElementById('inputPSId').value = idProd;
                                document.getElementById('inputPSFoto').src = "../Productos/Fotos/" + fotoProd;
                                document.getElementById('inputPSNombre').value = nombreProd;
                                document.getElementById('inputPSPrecioVenta').value = precioventaProd;
                                document.getElementById('inputPSDescuento').value = descuentoProd;
                                document.getElementById('inputPSExistencias').value = existenciasProd;

                                var divDatosProdSelec = document.getElementById("dataProductoSeleccionado");
                                divDatosProdSelec.removeAttribute("hidden");

                                // Cerrar la modal
                                swal.close();
                            });
                        });
                    }else{
                        swal(jsonResponse.title, jsonResponse.message, jsonResponse.type);
                    }
                    
                        
                    } else {
                        // Hubo algun error
                        swal(jsonResponse.title, jsonResponse.message, jsonResponse.type);
                    }
            },
            error: function(error) {
                swal('¡Error!', error, 'error'); // Maneja los errores del ajax
            }
        });
    }

    function agregarAlCarrito(){
        //Validaciones
        var IdProd = document.getElementById('inputPSId').value;
        var cantidadValue = document.getElementById('inputPSCantidad');

        var cantidad = parseInt(document.getElementById('inputPSCantidad').value, 10);
        var existencias = parseInt(document.getElementById('inputPSExistencias').value, 10);
        if(cantidadValue.value == ''){
            swal('No ingresaste una cantidad', 'Debes ingresar la cantidad de productos a agregar al carrito', 'error');
            return;
        }
        if(cantidad <= 0){
            swal('Cantidad de productos invalida', `Debes ingresar una cantidad mayor a 0`, 'error');
            return;
        }
        if(cantidad > existencias){
            swal('Demasiados productos', `No hay disponibles suficientes productos, no es posible agregar ${cantidad} productos al carrito por que solo hay ${existencias} disponibles`, 'error');
            return;
        }

        $.ajax({
            data: { IdProducto: IdProd,Cantidad: cantidad, Existencias: existencias},
            url: 'AgregarAlCarrito.php',
            type: 'POST',
            success: function(response) {
                var jsonResponse = JSON.parse(response);

                if (jsonResponse.success){
                    swal(jsonResponse.title, jsonResponse.message, jsonResponse.type).then((value) => {
                        // Esta parte se ejecutará después de que el usuario interactúe con el swal
                        location.reload();
                    });
                }else{
                    swal(jsonResponse.title,jsonResponse.message,jsonResponse.type);
                }

            }
        });

        //Esto es ya que se realizo todo el proceso de agregado y paso todas las validaciones
        var divDatosProdSelec = document.getElementById("dataProductoSeleccionado");
        divDatosProdSelec.setAttribute("hidden", true);
        cantidadValue.value = '';
        document.getElementById("datoBusquedaProducto").value='';
    }
    
    function vaciarCarrito() {
    // Realiza una solicitud AJAX para vaciar el carrito en el lado del servidor
    $.ajax({
        url: 'VaciarCarrito.php',
        method: 'POST',
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    }

    function eliminarDelCarrito(Id){
        $.ajax({
            data: { Id: Id },
            url: 'EliminarDelCarrito.php',
            type: 'POST',
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                swal(jsonResponse.title, jsonResponse.message, jsonResponse.type).then((value) => {
                    location.reload();
                });
            }
        });
    }

    function calculaCambio(PagaCon){
        if(PagaCon == ''){
            document.getElementById("inputCambio").value='';
            swal('Cantidad a pagar incorrecta','Debes ingresar una cantidad a pagar','error');
            document.getElementById("btnTerminarVenta").setAttribute("disabled", "disabled");
            return;
        }
        var cantPagaCon = parseFloat(PagaCon);
        var total = parseFloat(document.getElementById("totalPagar").value.replace('$', ''));

        if(total <= 0){
            document.getElementById("btnTerminarVenta").setAttribute("disabled", "disabled");
            return;
        }
        if(cantPagaCon < total){
            swal('Cantidad a pagar incorrecta','El pago no puede ser menor al total a pagar, porfavor ingresa una cantidad igual o mayor al total.','error');
            document.getElementById("btnTerminarVenta").setAttribute("disabled", "disabled");
        }else{
            var cambio = (cantPagaCon - total).toFixed(2);
            document.getElementById("btnTerminarVenta").removeAttribute("disabled");
            document.getElementById("inputCambio").value=cambio;
        }


    }

    function validarVenta(){
        var InputIdEmp = document.getElementById('inputEmpleado');

        // Obtener los componentes del folio
        var fechaActual = new Date();
        var año = fechaActual.getFullYear();
        var mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0'); // Los meses van de 0 a 11
        var dia = fechaActual.getDate().toString().padStart(2, '0');
        var horas = fechaActual.getHours().toString().padStart(2, '0');
        var minutos = fechaActual.getMinutes().toString().padStart(2, '0');
        var segundos = fechaActual.getSeconds().toString().padStart(2, '0');

        //Datos de la venta
        var TipoDoc = document.getElementById("selectTipoDoc").value;
        var Folio = año + mes + dia + horas + minutos + segundos;
        var IdEmpleado = InputIdEmp.getAttribute('data-id-empleado');
        var IdCaja = document.getElementById("inputIdCaja").value;
        var IdCliente = document.getElementById("inputIDClienteHidden").value;
        var MontoPago = document.getElementById("inputPagaCon").value;

        //1ra validacion
        if(IdCaja.trim() === 'No hay caja activa'||IdCaja.trim() === '-1'){
            swal('No hay una caja activa','Para poder realizar la venta es necesario que una caja se encuentre activa, puedes ir al apartado de caja y abrir una','error');
            return;
        }
        if (IdCliente.trim() === '-1' && TipoDoc.trim() === 'Factura') {
            swal('Error con el cliente', 'Para poder generar una factura necesitas ingresar un cliente', 'error');
            return;
        }

        
        $.ajax({
            data: { TipoDoc: TipoDoc,Folio:Folio,IdEmpleado:IdEmpleado,IdCaja:IdCaja,IdCliente:IdCliente,MontoPago:MontoPago},
            url: 'RegistrarVenta.php',
            type: 'POST',
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    var buttonsToShow = {
                        cancel: "Cerrar"
                    };
            
                    if (TipoDoc === 'Ticket') {
                        buttonsToShow.imprimirTicket = {
                            text: "Imprimir Ticket",
                            value: "imprimirTicket",
                        };
                    } else if (TipoDoc === 'Factura') {
                        buttonsToShow.imprimirFactura = {
                            text: "Imprimir Factura",
                            value: "imprimirFactura",
                        };
                    }

                    swal({
                        title: jsonResponse.title,
                        text: jsonResponse.message,
                        icon: jsonResponse.type,
                        buttons: buttonsToShow,
                    }).then((value) => {
                        switch (value) {
                            case "imprimirTicket":
                                // Lógica para imprimir el ticket
                                generarTicketPDF(Folio);
                                vaciarCarrito();
                                break;

                            case "imprimirFactura":
                                generarFacturaPDF(Folio);
                                vaciarCarrito();
                                break;

                            default:
                                vaciarCarrito();
                        }
                    });
                } 

            }
        });

        var total = parseFloat(document.getElementById("totalPagar").value.replace('$', ''));
        $.ajax({
            data: { IdCaja: IdCaja,Total: total, TipoMov: 3,IdEmpleado:IdEmpleado},
            url: 'ActualizarCaja.php',
            type: 'POST',
            success: function(response) {
                console.log(response);
            }
        });

    }

    function generarTicketPDF(Folio){
        // Redirige a TicketPDF.php y pasa el parámetro Folio en la URL
        window.open('TicketPDF.php?Folio=' + encodeURIComponent(Folio), '_blank');
    }

    function generarFacturaPDF(Folio) {
        // Redirige a FacturaPDF.php y pasa el parámetro Folio en la URL
        window.open('FacturaPDF.php?Folio=' + encodeURIComponent(Folio), '_blank');
    }

</script>