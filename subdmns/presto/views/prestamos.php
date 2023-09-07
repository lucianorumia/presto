<?php
?>
<h1 class="page-title">Pr&eacute;stamos</h1>
<!-- filter-strip -->
<form class="filter-strip" id="flt-form">
    <!-- <section class="defFltrs">
        <div>
            <label for="cliente_inp">Cliente</label>
            <input type="text" id="cliente_inp" list="clientes_lst" placeholder="Todos">
            <datalist id="clientes_lst">

            <?php
            // $sec = new secrty_ctrl;
            // $clientes = getAllClientes();
            // foreach ($clientes as $cliente):
            ?>

                <option value="<?php //echo $cliente['nombreCompleto']; ?>" data-key_cliente="<?php //echo $sec->simpleEncrypt($cliente['id']); ?>">

            <?php
            // endforeach;
            ?>

            </datalist>
        </div>
        <div>
            <label for="estado_inp">Estado</label>
            <select id="estado_inp">
                <option value="0">Todos</option>
                <option value="-1" selected>Vigentes</option>
                <option value="3">Con mora</option>
                <option value="2">Al d&iacute;a</option>
                <option value="1">Cancelados</option>
                <option value="4">Gesti&oacute;n Judicial</option>
                <option value="5">Incobrables</option>
            </select>
        </div>
        <input type="button" name="flter_btn" id="filter_btn" value="Consultar">
        <input type="button" name="reset_btn" id="reset_btn" value="Limpiar">
        <input type="checkbox" id="moreFltrs_chk" class="dispNone">
        <label id="moreFltrs_lbl" class="smplAct" for="moreFltrs_chk">+ mostrar más filtros</label>
    </section>
    <section class="moreFltrs dispNone">
        <div>
            <label for="fDesde">Otorgado:&nbsp;&nbsp;Desde</label>
            <input type="date" name="fDesde" id="fDesde_inp">
            <label for="fHasta">&nbsp;Hasta</label>
            <input type="date" name="fHasta" id="fHasta_inp">
        </div>
        <div>
            <label for="monto_inp">Monto</label>
            <select id="oprtMonto_inp">
                <option value="1">igual a</option>
                <option value="2">menor a</option>
                <option value="3">mayor a</option>
                <option value="4" hidden>entre</option>
            </select>
            <input type="number" id="monto_inp" placeholder="Ingresá el monto">
        </div>
        <div>
            <label for="cuotas_inp">Cuotas</label>
            <input type="number" id="cuotas_inp" placeholder="Ingresá cant. cuot.">
        </div>
        <div>
            <label for="periodcd_inp">Periodicidad</label>
            <select id="prdcdad_inp">
                <option value="1">Diaria</option>
                <option value="2" selected>Semanal</option>
                <option value="3">Quincenal</option>
                <option value="4">Mensual</option>
                <option value="0">(todas)</option>
            </select>
        </div>
    </section> -->
    <section class="filter-state"></section>
</form>
        
<div class="tableDiv flexOne overflwAuto">
    <table class="defTable defTable--exp" id="presTable">
        <thead>
            <tr>
                <th></th>
                <th>Cod.</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th>Monto</th>
                <th class="dispNone">Modalidad</th>
                <th>Cuotas</th>
                <th>Periodicidad</th>
                <th>Tasa</th>
                <th>Entrega</th>
                <!-- <th>Desarrollo</th> -->
                <th class="btnTh"></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<div class="action-bar">
    <a class="action-bar__button spclss--no-effects-font" href="/prestamos/alta">Nuevo pr&eacute;stamo</a>
    <div class="action-bar__circle"></div>
</div>