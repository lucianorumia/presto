<?php
use Back\Controllers\Clientes;
use Back\Controllers\Prestamos;

$clientes = new Clientes;
$prestamos = new Prestamos;

$token = $security->generateClientToken($_SESSION['token'], pathinfo(__FILE__, PATHINFO_FILENAME));

?>
<h1 class="page-title">Alta pr&eacute;stamo</h1>
<div class="multi-x">
    <div class="multi-x__slide">
        <div class="def-form__frame">
            <div class="def-form__frame-top"></div>
            <div class="def-form__container">
                <form id="new-prestamo-form" class="def-form">
                    <div class="def-form__field">
                        <label class="def-form__label" for="cliente-inp">Cliente</label>
                        <input class="def-form__input" id="cliente-inp" list="clientes-lst" autocomplete="off">
                        <datalist id="clientes-lst">
<?php
$clientes_list = $clientes->getClientes();

foreach ($clientes_list as $cliente) {
    $key = $security->aideEncrypt($cliente['id']);
    echo <<<HTML
                            <option value="{$cliente['denominacion']}" data-key="{$key}"></option>
HTML . PHP_EOL;
    }
?>
                        </datalist>
                    </div>
                    <div class="def-form__field">
                        <label class="def-form__label" for="monto-inp">Monto</label>
                        <input class="def-form__input" id="monto-inp" type="number" min="0" step="1000">
                    </div>
                    <div class="def-form__field">
                        <label class="def-form__label" for="modalidad-inp">Modalidad</label>
                        <select class="def-form__input" id="modalidad-inp">
<?php
$modalidades_list = $prestamos->getModalidades();

foreach ($modalidades_list as $modalidad) {
    $disabled_attr = ($modalidad['id'] != 1) ? ' disabled' : '';
    echo <<<HTML
                            <option value="{$modalidad['id']}"{$disabled_attr}>{$modalidad['modalidad']}</option>
HTML . PHP_EOL;
    }
?>
                        </select>
                    </div>
                    <div class="def-form__field">
                        <label class="def-form__label" for="cuotas-inp">Cuotas</label>
                        <input class="def-form__input" id="cuotas-inp" type="number" autocomplete="off" min="1" step="1" value="5">
                    </div>
                    <div class="def-form__field">
                        <label class="def-form__label" for="periodicidad-inp">Periodicidad</label>
                        <select class="def-form__input" id="periodicidad-inp">
<?php
$periodicidades_list = $prestamos->getPeriodicidades();

foreach ($periodicidades_list as $periodicidad) {
    $selected_attr = ($periodicidad['id'] === 2) ? ' selected' : '';
    echo <<<HTML
                            <option value="{$periodicidad['id']}"{$selected_attr}>{$periodicidad['periodicidad']}</option>
HTML . PHP_EOL;
    }
?>
                        </select>
                    </div>
                    <div class="def-form__field">
                        <label class="def-form__label" for="tasa-inp">Tasa (%)</label>
                        <input class="def-form__input" id="tasa-inp" type="number" min="0" autocomplete="off">
                    </div>
                    <div class="def-form__field">
                        <label class="def-form__label" for="fecha-entrega-inp">Entrega</label>
                        <input class="def-form__input" id="fecha-entrega-inp" type="date" value="<?php
                            $today = new DateTime();
                            echo $today->format('Y-m-d');
                        ?>">
                    </div>
                    <input type="hidden" id="token" value="<?php echo $token; ?>">
                </form>
            </div>
            <div class="def-form__frame-bottom"></div>
        </div>
        <div class="action-bar">
            <button class="action-bar__button" id="back-btn">Volver</button>
            <button class="action-bar__button" id="reset-btn">Limpiar</button>
            <button class="action-bar__button" id="simulate-btn">Simular</button>
            <div class="action-bar__circle"></div>
        </div>
    </div>
    <div class="multi-x__slide">
        <div class="def-table__container">
            <table class="def-table" id="sim-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Cuota</th>
                        <th>Fecha</th>
                        <th>Capital</th>
                        <th>Inter&eacute;s</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="sim-totals">
                <p>Duraci&oacute;n<span id="sim-duracion"></span></p>
                <p>Capital<span id="sim-capital"></span></p>
                <p>Intereses<span id="sim-interes"></span></p>
                <p>CFT<span id="sim-cft"></span></p>
            </div>
        </div>
        <div class="action-bar">
            <button class="action-bar__button" id="edit-btn">Modificar</button>
            <button class="action-bar__button" id="confirm-btn">Confirmar</button>
            <div class="action-bar__circle"></div>
        </div>
    </div>
</div>