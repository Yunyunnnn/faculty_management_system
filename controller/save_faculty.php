<?php
include($_SERVER['DOCUMENT_ROOT'] . "/faculty_management_system/config/connection.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
    $annual_salary_code = $_POST['annual_salary_code'] ?: 'none';
    $highest_degree_attained_code = $_POST['highest_degree_attained_code'] ?: 'none';
    
    // Retrieve the subjects_taught and semester values
    $subjects_taught = $_POST['subjects_taught'] ?: 'none';  // Default to 'none' if empty
    $semester = $_POST['semester'] ?: 'none';  // Default to 'none' if empty

    try {
        // Insert data into teaching_faculty_information
        $query = "INSERT INTO teaching_faculty_information 
                    (first_name, last_name, middle_initial, employment_status_code, gender_code, 
                    primary_teaching_discipline_code, professional_license_code, tenure_of_employment_code, 
                    faculty_rank_code, teaching_load_code, annual_salary_code, highest_degree_attained_code) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            $first_name, $last_name, $middle_initial, $employment_status_code, $gender_code,
            $primary_teaching_discipline_code, $professional_license_code, $tenure_of_employment_code,
            $faculty_rank_code, $teaching_load_code, $annual_salary_code, $highest_degree_attained_code
        ]);

        // Get the inserted faculty member's ID
        $teaching_faculty_id = $pdo->lastInsertId();

        // Insert subject and semester into teaching_faculty_subjects table
        $subject_query = "INSERT INTO teaching_faculty_subjects (teaching_faculty_id, subjects_taught, semester) 
                        VALUES (?, ?, ?)";
        $subject_stmt = $pdo->prepare($subject_query);

        // Insert the single subject and semester value
        if ($subjects_taught != 'none' && $semester != 'none') {
            $subject_stmt->execute([$teaching_faculty_id, $subjects_taught, $semester]);
        }

        // Handle Bachelor's Degrees
        if (!empty($_POST['bachelors_degree_program_name']) && !empty($_POST['bachelors_degree_code']) && !empty($_POST['bachelors_degree_major'])) {
            $bachelors_programs = $_POST['bachelors_degree_program_name'];
            $bachelors_codes = $_POST['bachelors_degree_code'];
            $bachelors_majors = $_POST['bachelors_degree_major'];

            foreach ($bachelors_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = isset($bachelors_codes[$index]) ? $bachelors_codes[$index] : 'none';
                $major = isset($bachelors_majors[$index]) ? $bachelors_majors[$index] : 'none';

                // Insert into bachelors_degree_earned if program, code, and major are not empty
                if ($program_name != 'none' && $degree_code != 'none' && $major != 'none') {
                    $edu_query = "INSERT INTO bachelors_degree_earned 
                                    (teaching_faculty_id, bachelors_degree_program_name, bachelors_degree_code, bachelors_degree_major) 
                                VALUES (?, ?, ?, ?)";
                    
                    $edu_stmt = $pdo->prepare($edu_query);
                    $edu_stmt->execute([$teaching_faculty_id, $program_name, $degree_code, $major]);
                }
            }
        }

        // Handle Master's Degrees
        if (!empty($_POST['masters_degree_program_name']) && !empty($_POST['masters_degree_code']) && !empty($_POST['masters_degree_major'])) {
            $masters_programs = $_POST['masters_degree_program_name'];
            $masters_codes = $_POST['masters_degree_code'];
            $masters_majors = $_POST['masters_degree_major'];

            foreach ($masters_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = isset($masters_codes[$index]) ? $masters_codes[$index] : 'none';
                $major = isset($masters_majors[$index]) ? $masters_majors[$index] : 'none';

                // Insert into masters_degree_earned if program, code, and major are not empty
                if ($program_name != 'none' && $degree_code != 'none' && $major != 'none') {
                    $edu_query = "INSERT INTO masters_degree_earned 
                                    (teaching_faculty_id, masters_degree_program_name, masters_degree_code, masters_degree_major) 
                                VALUES (?, ?, ?, ?)";
                    
                    $edu_stmt = $pdo->prepare($edu_query);
                    $edu_stmt->execute([$teaching_faculty_id, $program_name, $degree_code, $major]);
                }
            }
        }

        // Handle Doctorate Degrees
        if (!empty($_POST['doctorate_program_name']) && !empty($_POST['doctorate_program_code']) && !empty($_POST['doctorate_degree_major'])) {
            $doctorate_programs = $_POST['doctorate_program_name'];
            $doctorate_codes = $_POST['doctorate_program_code'];
            $doctorate_majors = $_POST['doctorate_degree_major'];

            foreach ($doctorate_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = isset($doctorate_codes[$index]) ? $doctorate_codes[$index] : 'none';
                $major = isset($doctorate_majors[$index]) ? $doctorate_majors[$index] : 'none';

                // Insert into doctorate_degree_earned if program, code, and major are not empty
                if ($program_name != 'none' && $degree_code != 'none' && $major != 'none') {
                    $edu_query = "INSERT INTO doctorate_degree_earned 
                                    (teaching_faculty_id, doctorate_program_name, doctorate_program_code, doctorate_degree_major) 
                                VALUES (?, ?, ?, ?)";
                    
                    $edu_stmt = $pdo->prepare($edu_query);
                    $edu_stmt->execute([$teaching_faculty_id, $program_name, $degree_code, $major]);
                }
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
