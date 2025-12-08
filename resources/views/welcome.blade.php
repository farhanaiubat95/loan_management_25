<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-white text-gray-800 relative">
    <!-- HEADER -->
    <x-header />

    <!-- HERO -->
    <section class="relative w-full h-[90vh] md:h-[95vh] flex items-center justify-center overflow-hidden bg-purple-700">

        <!-- Background Image -->
        <img src="{{ asset('storage/all_support_images/loan-logo.jfif') }}" class="absolute inset-0 w-full h-full object-cover" />

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <!-- HERO CONTENT -->
        <div class="relative z-10 max-w-4xl mx-auto text-center px-6 text-white">
            <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                Loan Management System
            </h1>

            <p class="mt-4 text-lg md:text-xl opacity-90">
                A modern, secure and automated system to manage loans, borrowers and financial workflows efficiently.
            </p>

            <button
                class="mt-8 px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white text-lg font-semibold rounded-full shadow-lg">
                Get Started
            </button>
        </div>

    </section>


    <!-- KEY FEATURES -->
    <section class="py-20">
        <h2 class="text-center text-3xl font-bold">Key Features</h2>
        <p class="text-center text-blue-700 font-medium mt-2">
            An end-to-end, customisable Loan Management Solution
        </p>

        <div class="max-w-6xl mx-auto px-6 mt-12 grid md:grid-cols-2 gap-10">

            <!-- Left Column: Feature List -->
            <div class="space-y-10">

                <div class="flex gap-4">
                    <img src="https://via.placeholder.com/50" class="w-12 h-12" />
                    <div>
                        <h3 class="font-bold text-lg">360° integrated lending solution</h3>
                        <p class="text-gray-600">Tailored toolset meeting needs of financial institutions.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <img src="https://via.placeholder.com/50" class="w-12 h-12" />
                    <div>
                        <h3 class="font-bold text-lg">Easy monitoring</h3>
                        <p class="text-gray-600">Monitor borrowers through a parameterised approach.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <img src="https://via.placeholder.com/50" class="w-12 h-12" />
                    <div>
                        <h3 class="font-bold text-lg">Customisable settlement capabilities</h3>
                        <p class="text-gray-600">Configure payments and tranche settlements.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <img src="https://via.placeholder.com/50" class="w-12 h-12" />
                    <div>
                        <h3 class="font-bold text-lg">Better credit risk management</h3>
                        <p class="text-gray-600">Strengthen credit risk with powerful credit analytics.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <img src="https://via.placeholder.com/50" class="w-12 h-12" />
                    <div>
                        <h3 class="font-bold text-lg">Streamlined back-office operations</h3>
                        <p class="text-gray-600">Boost transparency and processing efficiency.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <img src="https://via.placeholder.com/50" class="w-12 h-12" />
                    <div>
                        <h3 class="font-bold text-lg">Fully automated workflows</h3>
                        <p class="text-gray-600">Integrate automation to reduce manual dependency.</p>
                    </div>
                </div>

            </div>

            <!-- Right Column: Illustration -->
            <div class="flex justify-center items-start">
                <img src="https://via.placeholder.com/400x500" class="rounded-xl shadow-xl" />
            </div>

        </div>
    </section>

    <!-- OTHER TECHNOLOGY PLATFORMS -->
    <section class="bg-blue-50 py-20">
        <h2 class="text-center text-3xl font-bold">Other technology platforms</h2>
        <p class="text-center text-3xl font-bold">for financial institutions</p>

        <div class="mt-12 max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">

            <div class="bg-white py-4 px-6 shadow rounded-lg">
                Digital KYC and Onboarding Platform
            </div>

            <div class="bg-white py-4 px-6 shadow rounded-lg">
                Embedded Finance Platform
            </div>

            <div class="bg-white py-4 px-6 shadow rounded-lg">
                Anchor-Led Supply Chain Finance Platform
            </div>

            <div class="bg-white py-4 px-6 shadow rounded-lg">
                Vendor-led Supply Chain Finance
            </div>

            <div class="bg-white py-4 px-6 shadow rounded-lg">
                Receivables Financing Platform
            </div>

            <div class="bg-white py-4 px-6 shadow rounded-lg">
                Loan Management System
            </div>

            <div class="bg-white py-4 px-6 shadow rounded-lg">
                Pre-Shipment Financing
            </div>

            <div class="bg-white py-4 px-6 shadow rounded-lg">
                Deep-Tier Supply Chain Financing
            </div>

        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section class="py-20 text-center">
        <button class="px-10 py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-full text-lg font-semibold">
            Contact Us
        </button>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-100 py-9">
        <div class="max-w-7xl mx-auto px-6 text-gray-600 grid md:grid-cols-4 gap-6">

            <!-- Column 1 -->
            <div>
                <h4 class="font-bold mb-2">Enterprise</h4>
                <ul class="space-y-1 text-sm">
                    <li>Structured Trade</li>
                    <li>Early Payment Platform</li>
                    <li>Receivable Financing</li>
                </ul>
            </div>

            <!-- Column 2 -->
            <div>
                <h4 class="font-bold mb-2">Financial Institutions</h4>
                <ul class="space-y-1 text-sm">
                    <li>Digital KYC Platform</li>
                    <li>Embedded Finance</li>
                    <li>Loan Management System</li>
                </ul>
            </div>

            <!-- Column 3 -->
            <div>
                <h4 class="font-bold mb-2">Lending</h4>
                <ul class="space-y-1 text-sm">
                    <li>Startup Financing</li>
                    <li>Invoice Discounting</li>
                    <li>Working Capital Loans</li>
                </ul>
            </div>

            <!-- Column 4 -->
            <div>
                <h4 class="font-bold mb-2">Company</h4>
                <ul class="space-y-1 text-sm">
                    <li>About CredAble</li>
                    <li>Our Team</li>
                    <li>Careers</li>
                </ul>
            </div>

        </div>

        <p class="text-center text-xs text-gray-500 mt-10">
            © 2025 CredAble — All rights reserved
        </p>
    </footer>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/js/all.min.js"
    integrity="sha512-6BTOlkauINO65nLhXhthZMtepgJSghyimIalb+crKRPhvhmsCdnIuGcVbR5/aQY2A+260iC1OPy1oCdB6pSSwQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</html>
