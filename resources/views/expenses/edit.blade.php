<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold  text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create') }}
        </h2>
    </x-slot>
    {{-- @dd($expense) --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-gray  border-gray-200">
                    <div class="min-w-full align-middle">
                        <form action="{{ route('expenses.update', $expense->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name', $expense->name)" autofocus autocomplete="name" />
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
                                    name="date" :value="old('date', \Carbon\Carbon::parse($expense->date)->format('d-m-y'))" />

                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            <!-- Img -->
                            <div class="mt-4">
                                <div class="mt-4">
                                    <x-input-label for="image" :value="__('Image')" />

                                    <x-img-upload type="file" class="block mt-1 w-full" name="image" />
                                    @if ($expense->img)
                                        <div class="mt-2">
                                            <img src="{{ asset($expense->img) }}" alt="Current Image"
                                                class="h-40 w-40 object-cover" id="output">
                                        </div>
                                    @endif
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>

                                <!-- Amount -->
                                <div class="mt-4">
                                    <x-input-label for="amount" :value="__('Amount')" />
                                    <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"
                                        :value="old('amount', $expense->amount)" />
                                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                </div>

                                <!-- Description -->
                                <div class="mt-4">
                                    <x-input-label for="description" :value="__('Description')" />
                                    <x-textarea-input id="description" class="block mt-1 w-full" name="description"
                                        :value="old('description', $expense->description)" />
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>



                                <div class="flex items-center justify-end flex-nowrap mt-4 ">
                                    <x-secondary-button class="" onclick="goBack()">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>
                                    <x-primary-button class="ms-4">
                                        {{ __('Update') }}
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

    $(document).ready(function() {
        $('#img-upload').on('change', function(event) {
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    console.log(e.target.result);
                    $('#output').attr('src', e.target.result);
                };
                let das = reader.readAsDataURL(event.target.files[0]);
                console.FileReader(das);
            }
        });
    });
</script>
