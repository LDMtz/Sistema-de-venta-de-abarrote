<script>
    function eliminaProveedor(IdProveedor){
        $.ajax({
            data: { txtID: IdProveedor },
            url: 'EliminarProveedor.php',
            type: 'POST',
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                var urlActual = window.location.href;
                if(urlActual.indexOf('/ConsultarProveedor.php') !== -1){ //Se elimino desde la seccion de consultas
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    consultaPorDato($('#tipo_dato').val(),$('#dato').val());
                }
                else{
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    $("#BodyTabla").load("ListarProveedores.php"); //Se elimino desde el index
                }
            }
        });
    }

    function modificaProveedor(IdProveedor){
        $.ajax({
            data: { txtID: IdProveedor },
            type: 'GET',
            success: function(response) {
                document.location.href='ModificarProveedor.php?txtID='+IdProveedor;
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