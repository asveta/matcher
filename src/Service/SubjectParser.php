<?php

declare(strict_types=1);

namespace App\Service;

class SubjectParser
{
	/**
	 * @var string[]
	 */
	private array $subjects = [];

	private ?string $subject = null;

	public function __construct()
	{
	}

	public function getSubjects(): array
	{
		return $this->subjects;
	}

	public function parseLine(string $subject): self
	{
		$subject = str_replace(['язык'], '', $subject);
		$subject = mb_strtolower($subject);
		$this->subject = trim($subject);

		return $this;
	}

	public function getSubject(): string
	{
		return $this->subject;
	}
}
