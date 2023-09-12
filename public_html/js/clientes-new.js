import { CST_ERROR } from "/js/modules/errors.js";
import { MODAL_MODE, MODAL_BUTTON, setModal, resetModal } from "/js/modules/modal.js";
import { VLDT_TYPE, VltdField, vldtForm, vldtSetListeners, vldtUnset } from "/js/modules/validations.js";

const newClienteForm = document.getElementById('new-cliente-form');
const nombreInp = document.getElementById('nombre-inp');
const apellidoInp = document.getElementById('apellido-inp');

const telEntries = document.getElementsByClassName("tel__entry");
const telRemovers = document.getElementsByClassName("tel__remove");
const addTelSpan = document.getElementById("add-tel");
let maxTelId = 1;

const emailEntries = document.getElementsByClassName("email__entry");
const emailRemovers = document.getElementsByClassName("email__remove");
const addEmailSpan = document.getElementById("add-email");
let maxEmailId = 1;

const addressEntries = document.getElementsByClassName("address__entry");
const addressRemovers = document.getElementsByClassName("address__remove");
const addAddressSpan = document.getElementById("add-address");
let maxAddressId = 1;

const backBtn = document.getElementById('back-btn');
const resetBtn = document.getElementById('reset-btn');
const extendFormBtn = document.getElementById('extend-form-btn');
const saveBtn = document.getElementById('save-btn');

let extendFormFlag = false;

const modal = document.querySelector('.modal');

// Validations -----------------------------------------------------------------
const nombreVldt = new VltdField(nombreInp, [{type: VLDT_TYPE.REQUIRED, text: 'Campo requerido'}], new Event('input'));
const apellidoVldt = new VltdField(apellidoInp, [{type: VLDT_TYPE.REQUIRED, text: 'Campo requerido'}], new Event('input'));
const vldtFieldsArray = [nombreVldt, apellidoVldt];

// Phone handlers
addTelSpan.addEventListener("click", addTel);

function addTel(){
    maxTelId += 1;
    
    let insertPoint = document.getElementById('add-tel');
    let html_element = document.createElement('div');

    html_element.className = "def-form__fields-group tel__entry";
    html_element.id = `tel-${maxTelId}`;

    let html_str = `<p class="def-form__group-title">
            <span class="tel__title"></span>
            <span class="sprclss--action-span tel__remove" data-id="${maxTelId}">Eliminar</span>
        </p>
        <div class="def-form__field">
            <label class="def-form__label" for="tel-${maxTelId}-nro-inp">N&uacute;mero</label>
            <input class="def-form__input tel__nro" id="tel-${maxTelId}-nro-inp" type="tel" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field ">
            <label class="def-form__label" for="tel-${maxTelId}-tipo-inp">Tipo</label>
            <select class="def-form__input tel__tipo" id="tel-${maxTelId}-tipo-inp">
                <option value="1">M&oacute;vil</option>
                <option value="2">Casa</option>
                <option value="3">Trabajo</option>
                <option value="4">Otro</option>
            </select>
        </div>
        <div class="def-form__field ">
            <label class="tel__def">
                <input type="radio" name="def_tel" value="${maxTelId}">
                Principal
            </label>
        </div>`;

    html_element.innerHTML = html_str;
    insertPoint.before(html_element);
    
    setDisplayTel();
    setTelRemoverListeners();
}

function removeTel(e){
    let id = e.target.dataset.id;
    let telEntry = document.getElementById(`tel-${id}`);
    telEntry.parentNode.removeChild(telEntry);
    
    setDisplayTel();
}

function setTelRemoverListeners() {
    for (let remover of telRemovers) {
        remover.addEventListener("click", removeTel);
    }
}

function setDisplayTel() {
    const telTitles = document.querySelectorAll(".tel__title");
    const telDefLbls = document.querySelectorAll(".tel__def");
    
    if (telEntries.length > 1) {
        telTitles.forEach((title, i) => {
           title.textContent = `Teléfono ${i + 1}`; 
        });
        
        for (let remover of telRemovers) {
            if (remover.classList.contains("sprclss--display-none")) {
                remover.classList.remove("sprclss--display-none");
            }
        };
            
        telDefLbls.forEach(lbl => {
            if (lbl.classList.contains("sprclss--display-none")) {
                lbl.classList.remove("sprclss--display-none");
            }
        });
    } else {
        telTitles[0].textContent = "Teléfono"; 
        telRemovers[0].classList.add("sprclss--display-none");
        telDefLbls[0].classList.add("sprclss--display-none");
    }
    
    if (document.querySelectorAll(".tel__def input[type='radio']:checked").length === 0) {
        document.querySelector(".tel__def input[type='radio']").checked = true;
    }
}

