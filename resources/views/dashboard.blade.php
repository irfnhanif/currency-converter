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
                    <h1 class="text-4xl pb-5">Convert Currency</h1>
                    <div class="flex justify-evenly">
                        <div class="form-control w-full max-w-sm p-4">
                            <label class="label">
                                <span class="label-text text-lg">Amount</span>
                            </label>
                            <input id="selected-symbol-input" type="text" value="" class="input input-bordered rounded-box w-full max-w-xs" />
                        </div>

                        <div class="form-control w-full max-w-sm p-4">
                            <label class="label">
                                <span class="label-text text-lg">From</span>
                            </label>
                            <select id="currency-select" class="select select-bordered">
                                @foreach ($currencies as $currency)
                                <option value="{{ $currency['symbol'] }}"><span class="uppercase">{{ $currency['currency_code'] }}</span> - {{ $currency['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <script>
                            const selectedCurrencyInput = document.getElementById('selected-symbol-input');
                            const currencySelect = document.getElementById('currency-select');
                            let currencySymbol;

                            currencySelect.addEventListener('change', (event) => {
                                selectedCurrencyInput.value = event.target.value;
                                currencySymbol = event.target.value;
                            });

                            selectedCurrencyInput.addEventListener('input', (event) => {
                                if (!event.target.value.startsWith(currencySymbol)) {
                                    event.target.value = currencySymbol + event.target.value;
                                }
                            });
                        </script>

                        <div class="form-control w-full max-w-sm p-4">
                            <label class="label">
                                <span class="label-text text-lg">To</span>
                            </label>
                            <select class="select select-bordered">
                                @foreach ($currencies as $currency)
                                <option><span class="uppercase">{{ $currency['currency_code'] }}</span> - {{ $currency['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
