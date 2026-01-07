<div class="fixed left-0 right-0 top-0 z-50">
    <!-- HEADER -->
    <header class="w-full py-5 shadow-sm bg-gray-200 relative z-50 border-b-5 border-red-200">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center border-b-5 border-red-200">

            <!-- LOGO -->
            <a href="{{ route('welcome') }}">
                <h1 class="text-2xl font-semibold italic underline text-blue-950">LONERY Bank Limited</h1>
            </a>
            <!-- DESKTOP NAV -->
            <nav class="hidden lg:flex items-center gap-10 text-gray-700 font-medium">

                <!-- REUSABLE MENU ITEM -->
                <div class="relative group flex items-center gap-1 cursor-pointer">
                    <span class="hover:text-blue-900">Enterprise</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 mt-1 text-yellow-400" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M7 10l5 5 5-5H7z" />
                    </svg>

                    <!-- SUBMENU -->
                    <div
                        class="absolute left-0 top-4 mt-4 w-52 bg-blue-900 text-white rounded-lg shadow-lg opacity-0 scale-95 
                        group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 pointer-events-none 
                        group-hover:pointer-events-auto">
                        <ul class="py-3">
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Structured Trade</li>
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Early Payment Platform</li>
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Receivables Financing</li>
                        </ul>
                    </div>
                </div>

                <!-- Item -->
                <div class="relative group flex items-center gap-1 cursor-pointer">
                    <span class="hover:text-blue-900">Financial Institutions</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 mt-1 text-yellow-400" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M7 10l5 5 5-5H7z" />
                    </svg>

                    <div
                        class="absolute left-0 top-4 mt-4 w-52 bg-blue-900 text-white rounded-lg shadow-lg opacity-0 scale-95 
                        group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 pointer-events-none 
                        group-hover:pointer-events-auto">
                        <ul class="py-3">
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Digital KYC Platform</li>
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Embedded Finance</li>
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Supply Chain Finance</li>
                        </ul>
                    </div>
                </div>

                <!-- Item -->
                <div class="relative group flex items-center gap-1 cursor-pointer">
                    <span class="hover:text-blue-900">Lending</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 mt-1 text-yellow-400" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M7 10l5 5 5-5H7z" />
                    </svg>

                    <div
                        class="absolute left-0 top-4 mt-4 w-52 bg-blue-900 text-white rounded-lg shadow-lg opacity-0 scale-95 
                        group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 pointer-events-none 
                        group-hover:pointer-events-auto">
                        <ul class="py-3">
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Startup Financing</li>
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Invoice Discounting</li>
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Working Capital Loans</li>
                        </ul>
                    </div>
                </div>

                <!-- Item -->
                <div class="relative group flex items-center gap-1 cursor-pointer">
                    <span class="hover:text-blue-900">Resources</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 mt-1 text-yellow-400" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M7 10l5 5 5-5H7z" />
                    </svg>

                    <div
                        class="absolute left-0 top-4 mt-4 w-52 bg-blue-900 text-white rounded-lg shadow-lg opacity-0 scale-95 
                        group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 pointer-events-none 
                        group-hover:pointer-events-auto">
                        <ul class="py-3">
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Insights</li>
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Technology</li>
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Playbooks</li>
                        </ul>
                    </div>
                </div>

                <!-- Item -->
                <div class="relative group flex items-center gap-1 cursor-pointer">
                    <span class="hover:text-blue-900">Company</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 mt-1 text-yellow-400" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M7 10l5 5 5-5H7z" />
                    </svg>

                    <div
                        class="absolute left-0 top-4 mt-4 w-52 bg-blue-900 text-white rounded-lg shadow-lg opacity-0 scale-95 
                        group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 pointer-events-none 
                        group-hover:pointer-events-auto">
                        <ul class="py-3">
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">About Us</li>
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Our Team</li>
                            <li class="px-4 py-2 hover:bg-gray-500 cursor-pointer">Careers</li>
                        </ul>
                    </div>
                </div>

            </nav>

            <!-- LOGIN / REGISTER BUTTONS -->
            <div class="hidden lg:flex gap-4">
                <a href="{{ route('login') }}"
                    class="px-5 py-2 bg-blue-900 hover:bg-gray-500 text-white font-medium rounded-lg transition">Login</a>
                <a href="{{ route('register') }}"
                    class="px-5 py-2 bg-blue-900 hover:bg-gray-500 text-white font-medium rounded-lg transition">Register</a>
            </div>

            <!-- MOBILE MENU BUTTON -->
            <button id="mobileMenuBtn" class="lg:hidden text-3xl">&#9776;</button>
        </div>

        <!-- MOBILE MENU -->
        <div id="mobileMenu" class="hidden lg:hidden bg-white shadow-lg py-4 px-6 space-y-4">
            <a href="#" class="block">Enterprise</a>
            <a href="#" class="block">Financial Institutions</a>
            <a href="#" class="block">Lending</a>
            <a href="#" class="block">Resources</a>
            <a href="#" class="block">Company</a>

            <a href="{{ route('login') }}"
                class="block mt-3 px-4 py-2 bg-blue-900 hover:bg-gray-500 text-white text-center rounded-lg">Login</a>
            <a href="{{ route('register') }}"
                class="block px-4 py-2 bg-blue-900 hover:bg-gray-500 text-white text-center rounded-lg">Register</a>
        </div>
    </header>

    <script>
        document.getElementById("mobileMenuBtn").onclick = () =>
            document.getElementById("mobileMenu").classList.toggle("hidden");
    </script>

</div>
