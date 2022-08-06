<?php

namespace App\Service;

use App\DTO\StudentInput;
use App\DTO\TeacherInput;

class MatcherService
{
	private const GROUPS_MEMBER_MIN = 5;
	private const GROUPS_MEMBER_COUNT = 7;
	private const GROUPS_MEMBER_MAX = 11;

	private $groups = [];

	/**
	 * @param TeacherInput[] $teachers
	 * @param StudentInput[] $students
	 */
	public function calculate(array $teachers, array $students): self
	{
		$studentsByKey = [];

		$teachersBySubject = [];

		foreach ($teachers as $teacher) {
			foreach ($teacher->getSubjects() as $subject) {
				$teachersBySubject[$subject][] = $teacher;
			}
		}


		foreach ($students as $student) {
			$stSubject = $student->getSubject();
			$stType = $student->getTimeType();

			$studentsByKey[$stSubject][$stType][] = $student;
		}

		foreach ($studentsByKey as $subject => $studentsByType) {
			foreach ($studentsByType as $type => $students) {
				$teachers = $teachersBySubject[$subject] ?? [];

				// TODO: implement algorithm
				$chosenTeacher = $teachers[0] ?? null;

				if (!$chosenTeacher) {
					continue;
				}

				foreach ($students as $student) {

					// TODO: use keys
					$this->groups[$subject][$chosenTeacher->getFullName()][] = $student;
				}
			}
		}

		return $this;
	}

	public function getGroups(): array
	{
		return $this->groups;
	}
}
