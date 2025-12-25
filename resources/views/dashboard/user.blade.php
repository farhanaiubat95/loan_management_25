<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800">
                User Dashboard
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-xl p-6 shadow">
                <h3 class="text-xl font-semibold">
                    Hello {{ Auth::user()->name }} 👋
                </h3>
                <p class="text-sm mt-1 opacity-90">
                    Your financial activity is being monitored by our team.
                </p>
            </div>

            <!-- Main Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500">Account Number</p>
                    <p class="text-lg font-bold text-indigo-600 mt-1">
                        {{ Auth::user()->account_number }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500">Total Loans</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">
                        {{ Auth::user()->loans()->count() }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500">Pending Loans</p>
                    <p class="text-3xl font-bold text-yellow-500 mt-2">
                        {{ Auth::user()->loans()->where('status', 'pending')->count() }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow p-6">
                    <p class="text-sm text-gray-500">Approved Loans</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ Auth::user()->loans()->where('status', 'approved')->count() }}
                    </p>
                </div>

            </div>

            <!-- Insight Panel -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Slide Banner -->
                <div class="md:col-span-2 bg-white rounded-xl shadow overflow-hidden relative">
                
                    <!-- Slides -->
                    <div id="loanSlider" class="flex transition-transform duration-700 ease-in-out">
                
                        <!-- Slide 1 -->
                        <div class="min-w-full relative">
                            <img src="{{ asset('storage/all_support_images/u1.jpg') }}" class="w-full h-64 object-cover" alt="Loan Offer">
                            <div class="absolute inset-0 bg-black/20 flex items-center p-6">
                                <div class="text-white">
                                    <h3 class="text-2xl font-bold">Personal Loan</h3>
                                    <p class="mt-2 text-sm">Up to ৳5,00,000 • Low Interest</p>
                                </div>
                            </div>
                        </div>
                
                        <!-- Slide 2 -->
                        <div class="min-w-full relative">
                            <img src="{{ asset('storage/all_support_images/u2.jpg') }}" class="w-full h-64 object-cover" alt="Business Loan">
                            <div class="absolute inset-0 bg-black/20 flex items-center p-6">
                                <div class="text-white">
                                    <h3 class="text-2xl font-bold">Business Loan</h3>
                                    <p class="mt-2 text-sm">Grow your business with flexible EMI</p>
                                </div>
                            </div>
                        </div>
                
                        <!-- Slide 3 -->
                        <div class="min-w-full relative">
                            <img src="{{ asset('storage/all_support_images/u3.jpg') }}" class="w-full h-64 object-cover" alt="Instant Approval">
                            <div class="absolute inset-0 bg-black/20 flex items-center p-6">
                                <div class="text-white">
                                    <h3 class="text-2xl font-bold">Instant Approval</h3>
                                    <p class="mt-2 text-sm">Approval in minutes</p>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 4 -->
                        <div class="min-w-full relative">
                            <img src="{{ asset('storage/all_support_images/u4.jpg') }}" class="w-full h-64 object-cover" alt="Instant Approval">
                            <div class="absolute inset-0 bg-black/20 flex items-center p-6">
                                <div class="text-white">
                                    <h3 class="text-2xl font-bold">Online Help</h3>
                                    <p class="mt-2 text-sm">24/7 Customer Support</p>
                                </div>
                            </div>
                        </div>
                
                    </div>
                
                    <!-- Dots -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                        <span class="dot w-3 h-3 bg-white rounded-full opacity-100"></span>
                        <span class="dot w-3 h-3 bg-white rounded-full opacity-50"></span>
                        <span class="dot w-3 h-3 bg-white rounded-full opacity-50"></span>
                    </div>
                </div>


                <!-- Profile Snapshot -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">
                        Account Overview
                    </h4>

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

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">
                    Quick Actions
                </h4>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('profile.edit') }}"
                        class="px-6 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-700 transition">
                        Update Profile
                    </a>

                    <a href="#" class="px-6 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition">
                        View My Loans
                    </a>

                    <a href="#" class="px-6 py-2 rounded-lg bg-green-600 text-white hover:bg-green-500 transition">
                        Apply for Loan
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script>
        let currentSlide = 0;
        const slider = document.getElementById('loanSlider');
        const slides = slider.children;
        const dots = document.querySelectorAll('.dot');

        function showSlide(index) {
            slider.style.transform = `translateX(-${index * 100}%)`;

            dots.forEach((dot, i) => {
                dot.classList.toggle('opacity-100', i === index);
                dot.classList.toggle('opacity-50', i !== index);
            });
        }

        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }, 4000);
    </script>

</x-app-layout>