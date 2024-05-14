<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold  text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-gray  border-gray-200">
                    <div class="min-w-full align-middle">
                        <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name')" autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            {{-- @dd(Auth::user()->id) --}}

                            <!-- Category -->
                            {{-- <div class="mt-4">
                                <x-input-label for="category" :value="__('Category')" />
                                <x-select-input id="category" class="block mt-1 w-full" :placeholder="'Category'" />

                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div> --}}

                            {{-- date picker --}}
                            <div class="mt-4">
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="flatpicker" class="block mt-1 w-full flatpicker" type="text"
                                    name="date" :value="old('date')" />

                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            <!-- Img -->
                            <div class="mt-4">
                                <x-input-label for="img" :value="__('Image')" />
                                <x-img-upload id="image" type="file" class="block mt-1 w-full" name="image" />

                                <x-input-error :messages="$errors->get('img')" class="mt-2" />
                            </div>

                            <!-- Amount -->
                            <div class="mt-4">
                                <x-input-label for="amount" :value="__('Amount')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"
                                    :value="old('amount')" />
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <!-- Description -->

                            <div class="mt-4">
                                <x-input-label for="description" :value="__('Description')" />
                                <x-textarea-input id="description" class="block mt-1 w-full" type="text"
                                    name="description" :value="old('description')" />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>



                            <div class="flex items-center justify-end flex-nowrap mt-4 ">
                                <x-secondary-button class="" onclick="goBack()">
                                    {{ __('Cancel') }}
                                </x-secondary-button>
                                <x-primary-button class="ms-4">
                                    {{ __('Create') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>



                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function goBack() {
        window.history.back()
    }
    $(document).ready(function() {
        $(".flatpicker").flatpickr({
            // "locale": "jp"
        });
    });
</script>
