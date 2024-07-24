<x-app-layout>
    @push('title')
        ExpenseTrakcker | Currency Exchange
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight italic ...">
            {{ __("Let's Calculate Currency Rates") }}
        </h2>
    </x-slot>
    <div class="py-12 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 te">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form class="max-w-sm mx-auto p-5" action="{{ route('income.store') }}" method="post"
                    enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 dark:text-gray-200">Amount</label>
                        <input type="number" id="amount"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="Enter amount">
                    </div>
                    <div class="mb-4">
                        <label for="from-currency" class="block text-gray-700 dark:text-gray-200">From</label>
                        <select id="from-currency"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light">
                            <option value="USD">USD</option>
                            <option value="JPY">JPY</option>
                            <option value="SGD">SGD</option>
                            <option value="EUR">EUR</option>
                            <option value="CNY">CNY</option>
                            <option value="KRW">KRW</option>
                            <option value="MYR">MYR</option>
                            <option value="THB">THB</option>
                            <!-- Add more currencies as needed -->
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="to-currency" class="block text-gray-700 dark:text-gray-200">To</label>
                        <select id="to-currency"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light">
                            <option value="MMK">MMK</option>
                            <!-- Add more currencies as needed -->
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="result" class="block text-gray-700 dark:text-gray-200">Result</label>
                        <input type="text" id="result"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="Result" readonly>
                        <span class="mt-4 text-xs text-rose-800 dark:text-teal-400">
                            ⁂ Reference Exchange Rate From CBM
                        </span>
                    </div>
                </form>

            </div>
        </div>
        @push('scripts')
            <script>
                function calculateExchange() {
                    let rates = @json($rates);
                    let result;
                    const amount = parseFloat(document.getElementById('amount').value);
                    const fromCurrency = document.getElementById('from-currency').value;
                    const toCurrency = document.getElementById('to-currency').value;
                    if (!isNaN(amount) && fromCurrency && toCurrency) {
                        result = amount * rates[fromCurrency].replace(/,/g, "");
                        if (fromCurrency == "KRW" || fromCurrency == "JPY") {
                            result = result / 100;
                        }
                        document.getElementById('result').value = result.toFixed(2) + ' Kyats';
                    } else {
                        document.getElementById('result').value = 'Invalid input';
                    }
                }
                document.getElementById('amount').addEventListener('input', calculateExchange);
                document.getElementById('from-currency').addEventListener('change', calculateExchange);
            </script>
        @endpush
</x-app-layout>
