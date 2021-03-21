/**
 * To use calendar, make use of: <div id='calendar'></div>
 * To use time-calendar, make use of div#time-calendar
 * @type {HTMLElement}
 */

let selectedElement = null;
let selected = false;
let createdElement = null;

/*********************
 **  Days calendar  **
 *********************/
let calendarEl = document.getElementById('calendar');

if(calendarEl) {
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'fr',
        nowIndicator: true,
        showNonCurrentDates: false,
        slotMinTime: "08:00:00",
        slotMaxTime: "18:00:00",
        slotDuration: "0:30:00",
        allDaySlot: false,

        events: {
            url : '/index.php?page=events',
        },

        dateClick: (date) => {
            if(calendarEl.classList.contains('calendar-no-select')) {
                return;
            }
            let nearest = document.elementFromPoint(date.jsEvent.x + window.scrollX, date.jsEvent.y + window.scrollY);
            console.log(date.jsEvent);
            let nearestBoundaries = nearest.getBoundingClientRect();
            let dayBoundaries = date.dayEl.getBoundingClientRect();

            if(!selected && !date.date.toString().startsWith('Sun') && !date.date.toString().startsWith('Sat')) {
                selected = true;
                selectedElement = date.dayEl;
                createdElement = document.createElement('div');
                createdElement.style.position = 'absolute';
                createdElement.style.top = Math.trunc(nearestBoundaries.y).toString() + 'px';
                createdElement.style.left = Math.trunc(dayBoundaries.x).toString() + 'px';
                createdElement.style.backgroundColor = "#6c9bc3";
                createdElement.style.width = dayBoundaries.width.toString() + 'px';
                createdElement.style.height = nearestBoundaries.height.toString() + 'px';
                document.body.append(createdElement);

                let input = document.getElementById('form-date');
                if(!input) {
                    // Création d'un input hidden s'il n'existe pas.
                    input = document.createElement('input');
                    document.getElementsByTagName('form')[0].append(input);
                }

                input.name = 'form-date';
                input.type = 'hidden';
                input.id = 'form-date';
                input.value = date.dateStr.replace('T', ' ');

            }
            else if(selectedElement !== null) {
                if(selectedElement.dataset.date === date.dayEl.dataset.date) {
                    selected = false;
                    if(createdElement) {
                        document.getElementById('form-date').value = '';
                        createdElement.remove();
                    }
                }
            }
        },
    });
    calendar.render();
}