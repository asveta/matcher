<?php

require 'vendor/autoload.php';

// get list of teachers from csv file
use App\DTO\StudentInput;
use App\DTO\TeacherInput;
use App\Service\MatcherService;

$studentsInput = file('data/students_list.csv');

// get list of students from file
$teachersInput = file('data/teachers_list.csv');

$studentsData = array_map('str_getcsv', $studentsInput);
$teachersData = array_map('str_getcsv', $teachersInput);

array_shift($studentsData);
array_shift($teachersData);

/** @var StudentInput[] $studentsData */
$studentsData = array_map(function ($row) {
	try {
		return new StudentInput($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
	} catch (\Exception $e) {
		return null;
	}
}, $studentsData);
$studentsData = array_filter($studentsData);

/** @var TeacherInput[] $teachersData */
$teachersData = array_map(function ($row) {
	try {
		return new TeacherInput($row[0], $row[1], $row[2], $row[3]);
	} catch (\Exception $e) {
		return null;
	}
}, $teachersData);
$teachersData = array_filter($teachersData);


$service = (new MatcherService())->calculate($teachersData, $studentsData);
$groups = $service->getGroups();


echo "## Выкладчыкі:\n";

foreach ($groups as $subjectKey => $students) {
	[$subject, $grade] = explode('_', $subjectKey);
	foreach ($students as $teacherKey => $student) {
		$teacher = explode('_', $teacherKey)[0];
		echo str_pad($subject, 16, ' ') . ' | ' .
			'Клас: ' . str_pad($grade, 2, ' ') . ' | ' .
			str_pad($teacher, 32, ' ') . ' | ' .
			'Навучэнцаў: ' . count($student) . PHP_EOL;
	}
}

echo "\n";
echo "\n";
echo "## Навучэнцы:\n";

foreach ($groups as $subject => $students) {

	echo "\n";
	echo "## Група: $subject \n";

	foreach ($students as $teacher => $studentList) {
		foreach ($studentList as $student) {
			/** @var StudentInput $student */
			echo '| ' . str_pad($student->getName(), 20, ' ') . ' | ' .
				str_pad($student->getEmail(), 24, ' ') . ' | ' .
				str_pad($student->getTimeStart(), 4, ' ') . ' - ' .
				str_pad($student->getTimeEnd(), 4, ' ') . ' | ' .
				PHP_EOL;
		}
	}
}
