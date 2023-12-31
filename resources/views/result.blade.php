<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Result Page
        </h2>
    </x-slot>

    <div class="pt-12 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white flex justify-center p-5">Convert Currency</h1>

                    <p class="text-4xl font-medium text-gray-900 flex justify-center">{{ $amount }} {{ $fromCurrency['name'] }} = {{ $toCurrencyAmount }} {{ $toCurrency['name'] }}</p>

                    <p class="text-lg text-gray-600 flex justify-center pt-3" >{{ $toCurrency['symbol'] }}1 (<span class="uppercase">{{ $toCurrency['currency_code'] }}</span>) = {{ $fromCurrency['symbol'] }}{{ $oneAmountToCurrency }} (<span class="uppercase">{{ $fromCurrency['currency_code'] }}</span>)</p>

                    <p class="text-lg text-gray-600 flex justify-center pb-3">{{ $fromCurrency['symbol'] }}1 (<span class="uppercase">{{ $fromCurrency['currency_code'] }}</span>) = {{ $toCurrency['symbol'] }}{{ $oneAmountFromCurrency }} (<span class="uppercase">{{ $toCurrency['currency_code'] }}</span>)</p>

                    <div class="flex justify-center pt-3 pb-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-neutral">Return</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <footer class="footer footer-center p-4 text-base-content">
                    <aside>
                        <p class="text-base">Thank you for visiting my portfolio project. <br>~ <i>irfnhanif</i> ~</p>

                        <p class="pt-2 text-sm">You can check the project's code <span class="text-white bg-black p-0.5"><a href="https://github.com/irfnhanif/currency-converter">here</a></span></p>
                    </aside>
                </footer>
            </div>
        </div>
    </div>
</x-app-layout>
