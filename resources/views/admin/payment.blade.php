<x-admin-layout>
    @foreach($loans as $loan)


    @endforeach

    @if(session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif

    @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif


    <div class="p-6 space-y-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Approved Loan Disbursement
        </h2>
        @if (session('error'))
            <div class="mb-4 p-4 rounded bg-red-100 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif


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
                    <form method="POST" 
                        action="{{ route('admin.loan.disburse', $loan) }}">
                        @csrf
                        <button type="submit"
                            class="px-6 py-3 bg-slate-700 text-white rounded-lg hover:bg-slate-600 hover:text-white">
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

    <script>
        function showLoading(form) {
            alert('Processing loan transfer...\nPlease wait.');
        }
    </script>

</x-admin-layout>