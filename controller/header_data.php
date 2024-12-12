<?php
include($_SERVER['DOCUMENT_ROOT'] . "/faculty_management_system/config/connection.php");

// Prepare queries to fetch counts
$queryNonTeaching = "SELECT COUNT(*) AS non_teaching_count FROM non_teaching_faculty_information";
$queryTeaching = "SELECT COUNT(*) AS teaching_count FROM teaching_faculty_information";

// Modified query to count part-time faculty from both tables
$queryPartTime = "
    SELECT COUNT(*) AS part_time_count 
    FROM (
        SELECT employment_status_code FROM teaching_faculty_information WHERE employment_status_code = 'Part-time'
        UNION ALL
        SELECT employment_status_code FROM non_teaching_faculty_information WHERE employment_status_code = 'Part-time'
    ) AS part_time_faculty
";

// Modified query to count full-time faculty from both tables
$queryFullTime = "
    SELECT COUNT(*) AS full_time_count 
    FROM (
        SELECT employment_status_code FROM teaching_faculty_information WHERE employment_status_code = 'Full-time'
        UNION ALL
        SELECT employment_status_code FROM non_teaching_faculty_information WHERE employment_status_code = 'Full-time'
    ) AS full_time_faculty
";

// Execute queries and get the results
$nonTeachingCountStmt = $pdo->prepare($queryNonTeaching);
$nonTeachingCountStmt->execute();
$nonTeachingCount = $nonTeachingCountStmt->fetch(PDO::FETCH_ASSOC)['non_teaching_count'];

$teachingCountStmt = $pdo->prepare($queryTeaching);
$teachingCountStmt->execute();
$teachingCount = $teachingCountStmt->fetch(PDO::FETCH_ASSOC)['teaching_count'];

$partTimeCountStmt = $pdo->prepare($queryPartTime);
$partTimeCountStmt->execute();
$partTimeCount = $partTimeCountStmt->fetch(PDO::FETCH_ASSOC)['part_time_count'];

$fullTimeCountStmt = $pdo->prepare($queryFullTime);
$fullTimeCountStmt->execute();
$fullTimeCount = $fullTimeCountStmt->fetch(PDO::FETCH_ASSOC)['full_time_count'];

// Prepare the data array
$data = [
    'nonTeachingCount' => $nonTeachingCount,
    'teachingCount' => $teachingCount,
    'partTimeCount' => $partTimeCount,
    'fullTimeCount' => $fullTimeCount,
];

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
