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
                    @if ($errors->any())
                        <div class="alert alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('convert') }}" method="post">
                        @csrf
                        <div class="flex justify-evenly">
                            <div class="form-control w-full max-w-sm p-4">
                                <label class="label">
                                    <span class="label-text text-lg">Amount</span>
                                </label>
                                <input id="selected-symbol-input" type="text" value="" name="amount" class="input input-bordered rounded-box w-full max-w-xs" />
                            </div>

                            <div class="form-control w-full max-w-sm p-4">
                                <label class="label">
                                    <span class="label-text text-lg">From</span>
                                </label>
                                <select id="currency-select" class="select select-bordered" name="from_currency">
                                    @foreach ($currencies as $currency)
                                    <option value="{{ $currency['id'] }}:{{ $currency['symbol'] }}"><span class="uppercase">{{ $currency['currency_code'] }}</span> - {{ $currency['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-control w-full max-w-sm p-4">
                                <label class="label">
                                    <span class="label-text text-lg">To</span>
                                </label>
                                <select class="select select-bordered" name="to_currency">
                                    @foreach ($currencies as $currency)
                                    <option value="{{ $currency['id'] }}"><span class="uppercase">{{ $currency['currency_code'] }}</span> - {{ $currency['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-center py-5">
                            <input type="submit" class="btn btn-active btn-neutral" value="Convert"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const selectedCurrencyInput = document.getElementById('selected-symbol-input');
        const currencySelect = document.getElementById('currency-select');
        let value = currencySelect.value;
        [currencyId, currencySymbol] = value.split(':');

        selectedCurrencyInput.value = currencySymbol;

        currencySelect.addEventListener('change', (event) => {
            value = event.target.value;
            [currencyId, currencySymbol] = value.split(':');

            selectedCurrencyInput.value = currencySymbol;
        });

        selectedCurrencyInput.addEventListener('input', (event) => {
            const inputValue = event.target.value;
            const symbolLength = currencySymbol.length;

            if (!inputValue.startsWith(currencySymbol)) {
                if (inputValue.length === symbolLength + 1) {
                    event.target.value = currencySymbol;
                } else {
                    event.target.value = currencySymbol + inputValue.slice(symbolLength);
                }
            }
        });
    </script>
</x-app-layout>
