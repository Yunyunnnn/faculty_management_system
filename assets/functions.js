document.getElementById('addBachelorDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const bachelorDegreeFields = document.getElementById('bachelorDegreeFields');

    // Create a new div for the duplicated fields
    const newDegreeDiv = document.createElement('div');
    newDegreeDiv.classList.add('flex', 'flex-wrap', 'gap-4', 'items-center', 'mb-4');

    // Add the same structure for Bachelor's Program
    newDegreeDiv.innerHTML = `
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
            <input type="text" name="bachelors_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
            <input type="text" name="bachelors_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Bachelor's Major</label>
            <input type="text" name="bachelors_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-none">
            <label class="block text-sm font-medium text-gray-300">Remove</label>
            <button type="button" class="removeDegree mt-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Remove
            </button>
        </div>
    `;

    // Append the duplicated div to the container
    bachelorDegreeFields.appendChild(newDegreeDiv);

    // Add event listener to remove the new div when the remove button is clicked
    newDegreeDiv.querySelector('.removeDegree').addEventListener('click', function () {
        bachelorDegreeFields.removeChild(newDegreeDiv);
    });
});

document.getElementById('addMasterDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const masterDegreeFields = document.getElementById('masterDegreeFields');

    // Create a new div for the duplicated fields
    const newMasterDiv = document.createElement('div');
    newMasterDiv.classList.add('flex', 'flex-wrap', 'gap-4', 'items-center', 'mb-4');

    // Add the same structure for Master's Program
    newMasterDiv.innerHTML = `
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Master's Program</label>
            <input type="text" name="masters_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
            <input type="text" name="masters_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Master's Major</label>
            <input type="text" name="masters_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-none">
            <label class="block text-sm font-medium text-gray-300">Remove</label>
            <button type="button" class="removeDegree mt-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Remove
            </button>
        </div>
    `;

    // Append the duplicated div to the container
    masterDegreeFields.appendChild(newMasterDiv);

    // Add event listener to remove the new div when the remove button is clicked
    newMasterDiv.querySelector('.removeDegree').addEventListener('click', function () {
        masterDegreeFields.removeChild(newMasterDiv);
    });
});

document.getElementById('addDoctorateDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const doctorateDegreeFields = document.getElementById('doctorateDegreeFields');

    // Create a new div for the duplicated fields
    const newDoctorateDiv = document.createElement('div');
    newDoctorateDiv.classList.add('flex', 'flex-wrap', 'gap-4', 'items-center', 'mb-4');

    // Add the same structure for Doctorate Program
    newDoctorateDiv.innerHTML = `
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Doctorate Program</label>
            <input type="text" name="doctorate_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
            <input type="text" name="doctorate_program_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Doctorate Major</label>
            <input type="text" name="doctorate_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-none">
            <label class="block text-sm font-medium text-gray-300">Remove</label>
            <button type="button" class="removeDegree mt-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Remove
            </button>
        </div>
    `;

    // Append the duplicated div to the container
    doctorateDegreeFields.appendChild(newDoctorateDiv);

    // Add event listener to remove the new div when the remove button is clicked
    newDoctorateDiv.querySelector('.removeDegree').addEventListener('click', function () {
        doctorateDegreeFields.removeChild(newDoctorateDiv);
    });
});

document.getElementById('nonTeaching_addBachelorDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const bachelorDegreeFields = document.getElementById('nonTeaching_bachelorDegreeFields');

    // Create a new div for the duplicated fields
    const newBachelorDiv = document.createElement('div');
    newBachelorDiv.classList.add('flex', 'flex-wrap', 'gap-4', 'items-center', 'mb-4');

    // Add the same structure for Bachelor's Program
    newBachelorDiv.innerHTML = `
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
            <input type="text" name="non_teaching_bachelors_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
            <input type="text" name="non_teaching_bachelors_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Bachelor's Major</label>
            <input type="text" name="non_teaching_bachelors_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-none">
            <label class="block text-sm font-medium text-gray-300">Remove</label>
            <button type="button" class="removeDegree mt-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Remove
            </button>
        </div>
    `;

    // Append the duplicated div to the container
    bachelorDegreeFields.appendChild(newBachelorDiv);

    // Add event listener to remove the new div when the remove button is clicked
    newBachelorDiv.querySelector('.removeDegree').addEventListener('click', function () {
        bachelorDegreeFields.removeChild(newBachelorDiv);
    });
});

document.getElementById('nonTeaching_addMasterDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const masterDegreeFields = document.getElementById('nonTeaching_MasterDegreeFields');

    // Create a new div for the duplicated fields
    const newMasterDiv = document.createElement('div');
    newMasterDiv.classList.add('flex', 'flex-wrap', 'gap-4', 'items-center', 'mb-4');

    // Add the same structure for Master's Program
    newMasterDiv.innerHTML = `
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Master's Program</label>
            <input type="text" name="non_teaching_masters_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
            <input type="text" name="non_teaching_masters_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Master's Major</label>
            <input type="text" name="non_teaching_masters_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-none">
            <label class="block text-sm font-medium text-gray-300">Remove</label>
            <button type="button" class="removeDegree mt-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Remove
            </button>
        </div>
    `;

    // Append the duplicated div to the container
    masterDegreeFields.appendChild(newMasterDiv);

    // Add event listener to remove the new div when the remove button is clicked
    newMasterDiv.querySelector('.removeDegree').addEventListener('click', function () {
        masterDegreeFields.removeChild(newMasterDiv);
    });
});

