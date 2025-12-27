<x-admin-layout>

    {{-- PAGE TITLE --}}
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Users List</h1>

    {{-- TOP BAR --}}
    <div class="flex flex-wrap gap-4 justify-between items-center mb-6">

    {{-- SEARCH & ACTION BAR --}}
    <div class="flex flex-wrap gap-3 items-center justify-between mb-6">

    {{-- SEARCH INPUT --}}
    <input type="text" id="searchInput"
        placeholder="Search by account number"
        class="border rounded px-3 py-2 w-64" />

    </div>


    {{-- CREATE USER BUTTON --}}
    <div class="flex justify-end mb-4">
        <button onclick="openCreateUserModal()"
            class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
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
                    <th class="p-3">Phone Number</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                {{-- ONLY USERS Role --}}
                @php
$onlyUsers = $users->where('role', 'user');
                @endphp

                @forelse ($onlyUsers as $user)
                                                                                                                                                                                        <tr class="border-b text-center 
                                                                                                                {{ $user->status === 'rejected' ? 'bg-gray-100 text-gray-400' : 'hover:bg-gray-50' }}">


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

                                                                                                                                                                                            <td class="px-3 py-5 space-x-2 flex flex-row justify-center">

                                                                                                {{-- VIEW --}}
                                                                                                <button
                                                                            @if($user->status !== 'rejected')
                                                                                onclick='openViewModal(@json($user))'
                                                                            @endif
                                                                            class="px-1 py-1 rounded text-sm
                                                                                {{ $user->status === 'rejected'
                            ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                            : 'bg-green-600 text-white hover:bg-green-700' }}"
                                                                            {{ $user->status === 'rejected' ? 'disabled' : '' }}>
                                                                            <i class="fa fa-eye"></i>
                                                                        </button>

                                                                                                {{-- EDIT --}}
                                                                                                <button
                                                        @if(!in_array($user->status, ['blocked', 'rejected']))
                                                            onclick='openEditModal(@json($user))'
                                                        @endif
                                                        class="px-1 py-1 rounded text-sm
                                                            {{ in_array($user->status, ['blocked', 'rejected'])
                            ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                            : 'bg-blue-600 text-white hover:bg-blue-700' }}"
                                                        {{ in_array($user->status, ['blocked', 'rejected']) ? 'disabled' : '' }}>
                                                        <i class="fas fa-edit"></i>
                                                    </button>


                                                                                                {{-- STATUS (HIDDEN IF REJECTED) --}}
                                                                                                @if($user->status !== 'rejected')
                                                                                                    <button
                                                                                                        onclick="openStatusModal({{ $user->id }}, '{{ $user->status }}')"
                                                                                                        class="px-1 py-1 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700">
                                                                                                        <i class="fa-solid fa-layer-group"></i>
                                                                                                    </button>
                                                                                                @endif


                                                                                                {{-- DELETE --}}
                                                                                                <button
                        @if(!in_array($user->status, ['blocked', 'rejected']))
                            onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                        @endif
                        class="px-1 py-1 rounded text-sm
                            {{ in_array($user->status, ['blocked', 'rejected'])
                            ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                            : 'bg-red-600 text-white hover:bg-red-700' }}"
                        {{ in_array($user->status, ['blocked', 'rejected']) ? 'disabled' : '' }}>
                        <i class="fa-solid fa-trash"></i>
                    </button>


                                                                                            </td>

                                                                                                                                                                                        </tr>

                @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-gray-500 font-medium">
                            No users are available.
                        </td>
                    </tr>
                @endforelse

                <tr id="noDataRow" class="hidden">
                    <td colspan="8" class="p-6 text-center text-gray-500 font-medium">
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

        <div
            class="bg-white w-full max-w-2xl rounded-2xl shadow-xl p-8 relative 
                max-h-[90vh] overflow-y-auto">

            <div class="flex justify-between items-center mb-6">
                <!-- Header -->
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">User Details</h2>

                <!-- Close Button -->
                <button onclick="closeViewModal()" class="text-gray-600 hover:text-black text-2xl">&times;</button>

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

    {{-- -------------------------------- --}}
    {{-- EDIT USER MODAL --}}
    {{-- -------------------------------- --}}
    <div id="editModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4 overflow-y-auto">

        <div
            class="bg-white w-full max-w-5xl rounded-2xl shadow-xl p-8 relative 
                max-h-[90vh] overflow-y-auto">

            <!-- Close Button -->
            <button onclick="closeEditModal()"
                class="absolute top-3 right-4 text-gray-600 hover:text-black text-2xl">&times;</button>

            <!-- Header -->
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Edit User</h2>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- GRID LAYOUT -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="font-semibold text-gray-700">Full Name</label>
                        <input id="edit_name" type="text" name="name" class="w-full p-2 border rounded mt-1">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Email</label>
                        <input id="edit_email" type="email" name="email" class="w-full p-2 border rounded mt-1">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Phone</label>
                        <input id="edit_phone" type="text" name="phone" class="w-full p-2 border rounded mt-1">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Date of Birth</label>
                        <input id="edit_dob" type="date" name="dob" class="w-full p-2 border rounded mt-1">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">NID Number</label>
                        <input id="edit_nid" type="text" name="nid" class="w-full p-2 border rounded mt-1">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Change NID Image (optional)</label>
                        <input id="edit_nid_image" type="file" name="nid_image"
                            class="w-full p-2 border rounded mt-1">
                    </div>

                    <div class="md:col-span-2">
                        <label class="font-semibold text-gray-700">Address</label>
                        <input id="edit_address" type="text" name="address"
                            class="w-full p-2 border rounded mt-1">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Occupation</label>
                        <input id="edit_occupation" type="text" name="occupation"
                            class="w-full p-2 border rounded mt-1">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Income</label>
                        <input id="edit_income" type="number" name="income"
                            class="w-full p-2 border rounded mt-1">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Role</label>
                        <select id="edit_role" name="role" class="w-full p-2 border rounded mt-1 bg-white">
                            <option value="user">User</option>
                            <option value="manager">Manager</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                </div>

                <!-- SUBMIT BUTTON -->
                <button class="mt-6 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update User
                </button>
            </form>

        </div>
    </div>

    {{-- CREATE USER ACCOUNT MODAL --}}
