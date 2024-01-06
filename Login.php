    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Punto de Venta Abarrote - Equipo 6</title>
        <link rel="stylesheet" href="Css/LoginStyles.css">
        <script type="text/javascript" src="Libs/jquery.js"></script>
        <script type="text/javascript" src="Libs/sweetalert.min.js"></script>
        <link rel="icon" type="image/png" href="Resources/Images/logo.png"; ?>
    </head>
    <body>
        <div class="card-login">
            <h1 class="titleH1">Inicio de Sesión</h1>
            <img src="Resources/Images/LogoLion.png" alt="" class="logoImg">
            <div class="input-group">
                <div class="input-container">
                    <input type="text" id="Id" name="Id" placeholder="Id de empleado" autocomplete="off">
                    <img src="Resources/Icons/user.png" class="rscIcon"></img>
                </div>
            </div>
            <div class="input-group">
                <div class="input-container">
                    <input type="password" id="password" name="password" placeholder="Contraseña" autocomplete="off">
                    <img src="Resources/Icons/password.png" class="rscIcon"></img>
                </div>
            </div>
            <input name="send" type="submit" class="btn" value="Iniciar Sesion" onclick="validarEmpleado();">
        </div>

    </body>
    </html>

    <script>
        function validarEmpleado(){
            var Id = document.getElementById("Id").value;
            var password = document.getElementById("password").value;
            $.ajax({
                data: {Id:Id ,password:password},
                url: 'validaLogin.php',
                type: 'POST',
                success: function(response){
                    var jsonResponse = JSON.parse(response);
                    
                    if(jsonResponse.success){
                        document.location.href='index.php';
                    }
                    else{
                        swal(jsonResponse.title, jsonResponse.message, jsonResponse.type);
                    }

                }
            });
        }
    </script>