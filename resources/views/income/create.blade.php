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


                <form class="max-w-sm mx-auto p-5" action="{{ route('income.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="mb-5">
                        <label for="income" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter
                            Your Income Title
                        </label>
                        <input type="text" id="income"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="eg. salary" name="title" value="{{ old('title') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>
                    <div class="mb-5">
                        <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter
                            Amount
                        </label>
                        <input type="text" id="amount"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="1000000" name="amount" value="{{ old('amount') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <div class="mb-5">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter
                            date
                        </label>
                        <input type="date" id="flatpicker" name="date" value="{{ old('date') }}" type="text" name="date"
                            :placeholder="'Date'"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" />
                    </div>

                    <div class="mb-5">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload
                            photo
                        </label>
                        <input type="file" id="image"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="1000000" name="image" value="{{ old('image') }}" />
                        <div class="mt-2 flex items-center justify-center">
                            <img src="" alt="Current Image" class="h-50 w-60 object-cover" id="output">
                            <div class="">
                                <button id="remove-btn" type="button"
                                    class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Remove</button>
                            </div>
                        </div>
                    </div>

                    <label for="categories" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                        your Category</label>
                    <select id="categories" name="category_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($categories as $category)
                        <option value={{ $category->id }}>{{ $category->title }}</option>
                        @endforeach
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
    @push('scripts')
    <script>
        $(document).ready(function() {
                $("#flatpicker").flatpickr({
                    // "locale": "jp"
                });

                let output = $('#output');
                let removeBtn = $('#remove-btn');
                $('#image').on('change', function(event) {
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
                    $('#image').val(''); // Clear the file input value
                    output.attr('src', '').hide(); // Clear the src attribute and hide the image
                    removeBtn.hide();
                });
            });
    </script>
    @endpush
</x-app-layout>