<div id="createUserModal"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4 overflow-y-auto">

    <div class="bg-white w-full max-w-5xl rounded-2xl shadow-xl p-8 relative max-h-[90vh] overflow-y-auto">

        <button onclick="closeCreateUserModal()"
            class="absolute top-3 right-4 text-gray-600 hover:text-black text-2xl">&times;</button>

        <h2 class="text-2xl font-bold mb-6 border-b pb-3">Create User Account</h2>

        <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label>Full Name</label>
                    <input type="text" name="name" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label>Phone</label>
                    <input type="text" name="phone" class="w-full p-2 border rounded">
                </div>

                <div>
                    <label>Password</label>
                    <input type="password" name="password" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="w-full p-2 border rounded">
                </div>

                <div>
                    <label>NID Number</label>
                    <input type="text" name="nid" class="w-full p-2 border rounded">
                </div>

                <div>
                    <label>NID Image</label>
                    <input type="file" name="nid_image" class="w-full p-2 border rounded">
                </div>

                <div class="md:col-span-2">
                    <label>Address</label>
                    <input type="text" name="address" class="w-full p-2 border rounded">
                </div>

                <div>
                    <label>Occupation</label>
                    <input type="text" name="occupation" class="w-full p-2 border rounded">
                </div>

                <div>
                    <label>Monthly Income</label>
                    <input type="number" name="income" class="w-full p-2 border rounded">
                </div>

                <div>
                    <label>Role</label>
                    <select name="role" class="w-full p-2 border rounded">
                        <option value="user">User</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>

            </div>

            <button class="mt-6 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Create Account
            </button>
        </form>

    </div>
</div>

