<x-admin-layout>
        {{-- PAGE TITLE --}}
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Users List</h1>

    {{-- TOP BAR --}}
    <div class="flex flex-wrap gap-4 justify-between items-center mb-6">

        {{-- Error --}}
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: `
                        <ul class="text-left">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    `,
                    confirmButtonColor: '#dc2626'
                });
            </script>
        @endif

        {{-- SEARCH --}}
        <input
            type="text"
            id="searchInput"
            placeholder="Search by account number"
            class="border rounded px-3 py-2 w-64"
        />

        {{-- CREATE USER BUTTON --}}
        <div class="ml-auto">
            <button
                onclick="openCreateUserModal()"
                class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                + Create User Account
            </button>
        </div>

    </div>

    {{-- USERS TABLE --}}
    <div class="bg-white p-6 rounded-xl shadow border overflow-y-auto max-h-[70vh]">

        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-sm border-b text-center">
                    <th class="p-3">ID</th>
                    <th class="p-3">Acc Num</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">NID</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @php
$onlyUsers = $users->where('role', 'user');
                @endphp

                @forelse ($onlyUsers as $user)
                    <tr class="border-b text-center {{ $user->status === 'rejected' ? 'bg-gray-100 text-gray-400' : 'hover:bg-gray-50' }}">

                        <td class="p-3">{{ $user->id }}</td>
                        <td class="p-3">{{ $user->account_number }}</td>
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">{{ $user->nid }}</td>
                        <td class="p-3">{{ $user->phone }}</td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs">
                                {{ $user->role }}
                            </span>
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($user->status === 'active') bg-green-100 text-green-700
                                @elseif($user->status === 'inactive') bg-yellow-100 text-yellow-700
                                @elseif($user->status === 'blocked') bg-orange-100 text-orange-700
                                @elseif($user->status === 'rejected') bg-red-100 text-red-700
                                @endif">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>

                        <td class="px-3 py-5 flex justify-center gap-2">

                            {{-- VIEW --}}
                            <button
                                @if($user->status !== 'rejected')
                                    onclick='openViewModal(@json($user))'
                                @endif
                                class="px-2 py-1 rounded text-sm
                                    {{ $user->status === 'rejected' ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-green-600 text-white hover:bg-green-700'
                                    }}"
                                {{ $user->status === 'rejected' ? 'disabled' : '' }}
                            >
                                <i class="fa fa-eye"></i>
                            </button>

                            {{-- STATUS --}}
                            @if($user->status !== 'rejected')
                                <button
                                    onclick="openStatusModal({{ $user->id }}, '{{ $user->status }}')"
                                    class="px-2 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700"
                                >
                                    <i class="fa-solid fa-layer-group"></i>
                                </button>
                            @endif

                            {{-- DELETE --}}
                            <button
                                @if(!in_array($user->status, ['blocked', 'rejected']))
                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                @endif
                                class="px-2 py-1 rounded text-sm
                                    {{ in_array($user->status, ['blocked', 'rejected']) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-red-600 text-white hover:bg-red-700'
                                    }}"
                                {{ in_array($user->status, ['blocked', 'rejected']) ? 'disabled' : '' }}
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-6 text-center text-gray-500 font-medium">
                            No users are available.
                        </td>
                    </tr>
                @endforelse

                <tr id="noDataRow" class="hidden">
                    <td colspan="9" class="p-6 text-center text-gray-500 font-medium">
                        No matching users found.
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    {{-- -------------------------------- --}}
    {{-- VIEW USER MODAL --}}
    {{-- -------------------------------- --}}
    <div id="viewModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl p-8 relative max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <!-- Header -->
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">
                    User Details
                </h2>
    
                <!-- Close Button -->
                <button onclick="closeViewModal()" class="text-gray-600 hover:text-black text-2xl">
                    &times;
                </button>
            </div>
    
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
                <div>
                    <p class="text-gray-500 font-medium">Full Name</p>
                    <p id="view_name" class="text-lg font-semibold text-gray-800"></p>
                </div>
    
                <div>
                    <p class="text-gray-500 font-medium">Email</p>
                    <p id="view_email" class="text-lg"></p>
                </div>
    
                <div>
                    <p class="text-gray-500 font-medium">Phone</p>
                    <p id="view_phone" class="text-lg"></p>
                </div>
    
                <div>
                    <p class="text-gray-500 font-medium">Date of Birth</p>
                    <p id="view_dob" class="text-lg"></p>
                </div>
    
                <div>
                    <p class="text-gray-500 font-medium">NID Number</p>
                    <p id="view_nid" class="text-lg"></p>
                </div>
    
                <div>
                    <p class="text-gray-500 font-medium mb-1">NID Image</p>
                    <img id="view_nid_image" class="w-[150px] h-44 object-cover border rounded-lg shadow">
                </div>
    
                <div>
                    <p class="text-gray-500 font-medium">Address</p>
                    <p id="view_address" class="text-lg"></p>
                </div>
    
                <div>
                    <p class="text-gray-500 font-medium">Occupation</p>
                    <p id="view_occupation" class="text-lg"></p>
                </div>
    
                <div>
                    <p class="text-gray-500 font-medium">Income</p>
                    <p id="view_income" class="text-lg"></p>
                </div>
    
                <div>
                    <p class="text-gray-500 font-medium">Role</p>
                    <span id="view_role"
                        class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700"></span>
                </div>
    
            </div>
        </div>
    </div>
    
    
    {{-- CREATE USER ACCOUNT MODAL --}}
    <div id="createUserModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white w-full max-w-5xl rounded-2xl shadow-xl p-8 relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeCreateUserModal()" class="absolute top-3 right-4 text-gray-600 hover:text-black text-2xl">
                &times;
            </button>
    
            <h2 class="text-2xl font-bold mb-6 border-b pb-3">
                Create User Account
            </h2>
    
            <form id="createUserForm" method="POST" enctype="multipart/form-data">
                @csrf
    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
                    <div>
                        <label>Full Name</label>
                        <input type="text" name="name" class="w-full p-2 border rounded" required>
                    </div>
    
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
                        <span id="email_error" class="text-red-600 text-sm"></span>
                    </div>
    
                    <div>
                        <label>Phone</label>
                        <input type="text" name="phone" id="phone" maxlength="11" class="w-full p-2 border rounded"
                            required>
                        <span id="phone_error" class="text-red-600 text-sm"></span>
                    </div>
    
                    <div class="relative">
                        <label>Password</label>
    
                        <input type="password" name="password" id="password" class="w-full p-2 border rounded pr-10"
                            required>
    
                        <!-- Toggle Button -->
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-9 text-gray-500 hover:text-gray-700">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </button>
    
                        <span id="password_error" class="text-red-600 text-sm"></span>
                    </div>
    
                    <div>
                        <label>Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="w-full p-2 border rounded" required>
                        <span id="dob_error" class="text-red-600 text-sm"></span>
                    </div>
    
                    <div>
                        <label>NID Number</label>
                        <input type="number" name="nid" id="nid" class="w-full p-2 border rounded" required>
                        <span id="nid_error" class="text-red-600 text-sm"></span>
                    </div>
    
                    <div>
                        <label>NID Image</label>
                        <input type="file" name="nid_image" id="nid_image" class="w-full p-2 border rounded" required>
                        <span id="nid_image_error" class="text-red-600 text-sm"></span>
                    </div>
    
                    <div class="md:col-span-2">
                        <label>Address</label>
                        <input type="text" name="address" class="w-full p-2 border rounded" required>
                    </div>
    
                    <div>
                        <label>Occupation</label>
                        <input type="text" name="occupation" class="w-full p-2 border rounded" required>
                    </div>
    
                    <div>
                        <label>Monthly Income</label>
                        <input type="number" name="income" id="income" class="w-full p-2 border rounded" required>
                        <span id="income_error" class="text-red-600 text-sm"></span>
                    </div>
    
                    <div>
                        <label>Role</label>
                        <select name="role" class="w-full p-2 border rounded">
                            <option value="user">User</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>
    
                </div>
    
                <button type="button" id="createBtn" onclick="sendOtp()" disabled
                    class="mt-6 px-6 py-2 bg-gray-400 text-white rounded cursor-not-allowed flex items-center justify-center gap-2">
                    <span id="createBtnText">Create Account</span>
    
                    <!-- Spinner -->
                    <svg id="createBtnLoader" class="w-5 h-5 animate-spin hidden" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a12 12 0 00-12 12h4z">
                        </path>
                    </svg>
                </button>
    
            </form>
    
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}",
                        confirmButtonColor: '#16a34a'
                    });
                </script>
            @endif
        </div>
    </div>
    
    
    {{-- OTP Model --}}
    <div id="otpModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded w-96">
    
            <h3 class="text-lg font-bold mb-2">Verify OTP</h3>
    
            <p class="text-sm text-gray-600 mb-3">
                OTP expires in
                <span id="otpTimer" class="font-semibold text-red-600">05:00</span>
            </p>
    
            <input type="text" id="otp" maxlength="6" oninput="this.value=this.value.replace(/\D/g,'')"
                class="w-full border p-2 mb-3" placeholder="Enter 6-digit OTP">
    
            <button id="verifyOtpBtn" onclick="verifyOtp()" class="w-full bg-green-600 text-white py-2 rounded mb-2">
                Verify & Create
            </button>
    
            <button id="resendOtpBtn" onclick="resendOtp()"
                class="w-full bg-gray-400 text-white py-2 rounded hidden cursor-not-allowed">
                Resend OTP
            </button>
    
        </div>
    </div>
    
    
    {{-- Status Model --}}
    <div id="statusModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl p-6 w-96 relative">
    
            <h2 class="text-xl font-bold mb-4">Update User Status</h2>
    
            <form method="POST" id="statusForm">
                @csrf
    
                <select name="status" id="statusSelect" class="w-full p-2 border rounded mb-4">
                    <option value="inactive">Inactive (Pending)</option>
                    <option value="active">Active (Approved)</option>
                    <option value="blocked">Blocked</option>
                    <option value="rejected">Rejected</option>
                </select>
    
                <button class="w-full bg-blue-600 text-white py-2 rounded">
                    Update Status
                </button>
            </form>
    
            <button onclick="closeStatusModal()" class="absolute top-3 right-4 text-xl">
                &times;
            </button>
    
        </div>
    </div>


    {{-- JAVASCRIPT LOGIC --}}
    <script>

        // OPEN VIEW MODAL
        function openViewModal(user) {
            document.getElementById("view_name").innerText = user.name ?? '';
            document.getElementById("view_email").innerText = user.email ?? '';
            document.getElementById("view_phone").innerText = user.phone ?? '';
            document.getElementById("view_dob").innerText = user.dob ?? '';
            document.getElementById("view_nid").innerText = user.nid ?? '';
            document.getElementById("view_address").innerText = user.address ?? '';
            document.getElementById("view_occupation").innerText = user.occupation ?? '';
            document.getElementById("view_income").innerText = user.income ?? '';
            document.getElementById("view_role").innerText = user.role ?? 'User';

            if (user.nid_image) {
                const img = document.getElementById("view_nid_image");
                img.src = `/storage/${user.nid_image}`;
                img.classList.remove("hidden");
            } else {
                document.getElementById("view_nid_image").classList.add("hidden");
            }

            document.getElementById("viewModal").classList.remove("hidden");
        }

        // CLOSE VIEW MODAL
        function closeViewModal() {
            document.getElementById("viewModal").classList.add("hidden");
        }

        // OPEN DELETE MODAL
        function openDeleteModal(id) {
            document.getElementById("deleteForm").action = `/admin/users/${id}`;
            document.getElementById("deleteModal").classList.remove("hidden");
        }

        // CLOSE DELETE MODAL
        function closeDeleteModal() {
            document.getElementById("deleteModal").classList.add("hidden");
        }

        // CONFIRM DELETE
        function confirmDelete(id, name) {
            if (!confirm(`Are you sure to delete ${name}?`)) return;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${id}`;

            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="DELETE">
            `;

            document.body.appendChild(form);
            form.submit();
        }

        // Create account
        function openCreateUserModal() {
            document.getElementById('createUserModal').classList.remove('hidden');
        }

        // TOGGLE PASSWORD
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // SEND OTP
        function sendOtp() {
            const btn = document.getElementById('createBtn');
            const btnText = document.getElementById('createBtnText');
            const loader = document.getElementById('createBtnLoader');

            btn.disabled = true;
            btn.classList.add('cursor-not-allowed');
            btnText.innerText = 'Sending OTP...';
            loader.classList.remove('hidden');

            fetch("{{ route('admin.users.sendOtp') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    email: document.getElementById('email').value
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('createUserModal').classList.add('hidden');
                        document.getElementById('otpModal').classList.remove('hidden');
                        startOtpTimer(300);
                    } else {
                        Swal.fire('Error', data.message, 'error');
                        btn.disabled = false;
                        btnText.innerText = 'Create Account';
                        loader.classList.add('hidden');
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'Something went wrong. Try again.', 'error');
                    btn.disabled = false;
                    btnText.innerText = 'Create Account';
                    loader.classList.add('hidden');
                });
        }

        // RESEND OTP
        function resendOtp() {
            fetch("{{ route('admin.users.sendOtp') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    email: document.getElementById('email').value
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) throw data;
                    Swal.fire('OTP Sent', 'New OTP has been sent to email', 'success');
                    startOtpTimer(300);
                })
                .catch(() => {
                    Swal.fire('Error', 'Unable to resend OTP', 'error');
                });
        }

        // RESET CREATE BUTTON
        function resetCreateButton() {
            const btn = document.getElementById('createBtn');
            const btnText = document.getElementById('createBtnText');
            const loader = document.getElementById('createBtnLoader');

            btn.disabled = false;
            btnText.innerText = 'Create Account';
            loader.classList.add('hidden');
        }

        // VERIFY OTP
        function verifyOtp() {
            const btn = document.getElementById('verifyOtpBtn');
            btn.innerText = 'Verifying...';
            btn.disabled = true;

            const form = document.getElementById('createUserForm');
            const formData = new FormData(form);

            formData.append('otp', document.getElementById('otp').value);
            formData.append('email', document.getElementById('email').value);

            fetch("{{ route('admin.users.verifyOtp') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) throw data;

                    document.getElementById('otpModal').classList.add('hidden');

                    Swal.fire('Success', data.message, 'success');

                    // ONLY append if role is "user"
                    if (data.user && data.user.role === 'user') {
                        appendUserRow(data.user);
                    }

                    btn.innerText = 'Verify & Create';
                    btn.disabled = false;
                })
                .catch(err => {
                    Swal.fire('Error', err.message || 'Invalid OTP', 'error');
                    btn.innerText = 'Verify & Create';
                    btn.disabled = false;
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const email = document.getElementById('email');
            const phone = document.getElementById('phone');
            const nid = document.getElementById('nid');
            const income = document.getElementById('income');
            const password = document.getElementById('password');
            const dob = document.getElementById('dob');
            const nidImage = document.getElementById('nid_image');
            const createBtn = document.getElementById('createBtn');

            const email_error = document.getElementById('email_error');
            const phone_error = document.getElementById('phone_error');
            const nid_error = document.getElementById('nid_error');
            const income_error = document.getElementById('income_error');
            const password_error = document.getElementById('password_error');
            const dob_error = document.getElementById('dob_error');
            const nid_image_error = document.getElementById('nid_image_error');

            const validators = {
                email: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v),
                phone: v => /^\d{11}$/.test(v),
                nid: v => /^\d{10}$/.test(v),
                income: v => v >= 0 && v <= 99999999,
                password: v =>
                    /[A-Z]/.test(v) &&
                    /[a-z]/.test(v) &&
                    /\d/.test(v) &&
                    /[@$!%*?&#]/.test(v) &&
                    v.length >= 8
            };

            function toggleButton() {
                const valid =
                    validators.email(email.value) &&
                    validators.phone(phone.value) &&
                    validators.nid(nid.value) &&
                    validators.income(income.value) &&
                    validators.password(password.value) &&
                    dob_error.innerText === '' &&
                    nid_image_error.innerText === '';

                createBtn.disabled = !valid;
                createBtn.className = valid
                    ? 'mt-6 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700'
                    : 'mt-6 px-6 py-2 bg-gray-400 text-white rounded cursor-not-allowed';
            }

            email.addEventListener('input', () => {
                email_error.innerText = validators.email(email.value)
                    ? ''
                    : 'Invalid email format';
                toggleButton();
            });

            phone.addEventListener('input', () => {
                phone.value = phone.value.replace(/\D/g, '');
                if (phone.value.length > 0 && phone.value[0] !== '0') {
                    phone.value = '0' + phone.value;
                }
                phone.value = phone.value.slice(0, 11);

                phone_error.innerText = /^\d{11}$/.test(phone.value)
                    ? ''
                    : 'Phone must be 11 digits and start with 0';

                toggleButton();
            });

            nid.addEventListener('input', () => {
                nid.value = nid.value.replace(/\D/g, '');
                nid.value = nid.value.slice(0, 10);

                nid_error.innerText = nid.value.length === 10
                    ? ''
                    : 'NID must be exactly 10 digits';

                toggleButton();
            });

            income.addEventListener('input', () => {
                income_error.innerText = validators.income(income.value)
                    ? ''
                    : 'Income must be between 0 and 99,999,999';
                toggleButton();
            });

            password.addEventListener('input', () => {
                password_error.innerText = validators.password(password.value)
                    ? ''
                    : 'Password must contain uppercase, lowercase, number & symbol';
                toggleButton();
            });

            dob.addEventListener('change', () => {
                const birth = new Date(dob.value);
                const age = new Date().getFullYear() - birth.getFullYear();
                dob_error.innerText = age >= 19
                    ? ''
                    : 'User must be at least 19 years old';
                toggleButton();
            });

            nidImage.addEventListener('change', () => {
                const file = nidImage.files[0];
                if (!file) return;

                const allowed = ['image/jpeg', 'image/png', 'image/jpg'];

                if (!allowed.includes(file.type)) {
                    nid_image_error.innerText = 'Only JPG, JPEG, PNG allowed';
                    nidImage.value = '';
                    return;
                }

                if (file.size > 2048 * 1024) {
                    nid_image_error.innerText = 'Image must be under 2MB';
                    nidImage.value = '';
                    return;
                }

                nid_image_error.innerText = '';
                toggleButton();
            });
        });

        // UPDATE STATUS
        function openStatusModal(userId, currentStatus) {
            const select = document.getElementById('statusSelect');
            const form = document.getElementById('statusForm');

            Array.from(select.options).forEach(opt => opt.hidden = false);

            if (currentStatus === 'active') {
                select.querySelector('option[value="inactive"]').hidden = true;
                select.querySelector('option[value="rejected"]').hidden = true;
            }

            if (currentStatus === 'rejected') {
                select.querySelector('option[value="inactive"]').hidden = true;
                select.querySelector('option[value="active"]').hidden = true;
                select.querySelector('option[value="blocked"]').hidden = true;
            }

            if (currentStatus === 'blocked') {
                select.querySelector('option[value="inactive"]').hidden = true;
                select.querySelector('option[value="rejected"]').hidden = true;
            }

            select.value = currentStatus;
            form.action = `/admin/users/${userId}/status`;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        function closeCreateUserModal() {
            document.getElementById('createUserModal').classList.add('hidden');
        }

        document.getElementById('searchInput').addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr:not(#noDataRow)');
            const noDataRow = document.getElementById('noDataRow');

            let visibleCount = 0;

            rows.forEach(row => {
                const accountNumber = row.children[1].innerText.toLowerCase();
                if (accountNumber.includes(filter)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (visibleCount === 0) {
                noDataRow.classList.remove('hidden');
            } else {
                noDataRow.classList.add('hidden');
            }
        });
    </script>
</x-admin-layout>
