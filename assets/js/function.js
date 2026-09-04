//To Validate for required Field
function validateField(fieldId, errorId) {
    var value = $('#' + fieldId).val().trim();
    if (value === '') {
        $('#' + errorId).show();
        return false;
    } else {
        $('#' + errorId).hide();
        return true;
    }
}
//To Validate dob for employees if the employee must an 18 years
function validateDOB(fieldId, errorId) {
    var dob = $('#' + fieldId).val().trim();
    if (dob === '') {
        $('#' + errorId).text("DOB is required").show();
        return false;
    } else {
        var age = calculateAge(dob);
        if (age < 18) {
            $('#' + errorId).text("You must be at least 18 years old").show();
            return false;
        } else {
            $('#' + errorId).hide();
            return true;
        }
    }
}
//To validate the date of joining will not future 
function validateJoiningDate(fieldId, errorId) {
    var jDate = $('#' + fieldId).val().trim();
    if (jDate === '') {
        $('#' + errorId).text("Date of joining is required").show();
        return false;
    } else {
        var today = new Date();
        var joiningDate = new Date(jDate);
        if (joiningDate > today) {
            $('#' + errorId).text("Date of joining cannot be in the future").show();
            return false;
        } else {
            $('#' + errorId).hide();
            return true;
        }
    }
}
//To Calculate are for validate dob 
function calculateAge(dob) {
    var birthDate = new Date(dob);
    var today = new Date();
    var age = today.getFullYear() - birthDate.getFullYear();
    var monthDiff = today.getMonth() - birthDate.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

// Function to validate phone number
function validatePhoneNumber(fieldId, errorId) {
    var phoneInput = $('#' + fieldId);
    var phoneError = $('#' + errorId);
    var phoneNumber = phoneInput.val().trim();
    var phonePattern = /^\d{10}$/;

    // Limit input length to 10 digits
    phoneInput.on('input', function() {
        var value = phoneInput.val().trim();
        if (value.length > 10) {
            phoneInput.val(value.slice(0, 10)); // Truncate to 10 digits
        }
    });

    // Validate phone number
    if (phoneNumber === "") {
        phoneError.text("This field cannot be empty.").show();
        return false;
    } else if (!phonePattern.test(phoneNumber)) {
        phoneError.text("Please enter a valid 10-digit phone number.").show();
        return false;
    } else {
        phoneError.hide();
        return true;
    }
}

//validate date for salary date to use not select the future date
// Function to validate the date field
function validateDate() {
    const dateInput = document.getElementById('date');
    const selectedDate = new Date(dateInput.value);
    const currentYear = new Date().getFullYear();
    const errorMessage = document.getElementById('salDateError');
    
    // Check if the date is empty
    if (dateInput.value === '') {
        errorMessage.style.display = 'block';
        errorMessage.textContent = 'Please enter a date'; // Update the error message
        return false;
    }
    
    // Check if the selected date is in the future year
    if (selectedDate.getFullYear() > currentYear) {
        errorMessage.style.display = 'block';
        errorMessage.textContent = 'Date cannot be in the future year';
        dateInput.value = '';  // Clear the invalid date
        return false;
    } else {
        errorMessage.style.display = 'none';
        return true;
    }
}
//validate days for payroll absent days
function validateDays(inputId, errorId) {
    const daysInput = document.getElementById(inputId);
    const daysError = document.getElementById(errorId);
    const daysValue = parseInt(daysInput.value, 10);

    if (isNaN(daysValue) || daysValue < 0 || daysValue > 30) {
        daysError.textContent = 'Please enter a valid number of days (0-30).';
        daysError.style.display = 'block';
    } else {
        daysError.style.display = 'none';
    }
}
//Validate dob for college students
function validateDOBClg(fieldId, errorId) {
    var dob = $('#' + fieldId).val().trim();
    if (dob === '') {
        $('#' + errorId).text("DOB is required").show();
        return false;
    } else {
        var age = calculateAge(dob);
        if (age < 14) {
            $('#' + errorId).text("You must be at least 14 years old").show();
            return false;
        } else {
            $('#' + errorId).hide();
            return true;
        }
    }
}

// Validate name function
function validateName(fieldId, errorId) {
    var name = $('#' + fieldId).val().trim();
    // Updated pattern to allow for multiple names and initials like "Arun Durai C"
    var namePattern = /^[A-Za-z]+(?: [A-Za-z]+)*(?: [A-Za-z]\.)?$/;
    
    console.log('Validating name:', name); // Debug line
    
    if (name === "") {
        $('#' + errorId).text("This field cannot be empty.").show();
        return false;
    } else if (!namePattern.test(name)) {
        $('#' + errorId).text("Invalid name format.").show();
        return false;
    } else {
        $('#' + errorId).hide();
        return true;
    }
}

// Function to validate email
function validateEmail(fieldId, errorId) {
    var email = $('#' + fieldId).val().trim();
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    console.log('Validating email:', email); // Debug line

    if (email === "") {
        $('#' + errorId).text("This field cannot be empty.").show();
        return false;
    } else if (!emailPattern.test(email)) {
        $('#' + errorId).text("Invalid email format.").show();
        return false;
    } else {
        $('#' + errorId).hide();
        return true;
    }
}
//Function to validate the aadhar number 
function validateAadhaar(fieldId, errorId) {
    var aadhaarInput = $('#' + fieldId);
    var aadhaarError = $('#' + errorId);
    var aadhaarNumber = aadhaarInput.val().trim();
    var aadhaarPattern = /^\d{12}$/;

    // Limit input length to 12 digits
    aadhaarInput.on('input', function() {
        var value = aadhaarInput.val().trim();
        if (value.length > 12) {
            aadhaarInput.val(value.slice(0, 12)); // Truncate to 12 digits
        }
    });

    // Validate Aadhaar number
    if (aadhaarNumber === "") {
        aadhaarError.text("This field cannot be empty.").show();
        return false;
    } else if (!aadhaarPattern.test(aadhaarNumber)) {
        aadhaarError.text("Please enter a valid 12-digit Aadhaar number.").show();
        return false;
    } else {
        aadhaarError.hide();
        return true;
    }
}

//Fucntion to validate the 10h mark
function validateTenthMark(fieldId, errorId) {
    var marksInput = $('#' + fieldId);
    var marksError = $('#' + errorId);
    var marks = marksInput.val().trim();
    var marksPattern = /^[0-9]{1,3}$/; // Allows 1-3 digit numbers (0-999)

    // Validate 10th Marks
    if (marks === "") {
        marksError.text("This field cannot be empty.").show();
        return false;
    } else if (!marksPattern.test(marks) || parseInt(marks) > 500 || parseInt(marks) == 100) {
        marksError.text("Please enter a valid mark").show();
        return false;
    } else {
        marksError.hide();
        return true;
    }
}
function validateTwelft(fieldId, errorId) {
    var marksInput = $('#' + fieldId);
    var marksError = $('#' + errorId);
    var marks = marksInput.val().trim();
    var marksPattern = /^[0-9]{1,4}$/; // Allows 1-3 digit numbers (0-999)

    // Validate 10th Marks
    if (marks === "") {
      marksError.hide();
      return true;
    }
   if (!marksPattern.test(marks) || parseInt(marks) > 1200 || parseInt(marks) < 200) {
        marksError.text("Please enter a valid mark").show();
        return false;
    } else {
        marksError.hide();
        return true;
    }
}

//to validate the optional email

function optionalEmail(fieldId, errorId) {
    var emailField = document.getElementById(fieldId);
    var errorField = document.getElementById(errorId);

    // Trim white space from the email field
    emailField.value = emailField.value.trim();

    // Check if the email field is empty
    if (emailField.value === '') {
        // Hide error message if the email field is empty
        errorField.style.display = 'none';
        return true; // Valid since it is not required
    } else {
        // Validate the email format if not empty
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailField.value)) {
            errorField.style.display = 'block';
            errorField.textContent = 'Please enter a valid email address.';
            return false;
        } else {
            // Hide error message if the email is valid
            errorField.style.display = 'none';
            return true;
        }
    }
}


