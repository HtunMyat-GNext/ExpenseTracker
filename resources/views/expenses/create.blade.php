<x-app-layout>
    @push('title')
        ExpenseTrakcker | Expense
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight italic ...">
            {{ __("Let's Create Your Expenses") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">


                <form class="max-w-sm mx-auto p-5" action="{{ route('expenses.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- name --}}

                    <div class="mb-5">
                        <x-my-label :value="__('Expense Title')"></x-my-label>
                        <x-my-input :placeholder="__('Expense Title')" name="name" :value="old('name')">
                        </x-my-input>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    </div>

                    {{-- date picker --}}

                    <div class="mb-5">
                        <x-my-label :value="__('Date')"></x-my-label>
                        <x-my-input id="flatpicker" name="date" :value="old('date')" type="text" name="date"
                            :placeholder="__('Date')">
                        </x-my-input>
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />

                    </div>


                    <!-- Img -->
                    <div class="mb-5">
                        <x-my-label :value="__('Image')"></x-my-label>
                        <x-my-img id="image" type="file" :value="old('img')" class="block mt-1 w-full"
                            name="image" accept="image/*" />
                        <div class="mt-2 flex items-center justify-center">
                            <img src="" alt="Current Image" class="h-50 w-60 object-cover" id="output">
                            <div class="">
                                <button id="remove-btn" type="button"
                                    class="text-green-700 hover:text-white
                                    border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none
                                    focus:ring-green-300 font-sm rounded-lg text-sm px-5 py-2 text-center ms-2
                                    mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white
                                    dark:hover:bg-green-600 dark:focus:ring-green-800 cursor-pointer">Remove</button>
                            </div>
                        </div>
                        <span class="invisible text-red-500" id="imgErr"></span>
                        <x-input-error :messages="$errors->get('img')" class="mt-2" />
                    </div>

                    {{-- amount --}}

                    <div class="mb-5">
                        <x-my-label :value="__('Amount')"></x-my-label>
                        <x-my-input type="number" :value="old('amount')" :placeholder="__('Amount')" name="amount">
                        </x-my-input>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />

                    </div>

                    {{-- category --}}

                    <div class="mb-5">
                        <x-my-select name="category_id" :placeholder="__('Category')">
                            @foreach ($categories as $key => $category)
                                <option value="{{ $key }}" @selected(old('category_id') == $key)>{{ $category }}
                                </option>
                            @endforeach
                        </x-my-select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />

                    </div>

                    {{-- description --}}

                    <div class="mb-5">
                        <x-my-label :value="__('Description')"></x-my-label>
                        <x-my-textarea type="text" :value="old('description')" :placeholder="__('Description')" name="description">
                        </x-my-textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />

                    </div>


                    <div class="flex items-center justify-between  mt-4">
                        <div>
                            <a onclick="goBack()"
                                class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center  dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800 cursor-pointer">
                                {{ __('Go Back') }}</a>
                        </div>
                        <div>
                            <button type="submit"
                                class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center  dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                {{ __('Create Expense') }}
                            </button>
                        </div>
                    </div>
                </form>

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
        $("#flatpicker").flatpickr({
            // "locale": "jp"
        });
    });

    $(document).ready(function() {
        let output = $('#output');
        let removeBtn = $('#remove-btn');
        $('#img-upload').on('change', function(event) {
            var file = event.target.files[0];
            const maxSize = 2048 * 1024;
            if (file.size > maxSize) {
                alert('File size must be less then 2048 KB!');
                $(this).val('');
                output.hide();
                removeBtn.hide();
                return;
            }
            if (event.target.files && event.target.files[0]) {
                var file = event.target.files[0];
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        console.log(e.target.result);
                        output.attr('src', e.target.result);
                        output.show();
                        removeBtn.show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Clear the src attribute and hide the image if the file is not an image
                    output.attr('src', '').hide();
                    $('#imgErr').text("Please choose the correct file.").removeClass(
                        'invisible'); // Show the error message
                    removeBtn.hide();

                }
            } else {
                // Hide the image if no file is selected
                output.attr('src', '').hide();
            }
        });

        // Initially hide the output image
        output.hide();
        removeBtn.hide();

        // Remove button functionality
        $('#remove-btn').on('click', function() {
            $('#img-upload').val(''); // Clear the file input value
            output.attr('src', '').hide(); // Clear the src attribute and hide the image
            removeBtn.hide();
        });
    });
</script>
