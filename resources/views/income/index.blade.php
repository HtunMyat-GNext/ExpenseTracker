<x-app-layout>
    @push('title')
        ExpenseTrakcker | Income
    @endpush
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight italic ...">
                {{ __("Let's See Your Incomes") }}
            </h2>
            <div class="text-right ml-auto">
                <a href="{{ route('income.create') }}" type="button"
                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">Add
                    Income</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-column flex-wrap md:flex-row mb-3">
                <label for="table-Income" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="search"
                        class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search income">
                </div>
                <div class="relative">
                    <div class="flex justify-end">
                        <div class="flex items-center space-x-3">
                            <input type="text" id="start_date" name="start_date" value="{{ request()['start_date'] }}" type="text"
                                name="date" :placeholder="'Select start date'"
                                class="flatpicker shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" />
                            <input type="text" id="end_date" name="end_date" value="{{ request()['end_date'] }}" type="text"
                                name="date" :placeholder="'Select end date'"
                                class="flatpicker shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" />
                            <button onclick="exportIncome('pdf')"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                                </svg>
                                <span>PDF</span>
                            </button>
                            <button onclick="exportIncome('excel')"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                                </svg>
                                <span>Excel</span>
                            </button>
                        </div>

                    </div>
                </div>

            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" id="income-result">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Income Title
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Amount
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Category
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Image
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($incomes->isEmpty())
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="bg-white dark:bg-gray-800 p-8 font-bold text-lg text-center" colspan="8">
                                    <h3 class="dark:text-gray-400 text-gray-400 mx-auto">No income found!</h3>
                                </td>
                            </tr>
                        @else
                            @php $index = 1; @endphp
                            @foreach ($incomes as $income)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $index++ }}
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $income->title }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $income->amount }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="bg-indigo-100 text-black  font-medium  px-5 py-1 rounded-full dark:bg-indigo-900 dark:text-indigo-300">
                                            {{ $income->category->title ?? '' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <img src="{{ $income->image ? asset('images/' . $income->image) : asset('images/dummy.jpeg') }}"
                                            alt="" class="w-10 h-10 object-cover">
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $income->date ? $income->date : date('Y-m-d', strtotime($income->created_at)) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex">
                                            <a href="{{ route('income.edit', $income->id) }}"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-4">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path fill="#74C0FC"
                                                        d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z" />
                                                </svg></a>
                                            <a href="#" x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', { name: 'confirm-income-deletion', id: {{ $income->id }} })"
                                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path fill="#ce3b6f"
                                                        d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                </svg></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="m-4" id="paginate">
                    {{ $incomes->links() }}
                </div>
            </div>
        </div>
        <x-modal name="confirm-income-deletion" :show="$errors->expenseDeletion->isNotEmpty()" focusable>
            <form method="post" :action="`{{ route('income.destroy', '') }}/${id}`" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to delete this?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your income is deleted, all of its resources and data will be permanently deleted.') }}
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // set up flatpicker
                $(".flatpicker").flatpickr({
                    // "locale": "jp"
                });

                function searchIncome(query, page = 1) {
                    $.ajax({
                        url: '{{ route('income.index') }}',
                        type: 'GET',
                        data: {
                            search: query,
                            page: page,
                        },
                        success: function(data) {
                            $('#income-result').empty();
                            $('#income-result').html(data);
                        },
                        error: function(xhr, status, error) {
                            console.log('AJAX error: ' + status + ' : ' + error);
                        }
                    });
                }

                $('#search').keyup(function() {
                    let query = $(this).val();
                    searchIncome(query);
                });

                $(document).on('click', '#paginate a', function(e) {
                    e.preventDefault();
                    let query = $('#search').val();
                    let page = $(this).attr('href').split('page=')[1];
                    searchIncome(query, page);
                });
            })

            function exportIncome(type) {
                let query = $('#search').val();
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();
                
                if (type === 'excel') {
                    window.location.href = '{{ route('income.export', ['format' => 'xlsx']) }}';
                } else {
                    window.location.href = '{{ route('income.export', ['format' => 'pdf']) }}';
                }
            }
        </script>
    @endpush
</x-app-layout>
