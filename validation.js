document.addEventListener("DOMContentLoaded", function() {
    const form = document.forms['createListingForm'];
    
    form['title'].addEventListener('input', validateTitle);
    form['area'].addEventListener('input', validateArea);
    form['num_rooms'].addEventListener('input', validateNumRooms);
    form['price_per_night'].addEventListener('input', validatePricePerNight);
    form['start_date'].addEventListener('change', compare);
    form['ending_date'].addEventListener('change', compare);

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

    function validateNumRooms() {
        const numRooms = form['num_rooms'];
        if (!Number.isInteger(Number(numRooms.value)) || numRooms.value <= 0) {
            numRooms.setCustomValidity("Number of rooms must be a positive integer.");
            numRooms.reportValidity();
        } else {
            numRooms.setCustomValidity("");
        }
    }

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
document.addEventListener("DOMContentLoaded", function() {
    const form = document.forms['bookingForm']; 

    form['start_date'].addEventListener('change', compare);
    form['ending_date'].addEventListener('change', compare);

    function compare() {
        const startDt = form['start_date'].value;
        const endDt = form['ending_date'].value;

        if (!startDt || !endDt) {
            return; 
        }

        const startDate = new Date(startDt);
        const endDate = new Date(endDt);
        const currentDate = new Date();

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
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');

    burger.addEventListener('click', () => {
        navLinks.classList.toggle('nav-active');
    });
});
function myFunction() {
    var x = document.getElementById("nav-links");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}
document.addEventListener("DOMContentLoaded", function() {
    const form = document.forms['createAccountForm'];

    form['name'].addEventListener('input', validateName);
    form['surname'].addEventListener('input', validateSurname);
    form['password'].addEventListener('input', validatePassword);

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
