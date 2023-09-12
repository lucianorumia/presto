import { MODAL_MODE, MODAL_BUTTON, setModal, resetModal } from "/js/modules/modal.js";

const filtersForm = document.getElementById('filters-form')
const clienteInp = document.getElementById('cliente-inp');
const stateInp = document.getElementById('state-inp');
const applyFilters = document.getElementById('filter-btn');
const resetFilters = document.getElementById('reset-btn');
const modal = document.querySelector('.modal');
let modalMode, modalBtns, modalTitle, modalText;

getPrestamos();

applyFilters.addEventListener('click', (e) => {
    e.preventDefault();
    getPrestamos();
});

resetFilters.addEventListener('click', (e) => {
    e.preventDefault();
    filtersForm.reset();
    getPrestamos();
});

function getPrestamos() {
    const url = '/back-interface.php';
    const token = document.getElementById('token').value;
    const cliente = clienteInp.value === "" ? null : document.querySelector(`#clientes-lst option[value="${clienteInp.value}"]`).dataset.key;
    const state = stateInp.value === "0" ? null : parseInt(stateInp.value);

    const dataToSend = {
        token: token,
        cliente: cliente,
        state: state,
    }

    // console.log(dataToSend);

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
            const prestamosTable = document.getElementById('prestamos-table');
            if (respData.prestamos.length > 0) {
                const prestamosTblBody = prestamosTable.querySelector('tbody');
                prestamosTblBody.innerHTML = '';

                respData.prestamos.forEach(prestamo => {
                    const newElement = document.createElement('tr');
                    const innerHtmlStr = `<td><div class="def-table__row-mark def-table__row-mark--def"></div></td>
                        <td>${prestamo.cod}</td>
                        <td>${prestamo.cliente}</td>
                        <td>${prestamo.estado}</td>
                        <td>${prestamo.monto}</td>
                        <td>${prestamo.cuotas}</td>
                        <td>${prestamo.periodicidad}</td>
                        <td>${prestamo.tasa}</td>
                        <td></td>
                        <td>
                            <a class="def-table__plus-btn" href="/prestamos/${prestamo.key}">+</a>
                        </td>`;
                    
                    newElement.classList.add('def-table__body-row')
                    newElement.innerHTML = innerHtmlStr;
                    prestamosTblBody.appendChild(newElement);    
                });
                prestamosTable.style.visibility = "visible";
            } else {
                prestamosTable.style.visibility = "hidden";

                modalMode = MODAL_MODE.INFO;
                modalTitle = 'Ups!';
                modalText = 'No hay préstamos para mostrar.<br>'
                    + 'Cambiá el criterio de búsqueda y volvé a aplicar el filtro.';
                modalBtns = [MODAL_BUTTON.OK];
                setModal(modal, modalMode, modalTitle, modalText, modalBtns);

                modal.addEventListener('close', () => {
                    resetModal(modal);
                    clienteInp.select();
                }, {once: true});

                modal.showModal();
            }
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
        console.error(err);
    });

}
