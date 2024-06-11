<x-app-layout>
    @push('title')
        ExpenseTrakcker | Calendar
    @endpush
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight italic ...">
                {{ __('Calendar') }}
            </h2>
            <div class="text-right ml-auto">
                <a href="{{ route('events.index') }}"
                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">See
                    Calendar Events</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-5 gap-4">
                    <div id='external-events' class="col-span-1">
                        <p class="text-center p-4">
                            <strong>Your event lists</strong>
                        </p>
                        @foreach ($events as $event)
                            <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event m-2'>
                                <div class='fc-event-main p-2 text-center p-2 text-center'>{{ $event->title }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div id='calendar-container' class="col-span-4">
                        <div id='calendar'></div>
                    </div>
                </div>
                {{-- <div id='external-events'>
                    <p>
                        <strong>Create Your Events Here</strong>
                    </p>

                    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                        <div class='fc-event-main'>Meeting with Team</div>
                    </div>
                    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                        <div class='fc-event-main'>App Release</div>
                    </div>
                    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                        <div class='fc-event-main'>To do Task</div>
                    </div>
                    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                        <div class='fc-event-main'>Client Meeting</div>
                    </div>
                    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                        <div class='fc-event-main'>My Birthday</div>
                    </div>
                </div>

                <div id='calendar-container'>
                    <div id='calendar'></div>
                </div> --}}
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
            integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var Calendar = FullCalendar.Calendar;
                var Draggable = FullCalendar.Draggable;

                var containerEl = document.getElementById('external-events');
                var calendarEl = document.getElementById('calendar');
                var checkbox = document.getElementById('drop-remove');

                // initialize the external events
                // -----------------------------------------------------------------

                new Draggable(containerEl, {
                    itemSelector: '.fc-event',
                    eventData: function(eventEl) {
                        return {
                            title: eventEl.innerText
                        };
                    }
                });

                // initialize the calendar
                // -----------------------------------------------------------------

                var calendar = new Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    editable: true,
                    droppable: true, // this allows things to be dropped onto the calendar
                    eventColor: 'green'
                });

                calendar.render();
            });
        </script>
    @endpush
</x-app-layout>
