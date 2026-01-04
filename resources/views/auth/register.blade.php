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

            <button id="registerBtn" disabled class="bg-gray-400 cursor-not-allowed px-6 py-2 rounded-lg text-white">
                Register
            </button>
        </div>
    </form>

    <div id="otpModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">
    <div class="bg-white p-6 rounded w-96">
        <h3 class="font-bold mb-2">Verify OTP</h3>

        <input id="otpInput" class="w-full border p-2 mb-2" placeholder="6 digit OTP">

        <p class="text-sm mb-2">
            Expires in <span id="otpTimer">05:00</span>
        </p>

        <button id="verifyOtpBtn"
            class="w-full bg-blue-600 text-white py-2 rounded">
            Verify OTP
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

            btn.disabled = !ok;
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

document.getElementById('registerBtn').addEventListener('click', async () => {
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
    }
});


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
    }
};
</script>


</x-guest-layout>