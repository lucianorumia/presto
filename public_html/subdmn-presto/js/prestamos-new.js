import { MULTI_X, focusXSlide} from "/js/modules/multi-x.js";
import { MILISECONDS, Ymd, elapsedDays } from "/js/modules/dates.js";

const newPestamoForm = document.getElementById('new-prestamo-form');
const clienteInp = document.getElementById('cliente-inp');
const montoInp = document.getElementById('monto-inp');
const modalidadInp = document.getElementById('modalidad-inp');
const cuotasInp = document.getElementById('cuotas-inp');
const periodicidadInp = document.getElementById('periodicidad-inp');
const tasaInp = document.getElementById('tasa-inp');
const entregaInp = document.getElementById('fecha-entrega-inp');

const backBtn = document.getElementById('back-btn');
const resetBtn = document.getElementById('reset-btn');
const simulateBtn = document.getElementById('simulate-btn');
const editBtn = document.getElementById('edit-btn');
const confirmBtn = document.getElementById('confirm-btn');

let fecEntrega;
let cuotas;

backBtn.addEventListener('click', () => history.back());
resetBtn.addEventListener('click', () => newPestamoForm.reset());
simulateBtn.addEventListener('click', () => {
    setFecEntrega();
    cuotas = getCuotas();
    setSimTable();
    focusXSlide(MULTI_X, 1);
});
editBtn.addEventListener('click', () => focusXSlide(MULTI_X, 0));
confirmBtn.addEventListener('click', () => savePrestamo());

function setFecEntrega() {
    let date = entregaInp.valueAsDate;
    fecEntrega = new Date(date.getTime() + date.getTimezoneOffset() * MILISECONDS.MIN);
    // console.log(fecEntrega);
}

function getCuotas() {
    const monto = parseFloat(montoInp.value);
    const modalidad = parseInt(modalidadInp.value);
    const qCuotas = parseInt(cuotasInp.value);
    const periodicidad = parseInt(periodicidadInp.value);
    const tasa = parseFloat(tasaInp.value) / 100;
    
    let cuotas = [];

    for (let index = 0; index < qCuotas; index++) {
        const ord = index + 1;
        
        let vto;
        switch (periodicidad) {
            case 1:
                vto = new Date(fecEntrega.getTime() + ord * MILISECONDS.DAY);
                break;
            case 2:
                vto = new Date(fecEntrega.getTime() + ord * MILISECONDS.DAY * 7);
                break;
            case 3:
                vto = new Date(fecEntrega.getTime() + ord * MILISECONDS.DAY * 14);
                break;
            case 4:
                vto = new Date(fecEntrega.setMonth(fecEntrega.getMonth() + ord));
                break;
        }

        let k;
        let i;
        switch (modalidad) {
            case 1:
                k = Math.round(monto / qCuotas * 100) / 100;
                i = Math.round(monto * tasa * 100) / 100;
                break;
        }

        const total = k + i;

        cuotas.push({
            ord: ord,
            vto: vto,
            k: k,
            i: i,
            total: total
        })
    }

    return cuotas;
}

function setSimTable() {
    const simTbody = document.querySelector('#sim-table tbody');
    const simDuracion = document.getElementById('sim-duracion');
    const simCapital = document.getElementById('sim-capital');
    const simInteres = document.getElementById('sim-interes');
    const simCft = document.getElementById('sim-cft');
    
    const numFormat = new Intl.NumberFormat("es-AR", {
        minimumFractionDigits: 2,
    });

    let kAccum = 0;
    let iAccum = 0;
    
    simTbody.innerHTML = '';

    cuotas.forEach(cuota => {
        const vtoYmd = Ymd(cuota.vto);
        const vtoStr = `${vtoYmd.d}/${vtoYmd.m}/${vtoYmd.Y}`;
        const newElement = document.createElement('tr');
        const innerHtmlStr = `<td><div class="def-table__row-mark def-table__row-mark--def"></div></td>
            <td>${cuota.ord}</td>
            <td>${vtoStr}</td>
            <td>${numFormat.format(cuota.k)}</td>
            <td>${numFormat.format(cuota.i)}</td>
            <td>${numFormat.format(cuota.total)}</td>`
        newElement.innerHTML = innerHtmlStr;
        simTbody.appendChild(newElement);
        
        kAccum += cuota.k;
        iAccum += cuota.i;
    });

    let duration = elapsedDays(fecEntrega, cuotas[cuotas.length - 1].vto) + ' días';

    simDuracion.textContent = duration;
    simCapital.textContent = numFormat.format(kAccum);
    simInteres.textContent = numFormat.format(iAccum);
    simCft.textContent = Intl.NumberFormat("es-AR", {
        style: 'percent',
        minimumFractionDigits: 2,
    }).format(iAccum / kAccum);

}

function savePrestamo() {
    const url = '/back-interface.php';
    const token = document.getElementById('token').value;
    const cliente = document.querySelector(`#clientes-lst option[value="${clienteInp.value}"]`).dataset.key;
    const monto = parseFloat(montoInp.value);
    const modalidad = parseInt(modalidadInp.value);
    const periodicidad = parseInt(periodicidadInp.value);
    const tasa = parseFloat(tasaInp.value) / 100;
    const entrega = fecEntrega.toJSON();

    let dataToSend = {
        token: token,
        cliente: cliente,
        monto: monto,
        modalidad: modalidad,
        periodicidad: periodicidad,
        tasa: tasa,
        entrega: entrega,
        cuotas: cuotas,
        ctaDeb: 11, // hardcode!
        ctaCred: 5 // hardcode!
    }

    // console.log(dataToSend);

    fetch(url, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(dataToSend),
    })
    // .then(response => response.json())
    .then(response => response.text())
    .then(respData => {
        console.log(respData);
    })
    .catch(err => {
        console.error(err);
    });
}