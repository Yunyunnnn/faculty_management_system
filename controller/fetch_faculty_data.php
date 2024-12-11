<?php
include($_SERVER['DOCUMENT_ROOT']."/faculty_management_system/config/connection.php");

// Define the query to fetch both teaching and non-teaching faculty data
$query = "
SELECT 
    f.id, 
    f.first_name, 
    f.middle_initial, 
    f.last_name, 
    f.employment_status_code, 
    f.gender_code, 
    'Teaching Faculty' AS faculty_type
FROM 
    teaching_faculty_information f

UNION ALL

SELECT 
    n.id,
    n.first_name,
    n.middle_initial,
    n.last_name,
    n.employment_status_code,
    n.gender_code,
    'Non-Teaching Faculty' AS faculty_type
FROM 
    non_teaching_faculty_information n;
";

// Execute the query using the $pdo connection
$result = $pdo->query($query);

// Initialize an array to store faculty data
$facultyData = [];
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Map gender code to human-readable value
        $row['gender_name'] = $row['gender_code'] == 1 ? 'Male' : ($row['gender_code'] == 2 ? 'Female' : 'Unknown');
        $facultyData[] = $row;  // Store the result in an array
    }
}

$pdo = null;
?>
