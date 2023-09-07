import { MODAL_MODE, MODAL_BUTTON, setModal, resetModal } from "/js/modules/modal.js";

const filterForm = document.getElementById('filter-form')
const nameInp = document.getElementById('name');
const applyFtr = document.getElementById('apply-flt');
const resetFtr = document.getElementById('reset-flt');
const modal = document.querySelector('.modal');

getClientes();

applyFtr.addEventListener('click', getClientes)

resetFtr.addEventListener('click', () => {
    filterForm.reset();
});

function getClientes() {
    const token = document.getElementById('token').value;
    const name = (nameInp.value.trim() !== '') ? nameInp.value.trim() : null;
    const url = '/back-interface/clientes.php'

    const dataToSend = {
        token: token,
        name: name,
    };

    console.log(dataToSend);

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
        console.log(respData);
        
        if (respData.success) {
            const clientesTable = document.getElementById('clientes-table');
            if (respData.clientes.length > 0) {
                const clientesTblBody = clientesTable.querySelector('tbody');
                clientesTblBody.innerHTML = '';

                respData.clientes.forEach(cliente => {
                    const newElement = document.createElement('tr');
                    const innerHtmlStr = `<td><div class="def-table__row-mark def-table__row-mark--def"></div></td>
                        <td>${cliente.denominacion}</td>
                        <td>${cliente.telefono}</td>
                        <td>
                            <a class="def-table__plus-btn" href="/clientes/${cliente.key}">+</a>
                        </td>`;
                    
                    newElement.classList.add('def-table__body-row')
                    newElement.innerHTML = innerHtmlStr;
                    clientesTblBody.appendChild(newElement);    
                });
                clientesTable.style.visibility = "visible";
            } else {
                clientesTable.style.visibility = "hidden";

                let modalTitle = 'Ups!';
                let modalText = 'No hay clientes para mostrar.<br>'
                    + 'Cambiá el criterio    de búsqueda y volvé a aplicar el filtro.';
                let modalBtns = [MODAL_BUTTON.OK];
                setModal(modal, MODAL_MODE.INFO, modalTitle, modalText, modalBtns);

                modal.addEventListener('close', () => {
                    resetModal(modal);
                    nameInp.select();
                }, {once: true});

                modal.showModal();
            }
        } else {
            alert('Ha ocurrido un error!\nPonete en contacto con el administrador del sistema.');
            console.error(respData.error);    
        }
    })
    .catch(e => {
        console.error(e);
        alert('Ha ocurrido un error!\nPonete en contacto con el administrador del sistema.');
    })
}

// From Modals
const urlParamsStr = window.location.search;
const urlParams = new URLSearchParams(urlParamsStr);
const urlFrom = urlParams.get('from');
const urlSucc = urlParams.has('succ') ? urlParams.get('succ') : null;

let modalMode, modalTitle, modalText;
const modalBtns = [MODAL_BUTTON.OK];

if (urlFrom !== null) {
    switch (urlFrom) {
        case 'new':
            switch (urlSucc) {
                case 'true':
                    modalMode = MODAL_MODE.INFO;
                    modalTitle = 'Listo!';
                    modalText = 'El usuario se registró con éxito.'
                    break;
            
                case 'false':
                    modalMode = MODAL_MODE.ERROR;
                    modalTitle = 'Ups!';
                    modalText = 'No pudimos registrar el usuario.<br>'
                        + 'Ponete en contacto con el administrador del sistema';
                    break;
            }
            break;

        case 'delete':
            switch (urlSucc) {
                case 'true':
                    modalMode = MODAL_MODE.INFO;
                    modalTitle = 'Listo!';
                    modalText = 'El usuario fue eliminado con éxito.'
                    break;
            
                case 'false':
                    modalMode = MODAL_MODE.ERROR;
                    modalTitle = 'Ups!';
                    modalText = 'No pudimos eliminar el usuario.<br>'
                        + 'Ponete en contacto con el administrador del sistema';
                    break;
            }
            break;
    }

    setModal(modal, modalMode, modalTitle, modalText, modalBtns);

    modal.addEventListener('close', () => {
        resetModal(modal);
    }, {once: true});

    modal.showModal();
}
