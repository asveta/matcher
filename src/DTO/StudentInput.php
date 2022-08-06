<?php

declare(strict_types=1);

namespace App\DTO;

use App\Service\DatePeriodParser;
use App\Service\DayParser;
use App\Service\SubjectParser;

class StudentInput extends BaseInput
{
	private string $lead;
	private string $email;
	private string $name;
	private int $grade;
	private string $subject;
	private ?string $timeStart;
	private ?string $timeEnd;
	private int $timeType = 0;
	private array $days = [];

	public function __construct(
		string $lead,
		string $contactMail,
		string $name,
		string $grade,
		string $subject,
		string $timePeriod,
		string $daysLine
	)
	{
		$this->lead = $lead;
		$this->email = $contactMail;
		$this->name = $name;
		$this->grade = (int)trim($grade);
		$this->subject = (new SubjectParser())->parse($subject)->getSubject();

		$periodParser = (new DatePeriodParser())->parseTimePeriod($timePeriod);
		$this->timeStart = $periodParser->getTimeStart();
		$this->timeEnd = $periodParser->getTimeEnd();
		$this->timeType = $periodParser->getPeriodType();

		$daysLine = str_replace(';', ',', $daysLine);

		$this->days = array_map(static function ($day): ?int {
			return (new DayParser())->parseDay($day)->getDay();
		}, explode(',', $daysLine));

		$this->days = array_filter($this->days, static function (?int $day): bool {
			return null !== $day;
		});
	}

	public function getLead(): string
	{
		return $this->lead;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getGrade(): int
	{
		return $this->grade;
	}

	public function getSubject(): string
	{
		return $this->subject;
	}

	public function getTimeStart(): ?string
	{
		return $this->timeStart;
	}

	public function getTimeEnd(): ?string
	{
		return $this->timeEnd;
	}

	public function getTimeType(): ?int
	{
		return $this->timeType;
	}

	public function getDays(): array
	{
		return $this->days;
	}
}
