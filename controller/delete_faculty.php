<?php
include($_SERVER['DOCUMENT_ROOT'] . "/faculty_management_system/config/connection.php");

// Validate if faculty_id is provided
if (!isset($_POST['faculty_id'])) {
    echo json_encode(['success' => false, 'message' => 'Faculty ID not provided.']);
    exit();
}

$facultyId = $_POST['faculty_id'];

try {
    $pdo->beginTransaction();

    // Delete related records in the pivot table
    $pivotDeleteQuery = "DELETE FROM educational_credential_earned WHERE teaching_faculty_id = :faculty_id OR non_teaching_faculty_id = :faculty_id";
    $pivotStmt = $pdo->prepare($pivotDeleteQuery);
    $pivotStmt->execute(['faculty_id' => $facultyId]);

    // Delete from the teaching faculty table
    $teachingDeleteQuery = "DELETE FROM teaching_faculty_information WHERE id = :faculty_id";
    $teachingStmt = $pdo->prepare($teachingDeleteQuery);
    $teachingStmt->execute(['faculty_id' => $facultyId]);

    // Delete from the non-teaching faculty table
    $nonTeachingDeleteQuery = "DELETE FROM non_teaching_faculty_information WHERE id = :faculty_id";
    $nonTeachingStmt = $pdo->prepare($nonTeachingDeleteQuery);
    $nonTeachingStmt->execute(['faculty_id' => $facultyId]);

    // Check if any rows were affected
    if ($teachingStmt->rowCount() > 0 || $nonTeachingStmt->rowCount() > 0) {
        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Faculty record deleted successfully.']);
    } else {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'No record found to delete.']);
    }
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
