<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('EMI Details') }}
        </h2>
    </x-slot>
    <div class="container mx-auto py-8 px-4 max-w-6xl">
        @if (session('success'))
        <div class="mb-4 p-2 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="mb-4 p-2 bg-red-200 text-red-800 rounded">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('emi_details.process') }}" class="flex justify-center">
            @csrf
            <button type="submit" class="px-6 py-3 font-bold rounded-lg shadow-md border-2 border-green-800 mt-8 mb-8"
                style="background-color: #16a34a !important; color: #fff !important; opacity: 1 !important; box-shadow: 0 2px 8px rgba(22,163,74,0.15); margin-top: 10px;">
                Process Data
            </button>
        </form>
        @if (!empty($columns))
        <div class="mt-2 overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-400">
                <thead>
                    <tr>
                        @foreach ($columns as $col)
                        @if ($col !== 'id')
                        <th class="py-2 px-4 border border-gray-400 bg-gray-100">{{ $col }}</th>
                        @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                    <tr>
                        @foreach ($columns as $col)
                        @if ($col !== 'id')
                        <td class="py-2 px-4 border-b">{{ $row->$col }}</td>
                        @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        @if (is_object($data) && method_exists($data, 'links'))
        <div class="mt-6">
            {{ $data->links() }}
        </div>
        @endif
    </div>
</x-app-layout>