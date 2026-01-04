<!-- Welcome -->
<div class="bg-gray-500 text-white rounded-xl p-5 shadow">
    <h3 class="text-xl font-semibold">
        Hello {{ Auth::user()->name }} 👋
    </h3>
    <p class="text-sm mt-1 opacity-90">
        Your financial activity is being monitored by our team.
    </p>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-2xl shadow p-4 mt-3 border">
    <h4 class="text-lg font-semibold mb-4 text-gray-800">
        Quick Actions
    </h4>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <button @click="tab='dashboard'"
            class="py-3 rounded-lg bg-gray-900 text-white font-medium hover:bg-gray-800 transition">
            Dashboard
        </button>

        <button @click="tab='my-loans'"
            class="py-3 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-500 transition">
            My Loans
        </button>

        <button @click="tab='loan-types'"
            class="py-3 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-500 transition">
            Loan Types
        </button>

        <button @click="tab='apply'"
            class="py-3 rounded-lg bg-green-600 text-white font-medium hover:bg-green-500 transition">
            Apply Loan
        </button>

    </div>
</div>

{{-- User Stats --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 my-3">

    <div class="bg-white rounded-2xl shadow p-5 border">
        <p class="text-xs uppercase text-gray-400">Account Number</p>
        <p class="text-lg font-semibold text-indigo-700 mt-2">
            {{ Auth::user()->account_number }}
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 border">
        <p class="text-xs uppercase text-gray-400">Total Loans</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">
            {{ Auth::user()->loans->count() }}
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 border">
        <p class="text-xs uppercase text-gray-400">Pending Loans</p>
        <p class="text-3xl font-bold text-yellow-500 mt-2">
            {{ Auth::user()->loans->where('status', 'pending')->count() }}
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 border">
        <p class="text-xs uppercase text-gray-400">Approved Loans</p>
        <p class="text-3xl font-bold text-green-600 mt-2">
            {{ Auth::user()->loans->where('status', 'approved')->count() }}
        </p>
    </div>

</div>

{{-- Banner + Company description box--}}
<div class="flex gap-4">
    {{-- Left Part --}}

    <div class="w-full md:w-[70%]">
        <div x-data="{ slide: 1 }" x-cloak class="relative overflow-hidden rounded-2xl shadow-lg">
    
            <!-- Slide 1 -->
            <div x-show="slide === 1" x-transition class="h-56 md:h-64 bg-cover bg-center"
                style="background-image: url('{{ asset('storage/all_support_images/u1.jpg') }}');">
                <div class="absolute inset-0 bg-black/35 flex items-center px-6">
                    <div class="text-white">
                        <h2 class="text-2xl font-bold">
                            Welcome back, {{ Auth::user()->name }}
                        </h2>
                        <p class="mt-2 text-sm opacity-90">
                            Manage your loans securely and efficiently
                        </p>
                    </div>
                </div>
            </div>
    
            <!-- Slide 2 -->
            <div x-show="slide === 2" x-transition class="h-56 md:h-64 bg-cover bg-center"
                style="background-image: url('{{ asset('storage/all_support_images/u2.jpg') }}');">
                <div class="absolute inset-0 bg-black/35 flex items-center px-6">
                    <div class="text-white">
                        <h2 class="text-2xl font-bold">
                            Transparent & Trusted Banking
                        </h2>
                        <p class="mt-2 text-sm opacity-90">
                            Track applications, approvals & repayments
                        </p>
                    </div>
                </div>
            </div>
    
            <!-- Slide 3 -->
            <div x-show="slide === 3" x-transition class="h-56 md:h-64 bg-cover bg-center"
                style="background-image: url('{{ asset('storage/all_support_images/u3.jpg') }}');">
                <div class="absolute inset-0 bg-black/35 flex items-center px-6">
                    <div class="text-white">
                        <h2 class="text-2xl font-bold">
                            Fast Loan Processing
                        </h2>
                        <p class="mt-2 text-sm opacity-90">
                            Apply & get decisions without hassle
                        </p>
                    </div>
                </div>
            </div>
    
            <!-- Controls -->
            <div class="absolute bottom-4 right-4 flex gap-2">
                <button @click="slide = 1" class="w-3 h-3 rounded-full bg-white"></button>
                <button @click="slide = 2" class="w-3 h-3 rounded-full bg-white/70"></button>
                <button @click="slide = 3" class="w-3 h-3 rounded-full bg-white/70"></button>
            </div>
    
        </div>
    </div>

    {{-- Right Part --}}
    <div class="w-full md:w-[30%]">
    <div class="bg-white rounded-2xl shadow-lg p-6 h-full flex flex-col justify-between">

        {{-- Header --}}
        <div>
            <h3 class="text-xl font-bold text-gray-800">
                About Our Company
            </h3>
        </div>

        {{-- Business Points --}}
        <div class="mt-3 space-y-2">

            <div class="flex items-start gap-3">
                <span class="text-green-600 text-lg">✔</span>
                <p class="text-sm text-gray-700">
                    Instant loan application & real-time status tracking
                </p>
            </div>

            <div class="flex items-start gap-3">
                <span class="text-green-600 text-lg">✔</span>
                <p class="text-sm text-gray-700">
                    Transparent interest rates with no hidden charges
                </p>
            </div>

        </div>

        {{-- Footer Stats --}}
        <div class="mt-4 border-t pt-2 grid grid-cols-3 text-center">
            <div>
                <p class="text-lg font-bold text-blue-600">10K+</p>
                <p class="text-xs text-gray-500">Customers</p>
            </div>
            <div>
                <p class="text-lg font-bold text-blue-600">99%</p>
                <p class="text-xs text-gray-500">Approval Rate</p>
            </div>
            <div>
                <p class="text-lg font-bold text-blue-600">24/7</p>
                <p class="text-xs text-gray-500">Support</p>
            </div>
        </div>

    </div>
</div>

</div>


