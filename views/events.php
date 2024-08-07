<style>
  html,
  body {
    overflow: hidden;
    /* don't do scrollbars */
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }

  .fc-header-toolbar {
    /*
    the calendar will be butting up against the edges,
    but let's scoot in the header's buttons
    */
    padding-top: 1em;
    padding-left: 1em;
    padding-right: 1em;
  }

  header {
    text-align: center;
    padding: 12px 0px 0px 0px;

  }

  @media(max-width: 767px) {
    .fc-toolbar.fc-header-toolbar {
      display: flex;
      flex-direction: column;
    }

    .fc-toolbar.fc-header-toolbar .fc-left {
      order: 3;
    }

    .fc-toolbar.fc-header-toolbar .fc-center {
      order: 1;
    }

    .fc-toolbar.fc-header-toolbar .fc-right {
      order: 2;
    }
  }
</style>


<div id='calendar-container'>
  <header>
    <img src="<?php echo BASE_URL; ?>/assets/img/logo.png" width="150px" /><br />
    <button type="button" class="btn btn-primary" data-bs-target="#eventModal" id="btnNewEvent">
      Adicionar Evento
    </button>
  </header>
  <hr />
  <div id='calendar'></div>
</div>

<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="event-title">Evento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="eventForm">
          <input hidden value="0" id="idEvent" />
          <div class="mb-3">
            <label for="eventTitle" class="form-label">Título</label>
            <input type="text" class="form-control" id="eventTitle" required>
          </div>
          <div class="mb-3">
            <label for="eventDescription" class="form-label">Descrição</label>
            <textarea class="form-control" id="eventDescription" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="eventStart" class="form-label">Início</label>
            <input type="datetime-local" class="form-control" id="eventStart" step="900" required>
          </div>
          <div class="mb-3">
            <label for="eventEnd" class="form-label">Fim</label>
            <input type="datetime-local" class="form-control" id="eventEnd" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" id="btnRemove">Excluir</button>
        <button type="button" class="btn btn-primary" id="btnAdd">Salvar</button>
      </div>
    </div>
  </div>
</div>

<script src=" <?php echo BASE_URL; ?>assets/js/fullcalendar.js"></script>

<script>
  var calendar;
  var modal;

  window.mobilecheck = function() {
    var check = false;
    (function(a) {
      if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
  };

  document.addEventListener('DOMContentLoaded', function() {
    modal = new bootstrap.Modal(document.getElementById('eventModal'));
    loadEvents();

    var btnAdd = document.getElementById('btnAdd');
    var btnNewEvent = document.getElementById('btnNewEvent');
    var btnRemove = document.getElementById('btnRemove');
    btnAdd.addEventListener('click', addEvent);
    btnNewEvent.addEventListener('click', newEvent);
    btnRemove.addEventListener('click', removeEvent);

    const eventStart = document.getElementById('eventStart');
    const eventeend = document.getElementById('eventEnd');
    eventStart.addEventListener('input', function() {
      eventEnd.value = moment(eventStart.value).add(30, "minutes").format("YYYY-MM-DDTHH:mm");
    });

    var calendarElement = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarElement, {
      height: '100%',
      expandRows: true,
      slotMinTime: '08:00',
      slotMaxTime: '20:00',
      locale: 'pt-br',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      initialView: 'listWeek',
      defaultView: window.mobilecheck() ? "basicDay" : "agendaWeek",
      slotLabelFormat: [{
          week: "short"
        }, // top level of text
        {
          weekday: "short"
        } // lower level of text
      ],
      windowResize: function(view) {
        if (window.innerWidth >= 768) {
          calendar.changeView('dayGridMonth');
        } else {
          calendar.changeView('listWeek');
        }
      },
      initialDate: moment().format("YYYY-MM-DD"),
      navLinks: true,
      editable: true,
      selectable: true,
      nowIndicator: true,
      dayMaxEvents: true,
      eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      },
      events: [],

      customRender: true,
      eventRender: function(event, element) {
        element.find('.fc-event-title').append("<br/>" + event.extendedProps.description);
      },
      eventClick: function(info) {
        document.getElementById("idEvent").value = info.event.id;
        document.getElementById("event-title").innerHTML = "Editar evento: " + info.event.title;
        document.getElementById("eventTitle").value = info.event.title;
        document.getElementById("eventDescription").value = info.event.extendedProps.description;
        document.getElementById("eventStart").value = moment(info.event.start).format("YYYY-MM-DD HH:mm");
        document.getElementById("eventEnd").value = moment(info.event.end).format("YYYY-MM-DD HH:mm");
        modal.show();
      }
    });

    calendar.render();
  });
