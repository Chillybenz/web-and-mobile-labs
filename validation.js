// Wait for the DOM content to be loaded before running the script
document.addEventListener("DOMContentLoaded", function() {
    const form = document.forms['createListingForm'];
    
    // Add event listeners to form fields for validation
    form['title'].addEventListener('input', validateTitle);
    form['area'].addEventListener('input', validateArea);
    form['num_rooms'].addEventListener('input', validateNumRooms);
    form['price_per_night'].addEventListener('input', validatePricePerNight);
    form['start_date'].addEventListener('change', compare);
    form['ending_date'].addEventListener('change', compare);

    // Validate the title field to ensure it only contains alphabetic characters and spaces
    function validateTitle() {
        const title = form['title'];
        const titleRegex = /^[a-zA-Z\s]+$/;
        if (!title.value.match(titleRegex)) {
            title.setCustomValidity("Title must contain only characters.");
            title.reportValidity();
        } else {
            title.setCustomValidity("");
        }
    }

    // Validate the area field to ensure it only contains alphabetic characters and spaces
    function validateArea() {
        const area = form['area'];
        const areaRegex = /^[a-zA-Z\s]+$/;
        if (!area.value.match(areaRegex)) {
            area.setCustomValidity("Area must contain only characters.");
            area.reportValidity();
        } else {
            area.setCustomValidity("");
        }
    }

    // Validate the number of rooms field to ensure it is a positive integer
    function validateNumRooms() {
        const numRooms = form['num_rooms'];
        if (!Number.isInteger(Number(numRooms.value)) || numRooms.value <= 0) {
            numRooms.setCustomValidity("Number of rooms must be a positive integer.");
            numRooms.reportValidity();
        } else {
            numRooms.setCustomValidity("");
        }
    }

    // Validate the price per night field to ensure it is a positive integer
    function validatePricePerNight() {
        const pricePerNight = form['price_per_night'];
        if (!Number.isInteger(Number(pricePerNight.value)) || pricePerNight.value <= 0) {
            pricePerNight.setCustomValidity("Price per night must be a positive integer.");
            pricePerNight.reportValidity();
        } else {
            pricePerNight.setCustomValidity("");
        }
    }
});

// Additional event listeners for the booking form
document.addEventListener("DOMContentLoaded", function() {
    const form = document.forms['bookingForm']; 

    form['start_date'].addEventListener('change', compare);
    form['ending_date'].addEventListener('change', compare);

    // Compare start and end dates to ensure validity
    function compare() {
        const startDt = form['start_date'].value;
        const endDt = form['ending_date'].value;

        // Do nothing if either date is not set
        if (!startDt || !endDt) {
            return; 
        }

        const startDate = new Date(startDt);
        const endDate = new Date(endDt);
        const currentDate = new Date();

        // Ensure start date is a future date and end date is after start date
        if (startDate == currentDate) {
            form['start_date'].setCustomValidity("Start date must be future date.");
            form['start_date'].reportValidity();
        } else if (startDate >= endDate) {
            form['ending_date'].setCustomValidity("Ending date must be later than the start date.");
            form['ending_date'].reportValidity();
        } else {
            form['start_date'].setCustomValidity("");
            form['ending_date'].setCustomValidity("");
        }
    }
});

// Toggle navigation links visibility on burger icon click
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');

    burger.addEventListener('click', () => {
        navLinks.classList.toggle('nav-active');
    });
});

// Function to toggle the display of navigation links
function myFunction() {
    var x = document.getElementById("nav-links");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}

// Event listeners and validation for account creation form
document.addEventListener("DOMContentLoaded", function() {
    const form = document.forms['createAccountForm'];

    form['name'].addEventListener('input', validateName);
    form['surname'].addEventListener('input', validateSurname);
    form['password'].addEventListener('input', validatePassword);

    // Validate the name field to ensure it only contains alphabetic characters
    function validateName() {
        const name = form['name'];
        const namePattern = /^[a-zA-Z]+$/;
        if (!name.value.match(namePattern)) {
            name.setCustomValidity("Name must contain only characters.");
            name.reportValidity();
        } else {
            name.setCustomValidity("");
        }
    }

    // Validate the surname field to ensure it only contains alphabetic characters
    function validateSurname() {
        const surname = form['surname'];
        const surnamePattern = /^[a-zA-Z]+$/;
        if (!surname.value.match(surnamePattern)) {
            surname.setCustomValidity("Surname must contain only characters.");
            surname.reportValidity();
        } else {
            surname.setCustomValidity("");
        }
    }

    // Validate the password field to ensure it meets the specified pattern
    function validatePassword() {
        const password = form['password'];
        const passwordPattern = /(?=.*\d).{4,10}/;
        if (!password.value.match(passwordPattern)) {
            password.setCustomValidity("Password must be between 4 and 10 characters long and contain at least one number.");
            password.reportValidity();
        } else {
            password.setCustomValidity("");
        }
    }
});
