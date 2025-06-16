console.log("In js folder");
function validateForm() {
    // Get form input values
    var fname = document.getElementsByName("fname")[0].value.trim();
    var lname = document.getElementsByName("lname")[0].value.trim();
    var address = document.getElementsByName("address")[0].value.trim();
    var city = document.getElementsByName("city")[0].value.trim();
    var pin = document.getElementsByName("pin")[0].value.trim();
    var phone_number = document.getElementsByName("phone_number")[0].value.trim();
    
    // Validate first name
    if (fname.length == 0 || fname.length > 15) {
        document.getElementById("fname-error").innerHTML = "First name must be between 1 and 15 characters.";
        return false;
    } else if (/^\d+$/.test(fname)) { // Check if name contains numeric characters
        document.getElementById("fname-error").innerHTML = "First name cannot contain numeric characters.";
        return false;
    } else {
        document.getElementById("fname-error").innerHTML = "";
    }
    
    // Validate last name
    if (lname.length == 0 || lname.length > 15) {
        document.getElementById("lname-error").innerHTML = "Last name must be between 1 and 15 characters.";
        return false;
    } else if (/^\d+$/.test(lname)) { // Check if name contains numeric characters
        document.getElementById("lname-error").innerHTML = "Last name cannot contain numeric characters.";
        return false;
    } else {
        document.getElementById("lname-error").innerHTML = "";
    }
    
    // Validate address
    if (address.length == 0 || address.length > 30) {
        document.getElementById("add-error").innerHTML = "Address must be between 1 and 30 characters.";
        return false;
    } else {
        document.getElementById("add-error").innerHTML = "";
    }
    
    // Validate city
    if (city.length == 0 || city.length > 30) {
        document.getElementById("city-error").innerHTML = "City must be between 1 and 30 characters.";
        return false;
    } else {
        document.getElementById("city-error").innerHTML = "";
    }
    
    // Validate pin
    if (isNumeric(pin) || pin.length != 6) {
        document.getElementById("pin-error").innerHTML = "PIN must be a 6-digit number.";
        return false;
    } else {
        document.getElementById("pin-error").innerHTML = "";
    }
    
    // Validate phone number
    if (isNumeric(phone_number) || phone_number.length != 10) {
        document.getElementById("phone-error").innerHTML = "Phone number must be a 10-digit number.";
        return false;
    } else {
        document.getElementById("phone-error").innerHTML = "";
    }

    // Return true if all fields are valid
    return true;
}

// Helper function to allow only numeric input
function isNumeric(event) {
    return /\d/.test(event.key);
}
