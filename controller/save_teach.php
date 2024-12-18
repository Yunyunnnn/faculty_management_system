<?php
include($_SERVER['DOCUMENT_ROOT'] . "/faculty_management_system/config/connection.php");

// Capture form data from JavaScript submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // General Faculty Information
    $facultyId = $_POST['id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $middleInitial = $_POST['middle_initial'];
    $employmentStatus = $_POST['employment_status_code'];
    $gender = $_POST['gender_code'];
    $discipline = $_POST['primary_teaching_discipline_code']; // For teaching faculty
    $license = $_POST['professional_license_code'];
    $tenure = $_POST['tenure_of_employment_code'];
    $teachingLoad = $_POST['teaching_load_code']; // Specific to teaching faculty
    $annualSalary = $_POST['annual_salary_code'];
    $facultyRank = $_POST['faculty_rank_code']; // For teaching faculty
    $highestDegreeAttained = $_POST['highest_degree_attained_code'];

    try {
        // Prepare the query to insert or update the teaching faculty data
        $query = "INSERT INTO teaching_faculty_information 
                  (id, first_name, last_name, middle_initial, employment_status_code, gender_code, primary_teaching_discipline_code, professional_license_code, tenure_of_employment_code, teaching_load_code, annual_salary_code, faculty_rank_code, highest_degree_attained_code)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE 
                  first_name = VALUES(first_name),
                  last_name = VALUES(last_name),
                  middle_initial = VALUES(middle_initial),
                  employment_status_code = VALUES(employment_status_code),
                  gender_code = VALUES(gender_code),
                  primary_teaching_discipline_code = VALUES(primary_teaching_discipline_code),
                  professional_license_code = VALUES(professional_license_code),
                  tenure_of_employment_code = VALUES(tenure_of_employment_code),
                  teaching_load_code = VALUES(teaching_load_code),
                  annual_salary_code = VALUES(annual_salary_code),
                  faculty_rank_code = VALUES(faculty_rank_code),
                  highest_degree_attained_code = VALUES(highest_degree_attained_code)";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([$facultyId, $firstName, $lastName, $middleInitial, $employmentStatus, $gender, $discipline, $license, $tenure, $teachingLoad, $annualSalary, $facultyRank, $highestDegreeAttained]);

        $subjectId = $_POST['subject_id']; // The subject ID
        $subject = $_POST['subjects_taught']; // The subject taught
        $semester = $_POST['semester']; // The corresponding semester

        // Check if the subject_id exists and update accordingly
        if (!empty($subjectId)) {
            // Update the existing subject entry based on subject_id
            $query = "UPDATE teaching_faculty_subjects 
                    SET subjects_taught = ?, semester = ? 
                    WHERE id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$subject, $semester, $subjectId]);
        } else {
            // If no subject_id is provided, insert a new subject
            $query = "INSERT INTO teaching_faculty_subjects (teaching_faculty_id, subjects_taught, semester) 
                    VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$facultyId, $subject, $semester]);
        }

        // Handle Bachelor's Degree
        if (!empty($_POST['bachelors_degree_program_name'])) {
            echo "Processing Bachelor's Degree information.<br>";
            $queryExistingBachelors = "SELECT id, bachelors_degree_program_name FROM bachelors_degree_earned WHERE teaching_faculty_id = ?";
            $stmtExistingBachelors = $pdo->prepare($queryExistingBachelors);
            $stmtExistingBachelors->execute([$facultyId]);
            $existingBachelorsDegrees = $stmtExistingBachelors->fetchAll(PDO::FETCH_ASSOC);

            $submittedBachelors = $_POST['bachelors_degree_program_name'];
            foreach ($existingBachelorsDegrees as $existingDegree) {
                if (!in_array($existingDegree['bachelors_degree_program_name'], $submittedBachelors)) {
                    echo "Deleting Bachelor's degree: " . $existingDegree['bachelors_degree_program_name'] . "<br>";
                    $queryDelete = "DELETE FROM bachelors_degree_earned WHERE id = ?";
                    $stmtDelete = $pdo->prepare($queryDelete);
                    $stmtDelete->execute([$existingDegree['id']]);
                }
            }

            foreach ($submittedBachelors as $index => $programName) {
                $degreeCode = $_POST['bachelors_degree_code'][$index];
                $major = $_POST['bachelors_degree_major'][$index];
                echo "Inserting/Updating Bachelor's Degree: $programName, $degreeCode, $major<br>";

                $queryCheck = "SELECT id FROM bachelors_degree_earned WHERE teaching_faculty_id = ? AND bachelors_degree_program_name = ?";
                $stmtCheck = $pdo->prepare($queryCheck);
                $stmtCheck->execute([$facultyId, $programName]);
                $existingDegree = $stmtCheck->fetch();

                if ($existingDegree) {
                    echo "Updating Bachelor's Degree.<br>";
                    $queryUpdate = "UPDATE bachelors_degree_earned SET bachelors_degree_code = ?, bachelors_degree_major = ? WHERE id = ?";
                    $stmtUpdate = $pdo->prepare($queryUpdate);
                    $stmtUpdate->execute([$degreeCode, $major, $existingDegree['id']]);
                } else {
                    echo "Inserting new Bachelor's Degree.<br>";
                    $queryInsert = "INSERT INTO bachelors_degree_earned (teaching_faculty_id, bachelors_degree_program_name, bachelors_degree_code, bachelors_degree_major) VALUES (?, ?, ?, ?)";
                    $stmtInsert = $pdo->prepare($queryInsert);
                    $stmtInsert->execute([$facultyId, $programName, $degreeCode, $major]);
                }
            }
        }

        // Handle Master's Degree
        if (!empty($_POST['masters_degree_program_name'])) {
            echo "Processing Master's Degree information.<br>";
            
            // Get existing Master's degrees from the database
            $queryExistingMasters = "SELECT id, masters_degree_program_name FROM masters_degree_earned WHERE teaching_faculty_id = ?";
            $stmtExistingMasters = $pdo->prepare($queryExistingMasters);
            $stmtExistingMasters->execute([$facultyId]);
            $existingMastersDegrees = $stmtExistingMasters->fetchAll(PDO::FETCH_ASSOC);

            // Submitted Master's degrees from the form
            $submittedMasters = $_POST['masters_degree_program_name'];
            foreach ($existingMastersDegrees as $existingDegree) {
                // Delete Master's degrees that are not in the submitted list
                if (!in_array($existingDegree['masters_degree_program_name'], $submittedMasters)) {
                    echo "Deleting Master's degree: " . $existingDegree['masters_degree_program_name'] . "<br>";
                    $queryDelete = "DELETE FROM masters_degree_earned WHERE id = ?";
                    $stmtDelete = $pdo->prepare($queryDelete);
                    $stmtDelete->execute([$existingDegree['id']]);
                }
            }

            // Insert or update the submitted Master's degree details
            foreach ($submittedMasters as $index => $programName) {
                $degreeCode = $_POST['masters_degree_code'][$index];
                $major = $_POST['masters_degree_major'][$index];
                echo "Inserting/Updating Master's Degree: $programName, $degreeCode, $major<br>";

                // Check if the degree already exists in the database
                $queryCheck = "SELECT id FROM masters_degree_earned WHERE teaching_faculty_id = ? AND masters_degree_program_name = ?";
                $stmtCheck = $pdo->prepare($queryCheck);
                $stmtCheck->execute([$facultyId, $programName]);
                $existingDegree = $stmtCheck->fetch();

                if ($existingDegree) {
                    echo "Updating Master's Degree.<br>";
                    $queryUpdate = "UPDATE masters_degree_earned SET masters_degree_code = ?, masters_degree_major = ? WHERE id = ?";
                    $stmtUpdate = $pdo->prepare($queryUpdate);
                    $stmtUpdate->execute([$degreeCode, $major, $existingDegree['id']]);
                } else {
                    echo "Inserting new Master's Degree.<br>";
                    $queryInsert = "INSERT INTO masters_degree_earned (teaching_faculty_id, masters_degree_program_name, masters_degree_code, masters_degree_major) VALUES (?, ?, ?, ?)";
                    $stmtInsert = $pdo->prepare($queryInsert);
                    $stmtInsert->execute([$facultyId, $programName, $degreeCode, $major]);
                }
            }
        }

        // Handle Doctorate Degree
        if (!empty($_POST['doctorate_program_name'])) {
            echo "Processing Doctorate Degree information.<br>";
            
            // Get existing Doctorate degrees from the database
            $queryExistingDoctorate = "SELECT id, doctorate_program_name FROM doctorate_degree_earned WHERE teaching_faculty_id = ?";
            $stmtExistingDoctorate = $pdo->prepare($queryExistingDoctorate);
            $stmtExistingDoctorate->execute([$facultyId]);
            $existingDoctorateDegrees = $stmtExistingDoctorate->fetchAll(PDO::FETCH_ASSOC);

            // Submitted Doctorate degrees from the form
            $submittedDoctorate = $_POST['doctorate_program_name'];
            foreach ($existingDoctorateDegrees as $existingDegree) {
                // Delete Doctorate degrees that are not in the submitted list
                if (!in_array($existingDegree['doctorate_program_name'], $submittedDoctorate)) {
                    echo "Deleting Doctorate degree: " . $existingDegree['doctorate_program_name'] . "<br>";
                    $queryDelete = "DELETE FROM doctorate_degree_earned WHERE id = ?";
                    $stmtDelete = $pdo->prepare($queryDelete);
                    $stmtDelete->execute([$existingDegree['id']]);
                }
            }

            // Insert or update the submitted Doctorate degree details
            foreach ($submittedDoctorate as $index => $programName) {
                $degreeCode = $_POST['doctorate_program_code'][$index];
                $major = $_POST['doctorate_degree_major'][$index];
                echo "Inserting/Updating Doctorate Degree: $programName, $degreeCode, $major<br>";

                // Check if the degree already exists in the database
                $queryCheck = "SELECT id FROM doctorate_degree_earned WHERE teaching_faculty_id = ? AND doctorate_program_name = ?";
                $stmtCheck = $pdo->prepare($queryCheck);
                $stmtCheck->execute([$facultyId, $programName]);
                $existingDegree = $stmtCheck->fetch();

                if ($existingDegree) {
                    echo "Updating Doctorate Degree.<br>";
                    $queryUpdate = "UPDATE doctorate_degree_earned SET doctorate_program_code = ?, doctorate_degree_major = ? WHERE id = ?";
                    $stmtUpdate = $pdo->prepare($queryUpdate);
                    $stmtUpdate->execute([$degreeCode, $major, $existingDegree['id']]);
                } else {
                    echo "Inserting new Doctorate Degree.<br>";
                    $queryInsert = "INSERT INTO doctorate_degree_earned (teaching_faculty_id, doctorate_program_name, doctorate_program_code, doctorate_degree_major) VALUES (?, ?, ?, ?)";
                    $stmtInsert = $pdo->prepare($queryInsert);
                    $stmtInsert->execute([$facultyId, $programName, $degreeCode, $major]);
                }
            }
        }

        // Respond back to JavaScript (Success)
        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        // Catch any errors and send the error message in the response
        echo json_encode([
            'success' => false,
            'error_message' => $e->getMessage()
        ]);
    }
}
?>
