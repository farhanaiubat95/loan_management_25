<x-admin-layout>

    @php
$actionBtn = "w-7 h-7 flex items-center justify-center rounded text-white text-sm";
    @endphp


    <!-- PAGE TITLE -->
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Loan Management</h1>


    <!-- SEARCH & DOWNLOAD BAR -->
    <div class="flex flex-wrap gap-3 items-center justify-between mb-6">
    
        <input type="text" id="searchInput" placeholder="Search by Loan ID or account number"
            class="border rounded px-3 py-2 w-64" />
    
        <div class="flex gap-2">
            <button onclick="downloadCSV()" class="px-4 py-2 bg-yellow-600 text-white rounded">
                Download CSV
            </button>
    
            <button onclick="downloadLoanPDF()" class="px-4 py-2 bg-purple-600 text-white rounded">
                Download PDF
            </button>

            <button onclick="openCreateModal()" class="px-4 py-2 bg-red-900 text-white rounded hover:bg-blue-700">
                + Create Loan
            </button>
        </div>
    
    </div>

    <!-- SUCCESS MESSAGE -->
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- LOANS TABLE -->
    <div class="bg-white p-6 rounded-xl shadow border overflow-x-auto">
        <table class="w-full text-left text-sm border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 border-b text-center">
                    <th class="p-3">ID</th>
                    <th class="p-3">Acc Num</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Duration</th>
                    <th class="p-3">Interest</th>
                    <th class="p-3">EMI</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($loans as $loan)
                    <tr class="border-b hover:bg-gray-50 text-center">
                        <td class="p-3">{{ $loan->id }}</td>
                        <td class="p-3">{{ $loan->user->account_number }}</td>
                        <td class="p-3">{{ number_format($loan->amount, 2) }}</td>
                        <td class="p-3">{{ $loan->duration }} months</td>
                        <td class="p-3">{{ $loan->interest_rate }}%</td>
                        <td class="p-3">{{ number_format($loan->emi, 2) }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs
                            @if ($loan->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif ($loan->status === 'approved') bg-green-100 text-green-700
                            @elseif ($loan->status === 'active') bg-purple-100 text-purple-700
                            @elseif ($loan->status === 'completed') bg-blue-100 text-blue-700
                            @elseif ($loan->status === 'rejected') bg-red-100 text-red-700
                            @endif">
                                {{ ucfirst($loan->status) }}
                            </span>

                        </td>
                        <td class="px-3 py-5 flex gap-2 justify-center items-center">

                            <!-- View -->
                            <button onclick='openViewModal(@json($loan))' class="{{ $actionBtn }} bg-green-600 hover:bg-green-700">
                                <i class="fa fa-eye"></i>
                            </button>

                            {{-- EDIT BUTTON --}}
                            @if ($loan->status === 'pending' || $loan->status === 'approved')
                                <button onclick='openEditModal(@json($loan))' class="{{ $actionBtn }} bg-yellow-500 hover:bg-yellow-600"
                                    title="Edit Loan">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @else
                                <span class="{{ $actionBtn }} bg-gray-300 cursor-not-allowed" title="Editing disabled">
                                    <i class="fas fa-edit"></i>
                                </span>
                            @endif


                            {{-- STATUS ACTION --}}
                            @if (!in_array($loan->status, ['completed', 'rejected']))
                                <button onclick='openStatusModal({{ $loan->id }}, "{{ $loan->status }}")'
                                    class="{{ $actionBtn }} bg-blue-600 hover:bg-blue-700" title="Change Status">
                                    <i class="fa-solid fa-layer-group"></i>
                                </button>
                            @endif

                            {{-- DELETE authentication  --}}
                            @if(auth()->user()->role === 'admin')
                                @if (!in_array($loan->status, ['active', 'completed']))
                                <form action="{{ route('admin.loans.destroy', $loan->id) }}" method="POST" class="delete-form inline-flex">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="{{ $actionBtn }} bg-red-600 hover:bg-red-700 mt-3" onclick="confirmDelete(this)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                    <button type="button" class="{{ $actionBtn }} cursor-not-allowed bg-gray-300" onclick="confirmDelete(this)" title="Cannot delete active/completed loan">
                                        <i class="fa-solid fa-trash text-white "></i>
                                    </button>
                                @endif
                            @endif


                        </td>

                    </tr>
                @endforeach
                <tr id="noDataRow" class="hidden">
                    <td colspan="8" class="text-center py-4 text-gray-500">
                        No data present
                    </td>
                </tr>

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
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})
                                </option>
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

                <div><strong>User:</strong>
                    <p id="v_user"></p>
                </div>
                <div><strong>Amount:</strong>
                    <p id="v_amount"></p>
                </div>
                <div><strong>Duration:</strong>
                    <p id="v_duration"></p>
                </div>
                <div><strong>Interest Rate:</strong>
                    <p id="v_interest"></p>
                </div>
                <div><strong>EMI:</strong>
                    <p id="v_emi"></p>
                </div>
                <div><strong>Status:</strong>
                    <p id="v_status"></p>
                </div>

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
    <div id="statusModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-8 relative">
            <h2 class="text-xl font-bold mb-4">Update Loan Status</h2>

            <form method="POST" id="statusForm">
                @csrf
                <select name="status" id="statusSelect" class="w-full p-2 border rounded mt-1" required>
                </select>


                <button class="mt-6 px-6 py-2 bg-blue-600 text-white rounded">Update</button>
            </form>

            <button onclick="closeStatusModal()" class="absolute top-3 right-4 text-xl">&times;</button>
        </div>
    </div>

    <!-- EDIT LOAN MODAL -->
    <div id="editModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4 overflow-y-auto">

        <div class="bg-white w-full max-w-3xl rounded-2xl shadow-xl p-8 relative max-h-[90vh] overflow-y-auto">

            <h2 class="text-2xl font-bold mb-6">Edit Loan</h2>
            <p class="text-sm text-gray-500 mb-4">
                Editing mode:
                <span class="font-semibold text-blue-600" id="edit_mode"></span>
            </p>


            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label>Loan Amount</label>
                        <input type="number" name="amount" id="e_amount" class="w-full p-2 border rounded mt-1"
                            required>
                    </div>

                    <div>
                        <label>Duration (Months)</label>
                        <input type="number" name="duration" id="e_duration" class="w-full p-2 border rounded mt-1"
                            required>
                    </div>

                    <div>
                        <label>Interest Rate (%)</label>
                        <input type="number" name="interest_rate" id="e_interest"
                            class="w-full p-2 border rounded mt-1" required>
                    </div>

                    <div>
                        <label>EMI (Auto Calculated)</label>
                        <input type="text" id="e_emi" class="w-full p-2 border rounded mt-1 bg-gray-100"
                            readonly>
                    </div>

                    <div class="md:col-span-2">
                        <label>Description</label>
                        <textarea name="description" id="e_description" class="w-full p-2 border rounded mt-1"></textarea>
                    </div>

                </div>

                <button class="mt-6 px-6 py-2 bg-blue-600 text-white rounded">Update Loan</button>
            </form>

            <button onclick="closeEditModal()"
                class="absolute top-4 right-4 text-xl text-gray-600 hover:text-black">&times;</button>
        </div>
    </div>

    <!-- Edit Model -->
    <script>
        function calculateEMI(amount, interest, duration) {
            amount = parseFloat(amount);
            interest = parseFloat(interest);
            duration = parseInt(duration);

            if (!amount || !interest || !duration) return "";

            let monthlyRate = interest / 12 / 100;

            let emi = amount * monthlyRate * Math.pow(1 + monthlyRate, duration) /
                (Math.pow(1 + monthlyRate, duration) - 1);

            return emi.toFixed(2);
        }

        function updateEMIField() {
            let amt = document.getElementById('e_amount').value;
            let rate = document.getElementById('e_interest').value;
            let dur = document.getElementById('e_duration').value;

            document.getElementById('e_emi').value = calculateEMI(amt, rate, dur);
        }

        function openEditModal(loan) {

                const isPending = loan.status === 'pending';
                const isApproved = loan.status === 'approved';

                document.getElementById('e_amount').value = loan.amount;
                document.getElementById('e_duration').value = loan.duration;
                document.getElementById('e_interest').value = loan.interest_rate;
                document.getElementById('e_description').value = loan.description ?? '';
                document.getElementById('e_emi').value = loan.emi;

                // Lock fields based on status
                document.getElementById('e_amount').readOnly = !isPending;
                document.getElementById('e_duration').readOnly = !isPending;
                document.getElementById('e_interest').readOnly = !isPending;

                // Description allowed for pending & approved
                document.getElementById('e_description').readOnly = !(isPending || isApproved);

                // EMI auto update only if pending
                if (isPending) {
                    ['e_amount', 'e_duration', 'e_interest'].forEach(id => {
                        document.getElementById(id).addEventListener('input', updateEMIField);
                    });
                }

                document.getElementById('editForm').action = `/admin/loans/${loan.id}`;
                document.getElementById("editModal").classList.remove("hidden");
                document.getElementById('edit_mode').innerText =
                loan.status === 'pending' ? 'Full Edit Allowed' :
                    loan.status === 'approved' ? 'Limited Edit (Description only)' :
                        'Editing Locked';

            }
  
        function closeEditModal() {
            document.getElementById("editModal").classList.add("hidden");
        }


        function openStatusModal(id, currentStatus) {

                const select = document.getElementById('statusSelect');
                select.innerHTML = '';

                const transitions = {
                    pending: ['approved', 'rejected'],
                    approved: ['active'],
                    active: ['completed'],
                };

                (transitions[currentStatus] || []).forEach(status => {
                    let opt = document.createElement('option');
                    opt.value = status;
                    opt.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    select.appendChild(opt);
                });

                document.getElementById("statusForm").action = `/admin/loans/${id}/status`;
                document.getElementById("statusModal").classList.remove("hidden");
            }

    </script>


    <!-- ------------------------------ -->
    <!-- JAVASCRIPT LOGIC -->
    <!-- ------------------------------ -->
    <script>
        // Open Create Modal
        function openCreateModal() {
            document.getElementById("createModal").classList.remove("hidden");
        }

        // Close Create Modal
        function closeCreateModal() {
            document.getElementById("createModal").classList.add("hidden");
        }

        // View Modal
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

        // Close View Modal
        function closeViewModal() {
            document.getElementById("viewModal").classList.add("hidden");
        }

        // Open Status Modal


        // Close Status Modal
        function closeStatusModal() {
            document.getElementById("statusModal").classList.add("hidden");
        }

        // Search
        document.getElementById('searchInput').addEventListener('keyup', function () {

                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr:not(#noDataRow)');
                const noDataRow = document.getElementById('noDataRow');

                let visibleCount = 0;

                rows.forEach(row => {

                    const loanId = row.children[0].innerText.toLowerCase();    // ID
                    const borrower = row.children[1].innerText.toLowerCase(); // Borrower

                    if (
                        loanId.includes(filter) ||
                        borrower.includes(filter)
                    ) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // No data present"
                if (visibleCount === 0) {
                    noDataRow.classList.remove('hidden');
                } else {
                    noDataRow.classList.add('hidden');
                }
            });

        // Download CSV
        function downloadCSV() {
                let rows = document.querySelectorAll("tbody tr");
                let csv = [];

                csv.push(["ID", "User", "Amount", "Duration", "Interest", "EMI", "Status"]);

                rows.forEach(row => {
                    if (row.style.display === "none") return;

                    let cols = row.querySelectorAll("td");
                    csv.push([
                        cols[0].innerText,
                        cols[1].innerText,
                        cols[2].innerText,
                        cols[3].innerText,
                        cols[4].innerText,
                        cols[5].innerText,
                        cols[6].innerText
                    ]);
                });

                let blob = new Blob([csv.map(e => e.join(",")).join("\n")],
                    { type: "text/csv" });

                let a = document.createElement("a");
                a.href = URL.createObjectURL(blob);
                a.download = "loans.csv";
                a.click();
            }


            // Download PDF
             function downloadLoanPDF() {

                    let headers = [
                        "ID",
                        "Borrower",
                        "Amount",
                        "Duration",
                        "Interest",
                        "EMI",
                        "Status"
                    ];

                    let rows = [];

                    document.querySelectorAll("tbody tr").forEach(row => {
                        if (row.style.display === "none") return; // respect search

                        let cols = row.querySelectorAll("td");

                        rows.push([
                            cols[0].innerText,
                            cols[1].innerText,
                            cols[2].innerText,
                            cols[3].innerText,
                            cols[4].innerText,
                            cols[5].innerText,
                            cols[6].innerText
                        ]);
                    });

                    generatePDF({
                        title: "Loan Report",
                        headers: headers,
                        rows: rows
                    });
                }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Delete Modal --}}
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This loan will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
    
    <script src="{{ asset('js/pdf-helper.js') }}"></script>



</x-admin-layout>
