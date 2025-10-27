




//======== Cookie Handle ================

// Function to set cookies
function setCookie(name, value, days) {
    let date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    let expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// Function to get cookie value by name
function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null; // Return null if the cookie is not found
}

// Function to populate form fields with cookie values
function populateFormFields() {
    const clientName = getCookie('client_name');
    const clientContact = getCookie('client_contact');
    const buildingName = getCookie('client_buildingName');
    const floor = getCookie('client_floor');
    const apartment = getCookie('client_apartment');

    // Set the values of input fields if the cookies exist
    if (clientName) {
        document.querySelector('input[name="name"]').value = clientName;
    }
    if (clientContact) {
        document.querySelector('input[name="contact"]').value = clientContact;
    }
    if (buildingName) {
        document.querySelector('input[name="buildingName"]').value = buildingName;
    }
    if (floor) {
        document.querySelector('input[name="floor"]').value = floor;
    }
    if (apartment) {
        document.querySelector('input[name="apartment"]').value = apartment;
    }
}

// Populate form fields on page load
window.onload = populateFormFields;

// Function to store form data in cookies when the form is submitted
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    let name = document.querySelector('input[name="name"]').value;
    let contact = document.querySelector('input[name="contact"]').value;
    let buildingName = document.querySelector('input[name="buildingName"]').value;
    let floor = document.querySelector('input[name="floor"]').value;
    let apartment = document.querySelector('input[name="apartment"]').value;

    // Set cookies for personal details
    setCookie('client_name', name, 30);
    setCookie('client_contact', contact, 30);
    setCookie('client_buildingName', buildingName, 30);
    setCookie('client_floor', floor, 30);
    setCookie('client_apartment', apartment, 30);

    // Optionally, submit the form or perform other actions
    this.submit(); // Uncomment this line to actually submit the form after setting cookies
});

//======== Intersection Observer (slide-in effect) ================

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // When the element comes into view, add the 'slide-in' class
            entry.target.classList.add('slide-in');
            observer.unobserve(entry.target); // Stop observing after the animation is triggered
        }
    });
}, { threshold: 0.2 }); // Trigger when 20% of the element is in view

// Target the .report-issue element
const reportIssue = document.querySelector('.report-issue');
observer.observe(reportIssue);


//=========== Image File Handler =================

document.querySelector('.upload_button').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});

document.getElementById('fileInput').addEventListener('change', function(event) {
    const files = event.target.files;
    const fileNames = Array.from(files).map(file => file.name).join(', ');

    document.getElementById('fileNames').textContent = fileNames;
});

document.querySelector('.delete_button').addEventListener('click', function() {
    document.getElementById('fileInput').value = '';
    document.getElementById('fileNames').textContent = 'No file selected';
});


//======= Handle Delete Button =============//

document.querySelector('.delete_button').addEventListener('click', function() {
    // Reset the file input (clear selected files)
    document.getElementById('fileInput').value = '';

    // Clear the displayed file names
    document.getElementById('fileNames').textContent = 'No files selected';
});



// Show loader on form submit and hide it after form submission
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent the default form submission

    // Grab values from the fields to validate
    var floor = document.querySelector('input[name="floor"]').value;
    var imageField = document.querySelector('input[name="image"]').files.length;

    // Check if optional fields are blank (either floor or image)
    // Optional fields shouldn't stop the form submission
    if (floor.trim() === "" || imageField === 0) {
        console.log("One or both optional fields are blank.");
    }

    // Show the loader while processing
    document.getElementById('loader').style.display = 'block';

    // Prepare form data for submission
    var formData = new FormData(this);

    // Perform AJAX submission
    fetch('submit_ticket.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Hide the loader after submission
        document.getElementById('loader').style.display = 'none';

        // After the form is submitted successfully, redirect to success.php
        window.location.href = 'success.php';
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('loader').innerHTML = "There was an error submitting your ticket.";
    });
});













// Get dropdown elements for Building, Floor, Apartment, and Category
const buildingInputField = document.querySelector('input[name="buildingName"]');
const floorInputField = document.querySelector('input[name="floor"]');
const apartmentInputField = document.querySelector('input[name="apartment"]');
const categoryInputField = document.querySelector('input[name="Category"]');  // Added Category input field

