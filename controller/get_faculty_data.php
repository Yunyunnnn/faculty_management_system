<?php
include($_SERVER['DOCUMENT_ROOT'] . "/faculty_management_system/config/connection.php");

$facultyId = $_GET['id'];
$facultyType = $_GET['type'];

error_log("Faculty ID: $facultyId, Faculty Type: $facultyType");

// Fetch the data
if ($facultyType == 'Teaching Faculty') {
    $data = getTeachingFacultyData($facultyId);
} else if ($facultyType == 'Non-Teaching Faculty') {
    $data = getNonTeachingFacultyData($facultyId);
} else {
    $data = null;
    error_log("Invalid faculty type provided.");
}

if (!$data) {
    error_log("No data found for Faculty ID: $facultyId, Type: $facultyType");
}

header('Content-Type: application/json');
echo json_encode($data);

// Fetch teaching faculty data from the database
function getTeachingFacultyData($facultyId) {
    global $pdo;  // Assuming $pdo is your database connection

    // Prepare SQL query to fetch the data for teaching faculty
    $query = "
        SELECT 
            first_name, last_name, middle_initial, employment_status_code, 
            gender_code, professional_license_code, tenure_of_employment_code, 
            subjects_taught, annual_salary_code, primary_teaching_discipline_code, faculty_rank_code, teaching_load_code
        FROM teaching_faculty_information
        WHERE id = :facultyId
    ";

    // Execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute(['facultyId' => $facultyId]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        // Fetch educational credentials for the teaching faculty
        $educationalQuery = "
            SELECT 
                highest_degree_attained_code, bachelors_degree_program_name, 
                bachelors_degree_code, masters_degree_program_name, 
                masters_degree_code, doctorate_program_name, doctorate_program_code
            FROM educational_credential_earned
            WHERE teaching_faculty_id = :facultyId
        ";

        $stmt = $pdo->prepare($educationalQuery);
        $stmt->execute(['facultyId' => $facultyId]);
        $educationalData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Add educational data to the main data array
        if ($educationalData) {
            $data['educational_credentials_earned'] = $educationalData;
        }
    }

    return $data;
}

// Fetch non-teaching faculty data from the database
function getNonTeachingFacultyData($facultyId) {
    global $pdo;  

    $query = "
        SELECT 
            first_name, last_name, middle_initial, designation_code, 
            employment_status_code, gender_code, professional_license_code, 
            tenure_of_employment_code, years_of_service, annual_salary_code
        FROM non_teaching_faculty_information
        WHERE id = :facultyId
    ";

    // Execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute(['facultyId' => $facultyId]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    error_log("Non-Teaching Faculty Data: " . print_r($data, true));

    if ($data) {
        $educationalQuery = "
            SELECT 
                highest_degree_attained_code, bachelors_degree_program_name, 
                bachelors_degree_code, masters_degree_program_name, 
                masters_degree_code, doctorate_program_name, doctorate_program_code
            FROM educational_credential_earned
            WHERE non_teaching_faculty_id = :facultyId
        ";
    
        $stmt = $pdo->prepare($educationalQuery);
        $stmt->execute(['facultyId' => $facultyId]);
        $educationalData = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    
        if ($educationalData) {
            $data['educational_credentials'] = $educationalData;
        } else {
            $data['educational_credentials'] = [];  
        }
    }
   

    return $data;
}

?>
