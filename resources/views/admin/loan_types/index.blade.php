<x-admin-layout>

    {{-- PAGE HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            All Loans
            (<span class="text-lg text-gray-500">{{ $loanTypes->count() }}</span>)
        </h1>

        <div class="flex gap-2">
            <button onclick="openLoanTypeModal()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Add Loan Type
            </button>

            <button onclick="downloadCSV()" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                Download CSV
            </button>
        </div>
    </div>

    {{-- SEARCH --}}
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Search loan type..." class="border rounded px-3 py-2 w-64">
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow p-6 overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-center">
                    <th class="p-3">Name</th>
                    <th class="p-3">Interest</th>
                    <th class="p-3">Min</th>
                    <th class="p-3">Max</th>
                    <th class="p-3">Min Duration</th>
                    <th class="p-3">Max Duration</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>

            <tbody id="loanTypeTable">
                @foreach ($loanTypes as $type)
                    <tr class="border-b text-center">
                        <td class="p-3 font-semibold">{{ $type->name }}</td>
                        <td class="p-3">{{ $type->interest_rate }}%</td>
                        <td class="p-3">{{ number_format($type->min_amount) }}</td>
                        <td class="p-3">{{ number_format($type->max_amount) }}</td>
                        <td class="p-3">{{ $type->min_duration }} months</td>
                        <td class="p-3">{{ $type->max_duration }} months</td>
                        <td class="p-3">
                            @if($type->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Active</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Inactive</span>
                            @endif
                        </td>
                        <td  class="p-2">
                            <div class="pt-2 flex justify-center gap-2">
                                {{-- View --}}
                                <button onclick="openViewModal({{ $type->id }})"
                                    class="flex justify-center items-center w-8 h-8 bg-green-600 text-white rounded hover:bg-green-700">
                                    <i class="fa fa-eye"></i>
                                </button>

                                {{-- Edit --}}
                                <button onclick="openEditModal({{ $type->id }})"
                                    class="flex justify-center items-center w-8 h-8 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                    <i class="fas fa-edit"></i>
                                </button>

                                {{-- Status Toggle --}}
                                <form method="POST" action="{{ route('admin.loan-types.toggle-status', $type->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="flex justify-center items-center w-8 h-8 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        <i class="fa-solid fa-layer-group"></i>
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('admin.loan-types.destroy', $type->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this loan type?')"
                                        class="flex justify-center items-center w-8 h-8 bg-red-500 text-white rounded hover:bg-red-600">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ADD LOAN TYPE MODAL --}}
    <div id="loanTypeModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-4xl rounded-xl shadow-xl p-6 md:p-8 relative overflow-y-auto max-h-[90vh]">
            <h2 class="text-xl font-semibold mb-4">Add New Loan Type</h2>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => { openLoanTypeModal(); });
                </script>
            @endif

            <form method="POST" action="{{ route('admin.loan-types.store') }}"
                class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                {{-- Row 1 --}}
                <div>
                    <label class="text-sm font-medium">Loan Name</label>
                    <input name="name" required class="w-full border rounded-md p-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium">Interest Rate (%)</label>
                    <input type="number" step="0.01" name="interest_rate" required
                        class="w-full border rounded-md p-2 mt-1">
                </div>

                {{-- Row 2 --}}
                <div>
                    <label class="text-sm font-medium">Min Amount</label>
                    <input type="number" name="min_amount" required class="w-full border rounded-md p-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium">Max Amount</label>
                    <input type="number" name="max_amount" required class="w-full border rounded-md p-2 mt-1">
                </div>

                {{-- Row 3 --}}
                <div>
                    <label class="text-sm font-medium">Min Duration (Months)</label>
                    <input type="number" name="min_duration" required class="w-full border rounded-md p-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium">Max Duration (Months)</label>
                    <input type="number" name="max_duration" class="w-full border rounded-md p-2 mt-1">
                </div>

                <div>
                    <label class="text-sm font-medium">Benefits</label>
                    <textarea name="benefits" rows="1" class="w-full border rounded-md p-2 mt-1"></textarea>
                </div>
                <div>
                    <label class="text-sm font-medium">Process</label>
                    <textarea name="process" rows="1" class="w-full border rounded-md p-2 mt-1"></textarea>
                </div>
                <div>
                    <label class="text-sm font-medium">Description</label>
                    <textarea name="description" rows="1" class="w-full border rounded-md p-2 mt-1"></textarea>
                </div>

                {{-- Status --}}
                <div>
                    <label class="text-sm font-medium">Status</label>
                    <select name="is_active" class="w-full border rounded-md p-2 mt-1">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="md:col-span-2 flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeLoanTypeModal()"
                        class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded">Create Loan Type</button>
                </div>
            </form>

            <button onclick="closeLoanTypeModal()"
                class="absolute top-3 right-4 text-2xl text-gray-500 hover:text-black">&times;</button>
        </div>
    </div>

    {{-- VIEW LOAN TYPE MODAL --}}
    <div id="viewLoanModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl p-6 md:p-8 relative overflow-y-auto max-h-[90vh]">
            <h2 class="text-xl font-semibold mb-4">Loan Details</h2>
            <div id="viewLoanContent" class="space-y-2 text-gray-700"></div>
            <div class="flex justify-end mt-4">
                <button onclick="closeViewModal()" class="px-4 py-2 bg-gray-300 rounded">Close</button>
            </div>
            <button onclick="closeViewModal()"
                class="absolute top-3 right-4 text-2xl text-gray-500 hover:text-black">&times;</button>
        </div>
    </div>

    {{-- EDIT LOAN TYPE MODAL --}}
    <div id="editLoanModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-4xl rounded-xl shadow-xl p-6 md:p-8 relative overflow-y-auto max-h-[90vh]">
            <h2 class="text-xl font-semibold mb-4">Edit Loan Type</h2>
            <form id="editLoanForm" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-medium">Loan Name</label>
                    <input name="name" id="edit_name" class="w-full border rounded-md p-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium">Interest Rate (%)</label>
                    <input type="number" step="0.01" name="interest_rate" id="edit_interest_rate"
                        class="w-full border rounded-md p-2 mt-1">
                </div>

                <div>
                    <label class="text-sm font-medium">Min Amount</label>
                    <input type="number" name="min_amount" id="edit_min_amount"
                        class="w-full border rounded-md p-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium">Max Amount</label>
                    <input type="number" name="max_amount" id="edit_max_amount"
                        class="w-full border rounded-md p-2 mt-1">
                </div>

                <div>
                    <label class="text-sm font-medium">Min Duration (Months)</label>
                    <input type="number" name="min_duration" id="edit_min_duration"
                        class="w-full border rounded-md p-2 mt-1">
                </div>
                <div>
                    <label class="text-sm font-medium">Max Duration (Months)</label>
                    <input type="number" name="max_duration" id="edit_max_duration"
                        class="w-full border rounded-md p-2 mt-1">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-medium">Benefits</label>
                    <textarea name="benefits" id="edit_benefits" rows="2"
                        class="w-full border rounded-md p-2 mt-1"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm font-medium">Process</label>
                    <textarea name="process" id="edit_process" rows="2"
                        class="w-full border rounded-md p-2 mt-1"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm font-medium">Description</label>
                    <textarea name="description" id="edit_description" rows="2"
                        class="w-full border rounded-md p-2 mt-1"></textarea>
                </div>

                <div>
                    <label class="text-sm font-medium">Status</label>
                    <select name="is_active" id="edit_status" class="w-full border rounded-md p-2 mt-1">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="md:col-span-2 flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded">Update Loan Type</button>
                </div>
            </form>
            <button onclick="closeEditModal()"
                class="absolute top-3 right-4 text-2xl text-gray-500 hover:text-black">&times;</button>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // OPEN/CLOSE MODALS
        function openLoanTypeModal() { document.getElementById('loanTypeModal').classList.remove('hidden'); }
        function closeLoanTypeModal() { document.getElementById('loanTypeModal').classList.add('hidden'); }

        function openViewModal(id) {
            const loan = @json($loanTypes);
            const selected = loan.find(l => l.id === id);
            const content = `
                <p><strong>Name:</strong> ${selected.name}</p>
                <p><strong>Interest Rate:</strong> ${selected.interest_rate}%</p>
                <p><strong>Min Amount:</strong> ${selected.min_amount}</p>
                <p><strong>Max Amount:</strong> ${selected.max_amount}</p>
                <p><strong>Min Duration:</strong> ${selected.min_duration} months</p>
                <p><strong>Max Duration:</strong> ${selected.max_duration} months</p>
                <p><strong>Status:</strong> ${selected.is_active ? 'Active' : 'Inactive'}</p>
                <p><strong>Benefits:</strong> ${selected.benefits}</p>
                <p><strong>Process:</strong> ${selected.process}</p>
                <p><strong>Description:</strong> ${selected.description}</p>
            `;
            document.getElementById('viewLoanContent').innerHTML = content;
            document.getElementById('viewLoanModal').classList.remove('hidden');
        }
        function closeViewModal() { document.getElementById('viewLoanModal').classList.add('hidden'); }

        function openEditModal(id) {
            const loan = @json($loanTypes);
            const selected = loan.find(l => l.id === id);
            const form = document.getElementById('editLoanForm');
            form.action = `/admin/loan-types/${id}`;
            document.getElementById('edit_name').value = selected.name;
            document.getElementById('edit_interest_rate').value = selected.interest_rate;
            document.getElementById('edit_min_amount').value = selected.min_amount;
            document.getElementById('edit_max_amount').value = selected.max_amount;
            document.getElementById('edit_min_duration').value = selected.min_duration;
            document.getElementById('edit_max_duration').value = selected.max_duration;
            document.getElementById('edit_benefits').value = selected.benefits;
            document.getElementById('edit_process').value = selected.process;
            document.getElementById('edit_description').value = selected.description;
            document.getElementById('edit_status').value = selected.is_active ? '1' : '0';
            document.getElementById('editLoanModal').classList.remove('hidden');
        }
        function closeEditModal() { document.getElementById('editLoanModal').classList.add('hidden'); }

        // SEARCH
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#loanTypeTable tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

        // CSV DOWNLOAD
        function downloadCSV() {
            const rows = [['Name', 'Interest', 'Min', 'Max', 'Min Duration', 'Max Duration', 'Status']];
            document.querySelectorAll('#loanTypeTable tr').forEach(tr => {
                const cols = tr.querySelectorAll('td');
                if (cols.length) { rows.push([...cols].slice(0, 7).map(td => td.innerText)); }
            });
            const csv = rows.map(r => r.join(',')).join('\n');
            const blob = new Blob([csv], { type: 'text/csv' });
            const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = 'loan-types.csv'; a.click();
        }
    </script>

</x-admin-layout>