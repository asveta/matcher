<?php

declare(strict_types=1);

namespace App\Service;

class DatePeriodParser
{
	public const TYPE_MORNING = 1;
	public const TYPE_DAY = 2;
	public const TYPE_EVENING = 3;

	private ?string $timeStart = null;

	private ?string $timeEnd = null;

	private int $periodType = 0;

	public function __construct()
	{

	}

	public function parseTimePeriod(string $timePeriod): static
	{
		$parts = explode('-', $timePeriod);
		$this->timeStart = isset($parts[0]) ? trim($parts[0]) : null;
		$this->timeEnd = isset($parts[1]) ? trim($parts[1]) : null;

		[$hours, $minutes] = array_pad(explode(':', $this->timeEnd), 2, null);
		$hours = (int)$hours;

		if ($hours <= 13 && $hours >= 6) {
			$this->periodType = self::TYPE_MORNING;
		} elseif ($hours <= 18) {
			$this->periodType = self::TYPE_DAY;
		} else {
			$this->periodType = self::TYPE_EVENING;
		}

		return $this;
	}

	public function getTimeStart(): ?string
	{
		return $this->timeStart;
	}

	public function getTimeEnd(): ?string
	{
		return $this->timeEnd;
	}

	public function getPeriodType(): int
	{
		return $this->periodType;
	}
}
