<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Expenses') }}
        </h2>
    </x-slot>

    <x-slot name="button">
        {{-- <a href="{{  }}"
            class="font-semibold  text-gray-800 dark:text-gray-200 bg-slate-900 p-2 rounded hover:bg-white transition hover:text-black">
            {{ __('Create') }}
        </a> --}}
        <form action="{{ route('expenses.create') }}">
            <x-create-button>Create</x-create-button>
        </form>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-gray  border-gray-200">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full  ">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-center bg-slate-800">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('id') }}</span>
                                    </th>
                                    <th class="px-6 py-3 text-center bg-slate-800">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</span>
                                    </th>
                                    <th class="px-6 py-3 text-center bg-slate-800">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</span>
                                    </th>
                                    {{-- <th class="px-6 py-3 text-center bg-slate-800">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Category') }}</span>
                                    </th> --}}
                                    <th class="px-6 py-3 text-center bg-slate-800">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</span>
                                    </th>
                                    <th class="px-6 py-3 text-center bg-slate-800">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</span>
                                    </th>

                                    <th class="px-6 py-3 text-center bg-slate-800">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Image') }}</span>
                                    </th>

                                    <th class="px-6 py-3  bg-slate-800 text-center">
                                        <span
                                            class=" text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-gray divide-y divide-gray-200 divide-solid">
                                {{-- @dd($expenses) --}}

                                @forelse ($expenses as $expense)
                                    {{-- @dd($expense) --}}
                                    <tr class="bg-slate-600">
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                            {{ $expense->user->name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                            {{ \Carbon\Carbon::parse($expense->date)->format('d-m-y') }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                            {{ $expense->amount }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                            {{ $expense->description ?? '' }}
                                        </td>

                                        <td
                                            class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
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

                                        <td class="px-6 py-4 flex justify-center  text-sm leading-5 text-gray-900 ">
                                            <a href="{{ route('expenses.edit', $expense->id) }}">
                                                <svg class="w-5 mx-1" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path fill="#FFD43B"
                                                        d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                                </svg>

                                            </a>

                                            <form action="{{ route('expenses.destroy', $expense->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" {{-- onclick="return confirm('Are you sure you want to delete this expense?')" --}} class="flex items-center">
                                                    <svg class="w-5 mx-1" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                        <path fill="#ff0000"
                                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <div class="flex bg-slate-500 p-8 font-bold text-lg rounded-lg ">
                                        <h3 class="text-gray-700 mx-auto">There is no data yet!</h3>
                                    </div>
                                @endforelse


                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{-- {{ $expenses->links() }} --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
