<?php

declare(strict_types=1);

namespace App\DTO;

use App\Service\SubjectParser;

class TeacherInput extends BaseInput
{
	private ?string $createdAt;
	private ?string $fullName;
	private array $subjects = [];
	private array $grades = [];

	public function __construct(
		string $createdAt,
		string $fullName,
		string $subjectsLine,
		string $gradesLine
	)
	{
		$this->createdAt = $createdAt;
		$this->fullName = $fullName;
		$this->subjects = array_map(static function (string $subject): string {
			return (new SubjectParser())->parseLine($subject)->getSubject();
		}, explode(',', $subjectsLine));
		$this->grades = array_map(static function (string $grade): int {
			return (int)trim($grade);
		}, explode(',', $gradesLine));
	}

	public function getCreatedAt(): ?string
	{
		return $this->createdAt;
	}

	public function getFullName(): ?string
	{
		return $this->fullName;
	}

	public function getSubjects(): array
	{
		return $this->subjects;
	}

	public function getGrades(): array
	{
		return $this->grades;
	}
}
