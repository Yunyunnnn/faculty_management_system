const modal = document.getElementById('facultyModal');
const openModalBtn = document.getElementById('openModalBtn');
const closeModalBtn = document.getElementById('closeModalBtn');

// Open modal when the button is clicked
openModalBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
});

// Close modal when the close button is clicked
closeModalBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
});

// Handle form submission
document.getElementById("facultyForm").addEventListener("submit", function (e) {
    e.preventDefault(); 

    // Collect the form data
    const formData = new FormData(this);

    // Send the form data to PHP via AJAX
    fetch('controller/save_faculty.php', {
        method: 'POST',  // Ensure this is POST
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Faculty added successfully!');
            document.getElementById("facultyForm").reset();  // Reset the form
            document.getElementById("facultyModal").classList.add("hidden");  // Close modal
        } else {
            alert('Error adding faculty!!!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding faculty!' );
    });
});

const modalF = document.getElementById('nonTeachingFacultyModal');
const openModalBtnF = document.getElementById('openNonTeachingModalBtn');
const closeModalBtnF = document.getElementById('closeNonTeachingModalBtn');

// Open modal when the button is clicked
openModalBtnF.addEventListener('click', () => {
    modalF.classList.remove('hidden');
});

// Close modal when the close button is clicked
closeModalBtnF.addEventListener('click', () => {
    modalF.classList.add('hidden');
});

// Handle form submission
document.getElementById("nonTeachingFacultyForm").addEventListener("submit", function (e) {
    e.preventDefault();  // Prevent default form submission

    // Collect the form data
    const formData = new FormData(this);

    // Send the form data to PHP via AJAX
    fetch('controller/save_teaching.php', {
        method: 'POST',  // Ensure this is POST
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Faculty added successfully!');
            document.getElementById("nonTeachingFacultyForm").reset();  // Reset the form
            document.getElementById("nonTeachingFacultyModal").classList.add("hidden");  // Close modal
        } else {
            alert('Error adding faculty!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding faculty!');
    });
});


// Get references to both modals and close buttons
const modalTeach = document.getElementById('teachingFacultyModal');
const modalNone = document.getElementById('noneModal');
const closeModalBtnTeach = document.getElementById('closeEditfacultyBtn');  // Make sure this is the correct button ID
const closeModalBtnNone = document.getElementById('noneModalCloseBtn');  // Make sure this is the correct button ID

// Close buttons event listeners
closeModalBtnTeach.addEventListener('click', () => {
    modalTeach.classList.add('hidden');  // Close the Teaching Faculty Modal
    console.log("Closing Teaching Faculty Modal");  // Debugging statement
});

closeModalBtnNone.addEventListener('click', () => {
    modalNone.classList.add('hidden');  // Close the Non-Teaching Faculty Modal
    console.log("Closing Non-Teaching Faculty Modal");  // Debugging statement
});

