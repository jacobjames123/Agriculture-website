// Get the login and registration forms
var loginForm = document.querySelector(".login-form");
var registrationForm = document.querySelector(".registration-form");

// Get the "Register" and "Login" links within the modal
var registerLink = document.getElementById("showRegisterModal");
var loginLink = document.getElementById("loginLink");


// Function to display the login form and hide the registration form
function showLoginForm() {
    loginForm.style.display = "block";
    registrationForm.style.display = "none";
}

// Initially, show the login form and hide the registration form
showLoginForm();

// Function to display the registration form and hide the login form
function showRegistrationForm() {
    loginForm.style.display = "none";
    registrationForm.style.display = "block";
}




// Set click event listeners for the "Register" and "Login" links within the modal

loginLink.addEventListener("click", function (event) {
    event.preventDefault();
    showLoginForm();
});

registerLink.addEventListener("click", function (event) {
    event.preventDefault();
    showRegistrationForm();
});




// The following code remains the same to handle the initial modal display
var modal = document.getElementById("myModal");
var loginRegisterLink = document.getElementById("loginRegisterLink");
var closeBtn = document.getElementsByClassName("close")[0];

function openModal() {
    modal.style.display = "block";
}

function closeModal() {
    modal.style.display = "none";
}

loginRegisterLink.onclick = function(event) {
    event.preventDefault();
    openModal();
}

closeBtn.onclick = function() {
    closeModal();
}

window.onclick = function(event) {
    if (event.target == modal) {
        closeModal();
    }
}

function search() {
    // Get the search keywords entered by the user
    var keywords = document.getElementById("search-input").value.toLowerCase();

    // Define your keywords-to-section-ID mapping
    var keywordToSection = {
        "eco-friendly crop management": "services1",
        "soil health assessment": "services",
        "natural pest control": "services",
        "crop health analysis": "services",
        "sustainable irrigation": "services",
        "organic fertilizers": "services",
      
    };

    // Check if the keywords match any entry in the mapping
    if (keywordToSection.hasOwnProperty(keywords)) {
        var targetSection = keywordToSection[keywords];

        // Redirect to the services.html page with the fragment identifier
        window.location.href = "services.html#" + targetSection;

    } else {
        // Handle the case where no match is found
        alert("No matching results found.");
    }
}







// Admin section

