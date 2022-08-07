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
				foreach ($teacher->getGrades() as $grade) {
					$tCriteria = $subject . '_' . $grade;
					$teachersBySubject[$tCriteria][] = $teacher;
				}
			}
		}


		foreach ($students as $student) {
			$stSubject = $student->getSubject();
			$stType = $student->getTimeType();
			$stGrade = $student->getGrade();

			$stCriteria = sprintf('%s_%s_%s', $stSubject, $stGrade, $stType);
			$studentsByKey[$stCriteria][] = $student;
		}

		foreach ($studentsByKey as $stCriteria => $students) {
			[$subject, $grade, $stType] = explode('_', $stCriteria);
			$teachers = $teachersBySubject[$subject .'_' . $grade] ?? [];

			// TODO: implement algorithm
			/** @var TeacherInput $chosenTeacher */
			$chosenTeacher = $teachers[0] ?? null;

			if (!$chosenTeacher) {
				continue;
			}

			foreach ($students as $student) {

				// TODO: use keys
				$teacherKey = $chosenTeacher->getFullName() . '_' . $chosenTeacher->getCreatedAt();
				$this->groups[$subject . '_' . $grade][$teacherKey][] = $student;
			}
		}

		return $this;
	}

	public function getGroups(): array
	{
		return $this->groups;
	}
}
