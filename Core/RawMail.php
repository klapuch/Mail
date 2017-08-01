<?php
declare(strict_types = 1);
namespace Dasuos\Mail;

final class RawMail implements Mail {

	public function send(
		string $to, string $subject, Message $message, string $headers
	): void {
		mail($to, $subject, $message, $headers);
	}
}