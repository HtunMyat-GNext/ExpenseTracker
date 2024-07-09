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
                        <div id='calendar' class="pb-6"></div>
                        <p class="my-6 group text-xs font-semibold pb-1 text-red-700 ">
                            {{ __('To sync google-calendar datas,You need to check Make available to public in your google-calendar ') }}
                            <a href="https://calendar.google.com/calendar/u/0/r/settings?pli=1" target="__blank">
                                <span
                                    class=" group-hover:text-red-600 group-hover:font-extrabold transition-all border-b-red-800 group-hover:border-b-2 group-hover:border-b-red-800">{{ __('setting') }}</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="fixed
                            z-10 inset-0 overflow-y-auto hidden" id="deleteEventModal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">


            <!-- This element is to trick the browser into centering the modal contents. -->
            {{-- <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span> --}}

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class=" bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">

                        <div class="mt-3 text-lg font-medium text-gray-900 dark:text-gray-100">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Are you sure you want to delete this?') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Once your event is deleted, all of its resources and data will be permanently deleted.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 ms-3"
                        id="confirmDeleteBtn">
                        Delete
                    </button>
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                        data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>



    {{-- calendar import --}}
    @vite(['./resources/js/calendar.js'])
    <script type='importmap'>
      {
        "imports": {
          "@fullcalendar/core": "https://cdn.skypack.dev/@fullcalendar/core@6.1.14",
          "@fullcalendar/daygrid": "https://cdn.skypack.dev/@fullcalendar/daygrid@6.1.14"
        }
      }
    </script>

    {{-- calendar --}}
    <script>
        // Pass the PHP variable to JavaScript
        window.userEmail = @json($email);
        // Global object to pass URLs to the calendar.js file
        window.calendarUrls = {
            fetchEvents: '{{ route('calendar.fetch_events') }}',
            storeEvent: '{{ route('calendar.store') }}',
            deleteEvent: '{{ route('calendar.destroy', 'id') }}',
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
</x-app-layout>
