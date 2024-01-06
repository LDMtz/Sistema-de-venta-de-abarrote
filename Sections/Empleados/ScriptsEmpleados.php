<script>
    function eliminaEmpleado(IdEmpleado){
        $.ajax({
            data: { txtID: IdEmpleado },
            url: 'EliminarEmpleado.php',
            type: 'POST',
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                var urlActual = window.location.href;
                if(urlActual.indexOf('/ConsultarEmpleado.php') !== -1){ //Se elimino desde la seccion de consultas
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    consultaPorDato($('#tipo_dato').val(),$('#dato').val());
                }
                else{
                    swal(jsonResponse.title, jsonResponse.message, 'success');
                    $("#BodyTabla").load("ListarEmpleados.php"); //Se elimino desde el index
                }
            }
        });
    }

    function modificaEmpleado(IdEmpleado){
        $.ajax({
            data: { txtID: IdEmpleado },
            //url: 'ActualizaEmpleado.php',
            type: 'GET',
            success: function(response) {
                //$("#ContModEmp").load("ModificarEmpleados.php?txtID="+IdEmpleado);
                document.location.href='ModificarEmpleado.php?txtID='+IdEmpleado;
            }
        });
    }

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
</script>