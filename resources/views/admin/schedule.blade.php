<x-admin-layout>

    <h2 class="text-2xl font-bold mb-6">
        EMI Schedule for Loan #{{ $loan->id }}
    </h2>

    <p class="mb-4 text-gray-700">
        Borrower: <strong>{{ $loan->user->name }}</strong><br>
        Amount: <strong>{{ $loan->amount }}</strong><br>
        Duration: <strong>{{ $loan->duration }} months</strong><br>
        EMI: <strong>{{ number_format($loan->emi, 2) }}</strong>
    </p>

    <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3">#</th>
                    <th class="p-3">Due Date</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($loan->paymentsSchedule as $installment)
                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3">{{ $installment->installment_number }}</td>

                        <td class="p-3">{{ $installment->due_date }}</td>

                        <td class="p-3">{{ number_format($installment->amount, 2) }}</td>

                        <td class="p-3">
                            @if ($installment->status === 'pending')
                                <span class="px-2 py-1 text-sm rounded bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            @elseif ($installment->status === 'paid')
                                <span class="px-2 py-1 text-sm rounded bg-green-100 text-green-700">
                                    Paid
                                </span>
                            @elseif ($installment->status === 'overdue')
                                <span class="px-2 py-1 text-sm rounded bg-red-100 text-red-700">
                                    Overdue
                                </span>
                            @endif
                        </td>

                        <td class="p-3 text-right">
                            @if ($installment->status !== 'paid')
                                <form action="{{ route('admin.installment.pay', $installment->id) }}" method="POST"
                                    onsubmit="return confirm('Mark installment #{{ $installment->installment_number }} as paid?');">
                                    @csrf
                                    <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                                        Mark as Paid
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">Completed</span>
                            @endif

                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</x-admin-layout>
