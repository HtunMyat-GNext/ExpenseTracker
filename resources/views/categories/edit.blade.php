<x-app-layout>
    @push('title')
        ExpenseTrakcker | Categories
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

                    {{-- title --}}
                    <div class="mb-5">
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Category Title
                        </label>

                        <input type="text" id="title"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                            dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="Enter Category" value="{{ old('title', $category->title) }}" name="title" />
                    </div>

                    {{-- color picker --}}
                    <div class="color_picker grid grid-cols-2 gap-1">
                        <label for="hs-color-input" class="block text-sm font-medium mb-3 mt-2 dark:text-white">Choose
                            Your Color</label>
                        <input type="color"
                            class="p-1 h-10 w-full block bg-white border border-gray-300 cursor-pointer rounded-lg 
                            disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-100 dark:border-neutral-100"
                            id="hs-color-input" value="{{ old('color') }}" title="Choose your color" name="color">
                    </div>

                    {{-- color picker --}}
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Select Option
                    </label>

                    {{-- income / expense radio button  --}}
                    <div class="flex gap-10">
                        <div class="inline-flex items-center">
                            <label class="relative flex items-center p-3 rounded-full cursor-pointer" htmlFor="green">
                                <input name="is_income" type="radio" checked value="1"
                                    class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border
                                     border-blue-gray-200 text-green-500 transition-all before:absolute before:top-2/4 before:left-2/4 
                                     before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full
                                     before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-green-500 checked:before:bg-green-500 
                                     hover:before:opacity-10 "
                                    id="income" {{ old('is_income', $category->is_income) == 1 ? 'checked' : '' }} />

                                <span
                                    class="absolute text-green-500 transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 
                                    -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 16 16"
                                        fill="currentColor">
                                        <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                    </svg>
                                </span>
                            </label>

                            <label class="mt-px font-light text-sky-400/100 cursor-pointer select-none" htmlFor="html" for="income">
                                Income
                            </label>

                        </div>

                        <div class="inline-flex items-center">
                            <label class="relative flex items-center p-3 rounded-full cursor-pointer" htmlFor="green">
                                <input name="is_income" type="radio" value="0"
                                    class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-full border 
                                    border-blue-gray-200 text-green-500 transition-all before:absolute before:top-2/4 before:left-2/4 
                                    before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full 
                                    before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-green-500 checked:before:bg-green-500 
                                    hover:before:opacity-10"
                                    id="expense" {{ old('is_income', $category->is_income) == 0 ? 'checked' : '' }} />

                                <span
                                    class="absolute text-green-500 transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 -translate-y-2/4 
                                        -translate-x-2/4 peer-checked:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="currentColor">
                                        <circle data-name="ellipse" cx="8" cy="8" r="8"></circle>
                                    </svg>
                                </span>
                            </label>

                            <label class="mt-px font-light text-sky-400/100 cursor-pointer select-none" htmlFor="html" for="expense">
                                Expense
                            </label>
                        </div>
                    </div>

                    {{-- validation error for can't create same title, same income --}}
                    @error('is_income')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Save Or Back Btn --}}
                    <div class="flex items-center justify-between flex-column flex-wrap mt-4">
                        <div class="save_back">
                            <a href="{{ route('categories.index') }}"
                                class="text-green-700 hover:text-white border border-green-700 
                                hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 
                                font-medium rounded-lg text-sm px-8 py-3 text-center dark:border-green-500 
                                dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                Back
                            </a>
                        </div>

                        <button type="submit"
                            class="text-green-700 hover:text-white border border-green-700 
                            hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 
                            font-medium rounded-lg text-sm px-8 py-3 text-center dark:border-green-500 
                            dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
