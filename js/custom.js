// Executar quando o documento HTML for completamente carregado
document.addEventListener('DOMContentLoaded', function() {

    // Receber o SELETOR calendar do atributo id
    var calendarEl = document.getElementById('calendar');

    // Instanciar FullCalendar.Calendar e atribuir a variável calendar
    var calendar = new FullCalendar.Calendar(calendarEl, {

        eventClassNames: function(arg) {
            return arg.event.classNames; // Usa as classes CSS definidas para cada evento
        },

        // Incluir o bootstrap 5
        themeSystem: 'bootstrap5',

        // Criar o cabeçalho do calendário
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        // Definir o idioma usado no calendário
        locale: 'pt-br',

        // Definir a data inicial
        //initialDate: '2023-01-12',
        //initialDate: '2023-10-12',

        // Permitir clicar nos nomes dos dias da semana 
        navLinks: true, 

        // Permitir clicar e arrastar o mouse sobre um ou vários dias no calendário
        selectable: true,

        // Indicar visualmente a área que será selecionada antes que o usuário solte o botão do mouse para confirmar a seleção
        selectMirror: true,

        // Permitir arrastar e redimensionar os eventos diretamente no calendário.
        editable: true,

        // Número máximo de eventos em um determinado dia, se for true, o número de eventos será limitado à altura da célula do dia
        dayMaxEvents: true, 

        // Chamar o arquivo PHP para recuperar os eventos
        events: 'listar_evento.php',

        // Identificar o clique do usuário sobre o evento
        eventClick: function (info) {

            // Receber o SELETOR da janela modal
            const visualizarModal = new bootstrap.Modal(document.getElementById("visualizarModal")); 

            // Enviar para a janela modal os dados do evento
            document.getElementById("visualizar_id").innerText = info.event.id;
            document.getElementById("visualizar_start").innerText = info.event.start.toLocaleString();
            document.getElementById("visualizar_end").innerText = info.event.end.toLocaleString();
            // Abrir a janela modal
            visualizarModal.show();
        }
    });

    calendar.on('eventRender', function(info) {
        // Aqui você pode acessar as propriedades do evento e personalizar sua aparência
        info.el.style.backgroundColor = '#FF5733'; // Altera a cor de fundo
        info.el.style.borderColor = '#FF5733'; // Altera a cor da borda
        info.el.style.borderRadius = '10px'; // Arredonda as bordas
    });
    

    calendar.render();

    document.addEventListener('DOMContentLoaded', function() {

        // Receber o SELETOR calendar do atributo id
        var calendarEl = document.getElementById('calendar');
    
        // Instanciar FullCalendar.Calendar e atribuir a variável calendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
    
            // Restante do seu código FullCalendar aqui...
        });
    
        calendar.render();
    
        
    });
    
});