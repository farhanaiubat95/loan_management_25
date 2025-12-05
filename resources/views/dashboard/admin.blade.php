<x-admin-layout>

    <h1 class="text-2xl font-bold mb-6 text-gray-800">Admin Dashboard</h1>

    {{-- Top Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        {{-- Total Users --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-700"><i class="fa-solid fa-user text-green-600"></i> Total
                    Users</h3>
                <span class="text-green-600 text-xl font-bold">320</span>
            </div>
            <p class="text-sm text-gray-500 mt-2">Borrowers + Managers</p>
        </div>

        {{-- Total Loans --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-700"><i class="fas fa-hand-holding-usd text-blue-600"></i>
                    Total Loans</h3>
                <span class="text-blue-600 text-xl font-bold">125</span>
            </div>
            <p class="text-sm text-gray-500 mt-2">Active + Completed Loans</p>
        </div>

        {{-- Pending Approvals --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-700"><i class="fa-solid fa-circle-check text-yellow-500"></i>
                    Pending Approvals</h3>
                <span class="text-yellow-500 text-xl font-bold">14</span>
            </div>
            <p class="text-sm text-gray-500 mt-2">Waiting for admin review</p>
        </div>

    </div>


    {{-- Loan Overview + Recent Applications --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Loan Overview --}}
        <div class="bg-white p-6 shadow rounded-xl border lg:col-span-2">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Loan Overview</h2>

            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm border-b">
                        <th class="p-3">Borrower</th>
                        <th class="p-3">Amount</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="border-b">
                        <td class="p-3">Mahmud Hasan</td>
                        <td class="p-3">৳50,000</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs">
                                Pending
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            <a href="#" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>

                    <tr class="border-b">
                        <td class="p-3">Fahim Rahman</td>
                        <td class="p-3">৳30,000</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">
                                Approved
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            <a href="#" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>

                    <tr class="border-b">
                        <td class="p-3">Jannat Akter</td>
                        <td class="p-3">৳75,000</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs">
                                Rejected
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            <a href="#" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>


        {{-- Recent Activity --}}
        <div class="bg-white p-6 shadow rounded-xl border">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Recent Activity</h2>

            <ul class="space-y-4">

                <li class="flex items-start">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                    <p class="ml-3 text-gray-600 text-sm">
                        New loan application submitted by <strong>Mahmud Hasan</strong>.
                    </p>
                </li>

                <li class="flex items-start">
                    <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                    <p class="ml-3 text-gray-600 text-sm">
                        Loan of <strong>৳30,000</strong> approved for <strong>Fahim Rahman</strong>.
                    </p>
                </li>

                <li class="flex items-start">
                    <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                    <p class="ml-3 text-gray-600 text-sm">
                        4 new users registered.
                    </p>
                </li>

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
