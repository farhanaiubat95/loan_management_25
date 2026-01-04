<h2>Loan Approved</h2>

<p>Dear {{ $loan->user->name }},</p>

<p>
    Your loan request of <strong>{{ number_format($loan->amount) }} Tk</strong>
    has been <strong>approved</strong>.
</p>

<p>Status: Approved</p>

<p>Thank you for banking with us.</p>