<div id="statusModal"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-xl p-6 w-96 relative">
        <h2 class="text-xl font-bold mb-4">Update User Status</h2>

        <form method="POST" id="statusForm">
            @csrf

            <select name="status" id="statusSelect"
                class="w-full p-2 border rounded mb-4">
                <option value="inactive">Inactive (Pending)</option>
                <option value="active">Active (Approved)</option>
                <option value="blocked">Blocked</option>
                <option value="rejected">Rejected</option>
            </select>

            <button class="w-full bg-blue-600 text-white py-2 rounded">
                Update Status
            </button>
        </form>

        <button onclick="closeStatusModal()"
            class="absolute top-3 right-4 text-xl">&times;</button>
    </div>
</div>


    {{-- JAVASCRIPT LOGIC --}}
    <script>
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
                document.getElementById("view_nid_image").src = `/storage/${user.nid_image}`;
                document.getElementById("view_nid_image").classList.remove("hidden");
            } else {
                document.getElementById("view_nid_image").classList.add("hidden");
            }

            document.getElementById("viewModal").classList.remove("hidden");
        }

        function closeViewModal() {
            document.getElementById("viewModal").classList.add("hidden");
        }

        function closeViewModal() {
            document.getElementById("viewModal").classList.add("hidden");
        }

        function openEditModal(user) {
            document.getElementById("edit_name").value = user.name;
            document.getElementById("edit_email").value = user.email;
            document.getElementById("edit_phone").value = user.phone;
            document.getElementById("edit_dob").value = user.dob;
            document.getElementById("edit_nid").value = user.nid;
            document.getElementById("edit_address").value = user.address;
            document.getElementById("edit_occupation").value = user.occupation;
            document.getElementById("edit_income").value = user.income;
            document.getElementById("edit_role").value = user.role;

            document.getElementById("editForm").action = `/admin/users/${user.id}`;
            document.getElementById("editModal").classList.remove("hidden");
        }


        function closeEditModal() {
            document.getElementById("editModal").classList.add("hidden");
        }

        function openDeleteModal(id) {
            document.getElementById("deleteForm").action = `/admin/users/${id}`;
            document.getElementById("deleteModal").classList.remove("hidden");
        }

        function closeDeleteModal() {
            document.getElementById("deleteModal").classList.add("hidden");
        }

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

        function openStatusModal(userId, currentStatus) {
        document.getElementById('statusForm').action = `/admin/users/${userId}/status`;
        document.getElementById('statusSelect').value = currentStatus;
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
            // Account Number column index = 1
            const accountNumber = row.children[1].innerText.toLowerCase();

            if (accountNumber.includes(filter)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Show "No data found"
        if (visibleCount === 0) {
            noDataRow.classList.remove('hidden');
        } else {
            noDataRow.classList.add('hidden');
        }
    });


    function openStatusModal(userId, currentStatus) {

    const select = document.getElementById('statusSelect');
    const form = document.getElementById('statusForm');

    // Reset: show all options first
    Array.from(select.options).forEach(opt => opt.hidden = false);

    // BUSINESS RULES
    if (currentStatus === 'active') {
        // Active → only allowed to stay active or go blocked
        select.querySelector('option[value="inactive"]').hidden = true;
        select.querySelector('option[value="rejected"]').hidden = true;
    }

    if (currentStatus === 'rejected') {
        // Rejected → cannot go back
        select.querySelector('option[value="inactive"]').hidden = true;
        select.querySelector('option[value="active"]').hidden = true;
        select.querySelector('option[value="blocked"]').hidden = true;
    }

    if (currentStatus === 'blocked') {
        // Blocked → can only be active or stay blocked
        select.querySelector('option[value="inactive"]').hidden = true;
        select.querySelector('option[value="rejected"]').hidden = true;
    }

    

    // Set selected value
    select.value = currentStatus;

    // Set form action
    form.action = `/admin/users/${userId}/status`;

    // Show modal
    document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}
    </script>



</x-admin-layout>
