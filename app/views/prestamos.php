<?php

use Back\Controllers\Clientes;

$clientes = new Clientes;
$token = $security->generateClientToken($_SESSION['token'], pathinfo(__FILE__, PATHINFO_FILENAME));

?>
        <h1 class="page-title">Pr&eacute;stamos</h1>
        <!-- filters -->
        <form class="filters" id="filters-form">
            <section class="filters__def">
                <div class="filters__field">
                    <label class="filters__label" for="cliente-inp">Cliente</label>
                    <input class="filters__control" id="cliente-inp" type="text"  list="clientes-lst" placeholder="Todos">
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
                <div class="filters__field">
                    <label class="filters__label" for="state-inp">Estado</label>
                    <select class="filters__control" id="state-inp">
                        <option value="0">Todos</option>
                        <option value="-1" selected>Vigentes</option>
                        <option value="4">Con mora</option>
                        <option value="3">Al d&iacute;a</option>
                        <option value="1">Cancelados</option>
                        <option value="5">En gesti&oacute;n judicial</option>
                        <option value="2">Incobrables</option>
                    </select>
                </div>
                <input type="hidden" id="token" value="<?php echo $token; ?>">
            </section>
            <section class="filters__action-buttons">
                <input type="submit" id="filter-btn" value="Aplicar">
                <input type="reset" id="reset-btn" value="Limpiar">
            </section>
            <section class="filters__state">filters_state</section>
        </form>
        <div class="frame">
            <!-- def-table -->
            <div class="def-table__container">
                <table class="def-table" id="prestamos-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Cod.</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Monto</th>
                            <th>Cuotas</th>
                            <th>Periodicidad</th>
                            <th>Tasa</th>
                            <th>Desarrollo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="frame__bottom"></div>
        </div>
        <!-- action-bar -->
        <div class="action-bar">
            <a class="action-bar__button spclss--no-effects-font" href="/prestamos/alta">Nuevo pr&eacute;stamo</a>
            <div class="action-bar__circle"></div>
        </div>
