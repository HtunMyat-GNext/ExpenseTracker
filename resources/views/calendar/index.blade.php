<x-app-layout>
    @push('title')
        ExpenseTracker | Calendar
    @endpush
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight italic ...">
                {{ __('Calendar') }}
            </h2>
            <div class="text-right ml-auto">
                <a href="{{ route('events.index') }}"
                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                    {{ __('See Calendar Events') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 dark:text-white overflow-hidden shadow-md sm:rounded-lg p-8">
                <div class="grid grid-cols-5 gap-4">
                    <div id='external-events' class="col-span-1">
                        <p class="text-center p-4">
                            <strong>{{ __('Your event lists') }}</strong>
                        </p>
                        @foreach ($events as $event)
                            <div id="fc-event" class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event m-2'
                                style="background: {{ $event->color }};"
                                data-event='{"id":"{{ $event->id }}","title": "{{ $event->title }}", "color": "{{ $event->color }}"}'>
                                <div class='fc-event-main p-2 text-center'>{{ $event->title }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div id='calendar-container' class="col-span-4">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;

            var containerEl = document.getElementById('external-events');
            var calendarEl = document.getElementById('calendar');



            // initialize the external events
            new Draggable(containerEl, {
                itemSelector: '#fc-event',
                eventData: function(eventEl) {
                    var eventData = JSON.parse(eventEl.getAttribute('data-event'));
                    return {
                        title: eventData.title,
                        color: eventData.color
                    };
                }
            });

            // initialize the calendar
            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: fetchEvents, // Fetch events from the server
                editable: false,
                droppable: true, // allows things to be dropped onto the calendar

                // delete if event clicked
                eventClick: function(calendar) {
                    eventDelete(calendar.event.id);
                },

                // save data to calendar if event is dropped onto calendar
                eventReceive: function(dropData) {
                    // Event data
                    let eventData = JSON.parse(dropData.draggedEl.dataset.event);
                    let eventDate = dropData.event.startStr;

                    // Remove the event immediately after it's dropped
                    dropData.event.remove();

                    // AJAX request to save event data
                    saveEvent(eventData, eventDate, function() {
                        calendar.refetchEvents();
                    });

                },
            });

            // fetch created events from the server
            function fetchEvents(datas, successCallback, failureCallback) {
                $.ajax({
                    url: '{{ route('calendar.fetch') }}', // Adjust this to your route for fetching events
                    type: 'GET',
                    success: function(data) {
                        successCallback(data);
                    },
                    error: function(xhr, status, error) {
                        failureCallback(error);
                    }
                });
            }


            // Function to save event data
            function saveEvent(eventData, date, refetch) {
                $.ajax({
                    url: '{{ route('calendar.store') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        event_id: eventData.id,
                        date: date
                    },
                    success: function(data) {
                        console.log('Event saved successfully:', data);
                        refetch();
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX error: ' + status + ' : ' + error);
                    }
                });
            }

            // delete event
            function eventDelete(eventId) {
                var url = `{{ route('calendar.destroy', 'id') }}`;
                url = url.replace('id', eventId);
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: eventId
                    },
                    success: function(data) {
                        console.log('Event deleted successfully:', data);
                        calendar.refetchEvents();

                    },
                    error: function(xhr, status, error) {
                        failureCallback(error);
                    }
                })
            }
            calendar.render();
        });
    </script>
</x-app-layout>