document.getElementById('nonTeaching_addDoctorateDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const doctorateDegreeFields = document.getElementById('nonTeaching_doctorateDegreeFields');

    // Create a new div for the duplicated fields
    const newDoctorateDiv = document.createElement('div');
    newDoctorateDiv.classList.add('flex', 'flex-wrap', 'gap-4', 'items-center', 'mb-4');

    // Add the same structure for Doctorate Program
    newDoctorateDiv.innerHTML = `
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Doctorate Program</label>
            <input type="text" name="non_teaching_doctorate_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
            <input type="text" name="non_teaching_doctorate_program_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Doctorate Major</label>
            <input type="text" name="non_teaching_doctorate_degree_major[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="flex-none">
            <label class="block text-sm font-medium text-gray-300">Remove</label>
            <button type="button" class="removeDegree mt-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Remove
            </button>
        </div>
    `;

    // Append the duplicated div to the container
    doctorateDegreeFields.appendChild(newDoctorateDiv);

    // Add event listener to remove the new div when the remove button is clicked
    newDoctorateDiv.querySelector('.removeDegree').addEventListener('click', function () {
        doctorateDegreeFields.removeChild(newDoctorateDiv);
    });
});

function deleteFaculty(facultyId) {
    if (!confirm("Are you sure you want to delete this faculty member?")) return;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "controller/delete_faculty.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert(response.message);
                    document.getElementById("faculty-row-" + facultyId).remove();
                } else {
                    alert(response.message);
                }
            } catch (e) {
                console.error("Invalid JSON response:", xhr.responseText);
                alert("An unexpected error occurred.");
            }
        } else {
            alert("Request failed. Status: " + xhr.status);
        }
    };

    xhr.onerror = function () {
        alert("Request failed due to a network error.");
    };

    xhr.send("faculty_id=" + facultyId);
}

//for search bar
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const facultyTypeFilter = document.getElementById("facultyTypeFilter");
    const employmentStatusFilter = document.getElementById("employmentStatusFilter");
    const facultyTableBody = document.getElementById("facultyTableBody");

    // Function to fetch and display data
    function fetchFacultyData() {
        const searchTerm = searchInput.value;
        const facultyType = facultyTypeFilter.value;
        const employmentStatus = employmentStatusFilter.value;

        // Build the query string for the request
        const queryString = `controller/search.php?search=${encodeURIComponent(searchTerm)}&faculty_type=${encodeURIComponent(facultyType)}&employment_status_code=${encodeURIComponent(employmentStatus)}`;

        // Fetch data from the backend
        fetch(queryString)
            .then(response => response.json())
            .then(data => {
                // Clear the table body
                facultyTableBody.innerHTML = "";

                // Populate the table with the new data
                if (data.length > 0) {
                    data.forEach(row => {
                        facultyTableBody.innerHTML += `
                            <tr id='faculty-row-${row.id}'>
                                <td class='py-3 px-4'>${row.first_name}</td>
                                <td class='py-3 px-4'>${row.middle_initial}</td>
                                <td class='py-3 px-4'>${row.last_name}</td>
                                <td class='py-3 px-4'>${row.gender_code}</td>
                                <td class='py-3 px-4'>${row.faculty_type}</td>
                                <td class='py-3 px-4'>${row.employment_status_code}</td>
                                <td class='py-3 px-4'>
                                    <button class='text-blue-500 mr-2' onclick="editFaculty(${row.id}, '${row.faculty_type}')">Edit</button>
                                    <button class='text-red-500 mr-2' onclick="deleteFaculty(${row.id})">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    facultyTableBody.innerHTML = "<tr><td colspan='7' class='text-center py-3 px-4'>No faculty records found.</td></tr>";
                }
            })
            .catch(error => {
                console.error("Error fetching data:", error);
            });
    }

    // Add event listeners for dynamic search and filtering
    searchInput.addEventListener("input", fetchFacultyData);
    facultyTypeFilter.addEventListener("change", fetchFacultyData);
    employmentStatusFilter.addEventListener("change", fetchFacultyData);

    // Initial fetch on page load
    fetchFacultyData();
});

//header data
function fetchFacultyData() {
    fetch('/faculty_management_system/controller/header_data.php')
        .then(response => response.json())
        .then(data => {
            // Update the HTML with the dynamic data
            document.getElementById('nonTeachingCount').textContent = data.nonTeachingCount;
            document.getElementById('teachingCount').textContent = data.teachingCount;
            document.getElementById('partTimeCount').textContent = data.partTimeCount;
            document.getElementById('fullTimeCount').textContent = data.fullTimeCount;
        })
        .catch(error => {
            console.error('Error fetching faculty data:', error);
        });
}
window.onload = fetchFacultyData;

//page reload
document.getElementById('refreshButton').addEventListener('click', function () {
    window.location.reload();
});