</script>

<script>
  var events = {};

  // Adiciona um novo evento. Se for uma edição, atualiza
  function addEvent() {
    var idEvent = document.getElementById("idEvent").value;
    var title = document.getElementById("eventTitle").value;
    var description = document.getElementById("eventDescription").value;
    var start = document.getElementById("eventStart").value;
    var end = document.getElementById("eventEnd").value;

    if (idEvent != "0")
      document.getElementById("btnRemove").style.display = '';

    if (title == "") {
      message("Informe o título do evento", "error");
      return;
    }
    if (description == "") {
      message("Informe a descrição do evento", "error");
      return;
    }
    if (start == "") {
      message("Informe a data/hora inicial do evento", "error");
      return;
    }
    if (end == "") {
      message("Informe a data/hora final do evento", "error");
      return;
    }
    var data = {
      "title": title,
      "description": description,
      "start_datetime": moment(start).format('YYYY-MM-DDTHH:mm'),
      "end_datetime": moment(end).format('YYYY-MM-DDTHH:mm')
    }

    if (idEvent != "0") {
      fetch(base_url + `events/update/${idEvent}`, {
          method: "PUT",
          body: JSON.stringify(data),
          headers: {
            "Content-type": "application/json;charset=UTF-8"
          }
        }).then(response => response.json())
        .then(json => {
          success = json.success;
          msg = json.message;
          modal.hide();
          if (success) {
            loadEvents();
          } else {
            message(msg, 'error');
          }
        })
        .catch(err => console.log(err));
    } else {
      fetch(base_url + "events/add", {
          method: "POST",
          body: JSON.stringify(data),
          headers: {
            "Content-type": "application/json;charset=UTF-8"
          }
        }).then(response => response.json())
        .then(json => {
          success = json.success;
          msg = json.message;
          modal.hide();
          if (success) {
            loadEvents();
          } else {
            message(msg, 'error');
          }
        })
        .catch(err => console.log(err));
    }
  }

  // Carrega os eventos
  function loadEvents() {
    fetch(base_url + "events/list", {
        method: "GET",
        headers: {
          "Content-type": "application/json;charset=UTF-8"
        }
      }).then(response => response.json())
      .then(json => {
        success = json.success;
        msg = json.message;
        if (success) {
          // Remove todos os eventos
          calendar.removeAllEvents();
          // Adiciona os eventos do banco de dados
          json.data.forEach((row) => {
            calendar.addEvent({
              id: row.id,
              title: row.title,
              description: row.description,
              start: moment(row.start_datetime).format('YYYY-MM-DDTHH:mm'),
              end: moment(row.end_datetime).format('YYYY-MM-DDTHH:mm')
            }, );
          })
        } else {
          message(msg, 'error');
        }


      })
      .catch(err => console.log(err));
  }

  // Limpa os campos
  function clearFields() {
    document.getElementById("idEvent").value = "0";
    document.getElementById("btnRemove").style.display = 'none';
    document.getElementById("event-title").innerHTML = "Novo Evento";
    document.getElementById("eventTitle").value = "";
    document.getElementById("eventDescription").value = "";
    document.getElementById("eventStart").value = moment().format('YYYY-MM-DDTHH:mm');
    document.getElementById("eventEnd").value = moment(eventStart.value).add(30, "minutes").format("YYYY-MM-DDTHH:mm");
  }

  // Chama o modal para criar um novo evento
  function newEvent() {
    clearFields();
    modal.show();
  }

  // Remove o evento selecionado
  function removeEvent() {
    var idEvent = document.getElementById("idEvent").value;
    $.confirm({
      title: 'Exclusão',
      content: 'Confirma exclusão do evento?',
      buttons: {
        SIM: {
          text: 'Sim',
          btnClass: 'btn-blue',
          keys: ['enter', 'shift'],
          action: function() {
            fetch(base_url + `events/delete/${idEvent}`, {
                method: "DELETE",
                headers: {
                  "Content-type": "application/json;charset=UTF-8"
                }
              }).then(response => response.json())
              .then(json => {
                success = json.success;
                msg = json.message;
                modal.hide();
                if (success) {
                  loadEvents();
                } else {
                  message(msg, 'error');
                }
              })
              .catch(err => console.log(err));
          }
        },
        NAO: {
          text: 'Não',
          btnClass: 'btn-red'
        }
      }
    });

  }
</script>

<script>

</script>