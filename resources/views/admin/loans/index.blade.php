<x-admin-layout>

    <!-- PAGE TITLE -->
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Loan Management</h1>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- TOP BAR -->
    <div class="flex justify-end mb-4">
        <button onclick="openCreateModal()"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Create Loan
        </button>
    </div>

    <!-- LOANS TABLE -->
    <div class="bg-white p-6 rounded-xl shadow border overflow-x-auto">
        <table class="w-full text-left text-sm border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 border-b">
                    <th class="p-3">ID</th>
                    <th class="p-3">Borrower</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Duration</th>
                    <th class="p-3">Interest</th>
                    <th class="p-3">EMI</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($loans as $loan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $loan->id }}</td>
                        <td class="p-3">{{ $loan->user->name }}</td>
                        <td class="p-3">{{ number_format($loan->amount, 2) }}</td>
                        <td class="p-3">{{ $loan->duration }} months</td>
                        <td class="p-3">{{ $loan->interest_rate }}%</td>
                        <td class="p-3">{{ number_format($loan->emi, 2) }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($loan->status=='approved') bg-green-100 text-green-600
                                @elseif($loan->status=='rejected') bg-red-100 text-red-600
                                @elseif($loan->status=='paid') bg-blue-100 text-blue-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>

                        <td class="p-3 text-right space-x-2">
                            <button onclick='openViewModal(@json($loan))'
                                class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                                View
                            </button>

                            <button onclick='openStatusModal({{ $loan->id }})'
                                class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                                Status
                            </button>

                            <button onclick='openDeleteModal({{ $loan->id }})'
                                class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>


    <!-- ------------------------------ -->
    <!-- CREATE LOAN MODAL -->
    <!-- ------------------------------ -->
    <div id="createModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4 overflow-y-auto">

        <div class="bg-white w-full max-w-3xl rounded-2xl shadow-xl p-8 relative max-h-[90vh] overflow-y-auto">
            <h2 class="text-xl font-bold mb-4">Create New Loan</h2>

            <form method="POST" action="{{ route('admin.loans.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label>User</label>
                        <select name="user_id" class="w-full p-2 border rounded mt-1">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Loan Amount</label>
                        <input type="number" name="amount" class="w-full p-2 border rounded mt-1" required>
                    </div>

                    <div>
                        <label>Duration (Months)</label>
                        <input type="number" name="duration" class="w-full p-2 border rounded mt-1" required>
                    </div>

                    <div>
                        <label>Interest Rate (%)</label>
                        <input type="number" name="interest_rate" class="w-full p-2 border rounded mt-1" required>
                    </div>

                    <div class="md:col-span-2">
                        <label>Description</label>
                        <textarea name="description" class="w-full p-2 border rounded mt-1"></textarea>
                    </div>

                </div>

                <button class="mt-6 px-6 py-2 bg-blue-600 text-white rounded">Create Loan</button>
            </form>

            <button onclick="closeCreateModal()"
                class="absolute top-4 right-4 text-xl text-gray-600 hover:text-black">&times;</button>
        </div>
    </div>


    <!-- ------------------------------ -->
    <!-- VIEW LOAN MODAL -->
    <!-- ------------------------------ -->
    <div id="viewModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4 overflow-y-auto">

        <div class="bg-white w-full max-w-3xl rounded-2xl shadow-xl p-8 relative max-h-[90vh] overflow-y-auto">

            <h2 class="text-2xl font-bold mb-6">Loan Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div><strong>User:</strong> <p id="v_user"></p></div>
                <div><strong>Amount:</strong> <p id="v_amount"></p></div>
                <div><strong>Duration:</strong> <p id="v_duration"></p></div>
                <div><strong>Interest Rate:</strong> <p id="v_interest"></p></div>
                <div><strong>EMI:</strong> <p id="v_emi"></p></div>
                <div><strong>Status:</strong> <p id="v_status"></p></div>

                <div class="md:col-span-2">
                    <strong>Description:</strong>
                    <p id="v_description" class="text-gray-700"></p>
                </div>

            </div>

            <button onclick="closeViewModal()"
                class="absolute top-4 right-4 text-xl text-gray-600 hover:text-black">&times;</button>
        </div>
    </div>



    <!-- ------------------------------ -->
    <!-- STATUS MODAL -->
    <!-- ------------------------------ -->
    <div id="statusModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-8 relative">
            <h2 class="text-xl font-bold mb-4">Update Loan Status</h2>

            <form method="POST" id="statusForm">
                @csrf
                <select name="status" class="w-full p-2 border rounded mt-1">
                    <option value="pending">Pending</option>
                    <option value="approved">Approve</option>
                    <option value="rejected">Reject</option>
                    <option value="paid">Mark as Paid</option>
                </select>

                <button class="mt-6 px-6 py-2 bg-blue-600 text-white rounded">Update</button>
            </form>

            <button onclick="closeStatusModal()" class="absolute top-3 right-4 text-xl">&times;</button>
        </div>
    </div>


    <!-- ------------------------------ -->
    <!-- DELETE LOAN ALERT -->
    <!-- ------------------------------ -->
    <script>
        function openDeleteModal(id) {
            if (confirm("Are you sure you want to delete this loan?")) {
                window.location.href = "/admin/loans/" + id + "/delete";
            }
        }
    </script>


    <!-- ------------------------------ -->
    <!-- JAVASCRIPT LOGIC -->
    <!-- ------------------------------ -->
    <script>
        function openCreateModal() {
            document.getElementById("createModal").classList.remove("hidden");
        }
        function closeCreateModal() {
            document.getElementById("createModal").classList.add("hidden");
        }

        function openViewModal(loan) {
            document.getElementById("v_user").innerText = loan.user?.name;
            document.getElementById("v_amount").innerText = loan.amount;
            document.getElementById("v_duration").innerText = loan.duration + " months";
            document.getElementById("v_interest").innerText = loan.interest_rate + "%";
            document.getElementById("v_emi").innerText = loan.emi;
            document.getElementById("v_status").innerText = loan.status;
            document.getElementById("v_description").innerText = loan.description || "N/A";

            document.getElementById("viewModal").classList.remove("hidden");
        }
        function closeViewModal() {
            document.getElementById("viewModal").classList.add("hidden");
        }

        function openStatusModal(id) {
            document.getElementById("statusForm").action = `/admin/loans/${id}/status`;
            document.getElementById("statusModal").classList.remove("hidden");
        }
        function closeStatusModal() {
            document.getElementById("statusModal").classList.add("hidden");
        }
    </script>

</x-admin-layout>
