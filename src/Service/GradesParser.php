<?php

declare(strict_types=1);

namespace App\Service;

class GradesParser
{
	/**
	 * @var int[]
	 */
	private array $grades = [];

	public function __construct()
	{
	}

	public function getGrades(): array
	{
		return $this->grades;
	}

	public function parseLine(string $line): self
	{
		$line = str_replace(';', ',', $line);

		$this->grades = array_map(static function (string $grade): int {
			return (int)trim($grade);
		}, explode(',', $line));

		return $this;
	}
}
