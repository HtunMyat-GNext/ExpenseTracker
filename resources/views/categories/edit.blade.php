<x-app-layout>
    @push('title')
        ExpenseTracker | Categories
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight italic ...">
            {{ __("Let's Update Your Categories") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form class="max-w-sm mx-auto p-5" action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        {{-- title --}}
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            {{ __('Category Title') }}
                        </label>
                        <input type="text" id="title" name="title"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="{{ __('Enter Category') }}" value="{{ old('title', $category->title) }}" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    {{-- color picker --}}
                    <div class="color_picker grid grid-cols-2 gap-1">
                        <label for="hs-color-input" class="block text-sm font-medium mb-3 mt-2 dark:text-white">
                            {{ __('Choose Desired Color') }}
                        </label>
                        <input type="color"
                            class="p-1 h-10 w-full block bg-white border border-gray-300 cursor-pointer 
                            rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-100 
                            dark:border-neutral-100"
                            id="hs-color-input" value="{{ old('color', $category->color) }}" title="Choose your color" name="color">
                    </div>

                    {{-- income / expense radio buttons --}}
                    <div class="income_expense">
                        <label for="categories"
                            class="block mb-2 mt-3 text-sm font-medium text-gray-900 dark:text-white">
                            {{ __('Select Option') }}
                        </label>
                        <div class="flex gap-10">
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center p-3 rounded-full cursor-pointer"
                                    for="income">
                                    <input name="type" type="radio" value="income" id="income"
                                        class="before:content[''] peer relative h-5 w-5 cursor-pointer 
                                           appearance-none rounded-full border border-blue-gray-200 text-green-500 
                                           transition-all before:absolute before:top-2/4 before:left-2/4 before:block 
                                           before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full 
                                           before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-green-500 
                                           checked:before:bg-green-500 hover:before:opacity-10 
                                            {{ old('type', $category->type) === 'income' ? 'checked' : '' }}>" />
                                    <span
                                        class="absolute text-green-500 transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 
                                              -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 16 16"
                                            fill="currentColor">
                                            <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                        </svg>
                                    </span>
                                </label>
                                <label class="mt-px font-light text-sky-400/100 cursor-pointer select-none"
                                    for="income">
                                    {{ __('Income') }}
                                </label>
                            </div>
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center p-3 rounded-full cursor-pointer"
                                    for="expense">
                                    <input name="type" type="radio" value="expense" id="expense"
                                        class="before:content[''] peer relative h-5 w-5 cursor-pointer 
                                           appearance-none rounded-full border border-blue-gray-200 text-red-500 
                                           transition-all before:absolute before:top-2/4 before:left-2/4 before:block 
                                           before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full 
                                           before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-red-500 
                                           checked:before:bg-red-500 hover:before:opacity-10
                                           {{ old('type', $category->type) === 'expense' ? 'checked' : '' }}" />
                                    <span
                                        class="absolute text-red-500 transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 
                                              -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 16 16"
                                            fill="currentColor">
                                            <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                        </svg>
                                    </span>
                                </label>
                                <label class="mt-px font-light text-sky-400/100 cursor-pointer select-none"
                                    for="expense">
                                    {{ __('Expense') }}
                                </label>
                            </div>
                            <div class="inline-flex items-center">
                                <label class="relative flex items-center p-3 rounded-full cursor-pointer"
                                    for="others">
                                    <input name="type" type="radio" value="others" id="others"
                                        class="before:content[''] peer relative h-5 w-5 cursor-pointer 
                                           appearance-none rounded-full border border-blue-gray-200 text-blue-500 
                                           transition-all before:absolute before:top-2/4 before:left-2/4 before:block 
                                           before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full 
                                           before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-blue-500 
                                           checked:before:bg-blue-500 hover:before:opacity-10"
                                           {{ old('type', $category->type) === 'others' ? 'checked' : '' }} />
                                    <span
                                        class="absolute text-blue-500 transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 
                                              -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 16 16"
                                            fill="currentColor">
                                            <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                        </svg>
                                    </span>
                                </label>
                                <label class="mt-px font-light text-sky-400/100 cursor-pointer select-none"
                                    for="others">
                                    {{ __('Others') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Create Or Back Btn --}}
                    <div class="flex items-center justify-between flex-column flex-wrap mt-4">
                        <div class="back_submit">
                            <a href="{{ route('categories.index') }}"
                                class="text-green-700 hover:text-white border border-green-700 
                                hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 
                                font-medium rounded-lg text-sm px-8 py-3 text-center  mb-2 mt dark:border-green-500 
                                dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                {{ __('Go Back') }}
                            </a>
                        </div>
                        <button type="submit"
                            class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 
                            focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-3 text-center  
                            mb-2 mt-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 
                            dark:focus:ring-green-800">
                            {{ __('Create Category') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
