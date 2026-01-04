<h3 class="text-xl font-semibold mb-4 text-blue-800">My Loans</h3>

<table class="w-full text-sm bg-white rounded-xl shadow overflow-hidden">
    <thead class="bg-blue-800 text-white">
        <tr>
            <th class="p-3 text-center text-lg">ID</th>
            <th class="p-3">Loan Type</th>
            <th class="p-3">Amount</th>
            <th class="p-3">Status</th>
            <th class="p-3">Applied On</th>
        </tr>
    </thead>

    <tbody>
        @forelse(Auth::user()->loans as $loan)
            <tr class="border-b text-center text-lg">
                <td class="p-3">{{ $loan->id }}</td>
                <td class="p-3 capitalize">{{ $loan->loan_type }}</td>
                <td class="p-3">৳ {{ number_format($loan->amount) }}</td>
                <td class="p-3 capitalize">{{ $loan->status }}</td>
                <td class="p-3">{{ $loan->created_at->format('d M Y') }}</td>
            </tr>
        @empty
            <tr class="text-lg">
                <td colspan="5" class="p-6 text-center text-gray-500">
                    No data is available
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
