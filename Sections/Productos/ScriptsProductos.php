<script>

    function consultaPorDato(tipoDato,Dato){
        if(tipoDato === "Estado"){
            switch (Dato) {
                case "Activo":
                    Dato = 1;
                    break;
                case "Inactivo":
                    Dato = 0;
                    break;
                default:
                    Dato = -1;
                    break;
            }
        }
        $.ajax({
            data: { tipo_dato: tipoDato, dato:Dato },
            url: 'ListarConsulta.php',
            type: 'POST',
            success: function(response) {
                $("#BodyTabla").html(response);
            }
        });
    }

    function eliminaProducto(IdProducto){
        $.ajax({
            data: { txtID: IdProducto },
            url: 'EliminarProducto.php',
            type: 'POST',
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                var urlActual = window.location.href;
                if(urlActual.indexOf('/ConsultarProducto.php') !== -1){ //Se elimino desde la seccion de consultas
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    consultaPorDato($('#tipo_dato').val(),$('#dato').val());
                }
                else{
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    $("#BodyTabla").load("ListarProductos.php"); //Se elimino desde el index
                }
            }
        });
    }

    function modificaProducto(IdProducto){
        $.ajax({
            data: { txtID: IdProducto },
            type: 'GET',
            success: function(response) {
                document.location.href='ModificarProducto.php?txtID='+IdProducto;
            }
        });
    }

    function realizarDescuento(IdProducto,Descuento){
        //console.log(typeof IdProducto);
        //swal('BORRAR ESTE MENSAJE',IdProducto,'error');
        $.ajax({
            data: { txtID: IdProducto, txtDescuento: Descuento },
            url: 'RegistraDescuento.php',
            type: 'POST',
            success: function(response) {
                var jsonResponse = JSON.parse(response);

                if (jsonResponse.success) {
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    setTimeout(function(){
                        window.location.href = 'DescuentoProducto.php';
                    }, 1000);
                } else {
                    // Hubo algun error
                    swal(jsonResponse.title, jsonResponse.message, 'error');
                }
            },
            error: function(error){
                swal('¡Error!', error, 'error');
            }
        });
    }

    function terminarDescuento(IdDescuento){
        $.ajax({
            data: { txtID: IdDescuento },
            url: 'TerminarDescuento.php',
            type: 'POST',
            success: function(response) {
                //var urlActual = window.location.href;
                var jsonResponse = JSON.parse(response);

                if (jsonResponse.success) {
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    $("#BodyTabla").load("ListarDescuentos.php"); //Se elimino desde el index
                } else {
                    // Hubo algun error
                    swal(jsonResponse.title, jsonResponse.message, 'error');
                }
                    
            }
        });
    }

    function mostrarFormaDescuento(opcion){
        var inputPrecioNormal = document.getElementById("inputPrecioNormal");
        var inputPrecioDescuento = document.getElementById("inputPrecioDescuento");
        var inputCantidadADescontar = document.getElementById("inputCantidadADescontar");

        var inputCantidadDescuento = document.getElementById("inputCantidadDescuento");

        inputPrecioNormal.value="";
        inputPrecioDescuento.value="";
        inputCantidadADescontar.value="";

        var inputPorcentaje = document.getElementById("inputPorcentaje");
        var inputCantidad = document.getElementById("inputCantidad");
        
        

        switch(opcion.value){
            case "Ninguno":
                inputCantidadDescuento.setAttribute("hidden", true);
                inputPorcentaje.setAttribute("hidden",true);
                inputCantidad.setAttribute("hidden",true);
                break;
            case "Porcentaje":
                inputCantidadDescuento.removeAttribute("hidden");
                inputPorcentaje.removeAttribute("hidden");
                inputCantidad.setAttribute("hidden", true);
                break;
            case "Cantidad":
                inputCantidadDescuento.setAttribute("hidden", true);
                inputPorcentaje.setAttribute("hidden", true);
                inputCantidad.removeAttribute("hidden");
                break;
        }
    }

    function validaProducto() {
        var inputCodigoValue = document.getElementById("CodigoBarras").value;
        var cardDescuento = document.getElementById("bodyCardDescuento");

        $.ajax({
            data: { CodigoBarras: inputCodigoValue },
            url: 'ValidaProducto.php',
            type: 'POST',
            success: function(response) {
                //console.log(response); // Maneja la respuesta del servidor aquí (BORRARLO)

                var jsonResponse = JSON.parse(response);
                var jsonHTML = jsonResponse.HTML;

                //Si el json contiene algo
                if (jsonResponse && Object.keys(jsonResponse).length > 0){
                    if (jsonResponse.success) {
                        // Todo bien
                        swal(jsonResponse.title, jsonResponse.message, 'success');
                        $("#datosProducto").html(jsonHTML);
                        cardDescuento.removeAttribute("hidden");
                        
                    } else {
                        // Hubo algun error
                        swal(jsonResponse.title, jsonResponse.message, 'error');
                    }
                }
            },
            error: function(error) {
                swal('¡Error!', error, 'error'); // Maneja los errores del ajax
            }
        });
    }

    function calculaDescuento(formaDescuento, valorDescuento){
        var inputPrecioNormal = document.getElementById("inputPrecioNormal");
        var inputPrecioDescuento = document.getElementById("inputPrecioDescuento");
        var inputCantidadADescontar = document.getElementById("inputCantidadADescontar");

        var valorInputPrecioVenta = document.getElementById("inputPrecioVenta").value;
        valorInputPrecioVenta = valorInputPrecioVenta.replace('$', '');

        if(valorDescuento == ''){
            inputPrecioNormal.value="";
            inputPrecioDescuento.value="";
            inputCantidadADescontar.value="";

            swal('El campo debe tener algun valor', 'No ingresaste ningun valor a descontar', 'error');
            return;
        }

        var PrecioVenta = parseFloat(valorInputPrecioVenta);
        var Descuento = parseFloat(valorDescuento);

        switch(formaDescuento){
            case "Porcentaje":
                if(Descuento >= 100 || Descuento <= 0){
                    swal('Error en el porcentaje (%)', 'Solo se admiten valores de descuento del 1% al 99 %', 'error');
                    break;
                }

                var CantidadDescuento = (PrecioVenta*(Descuento/100));
                var PrecioConDescuento = PrecioVenta-CantidadDescuento;

                inputPrecioNormal.value = PrecioVenta;
                inputPrecioDescuento.value = PrecioConDescuento.toFixed(2);
                inputCantidadADescontar.value = CantidadDescuento.toFixed(2);
                
                break;
            case "Cantidad":
                if(Descuento >= PrecioVenta || Descuento <= 0){
                    swal('Error en la cantidad', 
                    'No es posible descontar un valor mayor o igual al precio de venta, tampoco se aceptan numeros negativos', 
                    'error');
                    break;
                }
                //calculando el descuento
                var PrecioConDescuento = PrecioVenta-Descuento;

                //Asignandole el valor correspondiente a los inputs
                inputPrecioNormal.value = PrecioVenta;
                inputPrecioDescuento.value = PrecioConDescuento.toFixed(2);
                inputCantidadADescontar.value = Descuento;
                break;
        }
    }

    function limpiarInputs(){
        window.location.href='EmpezarDescuento.php';
    }

    function buscarCodigo(){
        swal({
            title: "Introduce el código de barras",
            content: {
                element: "input",
                attributes: {
                placeholder: "Código de barras",
                type: "text",
                },
            },
            buttons: {
                buscar: true,
                cancel: "Cancelar",
            },
            }).then((value) => {
                if (value === "buscar" || (value && value.trim() !== "")) {
                    const codigoDeBarras = document.querySelector(".swal-content input").value;

                    validarCodigo(codigoDeBarras);
                }
        });
    }


    function validarCodigo(codigo){
        document.querySelector(".swal-content input").addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                const codigoDeBarras = document.querySelector(".swal-content input").value;

                validarCodigo(codigoDeBarras);

                // Cierra el modal después de presionar Enter
                swal.close();
            }
        });

        var cardDescuento = document.getElementById("bodyCardCodigo");
        $.ajax({
            data: { CodigoBarras: codigo },
            url: 'ValidaCodigo.php',
            type: 'POST',
            success: function(response) {

                var jsonResponse = JSON.parse(response);
                var jsonHTML = jsonResponse.HTML;

                //Si el json contiene algo
                if (jsonResponse && Object.keys(jsonResponse).length > 0){
                    if (jsonResponse.success) {
                        // Todo bien
                        swal(jsonResponse.title, jsonResponse.message, 'success');
                        $("#datosProducto").html(jsonHTML);
                        JsBarcode("#barcode", codigo);
                        cardDescuento.removeAttribute("hidden");
                        
                    } else {
                        // Hubo algun error
                        swal(jsonResponse.title, jsonResponse.message, 'error');
                    }
                }
            },
            error: function(error) {
                swal('¡Error!', error, 'error'); // Maneja los errores del ajax
            }
        });
    }



    function descargarCodigoimg(){
        var canvas = document.getElementById("barcode");
        var dataURL = canvas.toDataURL("image/png");

        // Crea un enlace temporal para descargar la imagen
        var link = document.createElement("a");
        link.href = dataURL;
        link.download = "codigo_barras.png";

        // Agrega el enlace al documento y simula un clic para descargar la imagen
        document.body.appendChild(link);
        link.click();

        // Limpia el enlace del documento
        document.body.removeChild(link);
    }

    function imprimirCodigoimg(){
        var canvas = document.getElementById('barcode');
        var ctx = canvas.getContext('2d');

        // Dibuja en el canvas (esto es solo un ejemplo)

        // Convierte el canvas en una imagen en formato de datos URL
        var dataURL = canvas.toDataURL();

        // Crea un elemento de imagen
        var img = document.createElement('img');
        img.src = dataURL;
        

        // Espera a que la imagen se cargue completamente antes de imprimir
        img.onload = function() {
            // Abre una nueva ventana e imprime la imagen
            var screenWidth = window.screen.width;
            var screenHeight = window.screen.height;
            var windowWidth = 700; // Ancho de la ventana emergente
            var windowHeight = 400; // Alto de la ventana emergente
            var left = (screenWidth - windowWidth) / 2;
            var top = (screenHeight - windowHeight) / 2;
            var printWindow = window.open('', '_blank', 'width=' + windowWidth + ',height=' + windowHeight + ',left=' + left + ',top=' + top);

            //var printWindow = window.open('', '', 'width=700,height=400');
            printWindow.document.write('<img src="' + dataURL + '" style="width:25%;">');
            printWindow.document.close();
            printWindow.print();
        };
    }

    function generarProductoPDF(){
        //window.location.href='ProductoPDF.php';
        var inputIdValue = document.getElementById("IdProducto").value;

        $.ajax({
            data: { Id: inputIdValue },
            url: 'ProductoPDF.php',
            type: 'POST',
            success: function(response) {
            },
            error: function(error) {
                swal('¡Error!', error, 'error'); // Maneja los errores del ajax
            }
        });
    }

    function updateIdProducto(){
    // Obtén el valor del input externo
        var inputIdProducto = document.getElementById('IdProducto').value;
        console.log(inputIdProducto);
        document.getElementById('IdProductoForm').value = inputIdProducto;
    };

</script>