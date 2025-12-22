<x-admin-layout>

    {{-- PAGE TITLE --}}
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Users List</h1>

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
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                {{-- ONLY USERS Role --}}
                @php
                    $onlyUsers = $users->where('role', 'user');
                @endphp

                @forelse ($onlyUsers as $user)
                    <tr class="border-b hover:bg-gray-50 text-center">
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

                        <td class="px-3 space-x-2 flex flex-row py-5">
                            <button onclick='openViewModal(@json($user))'
                                class="px-1 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>

                            <button onclick='openEditModal(@json($user))'
                                class="px-1 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button onclick='confirmDelete({{ $user->id }}, @json($user->name))'
                                class="px-1 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
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


    {{-- -------------------------------- --}}
    {{-- JAVASCRIPT LOGIC --}}
    {{-- -------------------------------- --}}
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
    </script>

</x-admin-layout>
