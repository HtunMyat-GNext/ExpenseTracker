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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">


                <form class="max-w-sm mx-auto p-5" action="{{ route('expenses.store') }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    {{-- name --}}

                    <div class="mb-5">
                        <x-my-label :value="'Enter name'"></x-my-label>
                        <x-my-input :placeholder="'name'" name="name">
                        </x-my-input>
                    </div>

                    {{-- date picker --}}

                    <div class="mb-5">
                        <x-my-label :value="'Enter Date'"></x-my-label>
                        <x-my-input id="flatpicker" name="date" type="text" name="date"
                            :placeholder="'Date'"></x-my-input>
                    </div>


                    <!-- Img -->
                    <div class="mb-5">
                        <x-my-label :value="'Choose your image'"></x-my-label>
                        <x-my-img id="image" type="file" class="block mt-1 w-full" name="image" />
                        <div class="mt-2 flex items-center">
                            <img src="" alt="Current Image" class="h-40 w-40 object-cover" id="output">
                            <div class="">
                                <button id="remove-btn" type="button"
                                    class="ml-2 bg-red-500 text-white px-2 py-1 text-sm rounded">Remove</button>
                            </div>
                        </div>

                        <x-input-error :messages="$errors->get('img')" class="mt-2" />
                    </div>

                    {{-- amount --}}

                    <div class="mb-5">
                        <x-my-label :value="'Enter Amount'"></x-my-label>
                        <x-my-input type="number" :placeholder="'amount'" name="amount">
                        </x-my-input>
                    </div>

                    {{-- description --}}

                    <div class="mb-5">
                        <x-my-label :value="'Enter Description'"></x-my-label>
                        <x-my-textarea type="text" :placeholder="'description'" name="description">
                        </x-my-textarea>
                    </div>


                    <div class="flex items-center justify-between  mt-4">
                        <div>
                            <a href="{{ route('income.index') }}"
                                class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                Back</a>
                        </div>
                        <div>
                            <button type="submit"
                                class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">Create
                                Expense
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