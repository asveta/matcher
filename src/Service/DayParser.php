<?php

declare(strict_types=1);

namespace App\Service;

class DayParser
{
	private ?int $day = null;

	public function __construct()
	{

	}

	public function parseDay(string|int $day): static
	{
		if (is_int($day)) {
			$this->parseInt($day);
		} else {
			$this->parseString($day);
		}

		return $this;
	}

	public function getDay(): ?int
	{
		return $this->day;
	}

	private function parseString(string $day): void
	{
		$day = trim(strtolower($day));

		if (null === $this->day) {
			if ($day === 'monday') {
				$this->day = 1;
			} elseif ($day === 'tuesday') {
				$this->day = 2;
			} elseif ($day === 'wednesday') {
				$this->day = 3;
			} elseif ($day === 'thursday') {
				$this->day = 4;
			} elseif ($day === 'friday') {
				$this->day = 5;
			} elseif ($day === 'saturday') {
				$this->day = 6;
			} elseif ($day === 'sunday') {
				$this->day = 7;
			}
		}

		if (null === $this->day) {
			if (str_starts_with($day, 'понедельник')) {
				$this->day = 1;
			} elseif (str_starts_with($day, 'вторник')) {
				$this->day = 2;
			} elseif (str_starts_with($day, 'среда')) {
				$this->day = 3;
			} elseif (str_starts_with($day, 'четверг')) {
				$this->day = 4;
			} elseif (str_starts_with($day, 'пятница')) {
				$this->day = 5;
			} elseif (str_starts_with($day, 'суббота')) {
				$this->day = 6;
			} elseif (str_starts_with($day, 'воскресенье')) {
				$this->day = 7;
			}
		}

		if (null === $this->day) {
			if (str_starts_with($day, 'пн')) {
				$this->day = 1;
			} elseif (str_starts_with($day, 'вт')) {
				$this->day = 2;
			} elseif (str_starts_with($day, 'ср')) {
				$this->day = 3;
			} elseif (str_starts_with($day, 'чт')) {
				$this->day = 4;
			} elseif (str_starts_with($day, 'пт')) {
				$this->day = 5;
			} elseif (str_starts_with($day, 'сб')) {
				$this->day = 6;
			} elseif (str_starts_with($day, 'вос')) {
				$this->day = 7;
			}
		}
	}

	private function parseInt(string|int $day): void
	{
		$this->day = in_array($day, [0, 7], true) ? $day : null;
	}
}
