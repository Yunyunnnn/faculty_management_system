<?php
include($_SERVER['DOCUMENT_ROOT']."/faculty_management_system/config/connection.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve and sanitize data for teaching faculty (replace empty values with 'none')
    $first_name = $_POST['first_name'] ?: 'none';
    $last_name = $_POST['last_name'] ?: 'none';
    $middle_initial = $_POST['middle_initial'] ?: 'none';
    $employment_status_code = $_POST['employment_status_code'] ?: 'none';
    $gender_code = $_POST['gender_code'] ?: 'none';
    $primary_teaching_discipline_code = $_POST['primary_teaching_discipline_code'] ?: 'none';
    $professional_license_code = $_POST['professional_license_code'] ?: 'none';
    $tenure_of_employment_code = $_POST['tenure_of_employment_code'] ?: 'none';
    $faculty_rank_code = $_POST['faculty_rank_code'] ?: 'none';
    $teaching_load_code = $_POST['teaching_load_code'] ?: 'none';
    $subjects_taught = $_POST['subjects_taught'] ?: 'none';
    $annual_salary_code = $_POST['annual_salary_code'] ?: 'none';

    // Retrieve highest degree attained code (if provided)
    $highest_degree_attained_code = $_POST['highest_degree_attained_code'] ?: 'none';

    // Prepare SQL query to insert data into teaching_faculty_information
    $query = "INSERT INTO teaching_faculty_information 
                (first_name, last_name, middle_initial, employment_status_code, gender_code, 
                 primary_teaching_discipline_code, professional_license_code, tenure_of_employment_code, 
                 faculty_rank_code, teaching_load_code, subjects_taught, annual_salary_code) 
              VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        // Prepare and execute the query using PDO
        $stmt = $pdo->prepare($query);
        $stmt->execute([$first_name, $last_name, $middle_initial, $employment_status_code, $gender_code, 
                        $primary_teaching_discipline_code, $professional_license_code, 
                        $tenure_of_employment_code, $faculty_rank_code, $teaching_load_code, 
                        $subjects_taught, $annual_salary_code]);

        // Get the inserted faculty member's ID
        $teaching_faculty_id = $pdo->lastInsertId();

        // Insert educational credentials with highest degree attained code
        $edu_query = "INSERT INTO educational_credential_earned 
                        (teaching_faculty_id, highest_degree_attained_code) 
                      VALUES (?, ?)";

        $edu_stmt = $pdo->prepare($edu_query);
        $edu_stmt->execute([$teaching_faculty_id, $highest_degree_attained_code]);

        // Handle Bachelor's Degrees
        if (isset($_POST['bachelors_degree_program_name']) && isset($_POST['bachelors_degree_code'])) {
            $bachelors_programs = is_array($_POST['bachelors_degree_program_name']) ? $_POST['bachelors_degree_program_name'] : [$_POST['bachelors_degree_program_name']];
            $bachelors_codes = is_array($_POST['bachelors_degree_code']) ? $_POST['bachelors_degree_code'] : [$_POST['bachelors_degree_code']];

            foreach ($bachelors_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = $bachelors_codes[$index] ?: 'none';

                $edu_query = "INSERT INTO educational_credential_earned 
                                (teaching_faculty_id, bachelors_degree_program_name, bachelors_degree_code) 
                              VALUES 
                                (?, ?, ?)";

                $edu_stmt = $pdo->prepare($edu_query);
                $edu_stmt->execute([$teaching_faculty_id, $program_name, $degree_code]);
            }
        }

        // Handle Master's Degrees
        if (isset($_POST['masters_degree_program_name']) && isset($_POST['masters_degree_code'])) {
            $masters_programs = is_array($_POST['masters_degree_program_name']) ? $_POST['masters_degree_program_name'] : [$_POST['masters_degree_program_name']];
            $masters_codes = is_array($_POST['masters_degree_code']) ? $_POST['masters_degree_code'] : [$_POST['masters_degree_code']];

            foreach ($masters_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = $masters_codes[$index] ?: 'none';

                $edu_query = "INSERT INTO educational_credential_earned 
                                (teaching_faculty_id, masters_degree_program_name, masters_degree_code) 
                              VALUES 
                                (?, ?, ?)";

                $edu_stmt = $pdo->prepare($edu_query);
                $edu_stmt->execute([$teaching_faculty_id, $program_name, $degree_code]);
            }
        }

        // Handle Doctorate Degrees
        if (isset($_POST['doctorate_program_name']) && isset($_POST['doctorate_program_code'])) {
            $doctorate_programs = is_array($_POST['doctorate_program_name']) ? $_POST['doctorate_program_name'] : [$_POST['doctorate_program_name']];
            $doctorate_codes = is_array($_POST['doctorate_program_code']) ? $_POST['doctorate_program_code'] : [$_POST['doctorate_program_code']];

            foreach ($doctorate_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = $doctorate_codes[$index] ?: 'none';

                $edu_query = "INSERT INTO educational_credential_earned 
                                (teaching_faculty_id, doctorate_program_name, doctorate_program_code) 
                              VALUES 
                                (?, ?, ?)";

                $edu_stmt = $pdo->prepare($edu_query);
                $edu_stmt->execute([$teaching_faculty_id, $program_name, $degree_code]);
            }
        }

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
