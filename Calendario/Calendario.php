<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <link rel="stylesheet" href="../css/calendario.css">
    <link href='./lib/fullcalendar.min.css' rel='stylesheet'/>
    <link href='./lib/fullcalendar.print.css' rel='stylesheet' media='print'/>
    <script src='./lib/jquery.min.js'></script>
    <script src='./lib/moment.min.js'></script>
    <script src='./lib/jquery-ui.custom.min.js'></script>
    <script src='./lib/fullcalendar.min.js'></script>
    <script>
        $(document).ready(function () {
            function fmt(date) {
                return date.format("YYYY-MM-DD HH:mm");
            }

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            $.ajax({
                url: 'events.php',
                success: function (response) {
                    // console.log("Eventos retornados:", response);
                },
                error: function (xhr, status, error) {
                    // console.error("Erro ao recuperar eventos:", error);
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },

                events: "events.php",

                eventRender: function (event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                selectable: true,
                selectHelper: true,
                select: function (start, end, allDay) {
                    var title = prompt('Evento Titulo:');
                    if (title) {
                        var start = fmt(start);
                        var end = fmt(end);
                        // console.log("Dados enviados para o PHP:");
                        // console.log("Título:", title);
                        // console.log("Início:", start);
                        // console.log("Fim:", end);
                        $.ajax({
                            url: 'add_events.php',
                            data: 'title=' + title + '&start=' + start + '&end=' + end,
                            type: "POST",
                            success: function (json) {
                                // console.log("Resposta do PHP:", json);
                            },
                            error: function (xhr, status, error) {
                                // console.error("Erro ao enviar dados para o PHP:", error);
                            }
                        });
                        calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                            true
                        );
                    }
                    calendar.fullCalendar('unselect');
                },

                editable: true,
                eventDrop: function (event, delta) {
                    var start = fmt(event.start);
                    var end = fmt(event.end);
                    // console.log("Evento arrastado. Novos dados:");
                    // console.log("Título:", event.title);
                    // console.log("Novo início:", start);
                    // console.log("Novo fim:", end);
                    $.ajax({
                        url: 'update_events.php',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        success: function (json) {
                            // console.log("Resposta do PHP:", json);
                        }
                    });
                },
                eventClick: function (event) {
                    if (event.id) {
                        // console.log("ID do evento:", event.id);
                        var decision = confirm("Deseja remover o evento?");
                        if (decision) {
                            $.ajax({
                                type: "POST",
                                url: "delete_event.php",
                                data: { id: event.id },
                                success: function (response) {
                                    // console.log(response);
                                    $('#calendar').fullCalendar('removeEvents', event.id);
                                },
                                error: function (xhr, status, error) {
                                    // console.error("Erro ao remover evento:", error);
                                }
                            });
                        }
                    } else {
                        // console.error("Erro: ID do evento não fornecido.");
                    }
                },

                eventResize: function (event) {
                    var start = fmt(event.start);
                    var end = fmt(event.end);
                    // console.log("Evento redimensionado. Novos dados:");
                    // console.log("Título:", event.title);
                    // console.log("Novo início:", start);
                    // console.log("Novo fim:", end);
                    $.ajax({
                        url: 'update_events.php',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        success: function (json) {
                            // console.log("Resposta do PHP:", json);
                        }
                    });
                }
            });
        });
    </script>
</head>
<body>
<div id='calendar'></div>
</body>
</html>
