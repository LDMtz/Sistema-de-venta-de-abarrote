<script>
    function eliminaCliente(IdCliente){
        $.ajax({
            data: { txtID: IdCliente },
            url: 'EliminarCliente.php',
            type: 'POST',
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                var urlActual = window.location.href;
                if(urlActual.indexOf('/ConsultarCliente.php') !== -1){ //Se elimino desde la seccion de consultas
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    consultaPorDato($('#tipo_dato').val(),$('#dato').val());
                }
                else{
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    $("#BodyTabla").load("ListarClientes.php"); //Se elimino desde el index
                }
            }
        });
    }

    function modificaCliente(IdCliente){
        $.ajax({
            data: { txtID: IdCliente },
            type: 'GET',
            success: function(response) {
                document.location.href='ModificarCliente.php?txtID='+IdCliente;
            }
        });
    }

    function consultaPorDato(tipoDato,Dato){
        $.ajax({
            data: { tipo_dato: tipoDato, dato:Dato },
            url: 'ListarConsulta.php',
            type: 'POST',
            success: function(response) {
                $("#BodyTabla").html(response);
            }
        });
    }
</script>