<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>{{ $amount }} {{ $fromCurrency['name'] }} = {{ $toCurrencyAmount }} {{ $toCurrency['name'] }}</p>
                    <p>{{ $fromCurrency['symbol'] }}1 (<span class="uppercase">{{ $fromCurrency['currency_code'] }}</span>) = {{ $toCurrency['symbol'] }}{{ $oneAmountToCurrency }} (<span class="uppercase">{{ $toCurrency['currency_code'] }}</span>)</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
