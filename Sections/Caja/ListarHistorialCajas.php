<?php
        include("../../Conexion.php");
        $listaCajas = [];

        $query = "SELECT
                    Caja.IdCaja, CASE WHEN Caja.Estado = 1 THEN 'Activo' ELSE 'Inactivo' END AS Estado,
                    Caja.MontoActual,
                    DATE_FORMAT(Caja.FechaHoraApertura, '%Y-%m-%d') AS FechaApertura,
                    DATE_FORMAT(Caja.FechaHoraApertura, '%H:%i') AS HoraApertura,
                    EmpApertura.Nombre AS NombreEmpleadoApertura,
                    Caja.MontoApertura,
                    CASE WHEN Caja.FechaHoraCierre IS NOT NULL THEN DATE_FORMAT(Caja.FechaHoraCierre, '%Y-%m-%d') ELSE 'En espera' END AS FechaCierre,
                    CASE WHEN Caja.FechaHoraCierre IS NOT NULL THEN DATE_FORMAT(Caja.FechaHoraCierre, '%H:%i') ELSE 'En espera' END AS HoraCierre,
                    COALESCE(EmpCierre.Nombre, 'En espera') AS NombreEmpleadoCierre,
                    COALESCE(Caja.MontoCierre, 'En espera') AS MontoCierre
                    FROM Caja
                    LEFT JOIN Empleados AS EmpApertura ON Caja.EmpleadoApertura = EmpApertura.IdEmpleado
                    LEFT JOIN Empleados AS EmpCierre ON Caja.EmpleadoCierre = EmpCierre.IdEmpleado";

        $resultado=mysqli_query($conexion,$query);

        if($resultado)
        while ($fila = mysqli_fetch_assoc($resultado))
            $listaCajas[] = $fila;

    mysqli_close($conexion);
    if (empty($listaCajas)) {
        echo "No se encontraron cajas.";
    } 

?>

<thead>
    <tr>
        <th scope="col" class="text-nowrap">Id Caja</th>
        <th scope="col" class="text-nowrap">Estado</th>
        <th scope="col" class="text-nowrap">Monto Actual</th>
        <th scope="col" class="text-nowrap">Fecha Apertura</th>
        <th scope="col" class="text-nowrap">Hora Apertura</th>
        <th scope="col" class="text-nowrap">Empleado Apertura</th>
        <th scope="col" class="text-nowrap">Monto Apertura</th>
        <th scope="col" class="text-nowrap">Fecha Cierre</th>
        <th scope="col" class="text-nowrap">Hora Cierre</th>
        <th scope="col" class="text-nowrap">Empleado Cierre</th>
        <th scope="col" class="text-nowrap">Monto Cierre</th>
    </tr>
</thead>
<tbody id="BodyTabla">
    <?php foreach ($listaCajas as $registro) {?>
        <tr class="">
            <td class="text-center"><?php echo $registro['IdCaja']?></td>
            <td class="text-center">
                <span class="badge <?php echo ($registro['Estado'] == 'Activo') ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo $registro['Estado']?>
                </span>
            </td>
            <td class="text-center"><?php echo '$' . $registro['MontoActual']?></td>
            <td class="text-center"><?php echo $registro['FechaApertura']?></td>
            <td class="text-center"><?php echo $registro['HoraApertura']?></td>
            <td class="text-center"><?php echo $registro['NombreEmpleadoApertura']?></td>
            <td class="text-center"><?php echo '$' . $registro['MontoApertura']?></td>
            <td class="text-center"><?php echo $registro['FechaCierre']?></td>
            <td class="text-center"><?php echo $registro['HoraCierre']?></td>
            <td class="text-center"><?php echo $registro['NombreEmpleadoCierre']?></td>
            <td class="text-center"><?php echo '$' . $registro['MontoCierre']?></td>
        </tr>
    <?php }?>
</tbody>





