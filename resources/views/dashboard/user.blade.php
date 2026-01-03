<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800">
                User Dashboard
            </h2>
        </div>
    </x-slot>

    <div x-data="{ tab: 'dashboard', selectedLoan: null }" class="py-5 bg-gray-100 min-h-screen" x-cloak>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-3">

            {{-- Dashboard Tab --}}
            <div x-show="tab === 'dashboard'" x-transition>
                @include('users.dashboard')
            </div>

            {{-- Loan Types Tab --}}
            <div x-show="tab === 'loan-types'" x-transition>
                @include('users.loan-types')
            </div>


            {{-- My Loans Tab --}}
            <div x-show="tab === 'my-loans'" x-transition>
                @include('users.my-loans')
            </div>

            {{-- Apply Loan Tab --}}
            <div x-show="tab === 'apply'" x-transition>
                @include('users.apply')
            </div>

        </div>
    </div>

    @include('layouts.footer')

    <style>
        [x-cloak] { display: none }
    </style>
</x-app-layout>