const buildingDropdownContent = document.querySelector('.dropdown-content[data-name="building"]');
const floorDropdownContent = document.querySelector('.dropdown-content[data-name="floor"]');
const apartmentDropdownContent = document.querySelector('.dropdown-content[data-name="apartment"]');
const categoryDropdownContent = document.querySelector('.dropdown-content[data-name="category"]');  // Added Category dropdown content

// Function to close all dropdowns
function closeAllDropdowns() {
    buildingDropdownContent.style.display = 'none';
    floorDropdownContent.style.display = 'none';
    apartmentDropdownContent.style.display = 'none';
    categoryDropdownContent.style.display = 'none';  // Close Category dropdown
}

// Toggle the dropdown for building, close others
buildingInputField.addEventListener('click', function(event) {
    if (buildingDropdownContent.style.display === 'block') {
        buildingDropdownContent.style.display = 'none'; // Close if it's already open
    } else {
        closeAllDropdowns(); // Close all dropdowns first
        buildingDropdownContent.style.display = 'block'; // Open building dropdown
    }
    event.stopPropagation(); // Prevent the click from closing the dropdown immediately
});

// Toggle the dropdown for floor, close others
floorInputField.addEventListener('click', function(event) {
    if (floorDropdownContent.style.display === 'block') {
        floorDropdownContent.style.display = 'none'; // Close if it's already open
    } else {
        closeAllDropdowns(); // Close all dropdowns first
        floorDropdownContent.style.display = 'block'; // Open floor dropdown
    }
    event.stopPropagation(); // Prevent the click from closing the dropdown immediately
});

// Toggle the dropdown for apartment, close others
apartmentInputField.addEventListener('click', function(event) {
    if (apartmentDropdownContent.style.display === 'block') {
        apartmentDropdownContent.style.display = 'none'; // Close if it's already open
    } else {
        closeAllDropdowns(); // Close all dropdowns first
        apartmentDropdownContent.style.display = 'block'; // Open apartment dropdown
    }
    event.stopPropagation(); // Prevent the click from closing the dropdown immediately
});

// Toggle the dropdown for category, close others
categoryInputField.addEventListener('click', function(event) {
    if (categoryDropdownContent.style.display === 'block') {
        categoryDropdownContent.style.display = 'none'; // Close if it's already open
    } else {
        closeAllDropdowns(); // Close all dropdowns first
        categoryDropdownContent.style.display = 'block'; // Open category dropdown
    }
    event.stopPropagation(); // Prevent the click from closing the dropdown immediately
});

// Handle selecting a building, floor, apartment, or category
document.querySelectorAll('.dropdown-item[data-name="building"]').forEach(item => {
    item.addEventListener('click', function(event) {
        buildingInputField.value = item.textContent;
        buildingDropdownContent.style.display = 'none'; // Close dropdown after selection
        event.stopPropagation(); // Prevent event bubbling
    });
});

document.querySelectorAll('.dropdown-item[data-name="floor"]').forEach(item => {
    item.addEventListener('click', function(event) {
        floorInputField.value = item.textContent;
        floorDropdownContent.style.display = 'none'; // Close dropdown after selection
        event.stopPropagation(); // Prevent event bubbling
    });
});

document.querySelectorAll('.dropdown-item[data-name="apartment"]').forEach(item => {
    item.addEventListener('click', function(event) {
        apartmentInputField.value = item.textContent;
        apartmentDropdownContent.style.display = 'none'; // Close dropdown after selection
        event.stopPropagation(); // Prevent event bubbling
    });
});

document.querySelectorAll('.dropdown-item[data-name="category"]').forEach(item => {
    item.addEventListener('click', function(event) {
        categoryInputField.value = item.textContent;
        categoryDropdownContent.style.display = 'none'; // Close dropdown after selection
        event.stopPropagation(); // Prevent event bubbling
    });
});

// Close all dropdowns if clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.input-area.dropdown')) {
        closeAllDropdowns(); // Close all dropdowns when clicking outside
    }
});























