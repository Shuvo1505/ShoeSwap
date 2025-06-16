// function validateForm(event) {
//     var cardDetailError = document.getElementById('card-detail-error');
//     cardDetailError.innerHTML = ''; // Clear any previous error messages

//     // Validate cardholder's name (only letters)
//     var cardholderName = document.getElementById('typeName').value;
//     if (!/^[A-Za-z ]+$/.test(cardholderName)) {
//         cardDetailError.innerHTML = 'Please enter a valid cardholder name (letters only).';
//         event.preventDefault(); // Prevent form submission
//         return false;
//     }

//     // Validate card number (16 digits with spaces)
//     var cardNumber = document.getElementById('typeText').value.replace(/\s/g, '');
//     if (!/^\d{16}$/.test(cardNumber)) {
//         cardDetailError.innerHTML = 'Please enter a valid card number (16 digits with spaces after every 4 digits).';
//         event.preventDefault(); // Prevent form submission
//         return false;
//     }

//     // Validate expiration (numbers and slash after first two digits)
//     var expiration = document.getElementById('typeExp').value;
//     if (!/^\d{2}\/\d{4}$/.test(expiration)) {
//         cardDetailError.innerHTML = 'Please enter a valid expiration date (MM/YYYY format).';
//         event.preventDefault(); // Prevent form submission
//         return false;
//     }

//     // Form is valid, proceed with submission or further processing
//     cardDetailError.innerHTML = 'Payment form submitted successfully!';
//     // Add your further logic here for processing the form submission

//     // Reset the form
    
//     return false;
// }
function validateForm(){
    return false;
}