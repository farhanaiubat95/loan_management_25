<h2>New Loan Application</h2>

<p>A new loan application has been submitted by <strong>{{ $loan->user->name }}</strong> ({{ $loan->user->email }}).</p>

<p><strong>Loan Type:</strong> {{ $loan->loan_type }}</p>
<p><strong>Amount:</strong> {{ number_format($loan->amount) }} Tk</p>
<p><strong>Duration:</strong> {{ $loan->duration }} months</p>
<p><strong>EMI:</strong> {{ number_format($loan->emi) }} Tk</p>
<p><strong>Purpose / Description:</strong> {{ $loan->description ?? 'N/A' }}</p>

<p>Please review the application in the admin dashboard.</p>