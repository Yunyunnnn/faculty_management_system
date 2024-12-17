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

function getTeachingFacultyData($facultyId) {
    global $pdo;

    // Get the faculty basic information
    $query = "
        SELECT 
            first_name, last_name, middle_initial, employment_status_code, 
            gender_code, professional_license_code, tenure_of_employment_code, 
            annual_salary_code, primary_teaching_discipline_code, faculty_rank_code, teaching_load_code
        FROM teaching_faculty_information
        WHERE id = :facultyId
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['facultyId' => $facultyId]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        // Retrieve Bachelor's Degree
        $bachelorQuery = "
            SELECT bachelors_degree_program_name, bachelors_degree_code, bachelors_degree_major
            FROM bachelors_degree_earned
            WHERE teaching_faculty_id = :facultyId
        ";
        $stmt = $pdo->prepare($bachelorQuery);
        $stmt->execute(['facultyId' => $facultyId]);
        $bachelorData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($bachelorData) {
            $data['bachelors_degrees'] = $bachelorData;
        }

        // Retrieve Master's Degree
        $masterQuery = "
            SELECT masters_degree_program_name, masters_degree_code, masters_degree_major
            FROM masters_degree_earned
            WHERE teaching_faculty_id = :facultyId
        ";
        $stmt = $pdo->prepare($masterQuery);
        $stmt->execute(['facultyId' => $facultyId]);
        $masterData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($masterData) {
            $data['masters_degrees'] = $masterData;
        }

        // Retrieve Doctorate Degree
        $doctorateQuery = "
            SELECT doctorate_program_name, doctorate_program_code, doctorate_degree_major
            FROM doctorate_degree_earned
            WHERE teaching_faculty_id = :facultyId
        ";
        $stmt = $pdo->prepare($doctorateQuery);
        $stmt->execute(['facultyId' => $facultyId]);
        $doctorateData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($doctorateData) {
            $data['doctorate_degrees'] = $doctorateData;
        }

        // Retrieve Subjects Taught and Semester from teaching_faculty_subjects
        $subjectQuery = "
            SELECT subjects_taught, semester
            FROM teaching_faculty_subjects
            WHERE teaching_faculty_id = :facultyId
        ";
        $stmt = $pdo->prepare($subjectQuery);
        $stmt->execute(['facultyId' => $facultyId]);
        $subjectData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($subjectData) {
            $data['subjects_taught'] = $subjectData;
        }
    }

    return $data;
}

function getNonTeachingFacultyData($facultyId) {
    global $pdo;

    // First, fetch the basic information about the faculty member
    $query = "
        SELECT 
            first_name, last_name, middle_initial, designation_code, 
            employment_status_code, gender_code, professional_license_code, 
            tenure_of_employment_code, years_of_service, annual_salary_code, highest_degree_attained_code
        FROM non_teaching_faculty_information
        WHERE id = :facultyId
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['facultyId' => $facultyId]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    error_log("Non-Teaching Faculty Data: " . print_r($data, true));

    if ($data) {
        // Fetch Bachelor's Degree Information
        $bachelorQuery = "
            SELECT 
                bachelors_degree_program_name, bachelors_degree_code, bachelors_degree_major
            FROM bachelors_degree_earned
            WHERE non_teaching_faculty_id = :facultyId
        ";
        $stmt = $pdo->prepare($bachelorQuery);
        $stmt->execute(['facultyId' => $facultyId]);
        $bachelorData = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch all records if multiple degrees exist

        // Fetch Master's Degree Information
        $masterQuery = "
            SELECT 
                masters_degree_program_name, masters_degree_code, masters_degree_major
            FROM masters_degree_earned
            WHERE non_teaching_faculty_id = :facultyId
        ";
        $stmt = $pdo->prepare($masterQuery);
        $stmt->execute(['facultyId' => $facultyId]);
        $masterData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch Doctorate Degree Information
        $doctorateQuery = "
            SELECT 
                doctorate_program_name, doctorate_program_code, doctorate_degree_major
            FROM doctorate_degree_earned
            WHERE non_teaching_faculty_id = :facultyId
        ";
        $stmt = $pdo->prepare($doctorateQuery);
        $stmt->execute(['facultyId' => $facultyId]);
        $doctorateData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Adding degree data to the main data array
        $data['bachelors_degree_earned'] = $bachelorData ?: [];
        $data['masters_degree_earned'] = $masterData ?: [];
        $data['doctorate_degree_earned'] = $doctorateData ?: [];
    }

    return $data;
}
?>
