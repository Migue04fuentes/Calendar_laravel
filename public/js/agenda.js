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

        //Click para agregar cita
        dayClick: function (date, jsEvent, view) {
            formulario.reset();
            var check = date.format();
            var today = moment(new Date()).format();
            if (check >= today) {
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
                document.getElementById("start").value = date.format();
                document.getElementById("end").value = date.format();
            } else {
                alert("No se pueden crear eventos en el pasado.");
            }
        },
        //click en cita asignada
        eventClick: function (calEvent, jsEvent, view) {

            axios
                .post("http://localhost/agenda/public/evento/editar/" + calEvent.id)
                .then((respuesta) => {
                    formulario.title.value = respuesta.data.title;
                    formulario.description.value = respuesta.data.description;
                    formulario.start.value = respuesta.data.start;
                    formulario.end.value = respuesta.data.end;
                    id = respuesta.data.id;
                    $("#evento").modal("show");
                })
                .catch((error) => {});
        },
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
        console.log(datos);

        axios
            .post(newurl, datos)
            .then((respuesta) => {
                $("#calendar").fullCalendar("refetchEvents");
                $("#evento").modal("hide");
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
