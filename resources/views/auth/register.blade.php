<x-guest-layout>

    <!-- TITLE -->
    <div class="text-center mb-10 mt-10 md:mt-0">
        <h2 class="text-3xl font-extrabold text-blue-900 italic tracking-wide">
            Create Your Account
        </h2>
        <p class="text-gray-600">Fill in the details to register</p>
    </div>

    <form id="registerForm" class="shadow-xl rounded-xl p-8 border border-gray-200 space-y-6"
      enctype="multipart/form-data">
        @csrf

        <!-- FIELDS -->
        <div class="flex flex-wrap gap-6">

            <!-- NAME -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label for="name">Full Name *</x-input-label>
                <x-text-input id="name" name="name" class="w-full" required />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <!-- EMAIL -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label for="email">Email *</x-input-label>
                <x-text-input id="email" name="email" type="email" class="w-full" required />
                <p id="email_error" class="text-red-600 text-sm"></p>
            </div>

            <!-- PHONE -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label for="phone">Phone *</x-input-label>
                <x-text-input id="phone" name="phone" class="w-full" required />
                <p id="phone_error" class="text-red-600 text-sm"></p>
            </div>

            <!-- DOB -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label for="dob">Date of Birth *</x-input-label>
                <x-text-input id="dob" name="dob" type="date" class="w-full" required />
                <p id="dob_error" class="text-red-600 text-sm"></p>
            </div>

            <!-- NID -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label for="nid">NID *</x-input-label>
                <x-text-input id="nid" name="nid" class="w-full" required />
                <p id="nid_error" class="text-red-600 text-sm"></p>
            </div>

            <!-- ADDRESS -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label for="address">Address *</x-input-label>
                <x-text-input id="address" name="address" class="w-full" required />
            </div>

            <!-- OCCUPATION -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label for="occupation">Occupation *</x-input-label>
                <x-text-input id="occupation" name="occupation" class="w-full" required />
            </div>

            <!-- INCOME -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label for="income">Monthly Income *</x-input-label>
                <x-text-input id="income" name="income" type="number" class="w-full" required />
                <p id="income_error" class="text-red-600 text-sm"></p>
            </div>

            <!-- PASSWORD -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label for="password">Password *</x-input-label>
                <x-text-input id="password" name="password" type="password" class="w-full" required />
                <p id="password_error" class="text-red-600 text-sm"></p>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label for="password_confirmation">Confirm Password *</x-input-label>
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="w-full"
                    required />
            </div>
        </div>

        <!-- FOOTER -->
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('login') }}" class="text-sm underline text-gray-600">
                Already registered?
            </a>

            <button id="registerBtn" type="button"
                class="bg-gray-400 cursor-not-allowed px-6 py-2 rounded-lg text-white flex items-center gap-2">
                <svg id="btnLoader" class="hidden w-4 h-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                <span id="btnText">Register</span>
            </button>


        </div>
    </form>

    <div id="otpModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50">
    
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">
    
            <!-- Close -->
            <button onclick="otpModal.classList.add('hidden')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                ✕
            </button>
    
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="mx-auto w-12 h-12 flex items-center justify-center
                    rounded-full bg-blue-100 text-blue-600 text-xl font-bold">
                    🔐
                </div>
                <h3 class="text-xl font-bold text-gray-800 mt-3">
                    OTP Verification
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                    Enter the 6-digit code sent to your email
                </p>
            </div>
    
            <!-- OTP Input -->
            <input id="otpInput" maxlength="6" inputmode="numeric" class="w-full text-center tracking-widest text-xl border rounded-lg py-3
                focus:ring-2 focus:ring-blue-500 focus:outline-none mb-3" placeholder="••••••">
    
            <!-- Timer -->
            <p class="text-center text-sm text-gray-500 mb-4">
                Code expires in <span id="otpTimer" class="font-semibold text-red-500">05:00</span>
            </p>
    
            <!-- Verify Button -->
            <button id="verifyOtpBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold">
                Verify & Continue
            </button>
        </div>
    </div>



    <!-- JS VALIDATION -->
    <script>
        const email = document.getElementById('email');
        const phone = document.getElementById('phone');
        const nid = document.getElementById('nid');
        const income = document.getElementById('income');
        const password = document.getElementById('password');
        const dob = document.getElementById('dob');
        const btn = document.getElementById('registerBtn');

    const errors = {
        email: document.getElementById('email_error'),
        phone: document.getElementById('phone_error'),
        nid: document.getElementById('nid_error'),
        income: document.getElementById('income_error'),
        password: document.getElementById('password_error'),
        dob: document.getElementById('dob_error')
    };


        const validate = {
            email: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v),
            phone: v => /^0\d{10}$/.test(v),
            nid: v => /^\d{10}$/.test(v),
            income: v => v > 0,
            password: v =>
                v.length >= 8 &&
                /[A-Z]/.test(v) &&
                /[a-z]/.test(v) &&
                /\d/.test(v) &&
                /[@$!%*?&#]/.test(v),
            dob: v => new Date().getFullYear() - new Date(v).getFullYear() >= 19
        };

        function toggleBtn() {
            const ok = Object.keys(validate).every(k =>
                validate[k](document.getElementById(k).value)
            );

            btn.dataset.valid = ok ? '1' : '0';
            btn.className = ok
                ? 'bg-blue-900 hover:bg-blue-800 px-6 py-2 rounded-lg text-white'
                : 'bg-gray-400 cursor-not-allowed px-6 py-2 rounded-lg text-white';
        }

        email.oninput = () => {
            errors.email.textContent = validate.email(email.value) ? '' : 'Invalid email';
            toggleBtn();
        };

        phone.oninput = () => {
            phone.value = phone.value.replace(/\D/g, '');
            if (phone.value[0] !== '0') phone.value = '0' + phone.value;
            phone.value = phone.value.slice(0, 11);
            errors.phone.textContent = validate.phone(phone.value) ? '' : 'Phone must be 11 digits';
            toggleBtn();
        };

        nid.oninput = () => {
            nid.value = nid.value.replace(/\D/g, '').slice(0, 10);
            errors.nid.textContent = validate.nid(nid.value) ? '' : 'NID must be 10 digits';
            toggleBtn();
        };

        income.oninput = () => {
            errors.income.textContent = validate.income(income.value) ? '' : 'Invalid income';
            toggleBtn();
        };

        password.oninput = () => {
            errors.password.textContent = validate.password(password.value)
                ? ''
                : 'Use upper, lower, number & symbol';
            toggleBtn();
        };

        dob.onchange = () => {
            errors.dob.textContent = validate.dob(dob.value)
                ? ''
                : 'Must be 19+';
            toggleBtn();
        };
    </script>

    <script>
