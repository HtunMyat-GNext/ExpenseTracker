<x-app-layout>
    @push('title')
        ExpenseTrakcker | Event
    @endpush
    <x-slot name="header">
        <h2 class="font-ssssssemibold text-gray-800 dark:text-gray-200 leading-tight italic ...">
            {{ __("Let's See Your Events") }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Search --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-column flex-wrap md:flex-row mb-3">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <x-my-input type="text" :placeholder="__('Search for Event')"
                        class="block px-10 py-2  text-sm border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        id="search">
                    </x-my-input>

                </div>

                <div>
                    <a href="{{ route('events.create') }}" type="button"
                        class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">{{__('Create')}}</a>
                </div>

            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" id="event-result">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{__('No')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__('Title')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__('Color')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__('Created At')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__('Action')}}
                            </th>
                        </tr>
                    </thead>

                    <tbody id="category-table-body">
                        @php
                            $index = 1;
                        @endphp
                        @forelse ($events as $event)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $index++ }}
                                </th>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $event->title }}
                                </th>
                                <td class="px-6 py-4">
                                    <span class="inline-block w-6 h-6 rounded-full"
                                        style="background-color: {{ $event->color }};"></span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $event->created_at }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex">

                                        <a href="{{ route('events.edit', $event->id) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-4"
                                            data-modal-target="default-modal" data-modal-toggle="default-modal">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 512 512">
                                                <path fill="#74C0FC"
                                                    d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9
                                                88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9
                                                2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7
                                                8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4
                                                22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88
                                                64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24
                                                10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z" />
                                            </svg>
                                        </a>

                                        <a href="#" x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', { name: 'confirm-category-deletion', id:{{ $event->id }} })"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 448 512">
                                                <path fill="#ce3b6f" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4
                                                    6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7
                                                    47.9-45L416 128z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="flex bg-stone-100 p-8 font-bold text-sm rounded-lg mt-3 dark:bg-gray-800 dark:text-gray-400">
                                        <h3 class="text-gray-600 mx-auto">There is no event. Let's create now!</h3>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="m-4" id="paginate">
                    {{ $events->links() }}
                </div>
            </div>
        </div>

        <x-modal name="confirm-category-deletion" :show="$errors->categoryDeletion->isNotEmpty()" focusable>
            <form method="post" :action="`{{ route('events.destroy', '') }}/${id}`" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete this?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your event is deleted, all of its resources and data will be permanently deleted.') }}
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Go Back') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete Event') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                /**
                 * Perform an AJAX search for income data based on the provided query and page number.
                 * 
                 * @param {string} query The search query to filter incomes by.
                 * @param {number} page The page number for pagination (default is 1).
                 */
                function searchEvent(query, page = 1) {
                    $.ajax({
                        url: '{{ route('events.index') }}',
                        type: 'GET',
                        data: {
                            search: query,
                            page: page,
                        },
                        success: function(data) {
                            $('#event-result').empty();
                            $('#event-result').html(data);
                        },
                        error: function(xhr, status, error) {
                            console.log('AJAX error: ' + status + ' : ' + error);
                        }
                    });
                }

                // search text when enter keyword on search text box
                $('#search').keyup(function() {
                    let query = $(this).val();
                    searchEvent(query);
                });

                // when click pagination link
                $(document).on('click', '#paginate a', function(e) {
                    e.preventDefault();
                    let query = $('#search').val();
                    let page = $(this).attr('href').split('page=')[1];
                    searchEvent(query, page);
                });
            })
        </script>
    @endpush
</x-app-layout>
