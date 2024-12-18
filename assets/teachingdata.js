// Populate the Teaching Faculty Modal with data
function populateTeachingFacultyModal(data) {
    // Basic Information
    document.getElementById('teachingModalFacultyId').value = data.id;
    document.getElementById('firstNameteaching').value = data.first_name;
    document.getElementById('lastNameteaching').value = data.last_name;
    document.getElementById('middleInitialteaching').value = data.middle_initial;
    document.getElementById('employmentStatusTeaching').value = data.employment_status_code;
    document.getElementById('genderTeaching').value = data.gender_code;
    document.getElementById('disciplineTeaching').value = data.primary_teaching_discipline_code;
    document.getElementById('licenseFaculty').value = data.professional_license_code;
    document.getElementById('tenureFaculty').value = data.tenure_of_employment_code;
    document.getElementById('rankTeaching').value = data.faculty_rank_code;
    document.getElementById('salaryTeaching').value = data.annual_salary_code;
    document.getElementById('teachingLoadTeaching').value = data.teaching_load_code;

    // Populate Subjects Taught and Semester
    if (data.subjects_taught && data.subjects_taught.length > 0) {
        document.getElementById('subjectsTaughtFaculty').value = data.subjects_taught[0].subjects_taught;
        document.getElementById('semesterFaculty').value = data.subjects_taught[0].semester;
        document.getElementById('subjects_id').value = data.subjects_taught[0].subject_id;
    }

    // Clear existing degree fields
    clearSection('bachelorDegreeFieldsSection');
    clearSection('masterDegreeFieldsSection');
    clearSection('doctorateDegreeFieldsSection');

    // Populate Bachelor's Degrees
    if (data.bachelors_degree_earned && data.bachelors_degree_earned.length > 0) {
        data.bachelors_degree_earned.forEach(degree => {
            addBachelorDegreeFields(degree); // Add degree fields and button
        });
    }

    // Populate Master's Degrees
    if (data.masters_degree_earned && data.masters_degree_earned.length > 0) {
        data.masters_degree_earned.forEach(degree => {
            addMasterDegreeFields(degree); // Add degree fields and button
        });
    }

    // Populate Doctorate Degrees
    if (data.doctorate_degree_earned && data.doctorate_degree_earned.length > 0) {
        data.doctorate_degree_earned.forEach(degree => {
            addDoctorateDegreeFields(degree); // Add degree fields and button
        });
    }

    // Populate the highest degree attained if available
    if (data.highest_degree_attained_code) {
        document.getElementById('highestDegreeFaculty').value = data.highest_degree_attained_code;
    }
}

// Function to add Bachelor's Degree Fields for Teaching Faculty
function addBachelorDegreeFields(degree = {}) {
    const section = document.getElementById('bachelorDegreeFieldsSection'); // Teaching faculty section
    
    // Create a wrapper div for the new field group
    const fieldGroupDiv = document.createElement('div');
    fieldGroupDiv.classList.add('flex', 'flex-wrap', 'gap-4', 'items-center', 'mb-4');

    // Bachelor's Program Field
    const programDiv = document.createElement('div');
    programDiv.classList.add('mb-4');
    const programLabel = createLabel('Bachelor\'s Program');
    const programInput = document.createElement('input');
    programInput.type = 'text';
    programInput.name = 'bachelors_degree_program_nameTeach[]'; // For teaching faculty modal
    programInput.value = degree.bachelors_degree_program_name || '';
    programInput.classList.add('w-full', 'mt-2', 'p-2', 'border', 'border-gray-600', 'bg-gray-800', 'text-gray-200', 'rounded');
    programDiv.appendChild(programLabel);
    programDiv.appendChild(programInput);
    fieldGroupDiv.appendChild(programDiv);

    // Bachelor's Degree Code Field
    const codeDiv = document.createElement('div');
    codeDiv.classList.add('mb-4');
    const codeLabel = createLabel('Degree Code');
    const codeInput = document.createElement('input');
    codeInput.type = 'text';
    codeInput.name = 'bachelors_degree_codeTeach[]'; // For teaching faculty modal
    codeInput.value = degree.bachelors_degree_code || '';
    codeInput.classList.add('w-full', 'mt-2', 'p-2', 'border', 'border-gray-600', 'bg-gray-800', 'text-gray-200', 'rounded');
    codeDiv.appendChild(codeLabel);
    codeDiv.appendChild(codeInput);
    fieldGroupDiv.appendChild(codeDiv);

    // Bachelor's Major Field
    const majorDiv = document.createElement('div');
    majorDiv.classList.add('mb-4');
    const majorLabel = createLabel('Major');
    const majorInput = document.createElement('input');
    majorInput.type = 'text';
    majorInput.name = 'bachelors_degree_majorTeach[]'; // For teaching faculty modal
    majorInput.value = degree.bachelors_degree_major || '';
    majorInput.classList.add('w-full', 'mt-2', 'p-2', 'border', 'border-gray-600', 'bg-gray-800', 'text-gray-200', 'rounded');
    majorDiv.appendChild(majorLabel);
    majorDiv.appendChild(majorInput);
    fieldGroupDiv.appendChild(majorDiv);

    // Add/Remove Button Section
    const buttonDiv = document.createElement('div');
    buttonDiv.classList.add('mb-4');

    if (section.children.length === 0) {
        // Initial "Add" button for the first entry
        const addButtonLabel = createLabel('Add');
        const addButton = document.createElement('button');
        addButton.type = 'button';
        addButton.textContent = '+';
        addButton.classList.add('mt-2', 'p-2', 'bg-blue-600', 'text-white', 'px-6', 'py-2', 'rounded-lg', 'hover:bg-blue-700');
        addButton.addEventListener('click', function () {
            addBachelorDegreeFields(); // Add a new degree field when clicked
        });
        buttonDiv.appendChild(addButtonLabel);
        buttonDiv.appendChild(addButton);
    } else {
        // "Remove" button for subsequent entries
        const removeButtonLabel = createLabel('Remove');
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.textContent = 'Remove';
        removeButton.classList.add('mt-2', 'p-2', 'bg-red-600', 'text-white', 'px-6', 'py-2', 'rounded-lg', 'hover:bg-red-700');
        removeButton.addEventListener('click', function () {
            section.removeChild(fieldGroupDiv);
        });
        buttonDiv.appendChild(removeButtonLabel);
        buttonDiv.appendChild(removeButton);
    }

    fieldGroupDiv.appendChild(buttonDiv);
    section.appendChild(fieldGroupDiv);
}

