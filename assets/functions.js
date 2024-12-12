document.getElementById('addBachelorDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const bachelorDegreeFields = document.getElementById('bachelorDegreeFields');

    // Create Bachelor's Program input field
    const bachelorProgramDiv = document.createElement('div');
    bachelorProgramDiv.classList.add('mb-4');
    bachelorProgramDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
        <input type="text" name="bachelors_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Bachelor's Degree Code input field
    const bachelorDegreeCodeDiv = document.createElement('div');
    bachelorDegreeCodeDiv.classList.add('mb-4');
    bachelorDegreeCodeDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
        <input type="text" name="bachelors_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Remove button field
    const removeButtonDiv = document.createElement('div');
    removeButtonDiv.classList.add('mb-4');
    removeButtonDiv.innerHTML = `
        <label class="mb-2 block text-sm font-medium text-gray-300">Remove Added Fields</label>
        <button type="button" class="removeDegree bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
            Remove
        </button>
    `;

    // Append the new fields directly to the bachelorDegreeFields grid container
    bachelorDegreeFields.appendChild(bachelorProgramDiv);
    bachelorDegreeFields.appendChild(bachelorDegreeCodeDiv);
    bachelorDegreeFields.appendChild(removeButtonDiv);

    // Add event listener to remove the input fields when the remove button is clicked
    removeButtonDiv.querySelector('.removeDegree').addEventListener('click', function () {
        bachelorDegreeFields.removeChild(bachelorProgramDiv);
        bachelorDegreeFields.removeChild(bachelorDegreeCodeDiv);
        bachelorDegreeFields.removeChild(removeButtonDiv);
    });
});

document.getElementById('addMasterDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const masterDegreeFields = document.getElementById('masterDegreeFields');

    // Create Master's Program input field
    const masterProgramDiv = document.createElement('div');
    masterProgramDiv.classList.add('mb-4');
    masterProgramDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Master's Program</label>
        <input type="text" name="masters_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Master's Degree Code input field
    const masterDegreeCodeDiv = document.createElement('div');
    masterDegreeCodeDiv.classList.add('mb-4');
    masterDegreeCodeDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
        <input type="text" name="masters_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Remove button field
    const removeButtonDiv = document.createElement('div');
    removeButtonDiv.classList.add('mb-4');
    removeButtonDiv.innerHTML = `
        <label class="mb-2 block text-sm font-medium text-gray-300">Remove Added Fields</label>
        <button type="button" class="removeDegree bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
            Remove
        </button>
    `;

    // Append the new fields directly to the masterDegreeFields grid container
    masterDegreeFields.appendChild(masterProgramDiv);
    masterDegreeFields.appendChild(masterDegreeCodeDiv);
    masterDegreeFields.appendChild(removeButtonDiv);

    // Add event listener to remove the input fields when the remove button is clicked
    removeButtonDiv.querySelector('.removeDegree').addEventListener('click', function () {
        masterDegreeFields.removeChild(masterProgramDiv);
        masterDegreeFields.removeChild(masterDegreeCodeDiv);
        masterDegreeFields.removeChild(removeButtonDiv);
    });
});

