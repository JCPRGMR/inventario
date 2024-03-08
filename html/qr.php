<?php
require '../request/botones.php';

ob_start();
?>
<style>
    table {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
        text-align: center;
    }

    .codigo {
        text-align: center;
    }

    td {
        max-width: 110px;
        max-height: 110px;
    }

    img {
        max-width: 110px;
        max-height: 110px;
    }
</style>
<table border="1">
    <?php
    $activos = Activos::pdfQR($_POST['from'], $_POST['to']);

    for ($i = 0; $i < count($activos); $i += 6) {
        echo '<tr>';
        for ($j = $i; $j < $i + 6 && $j < count($activos); $j++) {
            $row = $activos[$j]; // Obtener los datos de $data en lugar de $activos
            echo '<td>';
            echo '<img src="http://' . $_SERVER['HTTP_HOST'] . '/inventario_v0.0.1/img/img_qr/' . $row->qr . '">';
            echo '<div class="codigo">RTP - ' . sprintf("%02d", $row->codigo_ubicacion_gral_new) . '_'. sprintf("%02d", $row->codigo_ubicacion_esp) .'_' . sprintf("%02d", $row->codigo_rubro_new) . '_' . sprintf("%03d", $row->correlativo_nuevo) .'</div>';
            echo '</td>';
        }
        echo '</tr>';
    }
    ?>
</table>

<?php

$html = ob_get_clean();

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));

$dompdf->load_html($html);

$dompdf->setPaper('letter');

$dompdf->render();

$dompdf->stream("Lotes del ". $_POST['from'] . " al " . $_POST['to'], array("Attachment" => false));
