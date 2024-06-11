<x-app-layout>
    @push('title')
        ExpenseTrakcker | Dashboard
    @endpush
    <x-slot name="header">
        <h3 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight italic ...">
            {{ __("Let's See Your Incomes & Expenses Data") }}
        </h3>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- filter serach !-->
                <form action="{{ route('dashboard') }}" method="GET">
                    @csrf
                    @method('GET')
                    <div class="flex pt-6 pr-6 pl-6 items-center justify-end">
                        <div class="relative">
                            <input type="text" name="start_date" value="{{ request()['start_date'] }}" type="text"
                                name="date" :placeholder="'Select start date'"
                                class="flatpicker shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" />
                        </div>
                        <span class="mx-4 text-gray-500">To</span>
                        <div class="relative">
                            <input type="text" name="end_date" value="{{ request()['end_date'] }}" type="text"
                                name="date" :placeholder="'Select end date'"
                                class="flatpicker shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" />
                        </div>
                        <div class="relative ml-2 mt-2">
                            <button
                                class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">Filter</button>
                        </div>
                    </div>
                </form>
                <!-- end filter serach !-->
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <div class="w-full sm:w-1/2 p-4">
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg px-6 py-8 ring-1 ring-slate-900/5 shadow-xl text-center">
                            <a href="{{ route('income.index') }}">
                                <div>
                                    <span class="inline-flex items-center justify-center p-2 rounded-md">
                                        <svg class="h-12 w-12 animate-shake" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 512 512">
                                            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path fill="#74C0FC"
                                                d="M320 96H192L144.6 24.9C137.5 14.2 145.1 0 157.9 0H354.1c12.8 0 20.4 14.2 13.3 24.9L320 96zM192 128H320c3.8 2.5 8.1 5.3 13 8.4C389.7 172.7 512 250.9 512 416c0 53-43 96-96 96H96c-53 0-96-43-96-96C0 250.9 122.3 172.7 179 136.4l0 0 0 0c4.8-3.1 9.2-5.9 13-8.4zm84 88c0-11-9-20-20-20s-20 9-20 20v14c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V424c0 11 9 20 20 20s20-9 20-20V410.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l0 0-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V216z" />
                                        </svg>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="text-title-md font-bold text-black dark:text-white mt-4">
                                        {{__('Income')}}
                                    </h4>
                                </div>
                                <div>
                                    <h4 class="text-title-md font-bold text-black dark:text-white mt-4">
                                        {{ number_format($incomes, 0) }} Ks
                                    </h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="w-full sm:w-1/2 p-4">
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg px-6 py-8 ring-1 ring-slate-900/5 shadow-xl text-center">
                            <a href="{{ route('expenses.index') }}">
                                <div>
                                    <span class="inline-flex items-center justify-center p-2 rounded-md">
                                        <svg class="h-12 w-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path fill="#74C0FC"
                                                d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="text-title-md font-bold text-black dark:text-white mt-4">
                                        {{__('Expense')}}
                                    </h4>
                                </div>
                                <div>
                                    <h4 class="text-title-md font-bold text-black dark:text-white mt-4">
                                        {{ number_format($expenses, 0) }} Ks
                                    </h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="w-full sm:w-1/2 p-4">

                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg px-6 py-8 ring-1 ring-slate-900/5 shadow-xl text-center">
                            <a href="{{ route('categories.index') }}">
                                <div>
                                    <span class="inline-flex items-center justify-center p-2 rounded-md">
                                        <svg class="h-12 w-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path fill="#74C0FC"
                                                d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z" />
                                        </svg>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="text-title-md font-bold text-black dark:text-white mt-4">
                                       {{__('Categories')}}
                                    </h4>
                                </div>
                                <div>
                                    <h4 class="text-title-md font-bold text-black dark:text-white mt-4">
                                        You have {{ $categories }} Categories
                                    </h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="w-full sm:w-1/2 p-4">
                        <div
                            class="bg-white dark:bg-slate-800 rounded-lg px-6 py-8 ring-1 ring-slate-900/5 shadow-xl text-center">
                            <div>
                                <span class="inline-flex items-center justify-center p-2 rounded-md">
                                    <svg class="h-12 w-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path fill="#74C0FC"
                                            d="M128 0c13.3 0 24 10.7 24 24V64H296V24c0-13.3 10.7-24 24-24s24 10.7 24 24V64h40c35.3 0 64 28.7 64 64v16 48V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V192 144 128C0 92.7 28.7 64 64 64h40V24c0-13.3 10.7-24 24-24zM400 192H48V448c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V192zM329 297L217 409c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47 95-95c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                                    </svg>
                                </span>
                            </div>
                            <div>
                                <h4 class="text-title-md font-bold text-black dark:text-white mt-4">
                                   {{__('Events')}}
                                </h4>
                            </div>
                            <div>
                                <h4 class="text-title-md font-bold text-black dark:text-white mt-4">
                                    You can see your <a href="{{ route('calendar') }}">Events</a> here.
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- start pic chart section !-->
                <div
                    class="relative flex flex-col rounded-xl bg-white dark:bg-gray-800 bg-clip-border text-gray-700 shadow-md">
                    <div class="py-6 mt-4 grid place-items-center px-2">
                        <div class="w-full md:w-3/4 lg:w-1/2 xl:w-1/3 mx-auto">
                            <div id="pie-chart" class="h-auto"></div>
                        </div>
                    </div>
                </div>
                <!-- end pic chart section !-->
            </div>
        </div>
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script>
                $(document).ready(function() {
                    // set up flatpicker
                    $(".flatpicker").flatpickr({
                        // "locale": "jp"
                    });
                    // set up piechart
                    const categories = @json($categories_data);
                    //category total amounts
                    const amounts = categories.map((category) => parseInt(category.total));
                    //labels for
                    const labels = categories.map((category) => category.name);
                    const datas = categories.map((category) => category.count);
                    const color = categories.map((category) => category.color);
                    const chartConfig = {
                        // series: percentage,
                        chart: {
                            type: "pie",
                            width: 500,
                            height: 500,
                            toolbar: {
                                show: false,
                            },
                        },
                        series: amounts,
                        labels: labels,
                        title: {
                            show: "Expense",
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        colors: color,
                        legend: {
                            show: false,
                        },
                    };

                    const chart = new ApexCharts(document.querySelector("#pie-chart"), chartConfig);
                    chart.render();
                    window.addEventListener('resize', resizeChart);
                    resizeChart(); // Call on initial load

                    // Adjust chart size based on the window size
                    function resizeChart() {
                        const chartContainer = document.querySelector('#pie-chart');
                        if (window.innerWidth < 768) {
                            chart.updateOptions({
                                chart: {
                                    width: window.innerWidth - 30,
                                    height: window.innerWidth - 30
                                }
                            });
                        } else {
                            chart.updateOptions({
                                chart: {
                                    width: 500,
                                    height: 500
                                }
                            });
                        }
                    }

                });
            </script>
        @endpush
</x-app-layout>
