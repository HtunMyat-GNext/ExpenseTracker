<x-app-layout>
    @push('title')
        ExpenseTrakcker | Expense
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight italic ...">
            {{ __("Let's Update Your Expenses") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">


                <form class="max-w-sm mx-auto p-5" action="{{ route('expenses.update', $expense->id) }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- name --}}

                    <div class="mb-5">
                        <x-my-label :value="__('Expense Title')"></x-my-label>
                        <x-my-input :placeholder="__('Expense Title')" name="name" :value="old('name', $expense->name)">
                        </x-my-input>
                    </div>

                    {{-- date picker --}}

                    <div class="mb-5">
                        <x-my-label :value="__('Date')"></x-my-label>
                        <x-my-input id="flatpicker" name="date" type="text" name="date" :placeholder="__('Date')"
                            :value="old('date', \Carbon\Carbon::parse($expense->date)->format('d-m-y'))"></x-my-input>

                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>


                    <!-- Img -->

                    <div class="mb-5">
                        <x-my-label :value="__('Image')"></x-my-label>
                        <x-my-img type="file" class="block mt-1 w-full" name="image" accept="image/*" />

                        <div class="mt-2 flex items-center">
                            <img src="{{ $expense->img ? asset($expense->img) : '' }}" alt="Current Image"
                                class="h-50 w-60 object-cover" id="output"
                                style="display: {{ $expense->img ? 'block' : 'none' }}">
                            <div class="">
                                <button id="remove-btn" type="button"
                                    class="text-green-700 hover:text-white
                                    border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none
                                    focus:ring-green-300 font-sm rounded-lg text-sm px-5 py-2 text-center ms-2
                                    mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white
                                    dark:hover:bg-green-600 dark:focus:ring-green-800 cursor-pointer"
                                    style="display: {{ $expense->img ? 'inline-block' : 'none' }}">{{ __('Remove') }}</button>
                            </div>
                            <span class="invisible text-red-500" id="imgErr"></span>
                            <input type="hidden" name="remove_image" value="" id="remove-image">
                        </div>

                        <x-input-error :messages="$errors->get('img')" class="mt-2" />
                    </div>

                    {{-- amount --}}

                    <div class="mb-5">
                        <x-my-label :value="__('Amount')"></x-my-label>
                        <x-my-input type="number" :placeholder="__('Amount')" name="amount" :value="intval($expense->amount)">
                        </x-my-input>
                    </div>

                    {{-- category --}}

                    <div class="mb-5">
                        <x-my-label :value="__('Select your Category')"></x-my-label>
                        <x-my-select name="category_id" :placeholder="__('Select your Category')">
                            @foreach ($categories as $key => $category)
                                <option value="{{ $key }}"
                                    {{ $expense->category_id == $key ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </x-my-select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />

                    </div>

                    {{-- description --}}

                    <div class="mb-5">
                        <x-my-label :value="__('Description')"></x-my-label>
                        <x-my-textarea type="text" :placeholder="__('Description')" name="description" :value="$expense->description">
                        </x-my-textarea>
                    </div>


                    <div class="flex items-center justify-between  mt-4">
                        <a onclick="window.history.back()"
                            class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center  dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800 cursor-pointer">
                            {{ __('Go Back') }}</a>
                        <button type="submit"
                            class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center  dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                            {{ __('Update') }}
                        </button>


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
            dateFormat: "d-m-Y"
        });
    });

    $(document).ready(function() {
        let output = $('#output');
        let removeBtn = $('#remove-btn');
        let imgUpload = $('#img-upload');
        let removeImage = $('#remove-image')

        imgUpload.on('change', function(event) {
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
                removeBtn.hide();
            }
        });

        // Remove button functionality

        removeBtn.on('click', function() {
            imgUpload.val(''); // Clear the file input value
            output.attr('src', '').hide(); // Clear the src attribute and hide the image
            removeBtn.hide(); // Hide the remove button
            removeImage.val(true); // remove image
        });

        // On loading hide the image and remove button if no image exists
        if (!output.attr('src')) {
            output.hide();
            removeBtn.hide();
        }
    });
</script>