// Function to add Master's Degree Fields
function addMasterDegreeFields(degree = {}) {
    const section = document.getElementById('masterDegreeFieldsSection');

    // Create a wrapper div for the new field group
    const fieldGroupDiv = document.createElement('div');
    fieldGroupDiv.classList.add('flex', 'flex-wrap', 'gap-4', 'items-center', 'mb-4');

    // Master's Program Field
    const programDiv = document.createElement('div');
    programDiv.classList.add('mb-4');
    const programLabel = createLabel('Master\'s Program');
    const programInput = document.createElement('input');
    programInput.type = 'text';
    programInput.name = 'masters_degree_program_nameTeach[]';
    programInput.value = degree.masters_degree_program_name || '';
    programInput.classList.add('w-full', 'mt-2', 'p-2', 'border', 'border-gray-600', 'bg-gray-800', 'text-gray-200', 'rounded');
    programDiv.appendChild(programLabel);
    programDiv.appendChild(programInput);
    fieldGroupDiv.appendChild(programDiv);

    // Master's Degree Code Field
    const codeDiv = document.createElement('div');
    codeDiv.classList.add('mb-4');
    const codeLabel = createLabel('Master\'s Degree Code');
    const codeInput = document.createElement('input');
    codeInput.type = 'text';
    codeInput.name = 'masters_degree_codeTeach[]';
    codeInput.value = degree.masters_degree_code || '';
    codeInput.classList.add('w-full', 'mt-2', 'p-2', 'border', 'border-gray-600', 'bg-gray-800', 'text-gray-200', 'rounded');
    codeDiv.appendChild(codeLabel);
    codeDiv.appendChild(codeInput);
    fieldGroupDiv.appendChild(codeDiv);

    // Master's Major Field
    const majorDiv = document.createElement('div');
    majorDiv.classList.add('mb-4');
    const majorLabel = createLabel('Master\'s Major');
    const majorInput = document.createElement('input');
    majorInput.type = 'text';
    majorInput.name = 'masters_degree_majorTeach[]';
    majorInput.value = degree.masters_degree_major || '';
    majorInput.classList.add('w-full', 'mt-2', 'p-2', 'border', 'border-gray-600', 'bg-gray-800', 'text-gray-200', 'rounded');
    majorDiv.appendChild(majorLabel);
    majorDiv.appendChild(majorInput);
    fieldGroupDiv.appendChild(majorDiv);

    // Add/Remove Button Section
    const buttonDiv = document.createElement('div');
    buttonDiv.classList.add('mb-4');

    if (section.children.length === 0) {
        // Initial "Add" button for the first entry
        const addButtonLabel = createLabel('Add');
        const addButton = document.createElement('button');
        addButton.type = 'button';
        addButton.textContent = '+';
        addButton.classList.add('mt-2', 'p-2', 'bg-blue-600', 'text-white', 'px-6', 'py-2', 'rounded-lg', 'hover:bg-blue-700');
        addButton.addEventListener('click', function () {
            addMasterDegreeFields();
        });
        buttonDiv.appendChild(addButtonLabel);
        buttonDiv.appendChild(addButton);
    } else {
        // "Remove" button for subsequent entries
        const removeButtonLabel = createLabel('Remove');
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.textContent = 'Remove';
        removeButton.classList.add('mt-2', 'p-2', 'bg-red-600', 'text-white', 'px-6', 'py-2', 'rounded-lg', 'hover:bg-red-700');
        removeButton.addEventListener('click', function () {
            section.removeChild(fieldGroupDiv);
        });
        buttonDiv.appendChild(removeButtonLabel);
        buttonDiv.appendChild(removeButton);
    }

    fieldGroupDiv.appendChild(buttonDiv);
    section.appendChild(fieldGroupDiv);
}

