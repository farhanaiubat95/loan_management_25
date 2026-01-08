<x-admin-layout>
    <div class="flex items-center justify-center min-h-[70vh]">
        <div class="bg-white shadow-xl rounded-xl p-10 text-center max-w-lg w-full">

            <div class="text-green-500 text-6xl mb-4">
                ✅
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Payment Successful!
            </h2>

            <p class="text-gray-600 mb-6">
                Loan has been successfully disbursed via SSLCommerz.
            </p>

            <div class="bg-gray-50 rounded-lg p-4 text-left mb-6">
                <p><strong>Loan ID:</strong> {{ $loan->id }}</p>
                <p><strong>Borrower:</strong> {{ $loan->user->name }}</p>
                <p><strong>Amount:</strong> ৳{{ number_format($loan->amount, 2) }}</p>
                <p><strong>Status:</strong>
                    <span class="text-green-600 font-semibold">
                        {{ ucfirst($loan->status) }}
                    </span>
                </p>
            </div>

            <div class="flex justify-center gap-4">
                <a href="{{ route('admin.payment') }}"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Back to Payments
                </a>

                <a href="{{ route('admin.loans') }}"
                    class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    View Loans
                </a>
            </div>

        </div>
    </div>
</x-admin-layout>