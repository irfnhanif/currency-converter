<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Result Page
        </h2>
    </x-slot>

    <div class="py-12">
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
</x-app-layout>