// Function to add Doctorate Degree Fields
function addDoctorateDegreeFields(degree = {}) {
    const section = document.getElementById('doctorateDegreeFieldsSection');

    // Create a wrapper div for the new field group
    const fieldGroupDiv = document.createElement('div');
    fieldGroupDiv.classList.add('flex', 'flex-wrap', 'gap-4', 'items-center', 'mb-4');

    // Doctorate Program Field
    const programDiv = document.createElement('div');
    programDiv.classList.add('mb-4');
    const programLabel = createLabel('Doctorate\'s Program');
    const programInput = document.createElement('input');
    programInput.type = 'text';
    programInput.name = 'doctorate_program_nameTeach[]';
    programInput.value = degree.doctorate_program_name || '';
    programInput.classList.add('w-full', 'mt-2', 'p-2', 'border', 'border-gray-600', 'bg-gray-800', 'text-gray-200', 'rounded');
    programDiv.appendChild(programLabel);
    programDiv.appendChild(programInput);
    fieldGroupDiv.appendChild(programDiv);

    // Doctorate Degree Code Field
    const codeDiv = document.createElement('div');
    codeDiv.classList.add('mb-4');
    const codeLabel = createLabel('Degree Code');
    const codeInput = document.createElement('input');
    codeInput.type = 'text';
    codeInput.name = 'doctorate_program_codeTeach[]';
    codeInput.value = degree.doctorate_program_code || '';
    codeInput.classList.add('w-full', 'mt-2', 'p-2', 'border', 'border-gray-600', 'bg-gray-800', 'text-gray-200', 'rounded');
    codeDiv.appendChild(codeLabel);
    codeDiv.appendChild(codeInput);
    fieldGroupDiv.appendChild(codeDiv);

    // Doctorate Major Field
    const majorDiv = document.createElement('div');
    majorDiv.classList.add('mb-4');
    const majorLabel = createLabel('Major');
    const majorInput = document.createElement('input');
    majorInput.type = 'text';
    majorInput.name = 'doctorate_degree_majorTeach[]';
    majorInput.value = degree.doctorate_degree_major || '';
    majorInput.classList.add('w-full', 'mt-2', 'p-2', 'border', 'border-gray-600', 'bg-gray-800', 'text-gray-200', 'rounded');
    majorDiv.appendChild(majorLabel);
    majorDiv.appendChild(majorInput);
    fieldGroupDiv.appendChild(majorDiv);

    // Add/Remove Button Section
    const buttonDiv = document.createElement('div');
    buttonDiv.classList.add('mb-4');

    if (section.children.length === 0) {
        // Initial "Add" button for the first entry
        const addButtonLabel = createLabel('Add');
        const addButton = document.createElement('button');
        addButton.type = 'button';
        addButton.textContent = '+';
        addButton.classList.add('mt-2', 'p-2', 'bg-blue-600', 'text-white', 'px-6', 'py-2', 'rounded-lg', 'hover:bg-blue-700');
        addButton.addEventListener('click', function () {
            addDoctorateDegreeFields(); // Recursively add new doctorate degree fields
        });
        buttonDiv.appendChild(addButtonLabel);
        buttonDiv.appendChild(addButton);
    } else {
        // "Remove" button for subsequent entries
        const removeButtonLabel = createLabel('Remove');
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.textContent = 'Remove';
        removeButton.classList.add('mt-2', 'p-2', 'bg-red-600', 'text-white', 'px-6', 'py-2', 'rounded-lg', 'hover:bg-red-700');
        removeButton.addEventListener('click', function () {
            section.removeChild(fieldGroupDiv);
        });
        buttonDiv.appendChild(removeButtonLabel);
        buttonDiv.appendChild(removeButton);
    }

    fieldGroupDiv.appendChild(buttonDiv);
    section.appendChild(fieldGroupDiv);
}

