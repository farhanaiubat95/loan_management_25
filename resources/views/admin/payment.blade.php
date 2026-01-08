<x-admin-layout>
    <div class="p-6 space-y-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Approved Loan Disbursement
        </h2>

        @foreach($loans as $loan)
            <div class="bg-white rounded-xl shadow p-6 border grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- User Info -->
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">User Info</h4>
                    <p>Name: {{ $loan->user->name }}</p>
                    <p>Email: {{ $loan->user->email }}</p>
                    <p>Account No: {{ $loan->user->account_number }}</p>
                </div>

                <!-- Loan Info -->
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Loan Info</h4>
                    <p>Loan ID: {{ $loan->id }}</p>
                    <p>Amount: Tk {{ number_format($loan->amount, 2) }}</p>
                    <p>Status:
                        <span class="text-green-600 font-semibold">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </p>
                </div>

                <!-- Action -->
                <div class="flex items-center">
                    <form action="{{ route('admin.loan.ssl.pay', $loan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Distribute Loan
                        </button>
                    </form>
                </div>

            </div>
        @endforeach

        @if($loans->isEmpty())
            <p class="text-gray-500">No approved loans available.</p>
        @endif

    </div>
</x-admin-layout>