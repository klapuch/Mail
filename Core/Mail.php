<?php
declare(strict_types = 1);
namespace Dasuos\Mail;

interface Mail {

	public const NO_HEADERS = [];

	public function send(
		string $to, string $subject, Message $message, array $headers
	): void;
}