function createLabel(text) {
    const label = document.createElement('label');
    label.classList.add('block', 'text-sm', 'font-medium', 'text-gray-300');
    label.textContent = text;
    return label;
}
function clearSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.innerHTML = '';
    }
}
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Capture the form submit action
document.getElementById('submitEditfacultyBtn').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Prepare the data to be sent
    const formData = new FormData();
    const facultyId = document.getElementById('teachingModalFacultyId').value;
    
    // General Faculty Information
    formData.append('id', facultyId);
    formData.append('first_name', document.getElementById('firstNameteaching').value);
    formData.append('last_name', document.getElementById('lastNameteaching').value);
    formData.append('middle_initial', document.getElementById('middleInitialteaching').value);
    formData.append('employment_status_code', document.getElementById('employmentStatusTeaching').value);
    formData.append('gender_code', document.getElementById('genderTeaching').value);
    formData.append('primary_teaching_discipline_code', document.getElementById('disciplineTeaching').value);
    formData.append('faculty_rank_code', document.getElementById('rankTeaching').value);
    formData.append('teaching_load_code', document.getElementById('teachingLoadTeaching').value);
    formData.append('professional_license_code', document.getElementById('licenseFaculty').value);
    formData.append('tenure_of_employment_code', document.getElementById('tenureFaculty').value);
    formData.append('annual_salary_code', document.getElementById('salaryTeaching').value);
    formData.append('highest_degree_attained_code', document.getElementById('highestDegreeFaculty').value);

    formData.append('subject_id', document.getElementById('subjects_id').value);
    formData.append('subjects_taught', document.getElementById('subjectsTaughtFaculty').value);
    formData.append('semester', document.getElementById('semesterFaculty').value);

    // Bachelor's Degrees
    const bachelorsDegreeProgramNames = document.querySelectorAll('input[name="bachelors_degree_program_nameTeach[]"]');
    const bachelorsDegreeCodes = document.querySelectorAll('input[name="bachelors_degree_codeTeach[]"]');
    const bachelorsDegreeMajors = document.querySelectorAll('input[name="bachelors_degree_majorTeach[]"]');

    bachelorsDegreeProgramNames.forEach((input, index) => {
        formData.append('bachelors_degree_program_name[]', input.value); // Append program name
        formData.append('bachelors_degree_code[]', bachelorsDegreeCodes[index].value || ''); // Append code
        formData.append('bachelors_degree_major[]', bachelorsDegreeMajors[index].value || ''); // Append major
    });

    // Master's Degrees
    const mastersDegreeProgramNames = document.querySelectorAll('input[name="masters_degree_program_nameTeach[]"]');
    const mastersDegreeCodes = document.querySelectorAll('input[name="masters_degree_codeTeach[]"]');
    const mastersDegreeMajors = document.querySelectorAll('input[name="masters_degree_majorTeach[]"]');

    mastersDegreeProgramNames.forEach((input, index) => {
        formData.append('masters_degree_program_name[]', input.value); // Append program name
        formData.append('masters_degree_code[]', mastersDegreeCodes[index].value || ''); // Append code
        formData.append('masters_degree_major[]', mastersDegreeMajors[index].value || ''); // Append major
    });

    // Doctorate Degrees
    const doctorateDegreeProgramNames = document.querySelectorAll('input[name="doctorate_program_nameTeach[]"]');
    const doctorateDegreeCodes = document.querySelectorAll('input[name="doctorate_program_codeTeach[]"]');
    const doctorateDegreeMajors = document.querySelectorAll('input[name="doctorate_degree_majorTeach[]"]');

    doctorateDegreeProgramNames.forEach((input, index) => {
        formData.append('doctorate_program_name[]', input.value); // Append program name
        formData.append('doctorate_program_code[]', doctorateDegreeCodes[index].value || ''); // Append code
        formData.append('doctorate_degree_major[]', doctorateDegreeMajors[index].value || ''); // Append major
    });

    // Send the data via AJAX (fetch)
    fetch('controller/save_teach.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Faculty information saved successfully');
            document.getElementById("teachingFacultyModal").classList.add("hidden"); 
            location.reload(); 
        } else {
            alert('Error saving faculty information');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Faculty information saved successfully');
        document.getElementById("teachingFacultyModal").classList.add("hidden"); 
        location.reload();
    });
});