// Email handlers
addEmailSpan.addEventListener("click", addEmail);

function addEmail(){
    maxEmailId += 1;
    
    let insertPoint = document.getElementById('add-email');
    let html_element = document.createElement('div');

    html_element.className = "def-form__fields-group email__entry";
    html_element.id = `email-${maxEmailId}`;

    let html_str = `<p class="def-form__group-title">
            <span class="email__title"></span>
            <span class="sprclss--action-span email__remove" data-id="${maxEmailId}">Eliminar</span>
        </p>
        <div class="def-form__field">
            <label class="def-form__label" for="email-${maxEmailId}-direccion-inp">N&uacute;mero</label>
            <input class="def-form__input email__direccion" id="email-${maxEmailId}-direccion-inp" type="email" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field ">
            <label class="def-form__label" for="email-${maxEmailId}-tipo-inp">Tipo</label>
            <select class="def-form__input email__tipo" id="email-${maxEmailId}-tipo-inp">
                <option value="1">Personal</option>
                <option value="2">Laboral</option>
                <option value="3">Otro</option>
            </select>
        </div>
        <div class="def-form__field ">
            <label class="email__def">
                <input type="radio" name="def_email" value="${maxEmailId}">
                principal
            </label>
        </div>`;

    html_element.innerHTML = html_str;
    insertPoint.before(html_element);
    
    setDisplayEmail();
    setEmailRemoverListeners();
}

function removeEmail(e){
    let id = e.target.dataset.id;
    let emailEntry = document.getElementById(`email-${id}`);
    emailEntry.parentNode.removeChild(emailEntry);
    
    setDisplayEmail();
}

function setEmailRemoverListeners() {
    for (let remover of emailRemovers) {
        remover.addEventListener("click", removeEmail);
    }
}

function setDisplayEmail() {
    const emailTitles = document.querySelectorAll(".email__title");
    const emailDefLbls = document.querySelectorAll(".email__def");
    
    if (emailEntries.length > 1) {
        emailTitles.forEach((title, i) => {
           title.textContent = `Email ${i + 1}`; 
        });
        
        for (let remover of emailRemovers) {
            if (remover.classList.contains("sprclss--display-none")) {
                remover.classList.remove("sprclss--display-none");
            }
        };
            
        emailDefLbls.forEach(lbl => {
            if (lbl.classList.contains("sprclss--display-none")) {
                lbl.classList.remove("sprclss--display-none");
            }
        });
    } else {
        emailTitles[0].textContent = "Email"; 
        emailRemovers[0].classList.add("sprclss--display-none");
        emailDefLbls[0].classList.add("sprclss--display-none");
    }
    
    if (document.querySelectorAll(".email__def input[type='radio']:checked").length === 0) {
        document.querySelector(".email__def input[type='radio']").checked = true;
    }
}

// Address handlers
addAddressSpan.addEventListener("click", addAddress);

