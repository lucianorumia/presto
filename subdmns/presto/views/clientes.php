<?php
use Back\Cross\Views;

?>
<h1 class="page-title">Clientes</h1>

<!-- filter-strip -->
<div class="filter-strip">
    <section class="filter-strip__filters">
        <div class="filter-strip__criteria">
            <form id="filter-form">
                <label class="filter-strip__element">Buscar
                    <input type="text" class="filter-strip__input" id="name" autocomplete="off">
                </label>
                <input type="hidden" id="token" value="<?php echo $security->franEncrypt(Views::Clientes->value); ?>">
            </form>
        </div>
        <div class="filter-strip__action-buttons">
            <input type="button" id="apply-flt" class="filter-strip__button" value="Aplicar">
            <input type="button" id="reset-flt" class="filter-strip__button" value="Limpiar">
        </div>
    </section>
    <!-- <section class="filter-strip__state"></section> -->
</div>

<!-- clientes-tbl -->
<div class="def-table__container">
    <table class="def-table" id="clientes-table">
        <thead>
            <tr>
                <th></th>
                <th>Cliente</th>
                <th>Tel&eacute;fono</th>
                <th></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- action-bar -->
<div class="action-bar">
    <a class="action-bar__button spclss--no-effects-font" href="/clientes/alta">Nuevo cliente</a>
    <div class="action-bar__circle"></div>
</div>