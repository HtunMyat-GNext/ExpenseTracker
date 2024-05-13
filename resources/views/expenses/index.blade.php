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
                                    <th class="px-6 py-3 text-center bg-slate-800">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Category') }}</span>
                                    </th>
                                    <th class="px-6 py-3 text-center bg-slate-800">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</span>
                                    </th>
                                    <th class="px-6 py-3 text-center bg-slate-800">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</span>
                                    </th>

                                    <th class="px-6 py-3  bg-slate-800 text-center">
                                        <span
                                            class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-gray divide-y divide-gray-200 divide-solid">

                                @foreach ($expenses as $expense)
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $expense->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $expense->email }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-slate-600">
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                        {{ 2323 }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                        {{ 2323 }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                        {{ 2323 }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                        {{ 2323 }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                        {{ 2323 }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                        {{ 2323 }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900 text-center">
                                        <form action="{{ route('expenses.edit', 1) }}">
                                            <x-secondary-button :type="'submit'">Edit</x-secondary-button>
                                        </form>
                                        <form action="{{ route('expenses.destroy', 1) }}">
                                            <x-danger-button>Delete</x-danger-button>
                                        </form>
                                    </td>
                                </tr>
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
