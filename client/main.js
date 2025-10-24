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
    const appartment = getCookie('client_appartment');

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
    if (appartment) {
        document.querySelector('input[name="appartment"]').value = appartment;
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
    let appartment = document.querySelector('input[name="appartment"]').value;

    // Set cookies for personal details
    setCookie('client_name', name, 30);
    setCookie('client_contact', contact, 30);
    setCookie('client_buildingName', buildingName, 30);
    setCookie('client_floor', floor, 30);
    setCookie('client_appartment', appartment, 30);

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
