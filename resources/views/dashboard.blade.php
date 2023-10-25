<x-app-layout>
    <x-slot name="header" class="">
        <div class="flex justify-end">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight p-2">
                Main Currency: 
            </h2>
            <details class="dropdown dropdown-end">
                <summary class="btn">{{ $currencies[$idDefaultCurrency - 1]['currency_code'] }}</summary>
                <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-64">
                    @foreach ($currencies as $currency)
                        <li><a href="{{ route('dashboard', ['currencyId' => $currency['id']]) }}">{{ $currency['name'] }} <span class="uppercase">({{ $currency['currency_code'] }})</span></a></li>
                    @endforeach
                </ul>
            </details>
        </div>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white flex justify-center p-5">Convert Currency</h1>
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

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <h1 class="mb-4 text-2xl font-extrabold text-gray-900 md:text-5xl lg:text-6xl pt-2 pb-5 flex justify-center">Currency Rates for&nbsp;<span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">{{ $currencies[$idDefaultCurrency - 1]['name'] }}</span></h1>
                            <table class="table w-4/5 justify-center">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-xl">Currency</th>
                                        <th class="text-xl">Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < 19; $i++)
                                        <tr class="hover">
                                            <th class="text-base">{{ $i + 1 }}</th>
                                            <td class="text-base">{{ $convertedMainCurrencies[$i]['name'] }} (<span class="uppercase">{{ $convertedMainCurrencies[$i]['currency_code'] }}</span>)</td>
                                            <td class="text-base">{{ $convertedMainCurrencies[$i]['symbol'] }}{{ $rates[$i] }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
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
