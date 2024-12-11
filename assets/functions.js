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