function addAddress(){
    maxAddressId += 1;
    
    let insertPoint = document.getElementById('add-address');
    let html_element = document.createElement('div');

    html_element.className = "def-form__fields-group address__entry";
    html_element.id = `address-${maxAddressId}`;

    let html_str = `<p class="def-form__group-title">
            <span class="address__title"></span>
            <span class="sprclss--action-span address__remove" data-id="${maxAddressId}">Eliminar</span>
        </p>
        <div class="def-form__field ">
            <label class="def-form__label" for="address-${maxAddressId}-tipo-inp">Tipo</label>
            <select class="def-form__input address__tipo" id="address-${maxAddressId}-tipo-inp">
                <option value="1">Real</option>
                <option value="2">Legal/Fiscal</option>
                <option value="3">Laboral</option>
                <option value="4">Postal</option>
                <option value="5">Otro</option>
            </select>
        </div>
        <div class="def-form__field">
            <label class="def-form__label" for="address-${maxAddressId}-calle-inp">Calle</label>
            <input class="def-form__input address__calle" id="address-${maxAddressId}-calle-inp" type="text" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field">
            <label class="def-form__label" for="address-${maxAddressId}-nro-inp">N&uacute;mero</label>
            <input class="def-form__input address__nro" id="address-${maxAddressId}-nro-inp" type="number" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field def-form__extended sprclss--display-none">
            <label class="def-form__label" for="address-${maxAddressId}-piso-inp">Piso</label>
            <input class="def-form__input address__piso" id="address-${maxAddressId}-piso-inp" type="text" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field def-form__extended sprclss--display-none">
            <label class="def-form__label" for="address-${maxAddressId}-dpto-inp">Dpto.</label>
            <input class="def-form__input address__dpto" id="address-${maxAddressId}-dpto-inp" type="text" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field def-form__extended sprclss--display-none">
            <label class="def-form__label" for="address-${maxAddressId}-barrio-inp">Barrio</label>
            <input class="def-form__input address__barrio" id="address-${maxAddressId}-barrio-inp" type="text" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field">
            <label class="def-form__label" for="address-${maxAddressId}-localidad-inp">Localidad</label>
            <input class="def-form__input address__localidad" id="address-${maxAddressId}-localidad-inp" type="text" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field">
            <label class="def-form__label" for="address-${maxAddressId}-cp-inp">CP</label>
            <input class="def-form__input address__cp" id="address-${maxAddressId}-cp-inp" type="text" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field def-form__extended sprclss--display-none">
            <label class="def-form__label" for="address-${maxAddressId}-provincia-inp">Provincia/Estado</label>
            <input class="def-form__input address__provincia" id="address-${maxAddressId}-provincia-inp" type="text" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field def-form__extended sprclss--display-none">
            <label class="def-form__label" for="address-${maxAddressId}-pais-inp">Pa&iacute;s</label>
            <input class="def-form__input address__pais" id="address-${maxAddressId}-pais-inp" type="text" autocomplete="off">
            <p class="vldt__caption"></p>
        </div>
        <div class="def-form__field ">
            <label class="address__def sprclss--display-none">
                <input type="radio" class="address__def" name="def-address" value="${maxAddressId}">
                principal
            </label>
        </div>` ;

    html_element.innerHTML = html_str;
    insertPoint.before(html_element);
    
    setDisplayAddress();
    setAddressRemoverListeners();
}

function removeAddress(e){
    let id = e.target.dataset.id;
    let addressEntry = document.getElementById(`address-${id}`);
    addressEntry.parentNode.removeChild(addressEntry);
    
    setDisplayAddress();
}

function setAddressRemoverListeners() {
    for (let remover of addressRemovers) {
        remover.addEventListener("click", removeAddress);
    }
}

function setDisplayAddress() {
    const addressTitles = document.querySelectorAll(".address__title");
    const addressDefLbls = document.querySelectorAll(".address__def");
    
    if (addressEntries.length > 1) {
        addressTitles.forEach((title, i) => {
           title.textContent = `Domicilio ${i + 1}`; 
        });
        
        for (let remover of addressRemovers) {
            if (remover.classList.contains("sprclss--display-none")) {
                remover.classList.remove("sprclss--display-none");
            }
        };
            
        addressDefLbls.forEach(lbl => {
            if (lbl.classList.contains("sprclss--display-none")) {
                lbl.classList.remove("sprclss--display-none");
            }
        });
    } else {
        addressTitles[0].textContent = "Domicilio"; 
        addressRemovers[0].classList.add("sprclss--display-none");
        addressDefLbls[0].classList.add("sprclss--display-none");
    }
    
    if (document.querySelectorAll(".address__def input[type='radio']:checked").length === 0) {
        document.querySelector(".address__def input[type='radio']").checked = true;
    }
}

// Action buttons
backBtn.addEventListener('click', () => history.back());

resetBtn.addEventListener('click', () => {
    vldtUnset(vldtFieldsArray);
    newClienteForm.reset();
});

extendFormBtn.addEventListener('click', () => {
    document.querySelectorAll('.def-form__extended').forEach(element => {
        element.classList.toggle('sprclss--display-none');
    });

    if (extendFormFlag) {
        extendFormBtn.textContent = 'Más datos...';
    } else {
        extendFormBtn.textContent = 'Menos datos...';
    }

    extendFormFlag = !extendFormFlag;
})

saveBtn.addEventListener('click', () => {
    const validForm = (vldtForm(vldtFieldsArray));
    let modalTitle, modalText, modalBtns;

    if (validForm) {
        modalTitle = 'Guardar';
        modalText = 'Estás seguro que qurés dar de alta al cliente?'
        modalBtns = [MODAL_BUTTON.YES, MODAL_BUTTON.NO];
        setModal(modal, MODAL_MODE.QUESTION, modalTitle, modalText, modalBtns)
        
        modal.addEventListener('close', () => {
            const modalResp = parseInt(modal.returnValue);
            switch (modalResp) {
                case MODAL_BUTTON.YES.value:
                    sendClienteData();
                    break;
            }
            resetModal(modal);
        }, {once: true});

        modal.showModal();
    } else {
        vldtSetListeners(vldtFieldsArray);
    }
});

