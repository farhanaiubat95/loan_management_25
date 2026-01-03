<div class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow-lg" x-data="loanForm()">

    <!-- Success Message -->
    <template x-if="successMessage">
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg text-center font-medium">
            <p x-text="successMessage"></p>
        </div>
    </template>


    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-500 p-6 text-white rounded-t-xl">
        <h3 class="text-2xl font-bold">Apply for a Loan</h3>
        <p class="text-sm opacity-90 mt-1">
            Fast approval • Low interest • Secure
        </p>
    </div>

    <!-- Form -->
    <form action="{{ route('user.loans.store') }}" method="POST" @submit.prevent="checkForm($event)">
        @csrf

        <!-- Loan Type -->
        <div class="mt-4">
            <label class="text-sm font-medium text-gray-700">Loan Type</label>
            <select name="loan_type_id" x-model="selectedLoanType" required
                class="mt-2 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                @change="updateLoanLimits()">
                <option value="">Select Loan Type</option>
                @foreach($loanTypes as $type)
                    <option value="{{ $type->id }}" :data-min="{{ $type->min_amount }}" :data-max="{{ $type->max_amount }}"
                        :data-min-duration="{{ $type->min_duration }}" :data-max-duration="{{ $type->max_duration }}">
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>


            <div class="flex  justify-between w-full">
                <!-- Loan Amount -->
                <div class="mt-4 ">
                    <label class="text-sm font-medium text-gray-700">Loan Amount Tk</label>
                    <input type="number" name="amount" x-model.number="amount" placeholder="Tk 0"
                            class="mt-2 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                            @input="checkAmount">

                    <p class="text-sm text-gray-500 mt-1" x-show="amountHint" x-text="amountHint"></p>
                    <p class="text-sm text-red-600 mt-1" x-text="amountError"></p>
                </div>
                
                <!-- Duration -->
                <div class="mt-4 ">
                    <label class="text-sm font-medium text-gray-700">Loan Duration (months)</label>
                    <input type="number" name="duration" x-model.number="duration" placeholder="Enter duration"
                        class="mt-2 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                        @input="checkDuration">
                
                    <p class="text-sm text-gray-500 mt-1" x-show="durationHint" x-text="durationHint"></p>
                    <p class="text-sm text-red-600 mt-1" x-text="durationError"></p>
                </div>
            </div>



        <!-- Purpose -->
        <div>
            <label class="text-sm font-medium text-gray-700">Purpose</label>
            <textarea name="description" rows="2" placeholder="Briefly describe why you need the loan"
                class="mt-2 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                required></textarea>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" :disabled="isSubmitting"
                class="px-8 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-500 transition shadow-md flex items-center justify-center space-x-2">
                <span x-show="!isSubmitting">Submit Application</span>
                <span x-show="isSubmitting" class="flex items-center space-x-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4z">
                        </path>
                    </svg>
                    <span>Submitting...</span>
                </span>
            </button>
        </div>
    </form>

</div>

<script>
    function loanForm() {
        return {
            selectedLoanType: null,
            amount: null,
            duration: null,
            minAmount: 0,
            maxAmount: 0,
            minDuration: 0,
            maxDuration: 0,
            amountError: '',
            durationError: '',
            amountHint: '',
            durationHint: '',
            successMessage: '',
            isSubmitting: false,

            updateLoanLimits() {
                if (!this.selectedLoanType) {
                    this.minAmount = this.maxAmount = this.minDuration = this.maxDuration = 0;
                    this.amountHint = '';
                    this.durationHint = '';
                    return;
                }

                const option = document.querySelector(`select[name="loan_type_id"] option[value="${this.selectedLoanType}"]`);
                this.minAmount = parseInt(option.dataset.min);
                this.maxAmount = parseInt(option.dataset.max);
                this.minDuration = parseInt(option.dataset.minDuration);
                this.maxDuration = parseInt(option.dataset.maxDuration);

                this.amountHint = `You can apply for: ${this.minAmount} - ${this.maxAmount} Tk`;
                this.durationHint = `Duration range: ${this.minDuration} - ${this.maxDuration} months`;

                // Reset errors
                this.amountError = '';
                this.durationError = '';
            },

            checkAmount() {
                if (!this.selectedLoanType || this.amount === null) {
                    this.amountError = '';
                    return;
                }
                if (this.amount < this.minAmount || this.amount > this.maxAmount) {
                    this.amountError = `Amount must be between ${this.minAmount} and ${this.maxAmount} Tk.`;
                } else {
                    this.amountError = '';
                }
            },

            checkDuration() {
                if (!this.selectedLoanType || this.duration === null) {
                    this.durationError = '';
                    return;
                }
                if (this.duration < this.minDuration || this.duration > this.maxDuration) {
                    this.durationError = `Duration must be between ${this.minDuration} and ${this.maxDuration} months.`;
                } else {
                    this.durationError = '';
                }
            },

            checkForm(event) {
                this.checkAmount();
                this.checkDuration();

                if (this.amountError || this.durationError) {
                    return;
                }

                this.isSubmitting = true;

                const formData = new FormData(event.target);
                formData.set('loan_type_id', this.selectedLoanType);

                fetch(event.target.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.successMessage = "Your loan application has been submitted successfully.We will infrom you through email once your loan is approved by our admin.";

                            // reset form
                            event.target.reset();
                            this.selectedLoanType = null;
                            this.amount = null;
                            this.duration = null;
                            this.updateLoanLimits();
                        }
                    })
                    .catch(() => {
                        alert("Something went wrong. Please try again!");
                    })
                    .finally(() => {
                        this.isSubmitting = false;
                    });
            }

        }
    }
</script>