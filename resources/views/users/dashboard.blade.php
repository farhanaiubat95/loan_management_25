<!-- Welcome -->
<div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-xl p-6 shadow">
    <h3 class="text-xl font-semibold">
        Hello {{ Auth::user()->name }} 👋
    </h3>
    <p class="text-sm mt-1 opacity-90">
        Your financial activity is being monitored by our team.
    </p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Account Number</p>
        <p class="text-lg font-bold text-indigo-600 mt-1">{{ Auth::user()->account_number }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Total Loans</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ Auth::user()->loans->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Pending Loans</p>
        <p class="text-3xl font-bold text-yellow-500 mt-2">{{ Auth::user()->loans->where('status', 'pending')->count() }}
        </p>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Approved Loans</p>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ Auth::user()->loans->where('status', 'approved')->count() }}
        </p>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow p-6 mt-6">
    <h4 class="text-lg font-semibold mb-4">Quick Actions</h4>
    <div class="flex flex-wrap gap-4">
        <button @click="tab='dashboard'" class="px-6 py-2 bg-gray-800 text-white rounded-lg">Dashboard</button>
        <button @click="tab='my-loans'" class="px-6 py-2 bg-indigo-600 text-white rounded-lg">My Loans</button>
        <button @click="tab='loan-types'" class="px-6 py-2 bg-purple-600 text-white rounded-lg">Loan Types</button>
        <button @click="tab='apply'" class="px-6 py-2 bg-green-600 text-white rounded-lg">Apply Loan</button>
    </div>
</div>