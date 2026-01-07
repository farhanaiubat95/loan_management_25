<x-admin-layout>
    <div class="p-6 space-y-8 bg-gray-50 min-h-screen">

        <!-- Page Header -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Bank & Account Management</h2>
                <p class="text-gray-500 text-sm mt-1">
                    Manage bank accounts, balances & availability
                </p>
            </div>
        </div>

        <!-- ADD BANK ACCOUNT CARD -->
        <div class="bg-white rounded-2xl shadow-md border border-gray-100">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-700">
                    ➕ Add New Bank Account
                </h3>
            </div>

            <form method="POST" action="{{ route('admin.banks.store') }}"
                class="p-6 grid grid-cols-1 md:grid-cols-5 gap-4">
                @csrf

                <div>
                    <label class="text-sm font-medium text-gray-600">Bank Name</label>
                    <input name="bank_name" required
                        class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Account Name</label>
                    <input name="account_name" required
                        class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Account Number</label>
                    <input name="account_number" required
                        class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Opening Balance (BDT)</label>
                    <input name="current_balance" type="number" required
                        class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex items-end">
                    <button
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition">
                        Save Account
                    </button>
                </div>
            </form>
        </div>

        <!-- BANK LIST -->
        @foreach($banks as $bank)
            <div class="bg-white rounded-2xl shadow-md border border-gray-100">

                <!-- Bank Header -->
                <div class="flex justify-between items-center px-6 py-4 border-b">
                    <h3 class="text-xl font-semibold text-gray-800">
                        🏦 {{ $bank->name }}
                    </h3>

                    <span class="px-3 py-1 rounded-full text-sm font-medium
                            {{ $bank->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($bank->status) }}
                    </span>
                </div>

                <!-- Accounts Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left">Account Name</th>
                                <th class="px-6 py-3 text-left">Account Number</th>
                                <th class="px-6 py-3 text-right">Balance</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($bank->accounts as $account)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 font-medium text-gray-800">
                                                    {{ $account->account_name }}
                                                </td>

                                                <td class="px-6 py-4 text-gray-600">
                                                    {{ $account->account_number }}
                                                </td>

                                                <td class="px-6 py-4 text-right font-semibold text-gray-800">
                                                    Tk {{ number_format($account->current_balance, 2) }}
                                                </td>

                                                <td class="px-6 py-4 text-center">
                                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                                                {{ $account->status === 'active'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700' }}">
                                                        {{ ucfirst($account->status) }}
                                                    </span>
                                                </td>

                                                <td class="px-6 py-4 text-center">
                                                    <form method="POST" action="{{ route('admin.banks.accounts.toggle', $account->id) }}">
                                                        @csrf
                                                        <button class="px-4 py-1 text-sm rounded-lg font-medium
                                                                    {{ $account->status === 'active'
                                ? 'bg-red-50 text-red-600 hover:bg-red-100'
                                : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                                                            {{ $account->status === 'active' ? 'Disable' : 'Enable' }}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                        No accounts added yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        @endforeach

    </div>
</x-admin-layout>