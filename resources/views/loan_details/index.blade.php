<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Loan Details') }}
        </h2>
    </x-slot>
    <div class="container mx-auto py-8 px-4 max-w-6xl flex flex-col items-center">
        <table class="min-w-full bg-white border border-gray-400 mt-8" style="margin-top: 10px;">
            <thead>
                <tr>
                    <th class="py-2 px-4 border border-gray-400 bg-gray-100">Client ID</th>
                    <th class="py-2 px-4 border border-gray-400 bg-gray-100">Number of Payments</th>
                    <th class="py-2 px-4 border border-gray-400 bg-gray-100">First Payment Date</th>
                    <th class="py-2 px-4 border border-gray-400 bg-gray-100">Last Payment Date</th>
                    <th class="py-2 px-4 border border-gray-400 bg-gray-100">Loan Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loans as $loan)
                <tr>
                    <td class="py-2 px-4 border border-gray-300">{{ $loan->clientid }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $loan->num_of_payment }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $loan->first_payment_date }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $loan->last_payment_date }}</td>
                    <td class="py-2 px-4 border border-gray-300">{{ $loan->loan_amount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">
            {{ $loans->links() }}
        </div>
    </div>
</x-app-layout>