document.getElementById('addDoctorateDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const doctorateDegreeFields = document.getElementById('doctorateDegreeFields');

    // Create Doctorate Program input field
    const doctorateProgramDiv = document.createElement('div');
    doctorateProgramDiv.classList.add('mb-4');
    doctorateProgramDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Doctorate Program</label>
        <input type="text" name="doctorate_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Doctorate Degree Code input field
    const doctorateDegreeCodeDiv = document.createElement('div');
    doctorateDegreeCodeDiv.classList.add('mb-4');
    doctorateDegreeCodeDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
        <input type="text" name="doctorate_program_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Remove button field
    const removeButtonDiv = document.createElement('div');
    removeButtonDiv.classList.add('mb-4');
    removeButtonDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300 mb-2">Remove Added Fields</label>
        <button type="button" class="removeDegree bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
            Remove
        </button>
    `;

    // Append the new fields directly to the doctorateDegreeFields grid container
    doctorateDegreeFields.appendChild(doctorateProgramDiv);
    doctorateDegreeFields.appendChild(doctorateDegreeCodeDiv);
    doctorateDegreeFields.appendChild(removeButtonDiv);

    // Add event listener to remove the input fields when the remove button is clicked
    removeButtonDiv.querySelector('.removeDegree').addEventListener('click', function () {
        doctorateDegreeFields.removeChild(doctorateProgramDiv);
        doctorateDegreeFields.removeChild(doctorateDegreeCodeDiv);
        doctorateDegreeFields.removeChild(removeButtonDiv);
    });
});

document.getElementById('nonTeaching_addBachelorDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const bachelorDegreeFields = document.getElementById('nonTeaching_bachelorDegreeFields');

    // Create Bachelor's Program input field
    const bachelorProgramDiv = document.createElement('div');
    bachelorProgramDiv.classList.add('mb-4');
    bachelorProgramDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Bachelor's Program</label>
        <input type="text" name="non_teaching_bachelors_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Bachelor's Degree Code input field
    const bachelorDegreeCodeDiv = document.createElement('div');
    bachelorDegreeCodeDiv.classList.add('mb-4');
    bachelorDegreeCodeDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Bachelor's Degree Code</label>
        <input type="text" name="non_teaching_bachelors_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Remove button field
    const removeButtonDiv = document.createElement('div');
    removeButtonDiv.classList.add('mb-4');
    removeButtonDiv.innerHTML = `
        <label class="mb-2 block text-sm font-medium text-gray-300">Remove Added Fields</label>
        <button type="button" class="removeDegree bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
            Remove
        </button>
    `;

    // Append the new fields directly to the bachelorDegreeFields grid container
    bachelorDegreeFields.appendChild(bachelorProgramDiv);
    bachelorDegreeFields.appendChild(bachelorDegreeCodeDiv);
    bachelorDegreeFields.appendChild(removeButtonDiv);

    // Add event listener to remove the input fields when the remove button is clicked
    removeButtonDiv.querySelector('.removeDegree').addEventListener('click', function () {
        bachelorDegreeFields.removeChild(bachelorProgramDiv);
        bachelorDegreeFields.removeChild(bachelorDegreeCodeDiv);
        bachelorDegreeFields.removeChild(removeButtonDiv);
    });
});

document.getElementById('nonTeaching_addMasterDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const masterDegreeFields = document.getElementById('nonTeaching_masterDegreeFields');

    // Create Master's Program input field
    const masterProgramDiv = document.createElement('div');
    masterProgramDiv.classList.add('mb-4');
    masterProgramDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Master's Program</label>
        <input type="text" name="non_teaching_masters_degree_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Master's Degree Code input field
    const masterDegreeCodeDiv = document.createElement('div');
    masterDegreeCodeDiv.classList.add('mb-4');
    masterDegreeCodeDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Master's Degree Code</label>
        <input type="text" name="non_teaching_masters_degree_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Remove button field
    const removeButtonDiv = document.createElement('div');
    removeButtonDiv.classList.add('mb-4');
    removeButtonDiv.innerHTML = `
        <label class="mb-2 block text-sm font-medium text-gray-300">Remove Added Fields</label>
        <button type="button" class="removeDegree bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
            Remove
        </button>
    `;

    // Append the new fields directly to the masterDegreeFields grid container
    masterDegreeFields.appendChild(masterProgramDiv);
    masterDegreeFields.appendChild(masterDegreeCodeDiv);
    masterDegreeFields.appendChild(removeButtonDiv);

    // Add event listener to remove the input fields when the remove button is clicked
    removeButtonDiv.querySelector('.removeDegree').addEventListener('click', function () {
        masterDegreeFields.removeChild(masterProgramDiv);
        masterDegreeFields.removeChild(masterDegreeCodeDiv);
        masterDegreeFields.removeChild(removeButtonDiv);
    });
});

document.getElementById('nonTeaching_addDoctorateDegree').addEventListener('click', function () {
    // Get the container where new degree fields will be added
    const doctorateDegreeFields = document.getElementById('nonTeaching_doctorateDegreeFields');

    // Create Doctorate Program input field
    const doctorateProgramDiv = document.createElement('div');
    doctorateProgramDiv.classList.add('mb-4');
    doctorateProgramDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Doctorate Program</label>
        <input type="text" name="non_teaching_doctorate_program_name[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Doctorate Degree Code input field
    const doctorateDegreeCodeDiv = document.createElement('div');
    doctorateDegreeCodeDiv.classList.add('mb-4');
    doctorateDegreeCodeDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300">Doctorate Degree Code</label>
        <input type="text" name="non_teaching_doctorate_program_code[]" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
    `;

    // Create Remove button field
    const removeButtonDiv = document.createElement('div');
    removeButtonDiv.classList.add('mb-4');
    removeButtonDiv.innerHTML = `
        <label class="block text-sm font-medium text-gray-300 mb-2">Remove Added Fields</label>
        <button type="button" class="removeDegree bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
            Remove
        </button>
    `;

    // Append the new fields directly to the doctorateDegreeFields grid container
    doctorateDegreeFields.appendChild(doctorateProgramDiv);
    doctorateDegreeFields.appendChild(doctorateDegreeCodeDiv);
    doctorateDegreeFields.appendChild(removeButtonDiv);

    // Add event listener to remove the input fields when the remove button is clicked
    removeButtonDiv.querySelector('.removeDegree').addEventListener('click', function () {
        doctorateDegreeFields.removeChild(doctorateProgramDiv);
        doctorateDegreeFields.removeChild(doctorateDegreeCodeDiv);
        doctorateDegreeFields.removeChild(removeButtonDiv);
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





