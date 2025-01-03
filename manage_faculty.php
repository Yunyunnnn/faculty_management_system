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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <div class="p-4 mb-4 text-green-800 bg-green-200 border border-green-300 rounded-lg">
        Data has been successfully saved!
    </div>
<?php endif; ?>
<body class="bg-gray-900">

<!-- header -->
<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <!-- Title at the start -->
        <div class="flex items-center gap-2">
            <img src="https://i.ibb.co/P44qSBC/Group-9logofirst.png" alt="Logo" class="w-8 h-8">
            <h1 class="text-2xl font-bold text-white"> ADFC Faculty Management</h1>
        </div>
        
        <!-- Buttons at the end -->
        <div class="flex gap-4 justify-end">
            <button 
                id="exportTeachingBtn" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" 
                onclick="window.location.href='controller/export_teaching_faculty_excel.php'"
                style="display: none;"
            >
                Export Teaching Data
            </button>
            <button 
                id="exportNonTeachingBtn" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" 
                onclick="window.location.href='controller/export_Nonteaching_faculty_excel.php'"
                style="display: none;"
            >
                Export Non Teaching Data
            </button>
            <button 
                class="bg-blue-600 hover:bg-blue-500 px-6 py-3 text-sm text-white font-semibold rounded-lg shadow-md transition-all duration-300 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                id="openModalBtn"
            >
                Add Teaching Faculty
            </button>
            <button 
                class="bg-blue-600 hover:bg-blue-500 px-6 py-3 text-sm text-white font-semibold rounded-lg shadow-md transition-all duration-300 focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                id="openNonTeachingModalBtn"
            >
                Add None-Teaching Faculty
            </button>
        </div>
    </div>

    <!-- Faculty Table -->
    <div class="overflow-x-auto bg-gray-900 rounded-lg shadow-lg">

            <section class="text-gray-400 bg-gray-800 body-font">
                <div class="container px-5 py-24 mx-auto">
                    <div class="flex flex-wrap -m-4 text-center">
                        <div class="p-4 sm:w-1/4 w-1/2">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-user-tie text-white mr-4 text-3xl"></i>
                                <h2 id="nonTeachingCount" class="title-font font-medium sm:text-4xl text-3xl text-white">0</h2>
                            </div>
                            <p class="leading-relaxed">Non-Teaching Staff</p>
                        </div>
                        <div class="p-4 sm:w-1/4 w-1/2">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-chalkboard-teacher text-white mr-4 text-3xl"></i>
                                <h2 id="teachingCount" class="title-font font-medium sm:text-4xl text-3xl text-white">0</h2>
                            </div>
                            <p class="leading-relaxed">Teaching Staff</p>
                        </div>
                        <div class="p-4 sm:w-1/4 w-1/2">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-user-clock text-white mr-4 text-3xl"></i>
                                <h2 id="partTimeCount" class="title-font font-medium sm:text-4xl text-3xl text-white">0</h2>
                            </div>
                            <p class="leading-relaxed">Part-timers</p>
                        </div>
                        <div class="p-4 sm:w-1/4 w-1/2">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-user text-white mr-4 text-3xl"></i>
                                <h2 id="fullTimeCount" class="title-font font-medium sm:text-4xl text-3xl text-white">0</h2>
                            </div>
                            <p class="leading-relaxed">Full-timers</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Search and Filter Section -->
            <div class="flex flex-wrap items-center gap-4 p-4 bg-gray-800 rounded-t-lg">
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Search by name..." 
                    class="w-full sm:w-auto px-4 py-2 border border-gray-600 bg-gray-700 text-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
                <select 
                    id="facultyTypeFilter" 
                    class="w-1/3 sm:w-auto px-4 py-2 border border-gray-600 bg-gray-700 text-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                    <option value=""> Faculty Type</option>
                    <option value="Teaching Faculty">Teaching Faculty</option>
                    <option value="Non-Teaching Faculty">Non-Teaching Faculty</option>
                </select>
                <select 
                    id="employmentStatusFilter" 
                    class="w-1/3 sm:w-auto px-4 py-2 border border-gray-600 bg-gray-700 text-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                    <option value=""> Employment Status</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Full-time">Full-time</option>
                </select>            
                <button 
                    id="refreshButton" 
                    class="px-4 py-2 bg-red-300 text-white rounded-lg ml-2 hover:bg-blue-600">
                    Refresh
                </button>
            </div>

            <!-- Table Section -->
            <table class="min-w-full table-auto text-gray-200 bg-gray-800 rounded-b-lg">
                <thead class="bg-gray-700 text-gray-300">
                    <tr>
                        <th class="py-3 px-4 text-left">First Name</th>
                        <th class="py-3 px-4 text-left">Middle Name</th>
                        <th class="py-3 px-4 text-left">Last Name</th>
                        <th class="py-3 px-4 text-left">Gender</th>
                        <th class="py-3 px-4 text-left">Faculty Type</th>
                        <th class="py-3 px-4 text-left">Employment Status</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="facultyTableBody" class="bg-gray-800 divide-y divide-gray-700">
                    <?php
                    if (isset($facultyData) && !empty($facultyData)) {
                        foreach ($facultyData as $row) {
                            echo "
                            <tr id='faculty-row-{$row['id']}'>
                                <td class='py-3 px-4'>{$row['first_name']}</td>
                                <td class='py-3 px-4'>{$row['middle_initial']}</td>
                                <td class='py-3 px-4'>{$row['last_name']}</td>
                                <td class='py-3 px-4'>{$row['gender_name']}</td>
                                <td class='py-3 px-4'>{$row['faculty_type']}</td>
                                <td class='py-3 px-4'>{$row['employment_status_code']}</td>
                                <td class='py-3 px-4'>
                                    <button 
                                        class='text-blue-400 hover:text-blue-500 mr-2' 
                                        onclick=\"editFaculty({$row['id']}, '{$row['faculty_type']}')\" 
                                        id='openEditfacultyBtn'>
                                        Edit
                                    </button>
                                    <button 
                                        class='text-red-400 hover:text-red-500' 
                                        onclick='deleteFaculty({$row['id']})'>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            ";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center py-3 px-4'>No faculty records found.</td></tr>";
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
                            <label for="middleInitial" class="block text-sm font-medium text-gray-300">Middle Name</label>
                            <input type="text" id="middleInitial" name="middle_initial" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                    </div>

                    <!-- Employment and Discipline Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="employmentStatus" class="block text-sm font-medium text-gray-300">Employment Status</label>
                            <select id="employmentStatus" name="employment_status_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >Full-time</option>
                                <option >Part-time</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="gender" class="block text-sm font-medium text-gray-300">Gender</label>
                            <select id="gender" name="gender_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >Male</option>
                                <option >Female</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="discipline" class="block text-sm font-medium text-gray-300">Teaching Discipline</label>
                            <select id="discipline" name="primary_teaching_discipline_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >Math</option>
                                <option >Science</option>
                                <option >English</option>
                            </select>
                        </div>
                    </div>

                    <!-- Rank, Teaching Load, and Salary Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="rank" class="block text-sm font-medium text-gray-300">Faculty Rank</label>
                            <select id="rank" name="faculty_rank_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >Teaching Fellow or Teaching Associater</option>
                                <option >Teacher, Master Teacher</option>
                                <option >Lecturer, Senior Lecturer, Professorial Lecturer</option>
                                <option >Professor Emeritus</option>
                                <option >Visiting Professor</option>
                                <option >Adjunct or affiliate faculty</option>
                                <option >Instructor</option>
                                <option >Assistant Professor</option>
                                <option >Full Professor</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="teachingLoad" class="block text-sm font-medium text-gray-300">Teaching Load</label>
                            <select id="teachingLoad" name="teaching_load_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >1.0  - 6.0 units per semester</option>
                                <option >7.0  - 12.0 units per semester</option>
                                <option >13.0 - 18.0 units per semester</option>
                                <option >19.0 - 24.0 units per semester</option>
                                <option >more than 24 units per semester</option>
                                <option >Not known</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="salary" class="block text-sm font-medium text-gray-300">Annual Salary</label>
                            <select id="salary" name="annual_salary_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>60,000 below</option>
                                <option >60,000 -  69,999</option>
                                <option >70,000 -  79,999</option>
                                <option >80,000 - 89,999</option>
                                <option >90,000 -  99,999</option>
                                <option >100,000 - 149,999</option>
                                <option >150,000 - 249,999</option>
                                <option >250,000 - 499,999</option>
                                <option >500,000 - Above</option>
                            </select>
                        </div>
                    </div>

                    <!-- License and Tenure Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="license" class="block text-sm font-medium text-gray-300">Professional License</label>
                            <select id="license" name="professional_license_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >Licensed</option>
                                <option >Unlicensed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="tenure" class="block text-sm font-medium text-gray-300">Tenure of Employment</label>
                            <select id="tenure" name="tenure_of_employment_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >Permanent</option>
                                <option >Probationary</option>
                                <option >Casual</option>
                                <option >Contractual</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                            <label for="highestDegree" class="block text-sm font-medium text-gray-300">Highest Degree Attained</label>
                            <select id="highestDegree" name="highest_degree_attained_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >No formal education at all</option>
                                <option >Partial elementary schooling but did not complete Grade 4</option>
                                <option >Completed Grade 4 but did not graduate from elementary school</option>
                                <option >Completed Elementary School</option>
                                <option >Partial completion of High School</option>
                                <option >Secondary school graduate or equivalent</option>
                                <option >Completed Tech/Voch</option>
                                <option >Partial completion of pre-baccalaureate certificate, diploma or associateship</option>
                                <option >Completed pre-bacc certificate, diploma or associateship</option>
                                <option >Completed Year 1 of baccalaureate level or equivalent</option>
                                <option >Completed Year 2 of baccalaureate level or equivalent</option>
                                <option >Completed Year 3 of baccalaureate level or equivalent</option>
                                <option >Completed Year 4 of baccalaureate level or equivalent</option>
                                <option >Completed Year 5 of baccalaureate level or equivalent</option>
                                <option >Completed Year 6 of baccalaureate level or equivalent</option>
                                <option >Completed a baccalaureate degree (including DVM, DDM, D Opt)</option>
                                <option >Partial Completion of postgraduate certificate or diploma program</option>
                                <option >Completed Year 1 of MD or LLB</option>
                                <option >Completed Year 2 of MD or LLB</option>
                                <option >Completed Year 3 of MD or LLB</option>
                                <option >Completed Year 4 of MD or LLB</option>
                                <option >Completed MD or LLB (or equivalent)</option>
                                <option >Partial completion of masters degree</option>
                                <option >Completed all masters requirements except masters thesis</option>                                
                                <option >Completed all doctorate requirements except dissertation</option>
                                <option >Completed masters degree or equivalent</option>
                                <option >Partial completion of doctorate degree</option>
                                <option >Completed doctoratedegree</option>
                            </select>
                    </div>

                    <!-- Subjects Taught -->
                    <div class="grid grid-cols-2 gap-4 items-center mb-4">
                        <div class="mb-4">
                            <label for="subjectsTaught" class="block text-sm font-medium text-gray-300">Subjects Taught</label>
                            <input type="text" id="subjectsTaught" name="subjects_taught" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="semesterSelect" class="block text-sm font-medium text-gray-300">Semester</label>
                            <select id="semesterSelect" name="semester" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="First Semester">First Semester</option>
                                <option value="Second Semester">Second Semester</option>
                            </select>
                        </div>
                    </div>
                    
                    <h2 class="text-xl font-semibold text-white mb-4">Educational Credentials Earned</h2>
                    
                    <!-- Bachelor's Degree Section -->
                    <div id="bachelorDegreeFields">
                        <div class="flex flex-wrap gap-4 items-center" id="bachelorDegreeFields">
                            <div class="mb-4">
                                <label for="bachelorProgram" class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
                                <input type="text" id="bachelorProgram" name="bachelors_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="bachelorDegreeCode" class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
                                <input type="text" id="bachelorDegreeCode" name="bachelors_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="bachelorMajor" class="block text-sm font-medium text-gray-300">Bachelor's Major</label>
                                <input type="text" id="bachelorMajor" name="bachelors_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="addBachelorDegree" class="block text-sm font-medium text-gray-300">Add</label>
                                <button type="button" id="addBachelorDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>      

                    <!-- Master's Degree Section -->
                    <div id="masterDegreeFields">
                        <div class="flex flex-wrap gap-4 items-center" id="masterDegreeFields">
                            <div class="mb-4">
                                <label for="masterProgram" class="block text-sm font-medium text-gray-300">Master's Program</label>
                                <input type="text" id="masterProgram" name="masters_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="masterDegreeCode" class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
                                <input type="text" id="masterDegreeCode" name="masters_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="masterMajor" class="block text-sm font-medium text-gray-300">Master's Major</label>
                                <input type="text" id="masterMajor" name="masters_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="addMasterDegree" class="block text-sm font-medium text-gray-300">Add</label>
                                <button type="button" id="addMasterDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Doctorate Degree Section -->
                    <div id="doctorateDegreeFields">
                        <div class="flex flex-wrap gap-4 items-center" id="doctorateDegreeFields">
                            <div class="mb-4">
                                <label for="doctorateProgram" class="block text-sm font-medium text-gray-300">Doctorate Program</label>
                                <input type="text" id="doctorateProgram" name="doctorate_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="doctorateDegreeCode" class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
                                <input type="text" id="doctorateDegreeCode" name="doctorate_program_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="doctorateMajor" class="block text-sm font-medium text-gray-300">Doctorate Major</label>
                                <input type="text" id="doctorateMajor" name="doctorate_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="addDoctorateDegree" class="block text-sm font-medium text-gray-300">Add</label>
                                <button type="button" id="addDoctorateDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    +
                                </button>
                            </div>
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
                            <label for="nonTeaching_middleInitial" class="block text-sm font-medium text-gray-300">Middle Name</label>
                            <input type="text" id="nonTeaching_middleInitial" name="non_teaching_middle_initial" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                    </div>

                   <!-- Designation and Employment Fields for Non-Teaching Faculty -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="nonTeaching_designation" class="block text-sm font-medium text-gray-300">Designation</label>
                            <input type="text" id="nonTeaching_designation" name="non_teaching_designation" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_employmentStatus" class="block text-sm font-medium text-gray-300">Employment Status</label>
                            <select id="nonTeaching_employmentStatus" name="non_teaching_employment_status_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>Full-time</option>
                                <option>Part-time</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_gender" class="block text-sm font-medium text-gray-300">Gender</label>
                            <select id="nonTeaching_gender" name="non_teaching_gender_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- License and Tenure Fields for Non-Teaching Faculty -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="nonTeaching_license" class="block text-sm font-medium text-gray-300">Professional License</label>
                            <select id="nonTeaching_license" name="non_teaching_professional_license_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>Licensed</option>
                                <option>Unlicensed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_tenure" class="block text-sm font-medium text-gray-300">Tenure of Employment</label>
                            <select id="nonTeaching_tenure" name="non_teaching_tenure_of_employment_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >Permanent</option>
                                <option >Probationary</option>
                                <option >Casual</option>
                                <option >Contractual</option>
                            </select>
                        </div>
                    </div>

                    <!-- Years of Service and Annual Salary Code (Side by Side) for Non-Teaching Faculty -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="nonTeaching_yearsOfService" class="block text-sm font-medium text-gray-300">Years of Service</label>
                            <input type="number" id="nonTeaching_yearsOfService" name="non_teaching_years_of_service" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_salary" class="block text-sm font-medium text-gray-300">Annual Salary</label>
                            <select id="nonTeaching_salary" name="non_teaching_annual_salary_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>60,000 below</option>
                                <option >60,000 -  69,999</option>
                                <option >70,000 -  79,999</option>
                                <option >80,000 - 89,999</option>
                                <option >90,000 -  99,999</option>
                                <option >100,000 - 149,999</option>
                                <option >150,000 - 249,999</option>
                                <option >250,000 - 499,999</option>
                                <option >500,000 - Above</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_highestDegree" class="block text-sm font-medium text-gray-300">Highest Degree Attained</label>
                            <select id="nonTeaching_highestDegree" name="non_teaching_highest_degree_attained_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            <option >No formal education at all</option>
                                <option >Partial elementary schooling but did not complete Grade 4</option>
                                <option >Completed Grade 4 but did not graduate from elementary school</option>
                                <option >Completed Elementary School</option>
                                <option >Partial completion of High School</option>
                                <option >Secondary school graduate or equivalent</option>
                                <option >Completed Tech/Voch</option>
                                <option >Partial completion of pre-baccalaureate certificate, diploma or associateship</option>
                                <option >Completed pre-bacc certificate, diploma or associateship</option>
                                <option >Completed Year 1 of baccalaureate level or equivalent</option>
                                <option >Completed Year 2 of baccalaureate level or equivalent</option>
                                <option >Completed Year 3 of baccalaureate level or equivalent</option>
                                <option >Completed Year 4 of baccalaureate level or equivalent</option>
                                <option >Completed Year 5 of baccalaureate level or equivalent</option>
                                <option >Completed Year 6 of baccalaureate level or equivalent</option>
                                <option >Completed a baccalaureate degree (including DVM, DDM, D Opt)</option>
                                <option >Partial Completion of postgraduate certificate or diploma program</option>
                                <option >Completed Year 1 of MD or LLB</option>
                                <option >Completed Year 2 of MD or LLB</option>
                                <option >Completed Year 3 of MD or LLB</option>
                                <option >Completed Year 4 of MD or LLB</option>
                                <option >Completed MD or LLB (or equivalent)</option>
                                <option >Partial completion of masters degree</option>
                                <option >Completed all masters requirements except masters thesis</option>                                
                                <option >Completed all doctorate requirements except dissertation</option>
                                <option >Completed masters degree or equivalent</option>
                                <option >Partial completion of doctorate degree</option>
                                <option >Completed doctoratedegree</option>
                            </select>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-white mb-4">Educational Credentials Earned</h2>

                    <!-- Bachelor's Degree Section for Non-Teaching Faculty -->
                    <div id="nonTeaching_bachelorDegreeFields">
                        <div class="flex flex-wrap gap-4 items-center" >
                            <div class="mb-4">
                                <label for="nonTeaching_bachelorProgram" class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
                                <input type="text" id="nonTeaching_bachelorProgram" name="non_teaching_bachelors_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="nonTeaching_bachelorDegreeCode" class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
                                <input type="text" id="nonTeaching_bachelorDegreeCode" name="non_teaching_bachelors_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="nonTeaching_bachelorMajor" class="block text-sm font-medium text-gray-300">Bachelor's Degree Major</label>
                                <input type="text" id="nonTeaching_bachelorMajor" name="non_teaching_bachelors_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="nonTeaching_addBachelorDegree" class="block text-sm font-medium text-gray-300">Add</label>
                                <button type="button" id="nonTeaching_addBachelorDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Master's Degree Section for Non-Teaching Faculty -->
                    <div id="nonTeaching_MasterDegreeFields">
                        <div class="flex flex-wrap gap-4 items-center">
                            <div class="mb-4">
                                <label for="nonTeaching_masterProgram" class="block text-sm font-medium text-gray-300">Master's Program</label>
                                <input type="text" id="nonTeaching_masterProgram" name="non_teaching_masters_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="nonTeaching_masterDegreeCode" class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
                                <input type="text" id="nonTeaching_masterDegreeCode" name="non_teaching_masters_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="nonTeaching_masterMajor" class="block text-sm font-medium text-gray-300">Master's Degree Major</label>
                                <input type="text" id="nonTeaching_masterMajor" name="non_teaching_masters_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="nonTeaching_addMasterDegree" class="block text-sm font-medium text-gray-300">Add</label>
                                <button type="button" id="nonTeaching_addMasterDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Doctorate Degree Section for Non-Teaching Faculty -->
                    <div  id="nonTeaching_doctorateDegreeFields">
                        <div class="flex flex-wrap gap-4 items-center">
                            <div class="mb-4">
                                <label for="nonTeaching_doctorateProgram" class="block text-sm font-medium text-gray-300">Doctorate Program</label>
                                <input type="text" id="nonTeaching_doctorateProgram" name="non_teaching_doctorate_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="nonTeaching_doctorateDegreeCode" class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
                                <input type="text" id="nonTeaching_doctorateDegreeCode" name="non_teaching_doctorate_program_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="nonTeaching_doctorateMajor" class="block text-sm font-medium text-gray-300">Doctorate Degree Major</label>
                                <input type="text" id="nonTeaching_doctorateMajor" name="non_teaching_doctorate_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="nonTeaching_addDoctorateDegree" class="block text-sm font-medium text-gray-300">Add</label>
                                <button type="button" id="nonTeaching_addDoctorateDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    +
                                </button>
                            </div>
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
                <h2 class="text-xl font-semibold text-white mb-4">Edit Teaching Faculty</h2>
                <form id="facultyFormEdit">
                    <input type="hidden" name="id" id="teachingModalFacultyId">

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
                            <label for="middleInitial" class="block text-sm font-medium text-gray-300">Middle Name</label>
                            <input type="text" id="middleInitialteaching" name="middle_initialteaching" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                    </div>

                    <!-- Employment and Discipline Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="employmentStatusTeaching" class="block text-sm font-medium text-gray-300">Employment Status</label>
                            <select id="employmentStatusTeaching" name="employment_status_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>Full-time</option>
                                <option>Part-time</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="genderTeaching" class="block text-sm font-medium text-gray-300">Gender</label>
                            <select id="genderTeaching" name="gender_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="disciplineTeaching" class="block text-sm font-medium text-gray-300">Teaching Discipline</label>
                            <select id="disciplineTeaching" name="primary_teaching_discipline_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>Math</option>
                                <option>Science</option>
                                <option>English</option>
                            </select>
                        </div>
                    </div>

                    <!-- Rank, Teaching Load, and Salary Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="rankTeaching" class="block text-sm font-medium text-gray-300">Faculty Rank</label>
                            <select id="rankTeaching" name="faculty_rank_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            <option >Teaching Fellow or Teaching Associater</option>
                                <option >Teacher, Master Teacher</option>
                                <option >Lecturer, Senior Lecturer, Professorial Lecturer</option>
                                <option >Professor Emeritus</option>
                                <option >Visiting Professor</option>
                                <option >Adjunct or affiliate faculty</option>
                                <option >Instructor</option>
                                <option >Assistant Professor</option>
                                <option >Full Professor</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="teachingLoadTeaching" class="block text-sm font-medium text-gray-300">Teaching Load</label>
                            <select id="teachingLoadTeaching" name="teaching_load_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >1.0  - 6.0 units per semester</option>
                                <option >7.0  - 12.0 units per semester</option>
                                <option >13.0 - 18.0 units per semester</option>
                                <option >19.0 - 24.0 units per semester</option>
                                <option >more than 24 units per semester</option>
                                <option >Not known</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="salaryTeaching" class="block text-sm font-medium text-gray-300">Annual Salary</label>
                            <select id="salaryTeaching" name="annual_salary_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>60,000 below</option>
                                <option >60,000 -  69,999</option>
                                <option >70,000 -  79,999</option>
                                <option >80,000 - 89,999</option>
                                <option >90,000 -  99,999</option>
                                <option >100,000 - 149,999</option>
                                <option >150,000 - 249,999</option>
                                <option >250,000 - 499,999</option>
                                <option >500,000 - Above</option>
                            </select>
                        </div>
                    </div>

                    <!-- License and Tenure Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="licenseFaculty" class="block text-sm font-medium text-gray-300">Professional License</label>
                            <select id="licenseFaculty" name="professional_license_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>Licensed</option>
                                <option>Unlicensed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="tenureFaculty" class="block text-sm font-medium text-gray-300">Tenure of Employment</label>
                            <select id="tenureFaculty" name="tenure_of_employment_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >Permanent</option>
                                <option >Probationary</option>
                                <option >Casual</option>
                                <option >Contractual</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                            <label for="highestDegreefaculty" class="block text-sm font-medium text-gray-300">Highest Degree Attained</label>
                            <select id="highestDegreeFaculty" name="highest_degree_attained_code" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            <option >No formal education at all</option>
                                <option >Partial elementary schooling but did not complete Grade 4</option>
                                <option >Completed Grade 4 but did not graduate from elementary school</option>
                                <option >Completed Elementary School</option>
                                <option >Partial completion of High School</option>
                                <option >Secondary school graduate or equivalent</option>
                                <option >Completed Tech/Voch</option>
                                <option >Partial completion of pre-baccalaureate certificate, diploma or associateship</option>
                                <option >Completed pre-bacc certificate, diploma or associateship</option>
                                <option >Completed Year 1 of baccalaureate level or equivalent</option>
                                <option >Completed Year 2 of baccalaureate level or equivalent</option>
                                <option >Completed Year 3 of baccalaureate level or equivalent</option>
                                <option >Completed Year 4 of baccalaureate level or equivalent</option>
                                <option >Completed Year 5 of baccalaureate level or equivalent</option>
                                <option >Completed Year 6 of baccalaureate level or equivalent</option>
                                <option >Completed a baccalaureate degree (including DVM, DDM, D Opt)</option>
                                <option >Partial Completion of postgraduate certificate or diploma program</option>
                                <option >Completed Year 1 of MD or LLB</option>
                                <option >Completed Year 2 of MD or LLB</option>
                                <option >Completed Year 3 of MD or LLB</option>
                                <option >Completed Year 4 of MD or LLB</option>
                                <option >Completed MD or LLB (or equivalent)</option>
                                <option >Partial completion of masters degree</option>
                                <option >Completed all masters requirements except masters thesis</option>                                
                                <option >Completed all doctorate requirements except dissertation</option>
                                <option >Completed masters degree or equivalent</option>
                                <option >Partial completion of doctorate degree</option>
                                <option >Completed doctoratedegree</option>
                            </select>
                    </div>

                    <!-- subss -->
                    <div class="grid grid-cols-2 gap-4 items-center mb-4">
                        <input type="hidden" name="subject_id" id="subjects_id">
                        <div class="mb-4">
                            <label for="subjectsTaughtFaculty" class="block text-sm font-medium text-gray-300">Subjects Taught</label>
                            <input type="text" id="subjectsTaughtFaculty" name="subjects_taught" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="semesterFaculty" class="block text-sm font-medium text-gray-300">Semester</label>
                            <select id="semesterFaculty" name="semester" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option value="First Semester">First Semester</option>
                                <option value="Second Semester">Second Semester</option>
                            </select>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-white mb-4">Educational Credentials Earned</h2>
                    
                    <!-- Bachelor's Degree Section -->
                    <div class="items-center" id="bachelorDegreeFieldsSection">
                        <input type="hidden" name="bachelor_id[]">
                            <div class="mb-4">
                                <label for="bachelorProgramFieldFaculty" class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
                                <input type="text" id="bachelorProgramFieldFaculty" name="bachelors_degree_program_nameTeach[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="bachelorDegreeCodeFieldFaculty" class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
                                <input type="text" id="bachelorDegreeCodeFieldFaculty" name="bachelors_degree_codeTeach[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="bachelorMajorFieldFaculty" class="block text-sm font-medium text-gray-300">Bachelor's Major</label>
                                <input type="text" id="bachelorMajorFieldFaculty" name="bachelors_degree_majorTeach[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="addBachelorDegreeField" class="block text-sm font-medium text-gray-300">Add</label>
                                <button type="button" id="addBachelorDegreeFieldTeach" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    +
                                </button>
                            </div>
                    </div>

                    <!-- Master's Degree Section -->
                    <div class="items-center" id="masterDegreeFieldsSection">
                        <input type="hidden" name="masters_id[]">
                            <div class="mb-4">
                                <label for="masterProgramFieldFaculty" class="block text-sm font-medium text-gray-300">Master's Program</label>
                                <input type="text" id="masterProgramFieldFaculty" name="masters_degree_program_nameTeach[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="masterDegreeCodeFieldFaculty" class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
                                <input type="text" id="masterDegreeCodeFieldFaculty" name="masters_degree_codeTeach[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="masterMajorFieldFaculty" class="block text-sm font-medium text-gray-300">Master's Major</label>
                                <input type="text" id="masterMajorFieldFaculty" name="masters_degree_majorTeach[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="addMasterDegreeField" class="block text-sm font-medium text-gray-300">Add</label>
                                <button type="button" id="addMasterDegreeField" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    +
                                </button>
                            </div>
                    </div>

                    <!-- Doctorate Degree Section -->
                    <div class="items-center" id="doctorateDegreeFieldsSection">
                        <input type="hidden" name="doctorate_id[]">
                            <div class="mb-4">
                                <label for="doctorateProgramFieldFaculty" class="block text-sm font-medium text-gray-300">Doctorate Program</label>
                                <input type="text" id="doctorateProgramFieldFaculty" name="doctorate_program_nameTeach[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="doctorateDegreeCodeFieldFaculty" class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
                                <input type="text" id="doctorateDegreeCodeFieldFaculty" name="doctorate_program_codeTeach[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="doctorateMajorFieldFaculty" class="block text-sm font-medium text-gray-300">Doctorate Major</label>
                                <input type="text" id="doctorateMajorFieldFaculty" name="doctorate_degree_majorTeach[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="addDoctorateDegreeField" class="block text-sm font-medium text-gray-300">Add</label>
                                <button type="button" id="addDoctorateDegreeField" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    +
                                </button>
                            </div>
                    </div>

                    <!-- Buttons -->
                    <div class="!mt-4 flex justify-between items-center">
                        <button type="submit" id="submitEditfacultyBtn" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Faculty</button>
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
                <h2 class="text-xl font-semibold text-white mb-4">Edit None-Teaching Faculty</h2>
                <form id="noneModalFormEdit">
                    <input type="hidden" name="id" id="noneModalFacultyId">

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
                            <label for="noneModalMiddleInitial" class="block text-sm font-medium text-gray-300">Middle Name</label>
                            <input type="text" id="noneModalMiddleInitial" name="middle_initialEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                    </div>

                    <!-- Designation and Employment Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="noneModalDesignation" class="block text-sm font-medium text-gray-300">Designation</label>
                            <input type="text" id="noneModalDesignation" name="designationEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalEmploymentStatus" class="block text-sm font-medium text-gray-300">Employment Status</label>
                            <select id="noneModalEmploymentStatus" name="employment_status_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>Full-time</option>
                                <option>Part-time</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="noneModalGender" class="block text-sm font-medium text-gray-300">Gender</label>
                            <select id="noneModalGender" name="gender_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- License and Tenure Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="noneModalLicense" class="block text-sm font-medium text-gray-300">Professional License</label>
                            <select id="noneModalLicense" name="professional_license_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>Licensed</option>
                                <option>Unlicensed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="noneModalTenure" class="block text-sm font-medium text-gray-300">Tenure of Employment</label>
                            <select id="noneModalTenure" name="tenure_of_employment_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option >Permanent</option>
                                <option >Probationary</option>
                                <option >Casual</option>
                                <option >Contractual</option>
                            </select>
                        </div>
                    </div>

                    <!-- Years of Service and Annual Salary -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label for="noneModalYearsOfService" class="block text-sm font-medium text-gray-300">Years of Service</label>
                            <input type="number" id="noneModalYearsOfService" name="years_of_serviceEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalSalary" class="block text-sm font-medium text-gray-300">Annual Salary</label>
                            <select id="noneModalSalary" name="annual_salary_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                                <option>60,000 below</option>
                                <option >60,000 -  69,999</option>
                                <option >70,000 -  79,999</option>
                                <option >80,000 - 89,999</option>
                                <option >90,000 -  99,999</option>
                                <option >100,000 - 149,999</option>
                                <option >150,000 - 249,999</option>
                                <option >250,000 - 499,999</option>
                                <option >500,000 - Above</option>
                            </select>
                        </div>
                        <div class="mb-4">
                        <label for="noneModalHighestDegree" class="block text-sm font-medium text-gray-300">Highest Degree Attained</label>
                            <select id="noneModalHighestDegree" name="highest_degree_attained_codeEdit" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                            <option >No formal education at all</option>
                                <option >Partial elementary schooling but did not complete Grade 4</option>
                                <option >Completed Grade 4 but did not graduate from elementary school</option>
                                <option >Completed Elementary School</option>
                                <option >Partial completion of High School</option>
                                <option >Secondary school graduate or equivalent</option>
                                <option >Completed Tech/Voch</option>
                                <option >Partial completion of pre-baccalaureate certificate, diploma or associateship</option>
                                <option >Completed pre-bacc certificate, diploma or associateship</option>
                                <option >Completed Year 1 of baccalaureate level or equivalent</option>
                                <option >Completed Year 2 of baccalaureate level or equivalent</option>
                                <option >Completed Year 3 of baccalaureate level or equivalent</option>
                                <option >Completed Year 4 of baccalaureate level or equivalent</option>
                                <option >Completed Year 5 of baccalaureate level or equivalent</option>
                                <option >Completed Year 6 of baccalaureate level or equivalent</option>
                                <option >Completed a baccalaureate degree (including DVM, DDM, D Opt)</option>
                                <option >Partial Completion of postgraduate certificate or diploma program</option>
                                <option >Completed Year 1 of MD or LLB</option>
                                <option >Completed Year 2 of MD or LLB</option>
                                <option >Completed Year 3 of MD or LLB</option>
                                <option >Completed Year 4 of MD or LLB</option>
                                <option >Completed MD or LLB (or equivalent)</option>
                                <option >Partial completion of masters degree</option>
                                <option >Completed all masters requirements except masters thesis</option>                                
                                <option >Completed all doctorate requirements except dissertation</option>
                                <option >Completed masters degree or equivalent</option>
                                <option >Partial completion of doctorate degree</option>
                                <option >Completed doctoratedegree</option>
                            </select>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-white mb-4">Educational Credentials Earned</h2>

                    <!-- Bachelor's Degree Section -->
                    <div class="items-center" id="noneModalBachelorDegreeFields">
                        <input type="hidden" name="nonebachelor_id[]">
                        <div class="mb-4">
                            <label for="noneModalBachelorProgram" class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
                            <input type="text" id="noneModalBachelorProgram" name="bachelors_degree_program_nameEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalBachelorDegreeCode" class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
                            <input type="text" id="noneModalBachelorDegreeCode" name="bachelors_degree_codeEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalBachelorMajor" class="block text-sm font-medium text-gray-300">Bachelor's Major</label>
                            <input type="text" id="noneModalBachelorMajor" name="bachelors_degree_majorEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalAddBachelorDegree" class="block text-sm font-medium text-gray-300">Add </label>
                            <button type="button" id="noneModalAddBachelorDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Master's Degree Section --> 
                    <div class="items-center" id="noneModalMasterDegreeFields">
                        <input type="hidden" name="nonemaster_id[]" >
                        <div class="mb-4">
                            <label for="noneModalMasterProgram" class="block text-sm font-medium text-gray-300">Master's Program</label>
                            <input type="text" id="noneModalMasterProgram" name="masters_degree_program_nameEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalMasterDegreeCode" class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
                            <input type="text" id="noneModalMasterDegreeCode" name="masters_degree_codeEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalMasterMajor" class="block text-sm font-medium text-gray-300">Master's Major</label>
                            <input type="text" id="noneModalMasterMajor" name="masters_degree_majorEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalAddMasterDegree" class="block text-sm font-medium text-gray-300">Add </label>
                            <button type="button" id="noneModalAddMasterDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Doctorate Degree Section for Non-Teaching Faculty -->
                    <div class="items-center" id="noneModalDoctorateDegreeFields">
                        <input type="hidden" name="nonedoctorate_id[]">
                        <div class="mb-4">
                            <label for="noneModalDoctorateProgram" class="block text-sm font-medium text-gray-300">Doctorate Program</label>
                            <input type="text" id="noneModalDoctorateProgram" name="doctorate_degree_program_nameEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalDoctorDegreeCode" class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
                            <input type="text" id="noneModalDoctorDegreeCode" name="doctorate_program_codeEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="noneModalDoctorMajor" class="block text-sm font-medium text-gray-300">Doctorate Major</label>
                            <input type="text" id="noneModalDoctorMajor" name="doctorate_degree_majorEdit[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
                        </div>
                        <div class="mb-4">
                            <label for="nonTeaching_addDoctorateDegree" class="block text-sm font-medium text-gray-300">Add </label>
                            <button type="button" id="nonTeaching_addDoctorateDegree" class="mt-2 p-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="!mt-4 flex justify-between items-center">
                        <button type="submit" id="noneModalSubmitBtn" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Faculty</button>
                        <button type="button" id="noneModalCloseBtn" class="bg-gray-700 text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-600">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

    <script src="assets/script.js"></script>
    <script src="assets/nonteachingdata.js"></script>
    <script src="assets/teachingdata.js"></script>
    <script src="assets/functions.js"></script>
</body>
</html>
