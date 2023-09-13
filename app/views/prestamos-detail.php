<?php
use Back\Controllers\Prestamos;

$prestamo_id = $security->aideDecrypt($view_data['id']);
$token = $security->generateClientToken($_SESSION['token'], pathinfo(__FILE__, PATHINFO_FILENAME));

$prestamos = new Prestamos;
$prestamo_details = $prestamos->getPrestamoDetail($prestamo_id);

// var_dump($prestamo_details);

?>
        <h1 class="page-title">Detalle Pr&eacute;stamo</h1>
        <div class="details-band">
            <div class="details-band__element" id="detail-cod">
                <p class="details-band__label">C&oacute;digo</p>
                <p class="details-band__info"><?php echo $prestamo_details['cod']; ?></p>
            </div>
            <div class="details-band__element" id="detail-cliente">
                <p class="details-band__label">Cliente</p>
                <p class="details-band__info"><?php echo $prestamo_details['cliente']; ?></p>
            </div>
            <div class="details-band__element" id="detail-monto">
                <p class="details-band__label">Monto</p>
                <p class="details-band__info"><?php echo $prestamo_details['monto']; ?></p>
            </div>
            <div class="details-band__element" id="detail-fecha-entrega">
                <p class="details-band__label">Entrega</p>
                <p class="details-band__info"><?php echo $prestamo_details['fecha_entrega']; ?></p>
            </div>
            <div class="details-band__element" id="detail-modalidad">
                <p class="details-band__label">Modalidad</p>
                <p class="details-band__info"><?php echo $prestamo_details['modalidad']; ?></p>
            </div>
            <div class="details-band__element" id="detail-periodicidad">
                <p class="details-band__label">Periodicidad</p>
                <p class="details-band__info"><?php echo $prestamo_details['periodicidad']; ?></p>
            </div>
            <div class="details-band__element" id="detail-tasa">
                <p class="details-band__label">Tasa</p>
                <p class="details-band__info"><?php echo $prestamo_details['tasa']; ?></p>
            </div>
        </div>
