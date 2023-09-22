<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-4xl pb-5">Convert Currency</h1>
                    <div class="flex justify-evenly pb-16">
                        <div class="form-control w-full max-w-sm p-4">
                        <label class="label">
                            <span class="label-text text-lg">Amount</span>
                        </label>
                        <input type="text" placeholder="Type here" class="input input-bordered rounded-box w-full max-w-xs" />
                        </div>

                        <div class="form-control w-full max-w-sm dropdown dropdown-end p-4">
                        <label class="label">
                            <span class="label-text text-lg">From</span>
                        </label>
                        <label tabindex="0" class="btn m-1">Click</label>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                            @foreach ($currencies as $currency)
                                <li><a><span class="uppercase">{{ $currency['currency_code'] }} </span>- {{ $currency['name'] }}</a></li>
                            @endforeach
                        </ul>
                        </div>

                        <div class="form-control w-full max-w-sm dropdown dropdown-end p-4">
                        <label class="label">
                            <span class="label-text text-lg">To</span>
                        </label>
                        <label tabindex="0" class="btn m-1">Click</label>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52 overflow-y-auto">
                            @foreach ($currencies as $currency)
                                <li><a><span class="uppercase">{{ $currency['currency_code'] }} </span>- {{ $currency['name'] }}</a></li>
                            @endforeach
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
