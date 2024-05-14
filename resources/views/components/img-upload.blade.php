@props(['disabled' => false, 'db_image' => null])

<div>
    <input type="file" id="img-upload" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'block w-full text-sm text-gray-900 border border-gray-300 rounded cursor-pointer dark:text-gray-400 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm dark:text-gray-300 dark:bg-gray-900 dark:border-gray-700 p-3',
    ]) !!}>

    @if ($db_image)
        <div class="mt-2">
            <img src="{{ $db_image }}" alt="Current Image" class="h-40 w-40 object-cover">
        </div>
    @endif
</div>