const form = document.getElementById('registerForm');
const otpModal = document.getElementById('otpModal');


// REGISTER
    document.getElementById('registerBtn').addEventListener('click', async () => {

        if (btn.dataset.valid !== '1') {
            alert('Please fix validation errors first');
            return;
        }

        // 🔒 LOCK BUTTON
        btn.disabled = true;
        btn.className = 'bg-gray-400 cursor-not-allowed px-6 py-2 rounded-lg text-white flex items-center gap-2';
        document.getElementById('btnText').innerText = 'Sending OTP...';
        document.getElementById('btnLoader').classList.remove('hidden');

        const res = await fetch("{{ route('register.sendOtp') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: new FormData(form)
        });

        const data = await res.json();

        if (res.ok) {
            otpModal.classList.remove('hidden');
            startOtpTimer();
        } else {
            alert(data.message || 'OTP send failed');

            // 🔓 UNLOCK BUTTON IF ERROR
            btn.disabled = false;
            document.getElementById('btnText').innerText = 'Register';
            document.getElementById('btnLoader').classList.add('hidden');
        }
    });


// OTP timer
let otpTime = 300;
function startOtpTimer() {
    otpTime = 300;
    const timer = setInterval(() => {
        document.getElementById('otpTimer').innerText =
            `${Math.floor(otpTime/60)}:${String(otpTime%60).padStart(2,'0')}`;
        if (--otpTime <= 0) clearInterval(timer);
    }, 1000);
}

</script>
<script>
    document.getElementById('verifyOtpBtn').onclick = async () => {

        const verifyBtn = document.getElementById('verifyOtpBtn');
        verifyBtn.disabled = true;
        verifyBtn.innerText = 'Verifying...';

        const res = await fetch("{{ route('register.verifyOtp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                email: document.getElementById('email').value,
                otp: document.getElementById('otpInput').value
            })
        });

        if (res.ok) {
            window.location.href = "{{ route('dashboard') }}";
        } else {
            alert('Invalid OTP');
            verifyBtn.disabled = false;
            verifyBtn.innerText = 'Verify & Continue';
        }
    };

</script>


</x-guest-layout>