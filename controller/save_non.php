<?php
include($_SERVER['DOCUMENT_ROOT'] . "/faculty_management_system/config/connection.php");

// Capture form data from JavaScript submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // General Faculty Information
    $facultyId = $_POST['id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $middleInitial = $_POST['middle_initial'];
    $designationCode = $_POST['designation_code'];
    $employmentStatus = $_POST['employment_status'];
    $gender = $_POST['gender'];
    $license = $_POST['license'];
    $tenure = $_POST['tenure'];
    $yearsOfService = $_POST['years_of_service'];
    $annualSalary = $_POST['annual_salary'];
    $highestDegreeAttained = $_POST['highest_degree_attained'];

    // Prepare the query to insert or update the non-teaching faculty data
    $query = "INSERT INTO non_teaching_faculty_information 
              (id, first_name, last_name, middle_initial, designation_code, employment_status_code, gender_code, professional_license_code, tenure_of_employment_code, years_of_service, annual_salary_code, highest_degree_attained_code)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE 
              first_name = VALUES(first_name),
              last_name = VALUES(last_name),
              middle_initial = VALUES(middle_initial),
              designation_code = VALUES(designation_code),
              employment_status_code = VALUES(employment_status_code),
              gender_code = VALUES(gender_code),
              professional_license_code = VALUES(professional_license_code),
              tenure_of_employment_code = VALUES(tenure_of_employment_code),
              years_of_service = VALUES(years_of_service),
              annual_salary_code = VALUES(annual_salary_code),
              highest_degree_attained_code = VALUES(highest_degree_attained_code)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$facultyId, $firstName, $lastName, $middleInitial, $designationCode, $employmentStatus, $gender, $license, $tenure, $yearsOfService, $annualSalary, $highestDegreeAttained]);

    // Handle Bachelor's Degree
    if (!empty($_POST['bachelors_degree_program_name'])) {
        // Fetch existing Bachelor's degrees from the database
        $queryExistingBachelors = "SELECT id, bachelors_degree_program_name FROM bachelors_degree_earned WHERE non_teaching_faculty_id = ?";
        $stmtExistingBachelors = $pdo->prepare($queryExistingBachelors);
        $stmtExistingBachelors->execute([$facultyId]);
        $existingBachelorsDegrees = $stmtExistingBachelors->fetchAll(PDO::FETCH_ASSOC);

        // Collect the bachelor degree program names submitted in the form
        $submittedBachelors = $_POST['bachelors_degree_program_name'];

        // Remove Bachelor's degrees that are no longer in the submitted data
        foreach ($existingBachelorsDegrees as $existingDegree) {
            if (!in_array($existingDegree['bachelors_degree_program_name'], $submittedBachelors)) {
                // Degree is removed from the form, so delete it from the database
                $queryDelete = "DELETE FROM bachelors_degree_earned WHERE id = ?";
                $stmtDelete = $pdo->prepare($queryDelete);
                $stmtDelete->execute([$existingDegree['id']]);
            }
        }

        // Handle creation and update of Bachelor's degrees
        foreach ($submittedBachelors as $index => $programName) {
            $degreeCode = $_POST['bachelors_degree_code'][$index];
            $major = $_POST['bachelors_degree_major'][$index];

            // Check if Bachelor's Degree already exists
            $queryCheck = "SELECT id FROM bachelors_degree_earned WHERE non_teaching_faculty_id = ? AND bachelors_degree_program_name = ?";
            $stmtCheck = $pdo->prepare($queryCheck);
            $stmtCheck->execute([$facultyId, $programName]);
            $existingDegree = $stmtCheck->fetch();

            if ($existingDegree) {
                // Update existing Bachelor's Degree
                $queryUpdate = "UPDATE bachelors_degree_earned SET bachelors_degree_code = ?, bachelors_degree_major = ? WHERE id = ?";
                $stmtUpdate = $pdo->prepare($queryUpdate);
                $stmtUpdate->execute([$degreeCode, $major, $existingDegree['id']]);
            } else {
                // Insert new Bachelor's Degree
                $queryInsert = "INSERT INTO bachelors_degree_earned (non_teaching_faculty_id, bachelors_degree_program_name, bachelors_degree_code, bachelors_degree_major)
                                VALUES (?, ?, ?, ?)";
                $stmtInsert = $pdo->prepare($queryInsert);
                $stmtInsert->execute([$facultyId, $programName, $degreeCode, $major]);
            }
        }
    }

    // Handle Master's Degree (similar to Bachelor's)
    if (!empty($_POST['masters_degree_program_name'])) {
        // Fetch existing Master's degrees from the database
        $queryExistingMasters = "SELECT id, masters_degree_program_name FROM masters_degree_earned WHERE non_teaching_faculty_id = ?";
        $stmtExistingMasters = $pdo->prepare($queryExistingMasters);
        $stmtExistingMasters->execute([$facultyId]);
        $existingMastersDegrees = $stmtExistingMasters->fetchAll(PDO::FETCH_ASSOC);

        // Collect the master's degree program names submitted in the form
        $submittedMasters = $_POST['masters_degree_program_name'];

        // Remove Master's degrees that are no longer in the submitted data
        foreach ($existingMastersDegrees as $existingDegree) {
            if (!in_array($existingDegree['masters_degree_program_name'], $submittedMasters)) {
                // Degree is removed from the form, so delete it from the database
                $queryDelete = "DELETE FROM masters_degree_earned WHERE id = ?";
                $stmtDelete = $pdo->prepare($queryDelete);
                $stmtDelete->execute([$existingDegree['id']]);
            }
        }

        // Handle creation and update of Master's degrees
        foreach ($submittedMasters as $index => $programName) {
            $degreeCode = $_POST['masters_degree_code'][$index];
            $major = $_POST['masters_degree_major'][$index];

            // Check if Master's Degree already exists
            $queryCheck = "SELECT id FROM masters_degree_earned WHERE non_teaching_faculty_id = ? AND masters_degree_program_name = ?";
            $stmtCheck = $pdo->prepare($queryCheck);
            $stmtCheck->execute([$facultyId, $programName]);
            $existingDegree = $stmtCheck->fetch();

            if ($existingDegree) {
                // Update existing Master's Degree
                $queryUpdate = "UPDATE masters_degree_earned SET masters_degree_code = ?, masters_degree_major = ? WHERE id = ?";
                $stmtUpdate = $pdo->prepare($queryUpdate);
                $stmtUpdate->execute([$degreeCode, $major, $existingDegree['id']]);
            } else {
                // Insert new Master's Degree
                $queryInsert = "INSERT INTO masters_degree_earned (non_teaching_faculty_id, masters_degree_program_name, masters_degree_code, masters_degree_major)
                                VALUES (?, ?, ?, ?)";
                $stmtInsert = $pdo->prepare($queryInsert);
                $stmtInsert->execute([$facultyId, $programName, $degreeCode, $major]);
            }
        }
    }

    // Handle Doctorate Degree (similar to Bachelor's and Master's)
    if (!empty($_POST['doctorate_degree_program_name'])) {
        // Fetch existing Doctorate degrees from the database
        $queryExistingDoctorates = "SELECT id, doctorate_program_name FROM doctorate_degree_earned WHERE non_teaching_faculty_id = ?";
        $stmtExistingDoctorates = $pdo->prepare($queryExistingDoctorates);
        $stmtExistingDoctorates->execute([$facultyId]);
        $existingDoctorateDegrees = $stmtExistingDoctorates->fetchAll(PDO::FETCH_ASSOC);

        // Collect the doctorate degree program names submitted in the form
        $submittedDoctorates = $_POST['doctorate_degree_program_name'];

        // Remove Doctorate degrees that are no longer in the submitted data
        foreach ($existingDoctorateDegrees as $existingDegree) {
            if (!in_array($existingDegree['doctorate_program_name'], $submittedDoctorates)) {
                // Degree is removed from the form, so delete it from the database
                $queryDelete = "DELETE FROM doctorate_degree_earned WHERE id = ?";
                $stmtDelete = $pdo->prepare($queryDelete);
                $stmtDelete->execute([$existingDegree['id']]);
            }
        }

        // Handle creation and update of Doctorate degrees
        foreach ($submittedDoctorates as $index => $programName) {
            $degreeCode = $_POST['doctorate_program_code'][$index];
            $major = $_POST['doctorate_degree_major'][$index];

            // Check if Doctorate Degree already exists
            $queryCheck = "SELECT id FROM doctorate_degree_earned WHERE non_teaching_faculty_id = ? AND doctorate_program_name = ?";
            $stmtCheck = $pdo->prepare($queryCheck);
            $stmtCheck->execute([$facultyId, $programName]);
            $existingDegree = $stmtCheck->fetch();

            if ($existingDegree) {
                // Update existing Doctorate Degree
                $queryUpdate = "UPDATE doctorate_degree_earned SET doctorate_program_code = ?, doctorate_degree_major = ? WHERE id = ?";
                $stmtUpdate = $pdo->prepare($queryUpdate);
                $stmtUpdate->execute([$degreeCode, $major, $existingDegree['id']]);
            } else {
                // Insert new Doctorate Degree
                $queryInsert = "INSERT INTO doctorate_degree_earned (non_teaching_faculty_id, doctorate_program_name, doctorate_program_code, doctorate_degree_major)
                                VALUES (?, ?, ?, ?)";
                $stmtInsert = $pdo->prepare($queryInsert);
                $stmtInsert->execute([$facultyId, $programName, $degreeCode, $major]);
            }
        }
    }

    // Respond back to JavaScript (Success)
    echo json_encode(['success' => true]);
}
?>
