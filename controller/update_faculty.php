<?php
include($_SERVER['DOCUMENT_ROOT'] . "/faculty_management_system/config/connection.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $faculty_id = $_GET['facultyId'];  // Get the faculty ID from the POST request
    
    $first_name = $_POST['first_nameteaching'] ?: 'none';
    $last_name = $_POST['last_nameteaching'] ?: 'none';
    $middle_initial = $_POST['middle_initialteaching'] ?: 'none';
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
        // Update data in teaching_faculty_information table
        $query = "UPDATE teaching_faculty_information 
                    SET first_name = ?, last_name = ?, middle_initial = ?, employment_status_code = ?, gender_code = ?, 
                        primary_teaching_discipline_code = ?, professional_license_code = ?, tenure_of_employment_code = ?, 
                        faculty_rank_code = ?, teaching_load_code = ?, annual_salary_code = ?, highest_degree_attained_code = ? 
                    WHERE id = ?";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            $first_name, $last_name, $middle_initial, $employment_status_code, $gender_code,
            $primary_teaching_discipline_code, $professional_license_code, $tenure_of_employment_code,
            $faculty_rank_code, $teaching_load_code, $annual_salary_code, $highest_degree_attained_code, $faculty_id
        ]);

        // Update subjects and semester in teaching_faculty_subjects table
        $subject_query = "UPDATE teaching_faculty_subjects 
                          SET subjects_taught = ?, semester = ? 
                          WHERE teaching_faculty_id = ?";
        $subject_stmt = $pdo->prepare($subject_query);

        // If subjects are provided, update the record
        if ($subjects_taught != 'none' && $semester != 'none') {
            $subject_stmt->execute([$subjects_taught, $semester, $faculty_id]);
        }

        // Handle Bachelor's Degrees
        if (!empty($_POST['bachelors_degree_program_name']) && !empty($_POST['bachelors_degree_code']) && !empty($_POST['bachelors_degree_major'])) {
            $bachelors_programs = $_POST['bachelors_degree_program_name'];
            $bachelors_codes = $_POST['bachelors_degree_code'];
            $bachelors_majors = $_POST['bachelors_degree_major'];

            // Delete existing Bachelor's Degree records first
            $delete_bachelors_query = "DELETE FROM bachelors_degree_earned WHERE teaching_faculty_id = ?";
            $delete_bachelors_stmt = $pdo->prepare($delete_bachelors_query);
            $delete_bachelors_stmt->execute([$faculty_id]);

            // Insert updated Bachelor's Degrees
            foreach ($bachelors_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = isset($bachelors_codes[$index]) ? $bachelors_codes[$index] : 'none';
                $major = isset($bachelors_majors[$index]) ? $bachelors_majors[$index] : 'none';

                if ($program_name != 'none' && $degree_code != 'none' && $major != 'none') {
                    $edu_query = "INSERT INTO bachelors_degree_earned 
                                    (teaching_faculty_id, bachelors_degree_program_name, bachelors_degree_code, bachelors_degree_major) 
                                  VALUES (?, ?, ?, ?)";
                    $edu_stmt = $pdo->prepare($edu_query);
                    $edu_stmt->execute([$faculty_id, $program_name, $degree_code, $major]);
                }
            }
        }

        // Handle Master's Degrees
        if (!empty($_POST['masters_degree_program_name']) && !empty($_POST['masters_degree_code']) && !empty($_POST['masters_degree_major'])) {
            $masters_programs = $_POST['masters_degree_program_name'];
            $masters_codes = $_POST['masters_degree_code'];
            $masters_majors = $_POST['masters_degree_major'];

            // Delete existing Master's Degree records first
            $delete_masters_query = "DELETE FROM masters_degree_earned WHERE teaching_faculty_id = ?";
            $delete_masters_stmt = $pdo->prepare($delete_masters_query);
            $delete_masters_stmt->execute([$faculty_id]);

            // Insert updated Master's Degrees
            foreach ($masters_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = isset($masters_codes[$index]) ? $masters_codes[$index] : 'none';
                $major = isset($masters_majors[$index]) ? $masters_majors[$index] : 'none';

                if ($program_name != 'none' && $degree_code != 'none' && $major != 'none') {
                    $edu_query = "INSERT INTO masters_degree_earned 
                                    (teaching_faculty_id, masters_degree_program_name, masters_degree_code, masters_degree_major) 
                                  VALUES (?, ?, ?, ?)";
                    $edu_stmt = $pdo->prepare($edu_query);
                    $edu_stmt->execute([$faculty_id, $program_name, $degree_code, $major]);
                }
            }
        }

        // Handle Doctorate Degrees
        if (!empty($_POST['doctorate_program_name']) && !empty($_POST['doctorate_program_code']) && !empty($_POST['doctorate_degree_major'])) {
            $doctorate_programs = $_POST['doctorate_program_name'];
            $doctorate_codes = $_POST['doctorate_program_code'];
            $doctorate_majors = $_POST['doctorate_degree_major'];

            // Delete existing Doctorate Degree records first
            $delete_doctorate_query = "DELETE FROM doctorate_degree_earned WHERE teaching_faculty_id = ?";
            $delete_doctorate_stmt = $pdo->prepare($delete_doctorate_query);
            $delete_doctorate_stmt->execute([$faculty_id]);

            // Insert updated Doctorate Degrees
            foreach ($doctorate_programs as $index => $program_name) {
                $program_name = $program_name ?: 'none';
                $degree_code = isset($doctorate_codes[$index]) ? $doctorate_codes[$index] : 'none';
                $major = isset($doctorate_majors[$index]) ? $doctorate_majors[$index] : 'none';

                if ($program_name != 'none' && $degree_code != 'none' && $major != 'none') {
                    $edu_query = "INSERT INTO doctorate_degree_earned 
                                    (teaching_faculty_id, doctorate_program_name, doctorate_program_code, doctorate_degree_major) 
                                  VALUES (?, ?, ?, ?)";
                    $edu_stmt = $pdo->prepare($edu_query);
                    $edu_stmt->execute([$faculty_id, $program_name, $degree_code, $major]);
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
