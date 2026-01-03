<h3 class="text-xl font-semibold mb-4">My Loans</h3>

<table class="w-full text-sm bg-white rounded-xl shadow overflow-hidden">
    <thead class="bg-gray-300">
        <tr>
            <th class="p-3 text-center">ID</th>
            <th class="p-3">Loan Type</th>
            <th class="p-3">Amount</th>
            <th class="p-3">Status</th>
            <th class="p-3">Applied On</th>
        </tr>
    </thead>
    <tbody>
        @foreach(Auth::user()->loans as $loan)
            <tr class="border-b text-center">
                <td class="p-3">{{ $loan->id }}</td>
                <td class="p-3 capitalize">{{ $loan->loan_type }}</td>
                <td class="p-3">৳ {{ number_format($loan->amount) }}</td>
                <td class="p-3 capitalize">{{ $loan->status }}</td>
                <td class="p-3">{{ $loan->created_at->format('d M Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>