function sendClienteData() {
    let modalMode, modalBtns, modalTitle, modalText;
    const url = '/back-interface/clientes-new.php'
    const token = document.getElementById('token').value;
    const nombre = nombreInp.value.trim();
    const apellido = apellidoInp.value.trim();
    
    // Phones
    let telsData = [];
    let nros = document.getElementsByClassName('tel__nro');

    for (let i = 0; i < telEntries.length; i++) {
        if (nros[i].value.trim() === '') {
            continue;
        } else {
            let telTipo = parseInt(document.getElementsByClassName('tel__tipo')[i].value);
            let telDef = document.querySelectorAll('.tel__entry input[name="def_tel"]')[i].checked;
            telsData.push({
                nro: nros[i].value,
                tipo: telTipo,
                def: telDef
            });
        }
    }

    // Emails
    let emailsData = [];
    let direcciones = document.getElementsByClassName('email__direccion');

    for (let i = 0; i < emailEntries.length; i++) {
        if (direcciones[i].value.trim() === '') {
            continue;
        } else {
            let emailTipo = parseInt(document.getElementsByClassName('email__tipo')[i].value);
            let emailDef = document.querySelectorAll('.email__entry input[name="def_email"]')[i].checked;
            emailsData.push({
                direccion: direcciones[i].value,
                tipo: emailTipo,
                def: emailDef
            });
        }
    }

    // Addresses
    let addressesData = [];

    for (let i = 0; i < addressEntries.length; i++) {
        if (addressEntries[i].querySelector('.address__calle').value.trim() === '') {
            continue;
        } else {
            const addressTipo = parseInt(addressEntries[i].querySelector('.address__tipo').value);
            const addressCalle = addressEntries[i].querySelector('.address__calle').value.trim();
            const addressNro = (addressEntries[i].querySelector('.address__nro').value.trim() || null);
            const addressLocalidad = addressEntries[i].querySelector('.address__localidad').value.trim() || null;
            const addressCp = addressEntries[i].querySelector('.address__cp').value.trim() || null;
            const addressDef = addressEntries[i].querySelector('.address__def input[name="def-address"]').checked;
            
            addressesData.push({
                tipo: addressTipo,
                calle: addressCalle,
                nro: addressNro,
                localidad: addressLocalidad,
                cp: addressCp,
                def: addressDef
            });
        }
    }
    
    // Extend Address
    // const addressPiso = addressEntries[i].querySelector('.address__piso').value.trim() || null;
    // const addressDpto = addressEntries[i].querySelector('.address__dpto').value.trim() || null;
    // const addressBarrio = addressEntries[i].querySelector('.address__barrio').value.trim() || null;
    // const addressProvincia = addressEntries[i].querySelector('.address__provincia').value.trim() || null;
    // const addressPais = addressEntries[i].querySelector('.address__pais').value.trim() || null;

    const obs = document.getElementById('obs-inp').value.trim() || null;

    const dataToSend = {
        token: token,
        nombre: nombre,
        apellido: apellido,
        tels: telsData,
        emails: emailsData,
        addresses: addressesData,
        //extended: extendFormFlag,
        obs: obs
    };

    fetch(url, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(dataToSend),
    })
    .then(response => response.json())
    // .then(response => response.text())
    .then(respData => {
        if (respData.success) {
            modalMode = MODAL_MODE.INFO;
            modalBtns = [MODAL_BUTTON.OK];
            modalTitle = 'Listo!';
            modalText = 'Ya diste de alta al cliente';

            setModal(modal, modalMode, modalTitle, modalText, modalBtns);
        
            modal.addEventListener('close', () => {
                window.location.href = '/clientes';
            });

            modal.showModal();
            
        } else {
            modalMode = MODAL_MODE.ERROR;
            modalBtns = [MODAL_BUTTON.OK];
            modalTitle = CST_ERROR.CST099.modal.title;
            modalText = CST_ERROR.CST099.modal.text;

            console.error(respData.error);

            setModal(modal, modalMode, modalTitle, modalText, modalBtns);
        
            modal.addEventListener('close', () => {
                resetModal(modal);
            }, {once: true});

            modal.showModal();
        }
    })
    .catch(err => {
        modalMode = MODAL_MODE.ERROR;
        modalBtns = [MODAL_BUTTON.OK];
        modalTitle = CST_ERROR.CST099.modal.title;
        modalText = CST_ERROR.CST099.modal.text;
        
        console.error(err);
        
        setModal(modal, modalMode, modalTitle, modalText, modalBtns);
    
        modal.addEventListener('close', () => {
            resetModal(modal);
        }, {once: true});
    
        modal.showModal();
    })
}