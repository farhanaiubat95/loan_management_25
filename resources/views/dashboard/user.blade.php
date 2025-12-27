<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800">
                User Dashboard
            </h2>
        </div>
    </x-slot>

    {{-- Alpine Root --}}
    <div x-data="{ tab: 'dashboard' }" class="py-5 bg-gray-100 min-h-screen" x-cloak>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-3">

            {{-- ================= DASHBOARD ================= --}}
            <div x-show="tab === 'dashboard'" x-transition>

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
                        <p class="text-lg font-bold text-indigo-600 mt-1">
                            {{ Auth::user()->account_number }}
                        </p>
                    </div>

                    <div class="bg-white rounded-xl shadow p-6">
                        <p class="text-sm text-gray-500">Total Loans</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">
                            {{ Auth::user()->loans->count() }}
                        </p>
                    </div>

                    <div class="bg-white rounded-xl shadow p-6">
                        <p class="text-sm text-gray-500">Pending Loans</p>
                        <p class="text-3xl font-bold text-yellow-500 mt-2">
                            {{ Auth::user()->loans->where('status', 'pending')->count() }}
                        </p>
                    </div>

                    <div class="bg-white rounded-xl shadow p-6">
                        <p class="text-sm text-gray-500">Approved Loans</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">
                            {{ Auth::user()->loans->where('status', 'approved')->count() }}
                        </p>
                    </div>

                </div>

                <!-- Insight Panel -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

                    <!-- Slider -->
                    <div class="md:col-span-2 bg-white rounded-xl shadow overflow-hidden relative">

                        <div id="loanSlider" class="flex transition-transform duration-700">

                            @foreach(['u1.jpg', 'u2.jpg', 'u3.jpg', 'u4.jpg'] as $img)
                                <div class="min-w-full relative">
                                    <img src="{{ asset('storage/all_support_images/' . $img) }}"
                                        class="w-full h-64 object-cover">
                                    <div class="absolute inset-0 bg-black/30 flex items-center p-6">
                                        <div class="text-white">
                                            <h3 class="text-2xl font-bold">New Loan Offer</h3>
                                            <p class="text-sm mt-1">Fast approval & low interest</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <!-- Dots -->
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                            <span class="dot w-3 h-3 bg-white rounded-full opacity-100"></span>
                            <span class="dot w-3 h-3 bg-white rounded-full opacity-50"></span>
                            <span class="dot w-3 h-3 bg-white rounded-full opacity-50"></span>
                            <span class="dot w-3 h-3 bg-white rounded-full opacity-50"></span>
                        </div>
                    </div>

                    <!-- Profile -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <h4 class="text-lg font-semibold mb-4">Account Overview</h4>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex justify-between">
                                <span>Role</span>
                                <span class="font-semibold capitalize">{{ Auth::user()->role }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Occupation</span>
                                <span class="font-semibold">{{ Auth::user()->occupation }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Monthly Income</span>
                                <span class="font-semibold">৳ {{ number_format(Auth::user()->income) }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Member Since</span>
                                <span class="font-semibold">
                                    {{ Auth::user()->created_at->format('M Y') }}
                                </span>
                            </li>
                        </ul>
                    </div>

                </div>

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow p-6 mt-6">
                    <h4 class="text-lg font-semibold mb-4">Quick Actions</h4>
                    <div class="flex flex-wrap gap-4">
                        <button @click="tab='dashboard'" class="px-6 py-2 bg-gray-800 text-white rounded-lg">
                            Dashboard
                        </button>
                        <button @click="tab='loans'" class="px-6 py-2 bg-indigo-600 text-white rounded-lg">
                            My Loans
                        </button>
                        <button @click="tab='apply'" class="px-6 py-2 bg-green-600 text-white rounded-lg">
                            Apply Loan
                        </button>
                    </div>
                </div>

            </div>

            {{-- ================= LOANS ================= --}}
            <div x-show="tab === 'loans'" x-transition>
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-xl font-semibold mb-4">My Loans</h3>
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left">ID</th>
                                <th class="p-3">Amount</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->loans as $loan)
                                <tr class="border-b">
                                    <td class="p-3">{{ $loan->id }}</td>
                                    <td class="p-3">৳ {{ number_format($loan->amount) }}</td>
                                    <td class="p-3 capitalize">{{ $loan->status }}</td>
                                    <td class="p-3">{{ $loan->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ================= APPLY ================= --}}
            <div x-show="tab === 'apply'" x-transition>
                <div class="max-w-3xl mx-auto">
            
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-green-600 to-emerald-500 p-6 text-white">
                            <h3 class="text-2xl font-bold">Apply for a Loan</h3>
                            <p class="text-sm opacity-90 mt-1">
                                Fast approval • Low interest • Secure
                            </p>
                        </div>
            
                        <!-- Form -->
                        <form class="p-6 space-y-6">
            
                            <!-- Loan Amount -->
                            <div>
                                <label class="text-sm font-medium text-gray-700">
                                    Loan Amount Tk
                                </label>
                                <div class="relative mt-2">
                                    <span class="absolute left-3 top-2.5 text-gray-400">৳</span>
                                    <input type="number" placeholder="50000"
                                        class="pl-8 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500">
                                </div>
                            </div>
            
                            <!-- Duration -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
                                <div>
                                    <label class="text-sm font-medium text-gray-700">
                                        Loan Duration
                                    </label>
                                    <select
                                        class="mt-2 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500">
                                        <option>6 Months</option>
                                        <option>12 Months</option>
                                        <option>18 Months</option>
                                        <option>24 Months</option>
                                    </select>
                                </div>
                                
                                {{-- Loan Type --}}
                                <div>
                                    <label class="text-sm font-medium text-gray-700">
                                        Loan Type
                                    </label>
                                    <select name="loan_type" required
                                        class="mt-2 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500">
                                        <option value="">Select Loan Type</option>
                                        <option value="personal">Personal Loan</option>
                                        <option value="business">Business Loan</option>
                                        <option value="education">Education Loan</option>
                                        <option value="home">Home Loan</option>
                                    </select>
                                </div>

            
                            </div>
            
                            <!-- Purpose -->
                            <div>
                                <label class="text-sm font-medium text-gray-700">
                                    Purpose
                                </label>
                                <textarea rows="3" placeholder="Briefly describe why you need the loan"
                                    class="mt-2 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"></textarea>
                            </div>
            
                            <!-- Summary -->
                            <div class="bg-gray-50 rounded-xl p-4 border">
                                <h4 class="font-semibold text-gray-700 mb-3">
                                    Loan Summary
                                </h4>
            
                                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                    <div>
                                        <p class="text-gray-400">Interest Rate</p>
                                        <p class="font-semibold">8% – 12%</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Processing Fee</p>
                                        <p class="font-semibold">৳ 0</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Monthly EMI</p>
                                        <p class="font-semibold">Auto calculated</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Approval Time</p>
                                        <p class="font-semibold">Within 24 hours</p>
                                    </div>
                                </div>
                            </div>
            
                            <!-- Submit -->
                            <div class="flex justify-end">
                                <button
                                    class="px-8 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-500 transition shadow-md">
                                    Submit Application
                                </button>
                            </div>
            
                        </form>
            
                    </div>
            
                </div>
            </div>


        </div>
    </div>

    @include('layouts.footer')

    <style>
        [x-cloak] {
            display: none
        }
    </style>

    <script>
        let index = 0;
        const slider = document.getElementById('loanSlider');
        const dots = document.querySelectorAll('.dot');

        setInterval(() => {
            index = (index + 1) % slider.children.length;
            slider.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach((d, i) => d.classList.toggle('opacity-100', i === index));
        }, 4000);
    </script>

</x-app-layout>