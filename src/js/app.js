let paso = 1;

let pasoInicial = 1;
let pasoFinal = 3;

const cita = {
    id: "",
    nombre: "",
    fecha: "",
    hora: "",
    servicios: []
}

document.addEventListener('DOMContentLoaded', () => {
    iniciarApp();
});



function iniciarApp() {
    tabs(); // cambiar la seccion de los tabs
    mostrarSeccion();
    botonesPaginador(); // agrega o quita los botones paginador
    paginaSiguiente();
    paginaAnterior();

    consultarAPI();

    idCliente();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();

    mostrarResumen();
}


function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();

            botonesPaginador();
        })
    })
}

function mostrarSeccion() {

    // ocultar la seccion que tiene clase mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    seccionAnterior.classList.remove('mostrar');

    // seleccionar la seccion del paso ....
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');


    const tabAnterior = document.querySelector('.actual');
    tabAnterior.classList.remove('actual');

    // resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function botonesPaginador() {
    const paginaSiguiente = document.querySelector('#siguiente');
    const paginaAnterior = document.querySelector('#anterior');

    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaSiguiente.classList.add('ocultar');
        paginaAnterior.classList.remove('ocultar');

        mostrarResumen();
    } else if (paso === 2) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();

}

function paginaSiguiente() {
    const btnSiguiente = document.querySelector('#siguiente');
    btnSiguiente.addEventListener('click', () => {
        if (paso >= pasoFinal) return;
        paso++;

        botonesPaginador();

    })

}

function paginaAnterior() {
    const btnAnterior = document.querySelector('#anterior');
    btnAnterior.addEventListener('click', () => {
        if (paso <= pasoInicial) return;
        paso--;

        botonesPaginador();

    })
}

async function consultarAPI() {
    try {
        const url = `${location.origin}/api/servicios`;

        const resultado = await fetch(url);

        const servicios = await resultado.json();

        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('p');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('p');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `S/ ${precio}`;

        const servicioDiv = document.createElement('div');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);
    })
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // comprobar si un servicio fue agregado
    if (servicios.some(agregado => agregado.id === id)) {

        cita.servicios = servicios.filter((ele) => ele.id != id);
        divServicio.classList.remove('seleccionado');

    } else {

        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado')

    }

}

function nombreCliente() {
    cita.nombre = document.querySelector("#nombre").value;
}

function idCliente() {
    cita.id = document.querySelector("#id").value;
}

function seleccionarFecha() {
    const inputFecha = document.querySelector("#fecha");
    inputFecha.addEventListener("input", function (e) {

        const dia = new Date(e.target.value).getUTCDay();

        if ([6, 0].includes(dia)) {
            e.target.value = "";
            mostrarAlerta("Fines de semana no permitimos", "error", ".formulario");
        } else {
            cita.fecha = inputFecha.value;
        }

    })
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {

    const alertaPrevia = document.querySelector(".alerta");

    if (alertaPrevia) {
        alertaPrevia.remove();
    };

    const alerta = document.createElement('div');

    alerta.textContent = mensaje;

    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) {
        setTimeout(() => {
            alerta.remove();
        }, 3000)
    }


}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {

        const horaCita = e.target.value;
        const hora = horaCita.split(':')[0];

        if (hora < 10 || hora > 18) {
            e.target.value = "";
            mostrarAlerta('Hora no valida', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;
        }
    })
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // limpiar el contenido de resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de servicios, fecha u hora', 'error', '.contenido-resumen', false);
        return;
    }

    // agregar la estructura del resumen
    const { nombre, fecha, servicios, hora } = cita;

    // heading para servicios en resumen
    const heading = document.createElement('h3');
    heading.textContent = "Resumen de Servicios";
    resumen.appendChild(heading);

    // iterando los servicios
    servicios.forEach(servicio => {
        const { id, precio, nombre } = servicio;

        const contenidorServicio = document.createElement('div');
        contenidorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('p');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('p');
        precioServicio.innerHTML = `<span>Precio: </span>$${precio}`;

        contenidorServicio.appendChild(textoServicio);
        contenidorServicio.appendChild(precioServicio);

        resumen.appendChild(contenidorServicio);
    });

    const headingCita = document.createElement('h3');
    headingCita.textContent = "Resumen de Cita";
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('p');
    nombreCliente.innerHTML = `<span>Nombre: </span>${nombre}`;

    // formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const año = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(año, mes, dia));

    const opciones = { weekday: 'long', year: "numeric", month: 'long', day: 'numeric' };
    const fechaFormateada = fechaUTC.toLocaleDateString('es-ES', opciones);

    const fechaCita = document.createElement('p');
    fechaCita.innerHTML = `<span>Fecha: </span>${fechaFormateada}`;

    const horaCita = document.createElement('p');
    horaCita.innerHTML = `<span>Hora: </span>${hora}`;

    // boton para crear la cita
    const botonReservar = document.createElement("button");
    botonReservar.classList.add('boton');
    botonReservar.textContent = "Reservar Cita";
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);
}

async function reservarCita() {

    const { nombre, fecha, hora, servicios, id } = cita;

    const idServicios = servicios.map((servicio) => servicio.id);

    const datos = new FormData();
    datos.append('usuarioId', id);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicios);

    try {
        // peticion a la api de guardar cita
        const URL = "/api/citas";

        const respuesta = await fetch(URL, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();

        if (resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Cita creada",
                text: "Tu cita fue creada correctamente",
                button: "OK"
            }).then(() => {
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            });
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "No se ha concretado la cita, vuelve a intentarlo mas tarde"
        });
    }



}