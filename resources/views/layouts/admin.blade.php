{{-- resources/views/layouts/admin.blade.php --}}
<x-app-layout>

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r">
            <div class="p-4 border-b font-bold text-lg text-blue-900">
                Admin Panel
            </div>

            <nav class="p-4 space-y-2">

                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 rounded 
                    {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-chart-line mr-2"></i>  Dashboard
                </a>

                <a href="{{ route('admin.banks.index') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.banks.index') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="mr-2">🏦</span> Bank Details
                </a>

                <a href="{{ route('admin.users') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.users') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-users mr-2"></i> Users
                </a>

                <a href="{{ route('admin.loan-types.index') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.loan-types.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-hand-holding-usd mr-2"></i> Loans
                </a>

                <a href="{{ route('admin.loans') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.loans') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-donate mr-2"></i> All Loans
                </a>

                <a href="{{ route('admin.payment') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.payment') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-money-bill-transfer mr-2"></i> Loan Distribution
                </a>

            </nav>
        </aside>

        {{-- Main Content Area (Scrollable) --}}
        <main class="flex-1 p-4 bg-gray-300 overflow-y-auto h-screen">
            {{ $slot }}
        </main>

    </div>

</x-app-layout>
