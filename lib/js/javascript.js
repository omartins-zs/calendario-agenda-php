(function (win, doc) {
    'use strict';

    doc.addEventListener('DOMContentLoaded', function () {
        let calendarEl = doc.querySelector('.calendar');
        if (!calendarEl) return;

        // Base URL da aplicação
        let baseUrl = (win.APP_CONFIG && win.APP_CONFIG.dirpage) ? win.APP_CONFIG.dirpage : '/';
        let eventsEndpoint = baseUrl + 'controllers/ControllerEvents.php';

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'standard',
            headerToolbar: {
                start: 'prev,next today',
                center: 'title',
                end: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hoje',
                month: 'Mês',
                week: 'Semana',
                day: 'Dia'
            },
            locale: 'pt-br',
            navLinks: true,
            editable: true,
            selectable: true,
            selectMirror: true,
            dayMaxEvents: true,

            // Busca eventos dinâmicos do backend
            events: {
                url: eventsEndpoint,
                failure: function () {
                    console.warn('Falha ao carregar eventos da API. Usando fallback local.');
                }
            },

            // Clique em uma data vazia: abrir modal ou cadastrar evento
            dateClick: function (info) {
                openEventModal({
                    start: info.dateStr,
                    end: info.dateStr,
                    allDay: !info.dateStr.includes('T')
                });
            },

            // Clique em um evento existente
            eventClick: function (info) {
                let event = info.event;
                let details = `📌 ${event.title}\n` +
                    `📅 Início: ${event.start ? event.start.toLocaleString('pt-BR') : ''}\n` +
                    (event.end ? `🏁 Fim: ${event.end.toLocaleString('pt-BR')}\n` : '') +
                    (event.extendedProps.description ? `📝 Descrição: ${event.extendedProps.description}\n` : '');

                if (confirm(details + '\n\nDeseja excluir este evento?')) {
                    deleteEvent(event.id, function () {
                        event.remove();
                    });
                }
            },

            // Arrastar e soltar evento para nova data
            eventDrop: function (info) {
                updateEventDates(info.event);
            },

            // Redimensionar duração do evento
            eventResize: function (info) {
                updateEventDates(info.event);
            }
        });

        calendar.render();

        // Funções auxiliares de integração com o Backend
        function updateEventDates(event) {
            let start = event.startStr;
            let end = event.endStr || event.startStr;

            fetch(eventsEndpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'update_dates',
                    id: event.id,
                    start: start,
                    end: end
                })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert('Erro ao atualizar data do evento.');
                    calendar.refetchEvents();
                }
            })
            .catch(() => {
                calendar.refetchEvents();
            });
        }

        function deleteEvent(id, onSuccess) {
            fetch(eventsEndpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'delete',
                    id: id
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (onSuccess) onSuccess();
                } else {
                    alert('Não foi possível excluir o evento.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Erro de conexão ao excluir evento.');
            });
        }

        // Modal para criação de novos eventos
        let modal = doc.getElementById('modalEvent');
        let form = doc.getElementById('formNewEvent');
        let btnNewEvent = doc.getElementById('btnOpenModal');
        let btnCloseModal = doc.getElementById('btnCloseModal');
        let btnCancelModal = doc.getElementById('btnCancelModal');

        function openEventModal(initialData) {
            if (!modal) {
                // Fallback rápido se não houver modal no HTML
                let title = prompt('Título do Evento:');
                if (title) {
                    createQuickEvent(title, initialData.start, initialData.end);
                }
                return;
            }

            if (form) {
                form.reset();
                if (initialData.start) {
                    let startField = doc.getElementById('event_start');
                    if (startField) startField.value = initialData.start;
                }
                if (initialData.end) {
                    let endField = doc.getElementById('event_end');
                    if (endField) endField.value = initialData.end;
                }
            }
            modal.style.display = 'flex';
        }

        function closeModal() {
            if (modal) modal.style.display = 'none';
        }

        if (btnNewEvent) btnNewEvent.addEventListener('click', () => openEventModal({}));
        if (btnCloseModal) btnCloseModal.addEventListener('click', closeModal);
        if (btnCancelModal) btnCancelModal.addEventListener('click', closeModal);

        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                let title = doc.getElementById('event_title').value;
                let start = doc.getElementById('event_start').value;
                let end = doc.getElementById('event_end').value;
                let description = doc.getElementById('event_description').value;
                let color = doc.getElementById('event_color').value;

                fetch(eventsEndpoint, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'create',
                        title: title,
                        start: start,
                        end: end || start,
                        description: description,
                        color: color
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        closeModal();
                        calendar.refetchEvents();
                    } else {
                        alert(data.message || 'Erro ao salvar evento.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Erro de comunicação ao salvar evento.');
                });
            });
        }

        function createQuickEvent(title, start, end) {
            fetch(eventsEndpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'create',
                    title: title,
                    start: start,
                    end: end || start
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    calendar.refetchEvents();
                }
            });
        }
    });
})(window, document);
