<h3 class="text-xl font-semibold mb-4">Available Loan Types</h3>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($loanTypes as $type)
        <div @click="selectedLoan = {{ $type->id }}"
            class="bg-white rounded-xl shadow p-6 cursor-pointer hover:shadow-xl transition">
            <h4 class="text-lg font-semibold">{{ $type->name }}</h4>
            <p class="text-sm text-gray-500 mt-1">{{ $type->interest_rate }}% Interest</p>
            <p class="text-sm text-gray-500">{{ number_format($type->min_amount) }} - {{ number_format($type->max_amount) }}
                Tk</p>
            <p class="text-sm text-gray-500">{{ $type->min_duration }} - {{ $type->max_duration }} months</p>
        </div>
    @endforeach
</div>

<!-- Loan Detail Modal -->
<div x-show="selectedLoan" x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" x-cloak>
    <div x-transition.scale class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b bg-gray-50">
            <h3 class="text-xl font-semibold text-gray-800">
                Loan Details
            </h3>
            <button @click="selectedLoan = null" class="text-gray-400 hover:text-gray-700 text-2xl leading-none">
                &times;
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 max-h-[70vh] overflow-y-auto">
            @foreach($loanTypes as $type)
                <div x-show="selectedLoan == {{ $type->id }}" x-transition>

                    <!-- Title -->
                    <h2 class="text-2xl font-bold text-green-700 mb-4">
                        {{ $type->name }}
                    </h2>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Interest Rate</p>
                            <p class="text-lg font-semibold">{{ $type->interest_rate }}%</p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Loan Amount</p>
                            <p class="text-lg font-semibold">
                                {{ number_format($type->min_amount) }} – {{ number_format($type->max_amount) }} Tk
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Duration</p>
                            <p class="text-lg font-semibold">
                                {{ $type->min_duration }} – {{ $type->max_duration }} months
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Processing Type</p>
                            <p class="text-lg font-semibold">Fast & Secure</p>
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-700 mb-1">Benefits</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $type->benefits }}
                        </p>
                    </div>

                    <!-- Process -->
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-700 mb-1">Application Process</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $type->process }}
                        </p>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-1">Description</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $type->description }}
                        </p>
                    </div>

                    <!-- Footer CTA -->
                    <div class="flex justify-end border-t pt-4">
                        <button @click="tab='apply'; selectedLoan=null"
                            class="px-8 py-3 bg-green-600 hover:bg-green-500 text-white font-semibold rounded-lg shadow-md transition">
                            Apply for this Loan
                        </button>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>