<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WinnerMail extends Mailable {
	use Queueable, SerializesModels;

	public $winner;
	public $weekDay;

	/**
	 * Create a new message instance.
	 *
	 * @param array $winner
	 * @param int $weekDay
	 */
	public function __construct($winner, $weekDay) {
		$this->winner  = $winner;
		$this->weekDay = $weekDay;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		return $this->markdown('emails.winner')
		            ->subject("KBC Week {$this->weekDay} Winner Announcement")
		            ->from('noreply@kbcnepal.com');
	}
}
