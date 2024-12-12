<?php
include($_SERVER['DOCUMENT_ROOT'] . "/faculty_management_system/config/connection.php");

// Get the search and filter parameters from the request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$facultyType = isset($_GET['faculty_type']) ? $_GET['faculty_type'] : '';
$employmentStatus = isset($_GET['employment_status_code']) ? $_GET['employment_status_code'] : '';

// Prepare the base query with placeholders
$query = "
    SELECT 
        f.id, f.first_name, f.middle_initial, f.last_name, f.gender_code, 
        f.employment_status_code, f.faculty_type
    FROM (
        SELECT 
            id, first_name, middle_initial, last_name, gender_code, 
            employment_status_code, 'Teaching Faculty' AS faculty_type
        FROM teaching_faculty_information
        UNION ALL
        SELECT 
            id, first_name, middle_initial, last_name, gender_code, 
            employment_status_code, 'Non-Teaching Faculty' AS faculty_type
        FROM non_teaching_faculty_information
    ) AS f
    WHERE 1
";

// Add conditions based on search and filters
$params = [];

if ($searchTerm) {
    $query .= " AND (f.first_name LIKE :search OR f.middle_initial LIKE :search OR f.last_name LIKE :search)";
    $params[':search'] = '%' . $searchTerm . '%';
}

if ($facultyType) {
    $query .= " AND f.faculty_type = :faculty_type";
    $params[':faculty_type'] = $facultyType; 
}

if ($employmentStatus) {
    $query .= " AND f.employment_status_code = :employment_status_code";
    $params[':employment_status_code'] = $employmentStatus;
}

// Prepare the statement
$stmt = $pdo->prepare($query);

// Execute the query with parameters
$stmt->execute($params);

// Fetch the results
$facultyData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode($facultyData);
?>
