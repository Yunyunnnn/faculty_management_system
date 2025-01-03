<?php
require $_SERVER['DOCUMENT_ROOT'] . '/faculty_management_system/vendor/autoload.php';
include($_SERVER['DOCUMENT_ROOT'] . "/faculty_management_system/config/connection.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()
    ->setCreator("Faculty Management System")
    ->setTitle("Teaching Faculty Data Export");

// Header row 1
$sheet->setCellValue('A1', 'CHED FORM E5 - FACULTY OR TEACHING STAFF IN HIGHER EDUCATION PROGRAMS');
$sheet->mergeCells('A1:T1');
$sheet->getStyle('A1')->applyFromArray([
    'font' => [
        'name' => 'Arial',
        'size' => 12,
        'color' => ['rgb' => 'FFFFFF'],
        'bold' => true,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '003366'],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
]);

// Header row 2
$totalFacultyQuery = $pdo->query("SELECT COUNT(*) FROM teaching_faculty_information");
$totalFaculty = $totalFacultyQuery->fetchColumn();
$sheet->setCellValue('A2', 'TOTAL NUMBER OF FACULTY: ' . $totalFaculty);
$sheet->mergeCells('A2:T2');
$sheet->getStyle('A2')->applyFromArray([
    'font' => [
        'name' => 'Arial',
        'size' => 18,
        'color' => ['rgb' => 'FFFF00'],
        'bold' => true,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '000000'],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
]);

// Headers: Rows 3–6
$headers = [
    'A3' => 'Name of Faculty (LN, FN MN)',
    'B3' => 'Employment Status',
    'C3' => 'Gender',
    'D3' => 'Primary Teaching Discipline',
    'E3' => 'Educational Credentials Earned',
    'N3' => 'Professional License',
    'O3' => 'Tenure of Employment',
    'P3' => 'Faculty Rank',
    'Q3' => 'Teaching Load',
    'R3' => 'Subjects Taught',
    'S3' => 'Annual Salary',
    'T3' => 'Highest Degree Attained',
];

// Apply column headers and merge educational credentials
foreach ($headers as $cell => $text) {
    $sheet->setCellValue($cell, $text);

    // Merge cells vertically only if the column is not part of E3:M3
    $column = substr($cell, 0, 1);
    if (!in_array($column, range('E', 'M'))) {
        $sheet->mergeCells($column . '3:' . $column . '5');
    }
}

// Merge educational credentials horizontally
$sheet->mergeCells('E3:M3');

// Sub-headers for educational credentials
$sheet->setCellValue('E4', 'Specific Discipline of Bachelor\'s Degree');
$sheet->mergeCells('E4:G4');
$sheet->setCellValue('H4', 'Specific Discipline of Master\'s Degree');
$sheet->mergeCells('H4:J4');
$sheet->setCellValue('K4', 'Specific Discipline of Doctorate Degree');
$sheet->mergeCells('K4:M4');

// Sub-columns for Program Name, Code, and Major
$educationalColumns = [
    'E5' => 'Program Name',
    'F5' => 'Code',
    'G5' => 'Major',
    'H5' => 'Program Name',
    'I5' => 'Code',
    'J5' => 'Major',
    'K5' => 'Program Name',
    'L5' => 'Code',
    'M5' => 'Major',
];
foreach ($educationalColumns as $cell => $text) {
    $sheet->setCellValue($cell, $text);
}

// Apply styles for headers
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
        'size' => 12,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '000000'],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => 'FFFFFF'],
        ],
    ],
];
$sheet->getStyle('A3:T5')->applyFromArray($headerStyle);

// Set alignment to center vertically and horizontally with some indentation
$sheet->getStyle('A3:T5')->applyFromArray([
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'indent' => 1, // Adds a slight padding-like effect
    ],
]);

// Increase row height for more spacing
$sheet->getRowDimension('3')->setRowHeight(30); // Adjust height for header row
$sheet->getRowDimension('4')->setRowHeight(25);
$sheet->getRowDimension('5')->setRowHeight(25);

// Optionally, increase column width for all columns
foreach (range('A', 'T') as $columnID) {
    $sheet->getColumnDimension($columnID)->setWidth(20); // Adjust width as needed
}

// Fetch faculty data with degrees concatenated as comma-separated values
$query = $pdo->query("
    SELECT 
        CONCAT(tfi.last_name, ', ', tfi.first_name, ' ', tfi.middle_initial) AS faculty_name,
        tfi.employment_status_code, 
        tfi.gender_code, 
        tfi.primary_teaching_discipline_code,
        tfi.professional_license_code,
        tfi.tenure_of_employment_code,
        tfi.faculty_rank_code,
        tfi.teaching_load_code,
        tfi.annual_salary_code,
        tfi.highest_degree_attained_code,
        tfs.subjects_taught,
        GROUP_CONCAT(DISTINCT bde.bachelors_degree_program_name ORDER BY bde.bachelors_degree_program_name) AS bachelors_names,
        GROUP_CONCAT(DISTINCT bde.bachelors_degree_code ORDER BY bde.bachelors_degree_code) AS bachelors_codes,
        GROUP_CONCAT(DISTINCT bde.bachelors_degree_major ORDER BY bde.bachelors_degree_major) AS bachelors_majors,
        GROUP_CONCAT(DISTINCT mde.masters_degree_program_name ORDER BY mde.masters_degree_program_name) AS masters_names,
        GROUP_CONCAT(DISTINCT mde.masters_degree_code ORDER BY mde.masters_degree_code) AS masters_codes,
        GROUP_CONCAT(DISTINCT mde.masters_degree_major ORDER BY mde.masters_degree_major) AS masters_majors,
        GROUP_CONCAT(DISTINCT dde.doctorate_program_name ORDER BY dde.doctorate_program_name) AS doctorate_names,
        GROUP_CONCAT(DISTINCT dde.doctorate_program_code ORDER BY dde.doctorate_program_code) AS doctorate_codes,
        GROUP_CONCAT(DISTINCT dde.doctorate_degree_major ORDER BY dde.doctorate_degree_major) AS doctorate_majors
    FROM teaching_faculty_information tfi
    LEFT JOIN teaching_faculty_subjects tfs ON tfi.id = tfs.teaching_faculty_id
    LEFT JOIN bachelors_degree_earned bde ON tfi.id = bde.teaching_faculty_id
    LEFT JOIN masters_degree_earned mde ON tfi.id = mde.teaching_faculty_id
    LEFT JOIN doctorate_degree_earned dde ON tfi.id = dde.teaching_faculty_id
    GROUP BY tfi.id
");

$rowNumber = 6; // Start from row 6
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $facultyId = $row['faculty_name']; // Track faculty by name

    // First appearance, display full data with concatenated educational credentials
    $sheet->fromArray([
        $row['faculty_name'], $row['employment_status_code'], $row['gender_code'],
        $row['primary_teaching_discipline_code'],
        $row['bachelors_names'], $row['bachelors_codes'], $row['bachelors_majors'],
        $row['masters_names'], $row['masters_codes'], $row['masters_majors'],
        $row['doctorate_names'], $row['doctorate_codes'], $row['doctorate_majors'],
        $row['professional_license_code'], $row['tenure_of_employment_code'],
        $row['faculty_rank_code'], $row['teaching_load_code'], $row['subjects_taught'],
        $row['annual_salary_code'], $row['highest_degree_attained_code'],
    ], null, 'A' . $rowNumber);

    $rowNumber++;
}

// Auto-size columns
foreach (range('A', 'T') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Output file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="teaching_faculty_data.xlsx"');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
