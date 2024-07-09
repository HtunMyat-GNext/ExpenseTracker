<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <marquee direction="left">
        <img src="{{ asset('/exchange/USD.png') }}" alt="US Flag" class="inline-block">
        <span class="text-xs text-gray-800 dark:text-teal-400 mt-1 mr-2">1 USD = {{ $rates['USD'] }} MMK</span>
        <img src="{{ asset('/exchange/JPY.png') }}" alt="US Flag" class="inline-block">
        <span class="text-xs text-gray-800 dark:text-teal-400 mt-1 mr-2">100 JPY = {{ $rates['JPY'] }} MMK</span>
        <img src="{{ asset('/exchange/SGD.png') }}" alt="US Flag" class="inline-block">
        <span class="text-xs text-gray-800 dark:text-teal-400 mt-1 mr-2">1 SGD = {{ $rates['SGD'] }} MMK</span>
        <img src="{{ asset('/exchange/EUR.png') }}" alt="US Flag" class="inline-block">
        <span class="text-xs text-gray-800 dark:text-teal-400 mt-1 mr-2">1 EUR = {{ $rates['EUR'] }} MMK</span>
        <img src="{{ asset('/exchange/CNY.jpg') }}" alt="US Flag" class="inline-block">
        <span class="text-xs text-gray-800 dark:text-teal-400 mt-1 mr-2">1 CNY = {{ $rates['CNY'] }} MMK</span>
        <img src="{{ asset('/exchange/KRW.jpg') }}" alt="US Flag" class="inline-block">
        <span class="text-xs text-gray-800 dark:text-teal-400 mt-1 mr-2">100 KRW = {{ $rates['KRW'] }} MMK</span>
        <img src="{{ asset('/exchange/MYR.jpg') }}" alt="US Flag" class="inline-block">
        <span class="text-xs text-gray-800 dark:text-teal-400 mt-1 mr-2">1 MYR = {{ $rates['MYR'] }} MMK</span>
        <img src="{{ asset('/exchange/THB.jpg') }}" alt="US Flag" class="inline-block">
        <span class="text-xs text-gray-800 dark:text-teal-400 mt-1 mr-2">1 THB = {{ $rates['THB'] }} MMK</span>
    </marquee>
</div>
