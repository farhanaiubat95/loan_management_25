<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Loan;


class LoanStatusRejectedMail extends Mailable
{
    public function __construct(
        public Loan $loan,
        public string $reason
    ) {}

    public function build()
    {
        return $this->subject('Your Loan Application Was Rejected')
            ->view('emails.loan-rejected');
    }
}

