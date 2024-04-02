document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 650,
        events: '../calendario/fetchEvents.php',
        // Adicione o resto do código aqui conforme necessário
    });

    calendar.render();
});
