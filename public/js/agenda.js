function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

//Días
var hoy = new Date();
var dd = hoy.getDate();
if (dd < 10) {
    dd = "0" + dd;
}

//Meses
if (mm < 10) {
    mm = "0" + mm;
}

var mm = hoy.getMonth() + 1;
var yyyy = hoy.getFullYear();

dd = addZero(dd);
mm = addZero(mm);
var id;
$(document).ready(function () {
    // VARIABLES
    let fecha_start = document.getElementById('start');
    let fecha_end = document.getElementById('end');
    let formulario = document.querySelector("form");
    $("#calendar").fullCalendar({
        header: {
            left: "prev,next",
            center: "title",
            right: "month,agendaWeek,agendaDay",
        },
        defaultDate: yyyy + "-" + mm + "-" + dd,
        buttonIcons: true, // show the prev/next text
        weekNumbers: false,
        editable: true,
        eventLimit: true, // allow "mo,re" link when too many events
        events: "http://localhost/agenda/public/evento/mostrar",
        minTime: "06:00:00",
        maxTime: "18:00:00",
        slotDuration: "00:15:00",
        slotLabelInterval: "01:00:00",
        hiddenDays: [0],
        eventLimit: true,
        slotEventOverlap: false,
        selectOverlap: false,
        // selectable: true,
        eventConstraint: [
            {
                start: "11:00",
                end: "12:00"
            }
        ],

        //Click para agregar cita
        dayClick: function (date, jsEvent, view) {
            formulario.reset();
            var check = date.format();
            var today = moment(new Date()).format();
            if (check >= today) {
                $('#btnGuardar').show();
                $('#btnEditar').hide();
                $('#btnDelete').hide();
                $("#evento").modal("show");

                //Fecha
                let fechaparcial = date.format().substr(0, 10);

                //Hora Inicial
                let hora = date.hour();
                let min = date.minutes();
                if (hora < 10) {
                    hora = "0" + hora;
                }
                if (min < 10) {
                    min = "0" + min;
                }
                let horainicial = hora + ":" + min;
                fecha_start.value = check;
                let mint = 15;
                fecha_end.value = moment(check).add(mint, 'm').format('YYYY-MM-DDThh:mm:ss');
            } else {
                alertCenter('error','¡No se pueden agendar citas en fechas pasadas!');
            }
        },
        select: function (startDate, endDate) {
            alert(`Seleccionó de ${startDate.format()} a ${endDate.format()}`)
        },
        //click en cita asignada
        eventClick: function (calEvent, jsEvent, view) {
            axios
                .post(
                    "http://localhost/agenda/public/evento/editar/" +
                    calEvent.id
                )
                .then((respuesta) => {
                    formulario.title.value = respuesta.data.title;
                    formulario.description.value = respuesta.data.description;
                    formulario.start.value = calEvent.start.format();
                    formulario.end.value = calEvent.end.format();
                    id = respuesta.data.id;
                    $('#btnGuardar').hide();
                    $('#btnEditar').show();
                    $('#btnDelete').show();
                    $("#evento").modal("show");
                })
                .catch((error) => { });
        },
        eventDrop: function (ev, delta, revertFunc) {
            //Aquí verifico que no esté seleccionado el botón "Month"
            if (!$('.fc-month-button').hasClass('fc-state-active')) {
                //revierto la operación, esta función no hay que declararla es el 3er parámetro pasado al evento drop
                revertFunc(event);
            }
        }
    });
    // Guardar datos
    document.getElementById("btnGuardar").addEventListener("click", () => {
        enviarDatos("/evento/agregar");
    });
    document.getElementById("btnEditar").addEventListener("click", () => {
        enviarDatos("/evento/update/" + id);
    });
    document.getElementById("btnDelete").addEventListener("click", () => {
        enviarDatos("/evento/delete/" + id);
    });

    function enviarDatos(url) {
        const newurl = baseURL + url;
        const datos = new FormData(formulario);

        axios
            .post(newurl, datos)
            .then((respuesta) => {
                $("#calendar").fullCalendar("refetchEvents");
                $("#evento").modal("hide");
                switch (respuesta.data) {
                    case 1:
                        console.log(respuesta.data);
                        successAlert('error','Cupos agotados.');
                        break;
                    case 2:
                        console.log(respuesta.data);
                        successAlert('success','Su cita ha sido agendada.');
                        break;
                    case 3:
                        console.log(respuesta.data);
                        successAlert('error','No hay turnos disponibles para este horario.');
                        break;
                    default:
                        break;
                }
            })
            .catch((error) => {
                if (error.response) {
                    console.log(error.response.data);
                }
            });
    }
});
$(document).on("click", ".close", () => {
    $("#evento").modal("hide");
    $("#modal-event").modal("hide");
});


function successAlert(icon,title){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });
    Toast.fire({
        icon,
        title
      });
}

function alertCenter(icon, title){
    Swal.fire({
        position: 'top-center',
        icon,
        title,
        showConfirmButton: false,
        timer: 1500
      })
}
