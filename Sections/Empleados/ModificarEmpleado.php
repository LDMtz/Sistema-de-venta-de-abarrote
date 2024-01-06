
<?php include("../../Templates/Header.php"); ?>
<?php include("ActualizaEmpleado.php"); ?>

<link rel="stylesheet" href="../../Libs/bootstrap.min.css"/>


<br>
<h1>MODIFICAR EMPLEADO</h1>
<br>

<div class="container d-flex justify-content-center align-items-center">

    <div class="card col-6">
        <div class="card-header">
            Datos del Empleado
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="Id" class="form-label fw-bold">ID (No se puede modificar):</label>
                    <input type="text" value="<?php echo $datosEmpleado['IdEmpleado']?>"
                        class="form-control" name="Id" id="Id" aria-describedby="helpId" placeholder="Id" readonly>
                </div>

                <div class="mb-3">
                    <label for="Nombre" class="form-label fw-bold">Nombre:</label>
                    <input type="text" value="<?php echo $datosEmpleado['Nombre']?>"
                        class="form-control" name="Nombre" id="Nombre" aria-describedby="helpId" placeholder="Nombre y Apellido" required>
                </div>

                <div class="mb-3">
                    <label for="Correo" class="form-label fw-bold">Correo:</label>
                    <input type="email" value="<?php echo $datosEmpleado['Correo']?>"
                        class="form-control" name="Correo" id="Correo" aria-describedby="helpId" placeholder="Correo">
                </div>

                <div class="mb-3">
                    <label for="Telefono" class="form-label fw-bold">Telefono:</label>
                    <input type="text" value="<?php echo $datosEmpleado['Telefono']?>"
                        class="form-control" name="Telefono" id="Telefono" aria-describedby="helpId" placeholder="Telefono">
                </div>

                <div class="mb-3">
                    <label for="Clave" class="form-label fw-bold">Contraseña:</label>
                    <input type="password" value="<?php echo $datosEmpleado['Clave']?>"
                        class="form-control" name="Clave" id="Clave" aria-describedby="helpId" placeholder="Contraseña" required>
                </div>

                <div class="mb-3">
                    <label for="ClaveOk" class="form-label fw-bold">Confirmar Contraseña:</label>
                    <input type="password" value="<?php echo $datosEmpleado['Clave']?>"
                        class="form-control" name="ClaveOk" id="ClaveOk" aria-describedby="helpId" placeholder="Contraseña" required>
                </div>
                
                <div class="mb-3">
                    <label for="Foto" class="form-label fw-bold">Foto Actual:</label>
                    <br>
                    <img width="100" 
                            src="<?php echo 'Fotos/'.$datosEmpleado['Foto']?>" 
                            class="rounded" 
                            alt="FotoEmpleado">
                    <?php echo $datosEmpleado['Foto']?>
                    <br><br>

                    <input type="file" value=""
                        class="form-control" name="Foto" id="Foto" aria-describedby="helpId" placeholder="Foto">
                </div>

                <div class="mb-3">
                    <label for="IdRol" class="form-label fw-bold">Rol:</label>
                    <select class="form-select form-select-sm" name="IdRol" id="IdRol">
                        <?php foreach ($listaRoles as $registroRoles){?>
                            <option <?php echo ($datosEmpleado['IdRol']==$registroRoles['IdRol'])?"selected":"" ?> value="<?php echo $registroRoles['IdRol']?>" > 
                                <?php echo $registroRoles['NombreRol']?>
                            </option>
                        <?php }?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="Estado" class="form-label fw-bold">Estado:</label>
                    <select class="form-select form-select-sm" name="Estado" id="Estado">
                        <option <?php echo ($datosEmpleado['Estado']==1)?"selected":"" ?> value="1" >Activo</option> // 1 = Activo
                        <option <?php echo ($datosEmpleado['Estado']==0)?"selected":"" ?> value="0">Inactivo</option> //0 = Inactivo
                    </select>
                </div>
                
                <div class="d-flex justify-content-center mb-1">
                    <button type="submit" class="btn btn-info me-5">Actualizar</button>
                    <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
                </div>
            </form>
        </div>

        <div class="card-footer text-muted"></div>

    </div>
    
</div>

<br>

<?php include("../../Templates/Footer.php"); ?>