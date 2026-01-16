<x-admin-layout>

    @php
    $totalUsers = \App\Models\User::where('role', 'user')->count();
    $totalLoans = \App\Models\Loan::whereIn('status', ['active', 'completed'])->count();
    $pendingLoans = \App\Models\Loan::where('status', 'pending')->count();


    @endphp


    <h1 class="text-2xl font-bold mb-6 text-gray-800">Admin Dashboard</h1>

    {{-- Top Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        {{-- Total Users --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-700"><i class="fa-solid fa-user text-green-600"></i> Total
                    Users</h3>
                <span class="text-green-600 text-xl font-bold">{{ $totalUsers }}</span>
            </div>
            <p class="text-sm text-gray-500 mt-2">Borrowers</p>
        </div>

        {{-- Total Loans --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-700"><i class="fas fa-hand-holding-usd text-blue-600"></i>
                    Total Loans</h3>
                <span class="text-blue-600 text-xl font-bold">{{ $totalLoans }}</span>
            </div>
            <p class="text-sm text-gray-500 mt-2">Active + Completed Loans</p>
        </div>

        {{-- Pending Approvals --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-700"><i class="fa-solid fa-circle-check text-yellow-500"></i>
                    Pending Approvals</h3>
                <span class="text-yellow-500 text-xl font-bold">{{ $pendingLoans }}</span>
            </div>
            <p class="text-sm text-gray-500 mt-2">Waiting for admin review</p>
        </div>

        {{-- Total Balance --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-700"><i class="fa-solid fa-circle-dollar-to-slot text-red-800"></i>
                    Total Balance</h3>
                <span class="text-red-800 text-xl font-bold"> <span class="text-gray-500 text-sm">Tk</span> {{ number_format($totalBalance) }}</span>
            </div>
            <p class="text-sm text-gray-500 mt-2">All balances in system</p>
        </div>

        {{-- Total Bank Account --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-700">
                  🏦 Total Bank Account</h3>
                <span class="text-gray-500 text-xl font-bold">{{ $totalBankAccounts }}</span>
            </div>
            <p class="text-sm text-gray-500 mt-2">
                All bank accounts in system
            </p>
        </div>

        {{-- Total Transaction --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-700"><i class="fa-solid fa-money-bill-transfer text-purple-800"></i>
                    Total Transaction</h3>
                <span class="text-purple-800 text-xl font-bold">{{ $totalTransactions }}</span>
            </div>
            <p class="text-sm text-gray-500 mt-2">All transaction in system</p>
        </div>

    </div>


    {{-- Loan Overview + Recent Applications --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Loan Overview --}}
        <div class="bg-white p-6 shadow rounded-xl border lg:col-span-2">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Loan Overview (Active Loan)</h2>

            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm border-b">
                        <th class="p-3">Borrower</th>
                        <th class="p-3">Acc Num</th>
                        <th class="p-3">Amount</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($recentLoans as $loan)
                        @if ($loan->status === 'active')
                            <tr class="border-b">
                                <td class="p-3">{{ $loan->user->name }}</td>

                                <td class="p-3">{{ $loan->user->account_number }}</td>

                                <td class="p-3">Tk {{ number_format($loan->amount) }}</td>

                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-xs
                                        @if($loan->status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($loan->status === 'approved') bg-green-100 text-green-700
                                        @elseif($loan->status === 'active') bg-purple-100 text-purple-700
                                        @elseif($loan->status === 'completed') bg-blue-100 text-blue-700
                                        @elseif($loan->status === 'rejected') bg-red-100 text-red-700
                                        @endif">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>

                                <td class="p-3 text-right">
                                    <a href="{{ route('admin.loans') }}" class="text-blue-600 hover:underline">
                                        View
                                    </a>

                                </td>
                            </tr>

                        @endif
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                No loan data available
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>


        {{-- Recent Activity --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Recent Activity</h2>

            <ul class="space-y-4">
            
                @forelse ($recentLoans as $loan)

                    <li class="flex items-start">
                        <div class="w-2 h-2 rounded-full mt-2
                                @if($loan->status === 'pending') bg-yellow-500
                                @elseif($loan->status === 'approved') bg-green-500
                                @elseif($loan->status === 'active') bg-purple-500
                                @elseif($loan->status === 'completed') bg-blue-500
                                @elseif($loan->status === 'rejected') bg-red-500
                                @endif
                            "></div>

                        <p class="ml-3 text-gray-600 text-sm">
                            @if($loan->status === 'pending')
                                New loan application submitted by
                                <strong>{{ $loan->user->name }}</strong>.
                            @elseif($loan->status === 'approved')
                                Loan of <strong>৳{{ number_format($loan->amount) }}</strong>
                                approved for <strong>{{ $loan->user->name }}</strong>.
                            @elseif($loan->status === 'completed')
                                Loan of <strong>৳{{ number_format($loan->amount) }}</strong>
                                completed by <strong>{{ $loan->user->name }}</strong>.
                            @elseif($loan->status === 'rejected')
                                Loan application rejected for
                                <strong>{{ $loan->user->name }}</strong>.
                            @else
                                Loan updated for <strong>{{ $loan->user->name }}</strong>.
                            @endif
                        </p>
                    </li>

                @empty
                    <li class="text-gray-500 text-sm text-center">
                        No recent activity available
                    </li>
                @endforelse
            
            </ul>

        </div>

    </div>

    {{-- Loan Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

        {{-- Loan Amounts by Month (Bar Chart) --}}
        <div class="bg-white p-6 shadow rounded-xl border ">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Loan Amounts by Month</h2>
            <div id="loanBarChart"></div>
        </div>

        {{-- Loan Applications Trend (Line Chart) --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Loan Applications Trend</h2>
            <div id="loanLineChart"></div>
        </div>

    </div>
    {{-- ApexCharts CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // ----------------------
        // Bar Chart: Loan Amounts By Month
        // ----------------------
        var barOptions = {
            series: [{
                name: "Loan Amount (৳)",
                data: [50000, 30000, 70000, 45000, 90000, 60000, 75000, 82000, 58000, 40000, 95000, 70000]
            }],
            chart: {
                type: 'bar',
                height: 320
            },
            colors: ['#3b82f6'], // blue
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }
        };

        var barChart = new ApexCharts(document.querySelector("#loanBarChart"), barOptions);
        barChart.render();


        // ----------------------
        // Line Chart: Loan Applications Trend
        // ----------------------
        var lineOptions = {
            series: [{
                name: "Applications",
                data: [10, 15, 13, 20, 18, 25, 30, 28, 22, 26, 35, 40]
            }],
            chart: {
                type: 'line',
                height: 320
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: ['#10b981'], // green
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }
        };

        var lineChart = new ApexCharts(document.querySelector("#loanLineChart"), lineOptions);
        lineChart.render();
    </script>


</x-admin-layout>
