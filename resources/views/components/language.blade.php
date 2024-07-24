<div x-data="{ open: false }" @keydown.escape="open = false" class="relative">
    <button @click="open = !open" class="px-4 py-2">
        <svg width="20" height="20" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg"
            aria-labelledby="languageIconTitle" :stroke="darkMode ? '#ffffff' : '#000000'" stroke-width="1"
            stroke-linecap="square" stroke-linejoin="miter" fill="none" :color="darkMode ? '#ffffff' : '#000000'">
            <title id="languageIconTitle">Language</title>
            <circle cx="12" cy="12" r="10" />
            <path stroke-linecap="round"
                d="M12,22 C14.6666667,19.5757576 16,16.2424242 16,12 C16,7.75757576 14.6666667,4.42424242 12,2 C9.33333333,4.42424242 8,7.75757576 8,12 C8,16.2424242 9.33333333,19.5757576 12,22 Z" />
            <path stroke-linecap="round" d="M2.5 9L21.5 9M2.5 15L21.5 15" />
        </svg>
    </button>
    <div x-show="open" @click.away="open = false"
        class="absolute right-0 mt-2 w-30 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10">
        <a href="{{ route('language.switch', ['locale' => 'en']) }}"
            class="block px-4 py-2 hover:bg-gray-100 text-sm font-md"> <img src="{{ asset('logo/en.png') }}"
                alt=""></a>
        <a href="{{ route('language.switch', ['locale' => 'ja']) }}"
            class="block px-4 py-2 hover:bg-gray-100 text-sm font-md"> <img src="{{ asset('logo/jp.png') }}"
                alt=""></a>
        <!-- Add more language options as needed -->
    </div>
</div>
