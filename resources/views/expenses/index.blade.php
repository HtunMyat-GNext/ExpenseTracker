<x-app-layout>
    @push('title')
        ExpenseTrakcker | Expense
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Expense') }}
        </h2>
    </x-slot>

    <div class="py-12">
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
                    {{-- <form class="flex " method="GET">
                        <div class="mr-2">
                            <x-my-input type="text" :value="request()['search']" :placeholder="'Search for Expense'"
                                name="search"
                                class="block px-10 py-2  text-sm border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </x-my-input>
                        </div>
                        <div>
                            <button type="submit"
                                class="text-teal-700 hover:text-white border border-teal-700 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 font-sm rounded-lg text-sm px-5 py-2 text-center  dark:border-teal-500 dark:text-teal-500 dark:hover:text-white dark:hover:bg-teal-600 dark:focus:ring-teal-800 cursor-pointer">Search</button>
                        </div>
                    </form> --}}
                    <x-my-input type="text" :placeholder="'Search for Expense'"
                        class="block px-10 py-2  text-sm border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        id="search">
                    </x-my-input>

                </div>

                <div>
                    <a href="{{ route('expenses.create') }}" type="button"
                        class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">Create</a>
                </div>

            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    {{-- @dd($expenses->isNotEmpty()) --}}
                    @if ($expenses->isNotEmpty())
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Amount
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Image
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                    @endif

                    <tbody>

                        @forelse ($expenses as $expense)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5  text-center">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- user name --}}
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5  text-center">
                                    {{ $expense->name }}
                                </td>

                                {{-- date --}}
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5  text-center">
                                    {{ \Carbon\Carbon::parse($expense->date)->format('d-m-y') }}
                                </td>

                                {{-- amount --}}
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5  text-center">
                                    {{ intval($expense->amount) ?? '' }}
                                </td>

                                {{-- category --}}
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5  text-center">
                                    <span
                                        class="bg-indigo-100 text-black  font-medium  px-5 py-1 rounded-full dark:bg-indigo-900 dark:text-indigo-300">
                                        {{ $expense->category->title ?? '' }}

                                    </span>
                                </td>

                                {{-- description --}}
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5  text-center">
                                    {{ $expense->description ?? '' }}
                                </td>


                                {{-- image --}}
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5  text-center">
                                    @if ($expense->img)
                                        <a href="{{ asset($expense->img) }}" target="_blank">
                                            <img src="{{ asset($expense->img) }}"
                                                alt="Current Image of {{ $expense->name }}"
                                                class="h-10 w-10 object-cover cursor-pointer mx-auto">
                                        </a>
                                    @else
                                        <img src="{{ asset('images/dummy.jpeg') }}"
                                            class="w-10 h-10 object-cover mx-auto" alt="">
                                    @endif
                                </td>

                                <td class="px-6 py-4 flex justify-center  text-sm leading-5  ">

                                    {{-- edit btn --}}
                                    <a href="{{ route('expenses.edit', $expense->id) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-4"
                                        data-modal-target="default-modal" data-modal-toggle="default-modal">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path fill="#74C0FC"
                                                d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z" />
                                        </svg></a>


                                    {{-- delete btn --}}
                                    <a href="#"
                                        x-on:click.prevent="$dispatch('open-modal', { name: 'confirm-expense-deletion', id: {{ $expense->id }} })"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path fill="#ce3b6f"
                                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td class="bg-white dark:bg-gray-800 p-8 font-bold text-lg rounded-lg text-center"
                                    colspan="8">
                                    <h3 class="dark:text-gray-400 text-gray-400 mx-auto">There is no data!</h3>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $expenses->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- delete confirmation modal --}}
    <x-modal name="confirm-expense-deletion" :show="$errors->expenseDeletion->isNotEmpty()" focusable>
        <form method="post" :action="`{{ route('expenses.destroy', '') }}/${id}`" class="p-6">
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



</x-app-layout>
<script>
    // search function

    $(document).ready(function() {
        $('#search').keyup(function() {
            search();
        });

        function search() {
            var keyword = $('#search').val();
            $.ajax({
                url: '{{ route('expenses.index') }}',
                type: 'GET',
                data: {
                    search: keyword,
                },
                success: function(data) {
                    row(data.expenses.data);
                    console.log(data.expenses.data);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        function row(expenses) {
            let htmlView = '';
            if (expenses.length == 0) {

                // incase no data found

                htmlView += `
                <tr>
                    <td class="bg-white dark:bg-gray-800 p-8 font-bold text-lg rounded-lg text-center" colspan="8">
                        <h3 class="dark:text-gray-400 text-gray-400 mx-auto">No data found!</h3>
                    </td>
                    <div class="flex  ">
                        </div>
                </tr>`;
            } else {

                // searched rows or matched rows

                for (let i = 0; i < expenses.length; i++) {
                    htmlView += `
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-center">
                        ${i + 1}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-center">
                        ${expenses[i].name ?? ''}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-center">
                        ${new Date(expenses[i].date).toLocaleDateString('en-GB')}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-center">
                        ${expenses[i].amount ?? ''}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-center">
                        <span class="bg-indigo-100 text-black font-medium px-5 py-1 rounded-full dark:bg-indigo-900 dark:text-indigo-300">
                            ${expenses[i].category ? expenses[i].category.title : ''}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-center">
                        ${expenses[i].description ?? ''}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-center">
                        ${expenses[i].img ?
                            `<a href="${expenses[i].img}" target="_blank">
                                <img src="${expenses[i].img}" alt="Current Image of ${expenses[i].name}" class="h-10 w-10 object-cover cursor-pointer mx-auto">
                            </a>` :
                            `<img src="/images/dummy.jpeg" class="w-10 h-10 object-cover mx-auto" alt="">
                        `}
                    </td>
                    <td class="px-6 py-4 flex justify-center text-sm leading-5">
                        <a href="/expenses/${expenses[i].id}/edit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-4">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="#74C0FC" d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/>
                            </svg>
                        </a>
                        <a href="#" x-on:click.prevent="$dispatch('open-modal', { name: 'confirm-expense-deletion', id: ${expenses[i].id} })" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="#ce3b6f" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                            </svg>
                        </a>
                    </td>
                </tr>`;
                }
            }
            $('tbody').html(htmlView);
        }
    });
</script>
