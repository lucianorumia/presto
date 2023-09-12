<?php
use Back\Cross\Views;

?>

<h1 class="page-title">Alta Cliente</h1>

<!-- new-cliente-form -->
<div class="def-form__frame">
    <div class="def-form__frame-top"></div>
    <div class="def-form__container">
        <form id="new-cliente-form" class="def-form">
            <div class="def-form__field">
                <label class="def-form__label" for="nombre-inp">Nombre</label>
                <input class="def-form__input" id="nombre-inp" name="nombre" type="" autocomplete="off">
                <p class="vldt__caption"></p>
            </div>
            <div class="def-form__field">
                <label class="def-form__label" for="apellido-inp">Apellido</label>
                <input class="def-form__input" id="apellido-inp" name="apellido" type="" autocomplete="off">
                <p class="vldt__caption"></p>
            </div>
            <!-- Document -->
            <div class="def-form__fields-group def-form__extended sprclss--display-none">
                <p class="def-form__group-title">Documento</p>
                <div class="def-form__field ">
                    <label class="def-form__label" for="doc-tipo-inp">Tipo</label>
                    <select class="def-form__input" id="doc-tipo-inp" name="doc-tipo">
                        <option value="1">DNI</option>
                        <option value="2">CUIT</option>
                        <option value="3">CUIL</option>
                        <option value="4">PAS</option>
                    </select>
                </div>
                <div class="def-form__field">
                    <label class="def-form__label" for="doc-nro-inp">N&uacute;mero</label>
                    <input class="def-form__input" id="doc-nro-inp" name="doc-nro" type="">
                    <p class="vldt__caption"></p>
                </div>
            </div>
            <!-- Birthdate -->
            <div class="def-form__field def-form__extended sprclss--display-none">
                <label class="def-form__label" for="nacimiento-inp">Fecha Nacimiento</label>
                <input class="def-form__input" id="nacimiento-inp" type="date">
                <p class="vldt__caption"></p>
            </div>
            <!-- Phones -->
            <div class="def-form__fields-group tel__entry" id="tel-1">
                <p class="def-form__group-title">
                    <span class="tel__title">Tel&eacute;fono</span>
                    <span class="sprclss--action-span tel__remove sprclss--display-none" data-id="1">Eliminar</span>
                </p>
                <div class="def-form__field">
                    <label class="def-form__label" for="tel-1-nro-inp">N&uacute;mero</label>
                    <input class="def-form__input tel__nro" id="tel-1-nro-inp" type="tel" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field ">
                    <label class="def-form__label" for="tel-1-tipo-inp">Tipo</label>
                    <select class="def-form__input tel__tipo" id="tel-1-tipo-inp">
                        <option value="1">M&oacute;vil</option>
                        <option value="2">Casa</option>
                        <option value="3">Trabajo</option>
                        <option value="4">Otro</option>
                    </select>
                </div>
                <div class="def-form__field ">
                    <label class="tel__def sprclss--display-none">
                        <input type="radio" name="def_tel" value="1" checked>
                        Principal
                    </label>
                </div>
            </div>
            <span class="sprclss--action-span" id="add-tel">+ Agregar otro tel&eacute;fono</span>
            <!-- Emails -->
            <div class="def-form__fields-group email__entry" id="email-1">
                <p class="def-form__group-title">
                    <span class="email__title">Email</span>
                    <span class="sprclss--action-span email__remove sprclss--display-none" data-id="1">Eliminar</span>
                </p>
                <div class="def-form__field">
                    <label class="def-form__label" for="email-1-direccion-inp">Correo</label>
                    <input class="def-form__input email__direccion" id="email-1-direccion-inp" type="email" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field ">
                    <label class="def-form__label" for="email-1-tipo-inp">Tipo</label>
                    <select class="def-form__input email__tipo" id="email-1-tipo-inp">
                        <option value="1">Personal</option>
                        <option value="2">Laboral</option>
                        <option value="4">Otro</option>
                    </select>
                </div>
                <div class="def-form__field ">
                    <label class="email__def sprclss--display-none">
                        <input type="radio" name="def_email" value="1" checked>
                        Principal
                    </label>
                </div>
            </div>
            <span class="sprclss--action-span "id="add-email">+ Agregar otro email</span>
            <!-- Addresses -->
            <div class="def-form__fields-group address__entry sprclss--display-none" id="address-1">
                <p class="def-form__group-title">
                    <span class="address__title">Domicilio</span>
                    <span class="sprclss--action-span address__remove sprclss--display-none" data-id="1">Eliminar</span>
                </p>
                <div class="def-form__field ">
                    <label class="def-form__label" for="address-1-tipo-inp">Tipo</label>
                    <select class="def-form__input address__tipo" id="address-1-tipo-inp">
                        <option value="1">Real</option>
                        <option value="2">Legal/Fiscal</option>
                        <option value="3">Laboral</option>
                        <option value="4">Postal</option>
                        <option value="5">Otro</option>
                    </select>
                </div>
                <div class="def-form__field">
                    <label class="def-form__label" for="address-1-calle-inp">Calle</label>
                    <input class="def-form__input address__calle" id="address-1-calle-inp" type="text" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field">
                    <label class="def-form__label" for="address-1-nro-inp">N&uacute;mero</label>
                    <input class="def-form__input address__nro" id="address-1-nro-inp" type="number" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field def-form__extended sprclss--display-none">
                    <label class="def-form__label" for="address-1-piso-inp">Piso</label>
                    <input class="def-form__input address__piso" id="address-1-piso-inp" type="text" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field def-form__extended sprclss--display-none">
                    <label class="def-form__label" for="address-1-dpto-inp">Dpto.</label>
                    <input class="def-form__input address__dpto" id="address-1-dpto-inp" type="text" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field def-form__extended sprclss--display-none">
                    <label class="def-form__label" for="address-1-barrio-inp">Barrio</label>
                    <input class="def-form__input address__barrio" id="address-1-barrio-inp" type="text" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field">
                    <label class="def-form__label" for="address-1-localidad-inp">Localidad</label>
                    <input class="def-form__input address__localidad" id="address-1-localidad-inp" type="text" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field">
                    <label class="def-form__label" for="address-1-cp-inp">CP</label>
                    <input class="def-form__input address__cp" id="address-1-cp-inp" type="text" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field def-form__extended sprclss--display-none">
                    <label class="def-form__label" for="address-1-provincia-inp">Provincia/Estado</label>
                    <input class="def-form__input address__provincia" id="address-1-provincia-inp" type="text" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field def-form__extended sprclss--display-none">
                    <label class="def-form__label" for="address-1-pais-inp">Pa&iacute;s</label>
                    <input class="def-form__input address__pais" id="address-1-pais-inp" type="text" autocomplete="off">
                    <p class="vldt__caption"></p>
                </div>
                <div class="def-form__field ">
                    <label class="address__def sprclss--display-none">
                        <input type="radio" class="address__def" name="def-address" value="1" checked>
                        Principal
                    </label>
                </div>
            </div>
            <span class="sprclss--action-span sprclss--display-none" id="add-address">+ Agregar otro domicilio</span>
            <div class="def-form__field"> <!-- class="def-form__field def-form__extended sprclss--display-none" -->
                <label class="def-form__label" for="obs-inp">Observaciones</label>
                <textarea class="def-form__input" id="obs-inp" maxlength="255" rows="3"></textarea>
            </div>
            <input type="hidden" id="token" value="<?php echo $security->franEncrypt(Views::Clientes->value); ?>">
        </form>
    </div>
    <div class="def-form__frame-bottom"></div>
</div>

<!-- action-bar -->
<div class="action-bar">
    <button class="action-bar__button" id="back-btn">Volver</button>
    <button class="action-bar__button" id="reset-btn">Limpiar</button>
    <button class="action-bar__button sprclss--display-none" id="extend-form-btn">M&aacute;s datos...</button>
    <button class="action-bar__button" id="save-btn">Guardar</button>
    <div class="action-bar__circle"></div>
</div>