// Validate duration function
function projectDuration(fieldId, errorId) {
    var duration = $('#' + fieldId).val().trim();
    
    var durationPattern = /^[1-9][0-9]{0,4}$/;  // Pattern to match exactly four digits

    console.log('Validating duration:', duration); // Debug line

    if (duration === "") {
        $('#' + errorId).text("Duration is required.").show();
        return false;
    } else if (!durationPattern.test(duration)) {
        $('#' + errorId).text("Please check the duration.").show();
        return false;
    } else {
        $('#' + errorId).hide();
        return true;
    }
}


// Validate project amount function
function projectAmount(fieldId, errorId) {
    var amount = $('#' + fieldId).val().trim();
    
    // Pattern to match 1 to 10 digits, but not starting with 0
    var amountPattern = /^[1-9][0-9]{0,9}$/;

    console.log('Validating amount:', amount); // Debug line

    if (amount === "") {
        $('#' + errorId).text("Amount is required.").show();
        return false;
    } else if (!amountPattern.test(amount)) {
        $('#' + errorId).text("Please check the Amount.").show();
        return false;
    } else {
        $('#' + errorId).hide();
        return true;
    }
}

//Set max date today

function setMaxDate(inputId) {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById(inputId).setAttribute('max', today);
}

//Function to hide the error message while click the edit close button
function hideErrorMessages() {
    $('.error-message').hide(); // Hide all error messages
    }