// Function to open the correct modal based on faculty type
function editFaculty(facultyId, facultyType) {
    console.log("Editing faculty:", facultyId, facultyType);  

    let url = `/faculty_management_system/controller/get_faculty_data.php?id=${facultyId}&type=${encodeURIComponent(facultyType)}`;

    // Open the appropriate modal
    if (facultyType === 'Teaching Faculty') {
        modalTeach.classList.remove('hidden');
        console.log("Opening Teaching Faculty Modal"); 
    } else if (facultyType === 'Non-Teaching Faculty') {
        modalNone.classList.remove('hidden');
        console.log("Opening Non-Teaching Faculty Modal");  
    } else {
        console.log("Unknown faculty type:", facultyType);  
        return;
    }

    // Fetch data from the backend
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log("Fetched data:", data);
            if (facultyType === 'Teaching Faculty') {
                populateTeachingFacultyModal(data);
            } else if (facultyType === 'Non-Teaching Faculty') {
                populateNonTeachingFacultyModal(data);
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// Function to clear a section before populating it with new data
function clearSection(sectionId) {
    const section = document.getElementById(sectionId);
    while (section.children.length > 1) {
        section.removeChild(section.lastChild);
    }
}

// Populate the Teaching Faculty Modal with data
function populateTeachingFacultyModal(data) {
    // Basic Information
    document.getElementById('firstNameteaching').value = data.first_name;
    document.getElementById('lastNameteaching').value = data.last_name;
    document.getElementById('middleInitialteaching').value = data.middle_initial;
    document.getElementById('employmentStatusTeaching').value = data.employment_status_code;
    document.getElementById('genderTeaching').value = data.gender_code;
    document.getElementById('disciplineTeaching').value = data.primary_teaching_discipline_code;
    document.getElementById('tenureFaculty').value = data.tenure_of_employment_code;
    document.getElementById('licenseFaculty').value = data.professional_license_code;
    document.getElementById('rankTeaching').value = data.faculty_rank_code;
    document.getElementById('teachingLoadTeaching').value = data.teaching_load_code;

    // Populate Subjects Taught and Semester
    if (data.subjects_taught && data.subjects_taught.length > 0) {
        document.getElementById('subjectsTaughtFaculty').value = data.subjects_taught[0].subjects_taught;
        document.getElementById('semesterFaculty').value = data.subjects_taught[0].semester;
    }

    // Clear existing degree fields
    clearSection('bachelorDegreeFieldsSection');
    clearSection('masterDegreeFieldsSection');
    clearSection('doctorateDegreeFieldsSection');

    // Populate Bachelor's Degrees
    if (data.bachelors_degrees && data.bachelors_degrees.length > 0) {
        data.bachelors_degrees.forEach(degree => {
            addBachelorDegreeFields(degree);
        });
    }

    // Populate Master's Degrees
    if (data.masters_degrees && data.masters_degrees.length > 0) {
        data.masters_degrees.forEach(degree => {
            addMasterDegreeFields(degree);
        });
    }

    // Populate Doctorate Degrees
    if (data.doctorate_degrees && data.doctorate_degrees.length > 0) {
        data.doctorate_degrees.forEach(degree => {
            addDoctorateDegreeFields(degree);
        });
    }

    // Populate the highest degree attained if available
    if (data.highest_degree_attained_code) {
        document.getElementById('highestDegreeFaculty').value = data.highest_degree_attained_code;
    }
}

// Function to add Bachelor's Degree Fields
function addBachelorDegreeFields(degree) {
    const section = document.getElementById('bachelorDegreeFieldsSection');
    const fieldset = createDegreeFieldset('bachelors', degree.bachelors_degree_program_name, degree.bachelors_degree_code, degree.bachelors_degree_major);
    section.appendChild(fieldset);
}

// Function to add Master's Degree Fields
function addMasterDegreeFields(degree) {
    const section = document.getElementById('masterDegreeFieldsSection');
    const fieldset = createDegreeFieldset('masters', degree.masters_degree_program_name, degree.masters_degree_code, degree.masters_degree_major);
    section.appendChild(fieldset);
}

// Function to add Doctorate Degree Fields
function addDoctorateDegreeFields(degree) {
    const section = document.getElementById('doctorateDegreeFieldsSection');
    const fieldset = createDegreeFieldset('doctorate', degree.doctorate_program_name, degree.doctorate_program_code, degree.doctorate_degree_major);
    section.appendChild(fieldset);
}

// Helper function to create a degree fieldset dynamically
function createDegreeFieldset(type, programName, degreeCode, major) {
    const wrapper = document.createElement('div');
    wrapper.className = 'flex flex-wrap gap-4 items-center mb-4';

    wrapper.innerHTML = `
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300">${capitalizeFirstLetter(type)} Program</label>
            <input type="text" name="${type}_degree_program_name[]" value="${programName}" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300">${capitalizeFirstLetter(type)} Degree Code</label>
            <input type="text" name="${type}_degree_code[]" value="${degreeCode}" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300">${capitalizeFirstLetter(type)} Major</label>
            <input type="text" name="${type}_degree_major[]" value="${major}" class="w-full mt-2 p-2 border border-gray-600 bg-gray-800 text-gray-200 rounded">
        </div>
    `;

    return wrapper;
}

// Helper function to capitalize the first letter of a string
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// Populate the Non-Teaching Faculty Modal with data
function populateNonTeachingFacultyModal(data) {
    document.getElementById('noneModalFirstName').value = data.first_name;
    document.getElementById('noneModalLastName').value = data.last_name;
    document.getElementById('noneModalMiddleInitial').value = data.middle_initial;
    document.getElementById('noneModalDesignation').value = data.designation;
    document.getElementById('noneModalEmploymentStatus').value = data.employment_status_code;
    document.getElementById('noneModalGender').value = data.gender_code;
    document.getElementById('noneModalLicense').value = data.professional_license_code;
    document.getElementById('noneModalTenure').value = data.tenure_of_employment_code;
    document.getElementById('noneModalYearsOfService').value = data.years_of_service;
    document.getElementById('noneModalSalary').value = data.annual_salary_code;

    // Populate the educational credentials if available
    if (data.bachelors_degree_earned && data.bachelors_degree_earned.length > 0) {
        document.getElementById('noneModalBachelorProgram').value = data.bachelors_degree_earned[0].bachelors_degree_program_name;
        document.getElementById('noneModalBachelorDegreeCode').value = data.bachelors_degree_earned[0].bachelors_degree_code;
        document.getElementById('noneModalBachelorMajor').value = data.bachelors_degree_earned[0].bachelors_degree_major;
    }

    if (data.masters_degree_earned && data.masters_degree_earned.length > 0) {
        document.getElementById('noneModalMasterProgram').value = data.masters_degree_earned[0].masters_degree_program_name;
        document.getElementById('noneModalMasterDegreeCode').value = data.masters_degree_earned[0].masters_degree_code;
        document.getElementById('noneModalMasterMajor').value = data.masters_degree_earned[0].masters_degree_major;
    }

    if (data.doctorate_degree_earned && data.doctorate_degree_earned.length > 0) {
        document.getElementById('noneModalDoctorateProgram').value = data.doctorate_degree_earned[0].doctorate_program_name;
        document.getElementById('noenModalDoctorDegreeCode').value = data.doctorate_degree_earned[0].doctorate_program_code;
        document.getElementById('noneTeachingDoctorMajor').value = data.doctorate_degree_earned[0].doctorate_degree_major;
    }

    // Populate the highest degree attained if available
    if (data.highest_degree_attained_code) {
        document.getElementById('noneModalHighestDegree').value = data.highest_degree_attained_code;
    }

    console.log(data.doctorate_degree_earned);  // Check this in the browser console


}




