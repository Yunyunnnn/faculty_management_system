<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

include 'controller\fetch_faculty_data.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Faculty</title>
    <link href="assets/output.css" rel="stylesheet">
</head>
<style>
.example::-webkit-scrollbar {
  display: none;
}

.example {
  -ms-overflow-style: none; 
  scrollbar-width: none;  
}
</style>
<body class="bg-gray-900">

    <!-- Container -->
<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Manage Faculty</h1>
        <div class="flex gap-4">
            <button class="bg-green-600 px-6 py-3 text-white font-semibold rounded-lg" id="openModalBtn">
                Add New Teaching Faculty
            </button>
            <button class="bg-green-600 px-6 py-3 text-white font-semibold rounded-lg" id="openNonTeachingModalBtn">
                Add New None-Teaching Faculty
            </button>
        </div>
    </div>

    <!-- Faculty Table -->
    <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-md">
    <table class="min-w-full table-auto text-white">
    <thead class="bg-gray-700">
        <tr>
            <th class="py-3 px-4 text-left">First Name</th>
            <th class="py-3 px-4 text-left">Middle Initial</th>
            <th class="py-3 px-4 text-left">Last Name</th>
            <th class="py-3 px-4 text-left">Faculty Type</th>
            <th class="py-3 px-4 text-left">Gender</th>
            <th class="py-3 px-4 text-left">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($facultyData) && !empty($facultyData)) {
            foreach ($facultyData as $row) {
                echo "
                <tr id='faculty-row-{$row['id']}'>
                    <td class='py-3 px-4'>{$row['first_name']}</td>
                    <td class='py-3 px-4'>{$row['middle_initial']}</td>
                    <td class='py-3 px-4'>{$row['last_name']}</td>
                    <td class='py-3 px-4'>{$row['faculty_type']}</td>
                    <td class='py-3 px-4'>{$row['gender_name']}</td>
                    <td class='py-3 px-4'>
                        <!-- Inside your PHP loop where you generate the table -->
                        <button 
                            class='text-blue-500 mr-2' 
                            onclick=\"editFaculty({$row['id']}, '{$row['faculty_type']}')\" 
                            id='openEditfacultyBtn'>
                            Edit
                        </button>
                        <button class='text-red-500 mr-2' onclick='deleteFaculty({$row['id']})'>Delete</button>
                    </td>
                </tr>
                ";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center py-3 px-4'>No faculty records found.</td></tr>";
        }
        ?>
    </tbody>
</table>

    </div>

    <!-- Teaching Faculty Modal -->
    <div id="facultyModal" class="fixed inset-0 bg-gray-900 bg-opacity-90 hidden z-50 py-10 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gray-700 p-6 rounded-lg w-1/2 shadow-lg">
                <h2 class="text-xl font-semibold text-white mb-4">Add New Faculty</h2>
                <form id="facultyForm">
                    <!-- Name Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="firstName" class="block text-sm font-medium text-gray-300">First Name</label>
                            <input type="text" id="firstName" name="first_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="lastName" class="block text-sm font-medium text-gray-300">Last Name</label>
                            <input type="text" id="lastName" name="last_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="middleInitial" class="block text-sm font-medium text-gray-300">Middle Initial</label>
                            <input type="text" id="middleInitial" name="middle_initial" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                    </div>

                    <!-- Employment and Discipline Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="employmentStatus" class="block text-sm font-medium text-gray-300">Employment Status</label>
                            <select id="employmentStatus" name="employment_status_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Full-time</option>
                                <option value="2">Part-time</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="gender" class="block text-sm font-medium text-gray-300">Gender</label>
                            <select id="gender" name="gender_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="discipline" class="block text-sm font-medium text-gray-300">Teaching Discipline</label>
                            <select id="discipline" name="primary_teaching_discipline_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Math</option>
                                <option value="2">Science</option>
                                <option value="3">English</option>
                            </select>
                        </div>
                    </div>

                    <!-- Rank, Teaching Load, and Salary Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="rank" class="block text-sm font-medium text-gray-300">Faculty Rank</label>
                            <select id="rank" name="faculty_rank_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Assistant Professor</option>
                                <option value="2">Associate Professor</option>
                                <option value="3">Professor</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="teachingLoad" class="block text-sm font-medium text-gray-300">Teaching Load</label>
                            <select id="teachingLoad" name="teaching_load_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Full Load</option>
                                <option value="2">Partial Load</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="salary" class="block text-sm font-medium text-gray-300">Annual Salary</label>
                            <select id="salary" name="annual_salary_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Salary A</option>
                                <option value="2">Salary B</option>
                            </select>
                        </div>
                    </div>

                    <!-- License and Tenure Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="license" class="block text-sm font-medium text-gray-300">Professional License</label>
                            <select id="license" name="professional_license_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Licensed</option>
                                <option value="2">Unlicensed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="tenure" class="block text-sm font-medium text-gray-300">Tenure of Employment</label>
                            <select id="tenure" name="tenure_of_employment_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Permanent</option>
                                <option value="2">Temporary</option>
                            </select>
                        </div>
                    </div>

                    <!-- Subjects Taught -->
                    <div class="mb-4">
                        <label for="subjectsTaught" class="block text-sm font-medium text-gray-300">Subjects Taught</label>
                        <input type="text" id="subjectsTaught" name="subjects_taught" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                    </div>

                    <h2 class="text-xl font-semibold text-white mb-4">Educational Credentials Earned</h2>
                    
                    <!-- Educational Credentials Fields -->
                    <div class="mb-4">
                        <label for="highestDegree" class="block text-sm font-medium text-gray-300">Highest Degree Attained</label>
                        <select id="highestDegree" name="highest_degree_attained_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            <option value="1">Bachelor's Degree</option>
                            <option value="2">Master's Degree</option>
                            <option value="3">Doctorate Degree</option>
                        </select>
                    </div>

                    <!-- Bachelor's Degree Section -->
                    <div class="grid grid-cols-3 gap-4" id="bachelorDegreeFields">
                        <div class="mb-4">
                            <label for="bachelorProgram" class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
                            <input type="text" id="bachelorProgram" name="bachelors_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="bachelorDegreeCode" class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
                            <input type="text" id="bachelorDegreeCode" name="bachelors_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="addBachelorDegree" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="addBachelorDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Master's Degree Section -->
                    <div class="grid grid-cols-3 gap-4" id="masterDegreeFields">
                        <div class="mb-4">
                            <label for="masterProgram" class="block text-sm font-medium text-gray-300">Master's Program</label>
                            <input type="text" id="masterProgram" name="masters_degree_program_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="masterDegreeCode" class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
                            <input type="text" id="masterDegreeCode" name="masters_degree_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="addMasterDegree" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="addMasterDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Doctorate Degree Section -->
                    <div class="grid grid-cols-3 gap-4" id="doctorateDegreeFields">
                        <div class="mb-4">
                            <label for="doctorateProgram" class="block text-sm font-medium text-gray-300">Doctorate Program</label>
                            <input type="text" id="doctorateProgram" name="doctorate_program_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="doctorateDegreeCode" class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
                            <input type="text" id="doctorateDegreeCode" name="doctorate_program_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="addDoctorateDegree" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="addDoctorateDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                <!-- Buttons -->
                <div class="!mt-4 flex justify-between items-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Faculty</button>
                    <button id="closeModalBtn" class="bg-gray-700 text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-600">Close</button>
                </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Non-Teaching Faculty Modal -->
    <div id="nonTeachingFacultyModal" class="fixed inset-0 bg-gray-900 bg-opacity-90 hidden z-50 py-10 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gray-700 p-6 rounded-lg w-1/2 shadow-lg">
                <h2 class="text-xl font-semibold text-white mb-4">Add New Non-Teaching Faculty</h2>
                <form id="nonTeachingFacultyForm">
                    <!-- Name Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="nonTeaching_firstName" class="block text-sm font-medium text-gray-300">First Name</label>
                            <input type="text" id="nonTeaching_firstName" name="non_teaching_first_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_lastName" class="block text-sm font-medium text-gray-300">Last Name</label>
                            <input type="text" id="nonTeaching_lastName" name="non_teaching_last_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_middleInitial" class="block text-sm font-medium text-gray-300">Middle Initial</label>
                            <input type="text" id="nonTeaching_middleInitial" name="non_teaching_middle_initial" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                    </div>

                    <!-- Designation and Employment Fields for Non-Teaching Faculty -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="nonTeaching_designation" class="block text-sm font-medium text-gray-300">Designation</label>
                            <input type="number" id="nonTeaching_designation" name="non_teaching_designation" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_employmentStatus" class="block text-sm font-medium text-gray-300">Employment Status</label>
                            <select id="nonTeaching_employmentStatus" name="non_teaching_employment_status_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Full-time</option>
                                <option value="2">Part-time</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_gender" class="block text-sm font-medium text-gray-300">Gender</label>
                            <select id="nonTeaching_gender" name="non_teaching_gender_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- License and Tenure Fields for Non-Teaching Faculty -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="nonTeaching_license" class="block text-sm font-medium text-gray-300">Professional License</label>
                            <select id="nonTeaching_license" name="non_teaching_professional_license_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Licensed</option>
                                <option value="2">Unlicensed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_tenure" class="block text-sm font-medium text-gray-300">Tenure of Employment</label>
                            <select id="nonTeaching_tenure" name="non_teaching_tenure_of_employment_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Permanent</option>
                                <option value="2">Temporary</option>
                            </select>
                        </div>
                    </div>

                    <!-- Years of Service and Annual Salary Code (Side by Side) for Non-Teaching Faculty -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="nonTeaching_yearsOfService" class="block text-sm font-medium text-gray-300">Years of Service</label>
                            <input type="number" id="nonTeaching_yearsOfService" name="non_teaching_years_of_service" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_salary" class="block text-sm font-medium text-gray-300">Annual Salary</label>
                            <select id="nonTeaching_salary" name="non_teaching_annual_salary_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Salary A</option>
                                <option value="2">Salary B</option>
                            </select>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-white mb-4">Educational Credentials Earned</h2>
                    
                    <!-- Educational Credentials Fields for Non-Teaching Faculty -->
                    <div class="mb-4">
                        <label for="nonTeaching_highestDegree" class="block text-sm font-medium text-gray-300">Highest Degree Attained</label>
                        <select id="nonTeaching_highestDegree" name="non_teaching_highest_degree_attained_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            <option value="1">Bachelor's Degree</option>
                            <option value="2">Master's Degree</option>
                            <option value="3">Doctorate Degree</option>
                        </select>
                    </div>

                    <!-- Bachelor's Degree Section for Non-Teaching Faculty -->
                    <div class="grid grid-cols-3 gap-4" id="nonTeaching_bachelorDegreeFields">
                        <div class="mb-4">
                            <label for="nonTeaching_bachelorProgram" class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
                            <input type="text" id="nonTeaching_bachelorProgram" name="non_teaching_bachelors_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_bachelorDegreeCode" class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
                            <input type="text" id="nonTeaching_bachelorDegreeCode" name="non_teaching_bachelors_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_addBachelorDegree" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="nonTeaching_addBachelorDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Master's Degree Section for Non-Teaching Faculty -->
                    <div class="grid grid-cols-3 gap-4" id="nonTeaching_masterDegreeFields">
                        <div class="mb-4">
                            <label for="nonTeaching_masterProgram" class="block text-sm font-medium text-gray-300">Master's Program</label>
                            <input type="text" id="nonTeaching_masterProgram" name="non_teaching_masters_degree_program_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_masterDegreeCode" class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
                            <input type="text" id="nonTeaching_masterDegreeCode" name="non_teaching_masters_degree_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_addMasterDegree" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="nonTeaching_addMasterDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Doctorate Degree Section for Non-Teaching Faculty -->
                    <div class="grid grid-cols-3 gap-4" id="nonTeaching_doctorateDegreeFields">
                        <div class="mb-4">
                            <label for="nonTeaching_doctorateProgram" class="block text-sm font-medium text-gray-300">Doctorate Program</label>
                            <input type="text" id="nonTeaching_doctorateProgram" name="non_teaching_doctorate_program_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_doctorateDegreeCode" class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
                            <input type="text" id="nonTeaching_doctorateDegreeCode" name="non_teaching_doctorate_program_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_addDoctorateDegree" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="nonTeaching_addDoctorateDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="!mt-4 flex justify-between items-center">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Non-Teaching Faculty</button>
                        <button id="closeNonTeachingModalBtn" class="bg-gray-700 text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-600">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Teaching Faculty Modal edit -->
    <div id="teachingFacultyModal" class="fixed inset-0 bg-gray-900 bg-opacity-90 hidden z-50 py-10 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gray-700 p-6 rounded-lg w-1/2 shadow-lg">
                <h2 class="text-xl font-semibold text-white mb-4">Edit New Faculty</h2>
                <form id="facultyFormEdit">
                    <!-- Name Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="firstName" class="block text-sm font-medium text-gray-300">First Name</label>
                            <input type="text" id="firstNameteaching" name="first_nameteaching" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="lastName" class="block text-sm font-medium text-gray-300">Last Name</label>
                            <input type="text" id="lastNameteaching" name="last_nameteaching" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="middleInitial" class="block text-sm font-medium text-gray-300">Middle Initial</label>
                            <input type="text" id="middleInitialteaching" name="middle_initialteaching" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                    </div>

                    <!-- Employment and Discipline Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="employmentStatusTeaching" class="block text-sm font-medium text-gray-300">Employment Status</label>
                            <select id="employmentStatusTeaching" name="employment_status_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Full-time</option>
                                <option value="2">Part-time</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="genderTeaching" class="block text-sm font-medium text-gray-300">Gender</label>
                            <select id="genderTeaching" name="gender_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="disciplineTeaching" class="block text-sm font-medium text-gray-300">Teaching Discipline</label>
                            <select id="disciplineTeaching" name="primary_teaching_discipline_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Math</option>
                                <option value="2">Science</option>
                                <option value="3">English</option>
                            </select>
                        </div>
                    </div>

                    <!-- Rank, Teaching Load, and Salary Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="rankTeaching" class="block text-sm font-medium text-gray-300">Faculty Rank</label>
                            <select id="rankTeaching" name="faculty_rank_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Assistant Professor</option>
                                <option value="2">Associate Professor</option>
                                <option value="3">Professor</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="teachingLoadTeaching" class="block text-sm font-medium text-gray-300">Teaching Load</label>
                            <select id="teachingLoadTeaching" name="teaching_load_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Full Load</option>
                                <option value="2">Partial Load</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="salaryTeaching" class="block text-sm font-medium text-gray-300">Annual Salary</label>
                            <select id="salaryTeaching" name="annual_salary_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Salary A</option>
                                <option value="2">Salary B</option>
                            </select>
                        </div>
                    </div>

                    <!-- License and Tenure Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="licenseFaculty" class="block text-sm font-medium text-gray-300">Professional License</label>
                            <select id="licenseFaculty" name="professional_license_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Licensed</option>
                                <option value="2">Unlicensed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="tenureFaculty" class="block text-sm font-medium text-gray-300">Tenure of Employment</label>
                            <select id="tenureFaculty" name="tenure_of_employment_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Permanent</option>
                                <option value="2">Temporary</option>
                            </select>
                        </div>
                    </div>

                    <!-- Subjects Taught -->
                    <div class="mb-4">
                        <label for="subjectsTaughtFaculty" class="block text-sm font-medium text-gray-300">Subjects Taught</label>
                        <input type="text" id="subjectsTaughtFaculty" name="subjects_taught" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                    </div>

                    <h2 class="text-xl font-semibold text-white mb-4">Educational Credentials Earned</h2>
                    
                    <!-- Educational Credentials Fields -->
                    <div class="mb-4">
                        <label for="highestDegreefaculty" class="block text-sm font-medium text-gray-300">Highest Degree Attained</label>
                        <select id="highestDegreeFaculty" name="highest_degree_attained_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            <option value="1">Bachelor's Degree</option>
                            <option value="2">Master's Degree</option>
                            <option value="3">Doctorate Degree</option>
                        </select>
                    </div>

                    <!-- Bachelor's Degree Section -->
                    <div class="grid grid-cols-3 gap-4" id="bachelorDegreeFieldsSection">
                        <div class="mb-4">
                            <label for="bachelorProgramFieldFaculty" class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
                            <input type="text" id="bachelorProgramFieldFaculty" name="bachelors_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="bachelorDegreeCodeFieldFaculty" class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
                            <input type="text" id="bachelorDegreeCodeFieldFaculty" name="bachelors_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="addBachelorDegreeField" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="addBachelorDegreeField" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Master's Degree Section -->
                    <div class="grid grid-cols-3 gap-4" id="masterDegreeFieldsSection">
                        <div class="mb-4">
                            <label for="masterProgramFieldFaculty" class="block text-sm font-medium text-gray-300">Master's Program</label>
                            <input type="text" id="masterProgramFieldFaculty" name="masters_degree_program_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="masterDegreeCodeFieldFaculty" class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
                            <input type="text" id="masterDegreeCodeFieldFaculty" name="masters_degree_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="addMasterDegreeField" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="addMasterDegreeField" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Doctorate Degree Section -->
                    <div class="grid grid-cols-3 gap-4" id="doctorateDegreeFieldsSection">
                        <div class="mb-4">
                            <label for="doctorateProgramFieldFaculty" class="block text-sm font-medium text-gray-300">Doctorate Program</label>
                            <input type="text" id="doctorateProgramFieldFaculty" name="doctorate_program_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="doctorateDegreeCodeFieldFaculty" class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
                            <input type="text" id="doctorateDegreeCodeFieldFaculty" name="doctorate_program_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="addDoctorateDegreeField" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="addDoctorateDegreeField" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="!mt-4 flex justify-between items-center">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Faculty</button>
                        <button type="button" id="closeEditfacultyBtn" class="bg-gray-700 text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-600">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- None Teaching Faculty Modal edit -->
    <div id="noneModal" class="fixed inset-0 bg-gray-900 bg-opacity-90 hidden z-50 py-10 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gray-700 p-6 rounded-lg w-1/2 shadow-lg">
                <h2 class="text-xl font-semibold text-white mb-4">Edit New Faculty</h2>
                <form id="noneModalFormEdit">
                     <!-- Name Fields -->
                     <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="noneModalFirstName" class="block text-sm font-medium text-gray-300">First Name</label>
                            <input type="text" id="noneModalFirstName" name="first_nameEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="noneModalLastName" class="block text-sm font-medium text-gray-300">Last Name</label>
                            <input type="text" id="noneModalLastName" name="last_nameEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="noneModalMiddleInitial" class="block text-sm font-medium text-gray-300">Middle Initial</label>
                            <input type="text" id="noneModalMiddleInitial" name="middle_initialEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                    </div>

                    <!-- Designation and Employment Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="noneModalDesignation" class="block text-sm font-medium text-gray-300">Designation</label>
                            <input type="number" id="noneModalDesignation" name="designationEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalEmploymentStatus" class="block text-sm font-medium text-gray-300">Employment Status</label>
                            <select id="noneModalEmploymentStatus" name="employment_status_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Full-time</option>
                                <option value="2">Part-time</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="noneModalGender" class="block text-sm font-medium text-gray-300">Gender</label>
                            <select id="noneModalGender" name="gender_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- License and Tenure Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="noneModalLicense" class="block text-sm font-medium text-gray-300">Professional License</label>
                            <select id="noneModalLicense" name="professional_license_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Licensed</option>
                                <option value="2">Unlicensed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="noneModalTenure" class="block text-sm font-medium text-gray-300">Tenure of Employment</label>
                            <select id="noneModalTenure" name="tenure_of_employment_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Permanent</option>
                                <option value="2">Temporary</option>
                            </select>
                        </div>
                    </div>

                    <!-- Years of Service and Annual Salary -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="noneModalYearsOfService" class="block text-sm font-medium text-gray-300">Years of Service</label>
                            <input type="number" id="noneModalYearsOfService" name="years_of_serviceEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalSalary" class="block text-sm font-medium text-gray-300">Annual Salary</label>
                            <select id="noneModalSalary" name="annual_salary_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="1">Salary A</option>
                                <option value="2">Salary B</option>
                            </select>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-white mb-4">Educational Credentials Earned</h2>

                    <!-- Educational Credentials Fields -->
                    <div class="mb-4">
                        <label for="noneModalHighestDegree" class="block text-sm font-medium text-gray-300">Highest Degree Attained</label>
                        <select id="noneModalHighestDegree" name="highest_degree_attained_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            <option value="1">Bachelor's Degree</option>
                            <option value="2">Master's Degree</option>
                            <option value="3">Doctorate Degree</option>
                        </select>
                    </div>

                    <!-- Bachelor's Degree Section -->
                    <div class="grid grid-cols-3 gap-4" id="noneModalBachelorDegreeFields">
                        <div class="mb-4">
                            <label for="noneModalBachelorProgram" class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
                            <input type="text" id="noneModalBachelorProgram" name="bachelors_degree_program_nameEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalBachelorDegreeCode" class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
                            <input type="text" id="noneModalBachelorDegreeCode" name="bachelors_degree_codeEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalAddBachelorDegree" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="noneModalAddBachelorDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Master's Degree Section -->
                    <div class="grid grid-cols-3 gap-4" id="noneModalMasterDegreeFields">
                        <div class="mb-4">
                            <label for="noneModalMasterProgram" class="block text-sm font-medium text-gray-300">Master's Program</label>
                            <input type="text" id="noneModalMasterProgram" name="masters_degree_program_nameEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalMasterDegreeCode" class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
                            <input type="text" id="noneModalMasterDegreeCode" name="masters_degree_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalAddMasterDegree" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="noneModalAddMasterDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Doctorate Degree Section for Non-Teaching Faculty -->
                    <div class="grid grid-cols-3 gap-4" id="nonTeaching_doctorateDegreeFields">
                        <div class="mb-4">
                            <label for="nonTeaching_doctorateProgram" class="block text-sm font-medium text-gray-300">Doctorate Program</label>
                            <input type="text" id="nonTeaching_doctorateProgram" name="non_teaching_doctorate_program_name" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_doctorateDegreeCode" class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
                            <input type="text" id="nonTeaching_doctorateDegreeCode" name="non_teaching_doctorate_program_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_addDoctorateDegree" class="block text-sm font-medium text-gray-300">Add Degree</label>
                            <button type="button" id="nonTeaching_addDoctorateDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="!mt-4 flex justify-between items-center">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Faculty</button>
                        <button type="button" id="noneModalCloseBtn" class="bg-gray-700 text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-600">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

</div>
    <script src="assets/script.js"></script>
    <script src="assets/functions.js"></script>
</body>
</html>
