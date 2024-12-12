<?php
include($_SERVER['DOCUMENT_ROOT']."/faculty_management_system/config/connection.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve and sanitize data for non-teaching faculty (replace empty values with 'none')
    $first_name = $_POST['non_teaching_first_name'] ?: 'none';
    $last_name = $_POST['non_teaching_last_name'] ?: 'none';
    $middle_initial = $_POST['non_teaching_middle_initial'] ?: 'none';
    $designation = $_POST['non_teaching_designation'] ?: 'none';
    $employment_status_code = $_POST['non_teaching_employment_status_code'] ?: 'none';
    $gender_code = $_POST['non_teaching_gender_code'] ?: 'none';
    $professional_license_code = $_POST['non_teaching_professional_license_code'] ?: 'none';
    $tenure_of_employment_code = $_POST['non_teaching_tenure_of_employment_code'] ?: 'none';
    $years_of_service = $_POST['non_teaching_years_of_service'] ?: 'none';
    $annual_salary_code = $_POST['non_teaching_annual_salary_code'] ?: 'none';

    $highest_degree_attained_code = $_POST['non_teaching_highest_degree_attained_code'] ?: 'none';

    try {
        // Insert non-teaching faculty information
        $query = "INSERT INTO non_teaching_faculty_information 
                    (first_name, last_name, middle_initial, designation_code, employment_status_code, gender_code, 
                     professional_license_code, tenure_of_employment_code, years_of_service, annual_salary_code) 
                  VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$first_name, $last_name, $middle_initial, $designation, $employment_status_code, $gender_code, 
                        $professional_license_code, $tenure_of_employment_code, $years_of_service, $annual_salary_code]);

        // Get the inserted non-teaching faculty ID
        $non_teaching_faculty_id = $pdo->lastInsertId();

        // Insert educational credentials for non-teaching faculty
        if (isset($_POST['non_teaching_bachelors_degree_program_name']) && isset($_POST['non_teaching_bachelors_degree_code'])) {
            $bachelor_programs = is_array($_POST['non_teaching_bachelors_degree_program_name']) ? $_POST['non_teaching_bachelors_degree_program_name'] : [$_POST['non_teaching_bachelors_degree_program_name']];
            $bachelor_codes = is_array($_POST['non_teaching_bachelors_degree_code']) ? $_POST['non_teaching_bachelors_degree_code'] : [$_POST['non_teaching_bachelors_degree_code']];

            foreach ($bachelor_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = $bachelor_codes[$index] ?: 'none';

                $edu_query = "INSERT INTO educational_credential_earned 
                                (non_teaching_faculty_id, bachelors_degree_program_name, bachelors_degree_code) 
                              VALUES 
                                (?, ?, ?)";

                $edu_stmt = $pdo->prepare($edu_query);
                $edu_stmt->execute([$non_teaching_faculty_id, $program_name, $degree_code]);
            }
        }

        // Handle Master's Degrees
        if (isset($_POST['non_teaching_masters_degree_program_name']) && isset($_POST['non_teaching_masters_degree_code'])) {
            $masters_programs = is_array($_POST['non_teaching_masters_degree_program_name']) ? $_POST['non_teaching_masters_degree_program_name'] : [$_POST['non_teaching_masters_degree_program_name']];
            $masters_codes = is_array($_POST['non_teaching_masters_degree_code']) ? $_POST['non_teaching_masters_degree_code'] : [$_POST['non_teaching_masters_degree_code']];

            foreach ($masters_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = $masters_codes[$index] ?: 'none';

                $edu_query = "INSERT INTO educational_credential_earned 
                                (non_teaching_faculty_id, masters_degree_program_name, masters_degree_code) 
                              VALUES 
                                (?, ?, ?)";

                $edu_stmt = $pdo->prepare($edu_query);
                $edu_stmt->execute([$non_teaching_faculty_id, $program_name, $degree_code]);
            }
        }

        // Handle Doctorate Degrees
        if (isset($_POST['non_teaching_doctorate_program_name']) && isset($_POST['non_teaching_doctorate_program_code'])) {
            $doctorate_programs = is_array($_POST['non_teaching_doctorate_program_name']) ? $_POST['non_teaching_doctorate_program_name'] : [$_POST['non_teaching_doctorate_program_name']];
            $doctorate_codes = is_array($_POST['non_teaching_doctorate_program_code']) ? $_POST['non_teaching_doctorate_program_code'] : [$_POST['non_teaching_doctorate_program_code']];

            foreach ($doctorate_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = $doctorate_codes[$index] ?: 'none';

                $edu_query = "INSERT INTO educational_credential_earned 
                                (non_teaching_faculty_id, doctorate_program_name, doctorate_program_code) 
                              VALUES 
                                (?, ?, ?)";

                $edu_stmt = $pdo->prepare($edu_query);
                $edu_stmt->execute([$non_teaching_faculty_id, $program_name, $degree_code]);
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
