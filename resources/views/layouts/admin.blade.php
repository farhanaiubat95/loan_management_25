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
                    Dashboard
                </a>

                <a href="{{ route('admin.users') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.users') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Users
                </a>

                <a href="{{ route('admin.loans') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.loans') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Loans
                </a>

                <a href="{{ route('admin.settings') }}"
                    class="block px-4 py-2 rounded
                    {{ request()->routeIs('admin.settings') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Settings
                </a>

            </nav>
        </aside>

        {{-- Main Content Area (Scrollable) --}}
        <main class="flex-1 p-4 bg-gray-300 overflow-y-auto h-screen">
            {{ $slot }}
        </main>

    </div>

</x-app-layout>
