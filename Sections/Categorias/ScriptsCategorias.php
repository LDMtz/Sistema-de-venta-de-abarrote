<script>
    function eliminaCategoria(IdCategoria){
        $.ajax({
            data: { txtID: IdCategoria },
            url: 'EliminarCategoria.php',
            type: 'POST',
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                var urlActual = window.location.href;
                if(urlActual.indexOf('/ConsultarCategoria.php') !== -1){ //Se elimino desde la seccion de consultas
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    consultaPorDato($('#tipo_dato').val(),$('#dato').val());
                }
                else{
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    $("#BodyTabla").load("ListarCategorias.php"); //Se elimino desde el index
                }
            }
        });
    }

    function modificaCategoria(IdCategoria){
        $.ajax({
            data: { txtID: IdCategoria },
            type: 'GET',
            success: function(response) {
                document.location.href='ModificarCategoria.php?txtID='+IdCategoria;
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