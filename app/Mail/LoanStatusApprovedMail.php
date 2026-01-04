<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Loan;


class LoanStatusApprovedMail extends Mailable
{
    public function __construct(public Loan $loan) {}

    public function build()
    {
        return $this->subject('Your Loan Has Been Approved')
            ->view('emails.loan-approved');
    }
}
