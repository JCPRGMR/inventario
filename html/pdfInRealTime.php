<?php include 'templates/header.php' ?>
<?php
require '../request/botones.php';

ob_start();
// var_dump($_POST);
// $sql = "SELECT * FROM vista_activos WHERE id_activos >= ? AND id_activos <= ?";
// $stmt = Activos::Abrir()->prepare($sql);
// $stmt->bindParam(1, $_POST['from'], PDO::PARAM_INT);
// $stmt->bindParam(2, $_POST['to'], PDO::PARAM_INT);
// $stmt->execute()->fetchAll(PDO::FETCH_OBJ);
// ?>
<style>
    table{
        border-collapse: collapse;
        font-size: 10px;
        font-family: Arial, Helvetica, sans-serif;
    }
    td{
        text-align: center;
    }
</style>
<table border="1">
    <thead>
        <tr>
            <th colspan="3">CODIGO ANTIGUO</th>
            <th colspan="4">CODIGO NUEVO</th>
        </tr>
        <tr>
            <th>Ubicaion general</th>
            <th>Rubro</th>
            <th>Correlativo</th>

            <th>Ubicacion general</th>
            <th>Ubicacion especifica</th>
            <th>Rubro</th>
            <th>Correlativo</th>

            <th>Activos</th>
            <th>Detalles</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Serie</th>
            <th>Pais</th>
            <th>Año</th>

            <!-- <th>Empresa Factura</th>
            <th>Nro Factura</th> -->
            <th>Estado</th>
            <th>Valor inicial</th>
            <th>Al 2021</th>
            <th>Valor recidual</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach (Activos::VerPDF($_POST['from'], $_POST['to']) as $row) : ?>
            <tr>
                <td><?= $row->codigo_ubicacion_gral_old ?></td>
                <td><?= $row->codigo_rubro_old ?></td>
                <td><?= $row->correlativo_antiguo ?></td>

                <td><?= $row->codigo_ubicacion_gral_new ?></td>
                <td><?= $row->codigo_ubicacion_esp ?></td>
                <td><?= $row->codigo_rubro_new ?></td>
                <td><?= sprintf("%04d",  $row->correlativo_nuevo) ?></td>

                <td><?= $row->des_tipo ?></td>
                <td><?= $row->detalles ?></td>
                <td><?= $row->des_marca ?></td>
                <td><?= $row->modelo ?></td>
                <td><?= $row->serie ?></td>
                <td><?= $row->des_pais ?></td>
                <td><?= $row->año_compra ?></td>

                <!-- <td><?php // $row->empresa_factura ?></td>
                <td><?php // $row->nro_factura ?></td> -->
                <td><?= $row->codigo_estado ?></td>
                <td><?= $row->valor_inicial ?></td>
                <td><?= $row->al_2021 ?></td>
                <td><?= $row->valor_recidual ?></td>
                <!-- <td> -->
                    <!-- <img src="../img_qr/codigo_qr.svg" alt=""> -->
                <!-- </td> -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$html = ob_get_clean();
use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));

$dompdf->load_html($html);

$dompdf->setPaper('letter', 'landscape');

$dompdf->render();

$dompdf->stream("qr.pdf", array("Attachment" => false));