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

// Populate the Teaching Faculty Modal with data
function populateTeachingFacultyModal(data) {
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
    document.getElementById('subjectsTaughtFaculty').value = data.subjects_taught;
    document.getElementById('licenseFaculty').value = data.professional_license_code;

    // Populate the educational credentials if available
    if (data.educational_credentials) {
        document.getElementById('highestDegreeFaculty').value = data.educational_credentials.highest_degree_attained_code;
        document.getElementById('bachelorProgramFieldFaculty').value = data.educational_credentials.bachelors_degree_program_name;
        document.getElementById('bachelorDegreeCodeFieldFaculty').value = data.educational_credentials.bachelors_degree_code;
        document.getElementById('masterProgramFieldFaculty').value = data.educational_credentials.masters_degree_program_name;
        document.getElementById('masterDegreeCodeFieldFaculty').value = data.educational_credentials.masters_degree_code;
        document.getElementById('doctorateProgramFieldFaculty').value = data.educational_credentials.doctorate_program_name;
        document.getElementById('doctorateDegreeCodeFieldFaculty').value = data.educational_credentials.doctorate_program_code;
    }
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
    if (data.educational_credentials) {
        document.getElementById('noneModalHighestDegree').value = data.educational_credentials.highest_degree_attained_code;
        document.getElementById('noneModalBachelorProgram').value = data.educational_credentials.bachelors_degree_program_name;
        document.getElementById('noneModalBachelorDegreeCode').value = data.educational_credentials.bachelors_degree_code;
        document.getElementById('noneModalMasterProgram').value = data.educational_credentials.masters_degree_program_name;
        document.getElementById('noneModalMasterDegreeCode').value = data.educational_credentials.masters_degree_code;
        document.getElementById('noneModalDoctorateProgram').value = data.educational_credentials.doctorate_program_name;
        document.getElementById('noneModalDoctorateDegreeCode').value = data.educational_credentials.doctorate_program_code;
    }
}



