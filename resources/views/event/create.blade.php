<x-app-layout>
    @push('title')
        ExpenseTrakcker | Event | Create
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight italic ...">
            {{ __("Let's Create Your Event") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <form class="max-w-sm mx-auto p-5" method="POST" action="{{ route('events.store') }}">
                    @csrf
                    {{-- validation error for can't create same title, same income --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-5">

                        {{-- title --}}
                        <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Event Title
                        </label>

                        <input type="text" id="title" name="title"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="Enter Category" value="{{ old('title') }}" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    {{-- color picker --}}
                    <div class="color_picker grid grid-cols-2 gap-1">
                        <label for="hs-color-input" class="block text-sm font-medium mb-3 mt-2 dark:text-white">
                            Choose Desire Color
                        </label>

                        <input type="color"
                            class="p-1 h-10 w-full block bg-white border border-gray-300 cursor-pointer 
                            rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-100 
                            dark:border-neutral-100"
                            id="hs-color-input" value="{{ old('color', '') }}" title="Choose your color" name="color">
                    </div>
                    {{-- Create Or Back Btn --}}
                    <div class="flex items-center justify-between flex-column flex-wrap mt-4">
                        <div class="back_submit">
                            <a href="{{ route('events.index') }}"
                                class="text-green-700 hover:text-white border border-green-700 
                                hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 
                                font-medium rounded-lg text-sm px-8 py-3 text-center  mb-2 mt dark:border-green-500 
                                dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                Back
                            </a>
                        </div>

                        <button type="submit"
                            class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 
                            focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-3 text-center  
                            mb-2 mt-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 
                            dark:focus:ring-green-800">
                            Create Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
