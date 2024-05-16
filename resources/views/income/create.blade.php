<x-app-layout>
    @push('title')
        ExpenseTrakcker | Income
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Income') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">


                <form class="max-w-sm mx-auto p-5" action="{{ route('income.store') }}" method="post">
                    @csrf
                    @method("POST")
                    <div class="mb-5">
                        <label for="income" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter
                            Your Income Title
                        </label>
                        <input type="text" id="income"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="eg. salary" name="title" value="{{ old('title') }}"/>
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>
                    <div class="mb-5">
                        <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter
                            Amount
                        </label>
                        <input type="text" id="amount"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="1000000" name="amount" value="{{ old('amount') }}"/>
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <label for="categories" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                        your Category</label>
                    <select id="categories" name="category_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        <option value="1">Salary</option>
                        <option value="2">Shop</option>
                        <option value="3">Farm</option>
                        <option value="4">Present</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                    <div class="flex items-center justify-between flex-column flex-wrap mt-4">
                        <div>
                            <a href="{{ route('income.index') }}"
                                class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                Back</a>
                        </div>
                        <button type="submit"
                            class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">Create
                            Income
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    </div>
</x-app-layout>
