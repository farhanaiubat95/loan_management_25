<h2>Loan Application Rejected</h2>

<p>Dear {{ $loan->user->name }},</p>

<p>
    We regret to inform you that your loan application
    of <strong>{{ number_format($loan->amount) }} Tk</strong>
    has been rejected.
</p>

<p><strong>Reason:</strong></p>
<p>{{ $reason }}</p>

<p>You may apply again in the future.</p>