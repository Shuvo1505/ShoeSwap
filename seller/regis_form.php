<?php
require 'php/ping_test.php';
session_start();
$loginname = $_SESSION['seller_username'];

if (!isset($loginname)){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Seller Registration</title>

    <link rel="icon" href="images\webisite_logo.png" type="image/x">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
  <script src="js/regis_form_seller.js"></script>
  <style>

          .custom-select-wrapper::after {
            content: '▼';
            position: absolute;
            top: 72%;
            right: 18px;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6c757d;
            font-size: 0.8rem;
        }
        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 2rem;
            background-color: #fff;
        }
  </style>
</head>

<body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
    Swal.fire({
        title: 'You need to fill one registration form first to maintain your authenticity before proceed',
        icon: 'warning',
        confirmButtonText: "Okay, I Understand",
        allowOutsideClick: false,
        allowEscapeKey: false
    });
</script>
  <!-- -------------------------------Body-------------------------------->
  
  <section id="my-form" class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
      <div class="card shadow-lg mx-auto" style="max-width: 600px; border-radius: 15px;">
        <div class="card-header text-center text-white" style="background-color: #213555!important;">
          <h3 class="mb-0">Registration Form</h3>
        </div>
        <div class="card-body p-5">
          <form method="POST" action="php/registration_data.php" onsubmit="return validateForm()">
          <div class="form-row">  
          <div class="form-group col-md-6">
              <label for="fname"><strong>First Name</strong></label>
              <input type="text" name="fname" class="form-control" placeholder="Enter first name" required maxlength="15">
              <span id="fname-error" class="form-error text-danger small"></span>
            </div>
            <div class="form-group col-md-6">
              <label for="lname"><strong>Last Name</strong></label>
              <input type="text" name="lname" class="form-control" placeholder="Enter last name" required maxlength="15">
              <span id="lname-error" class="form-error text-danger small"></span>
            </div>
            </div>
            <div class="form-group">
              <label for="address"><strong>Address</strong></label>
              <input type="text" name="address" class="form-control" placeholder="Enter address" required maxlength="30">
              <span id="add-error" class="form-error text-danger small"></span>
            </div>
            <div class="form-group">
              <label for="city"><strong>City</strong></label>
              <input type="text" name="city" class="form-control" placeholder="Enter city" required maxlength="30">
              <span id="city-error" class="form-error text-danger small"></span>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
              <label for="pin"><strong>PIN Code</strong></label>
              <input type="text" name="pin" class="form-control" placeholder="Enter PIN" required maxlength="6">
              <span id="pin-error" class="form-error text-danger small"></span>
            </div>
            <div class="form-group col-md-6">
              <label for="phone_number"><strong>Contact</strong></label>
              <input type="text" name="phone_number" maxlength="10" required onkeypress="return isNumeric(event)" class="form-control" placeholder="Enter contact number">
              <span id="phone-error" class="form-error text-danger small"></span>
            </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6 custom-select-wrapper">
              <label for="govt_id_type"><strong>Govt. ID</strong></label>
              <select name="govt_id_type" class="form-control" required>
                <option value="">Select ID Type</option>
                <option value="Aadhaar Card">Aadhaar Card</option> <!--12-->
                <option value="Voter Card">Voter Card</option> <!--10-->
                <option value="Passport">Passport</option> <!--8 to 12-->
                <option value="PAN Card">PAN Card</option> <!--10-->
              </select>
              <span id="govt_id_type-error" class="form-error text-danger small"></span>
            </div>
            <div class="form-group col-md-6">
              <label for="govt_id_number"><strong>ID Number</strong></label>
              <input type="text" name="govt_id_number" class="form-control" placeholder="Enter ID number" required maxlength="12">
              <span id="govt_id_number-error" class="form-error text-danger small"></span>
            </div>
            </div>
            <br>
            <div class="text-center">
              <div class="row-md-6">  
            <button type="reset" class="btn btn-primary" style="background-color: grey;">Reset</button>
            <button type="submit" class="btn btn-primary" style="background-color: #213555;">Proceed</button>
          </div>  
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!--Form Validations-->
  <script>
    function validateForm() {
        let isValid = true;

        // First Name
        const fname = document.querySelector('input[name="fname"]').value.trim();
        if (fname === "") {
          document.getElementById("fname-error").innerHTML = "First name is required";
          isValid = false;
        } else if (!/^[a-zA-Z]+$/.test(fname)) {
          document.getElementById("fname-error").innerHTML = "First name should be alphabetic";
          isValid = false;
        } else {
          document.getElementById("fname-error").innerHTML = "";
        }

        // Last Name
        const lname = document.querySelector('input[name="lname"]').value.trim();
        if (lname === "") {
          document.getElementById("lname-error").innerHTML = "Last name is required";
          isValid = false;
        } else if (!/^[a-zA-Z]+$/.test(lname)) {
          document.getElementById("lname-error").innerHTML = "Last name should be alphabetic";
          isValid = false;
        } else {
          document.getElementById("lname-error").innerHTML = "";
        }

        // Address
        const address = document.querySelector('input[name="address"]').value.trim();
        if (address === "") {
          document.getElementById("add-error").innerHTML = "Address is required";
          isValid = false;
        } else if (!/^[a-zA-Z0-9\s,.-]+$/.test(address)) {
          document.getElementById("add-error").innerHTML = "Address should be alphanumeric";
          isValid = false;
        } else if (/^\d+$/.test(address)) {
          document.getElementById("add-error").innerHTML = "Address should not be only numeric";
          isValid = false;
        } else {
          document.getElementById("add-error").innerHTML = "";
        }

        // City
        const city = document.querySelector('input[name="city"]').value.trim();
        if (city === "") {
          document.getElementById("city-error").innerHTML = "City is required";
          isValid = false;
        } else if (!/^[a-zA-Z]+$/.test(city)) {
          document.getElementById("city-error").innerHTML = "City should be alphabetic";
          isValid = false;
        } else {
          document.getElementById("city-error").innerHTML = "";
        }

        // PIN Code
        const pin = document.querySelector('input[name="pin"]').value.trim();
        if (pin === "") {
          document.getElementById("pin-error").innerHTML = "PIN code is required";
          isValid = false;
        } else if (!/^\d{6}$/.test(pin)) {
          document.getElementById("pin-error").innerHTML = "PIN code should be 6 digits";
          isValid = false;
        } else if (parseInt(pin) <= 0) {
          document.getElementById("pin-error").innerHTML = "PIN code should be greater than 0";
          isValid = false;
        } else {
          document.getElementById("pin-error").innerHTML = "";
        }

        // Contact Number
        const phoneNumber = document.querySelector('input[name="phone_number"]').value.trim();
        if (phoneNumber === "") {
          document.getElementById("phone-error").innerHTML = "Contact number is required";
          isValid = false;
        } else if (!/^\d{10}$/.test(phoneNumber)) {
          document.getElementById("phone-error").innerHTML = "Contact number should be 10 digits";
          isValid = false;
        } else if (parseInt(phoneNumber) <= 0) {
          document.getElementById("phone-error").innerHTML = "Contact number should be greater than 0";
          isValid = false;
        } else {
          document.getElementById("phone-error").innerHTML = "";
        }

        // Govt ID Type
        const govtIdType = document.querySelector('select[name="govt_id_type"]').value;
        if (govtIdType === "") {
          document.getElementById("govt_id_type-error").innerHTML = "Govt ID type is required";
          isValid = false;
        } else {
          document.getElementById("govt_id_type-error").innerHTML = "";
        }

        // Govt ID Number
        const govtIdNumber = document.querySelector('input[name="govt_id_number"]').value.trim();
        if (govtIdNumber === "") {
          document.getElementById("govt_id_number-error").innerHTML = "Govt ID number is required";
          isValid = false;
        } else {
          let regex;
          switch (govtIdType) {
            case "aadhaar":
              regex = /^\d{12}$/;
              break;
            case "voter":
              regex = /^[a-zA-Z0-9]{10,12}$/;
              break;
            case "passport":
              regex = /^[A-Z][0-9]{7}$/;
              break;
            case "pan":
              regex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
              break;
            default:
              regex = null;
          }
          if (regex && !regex.test(govtIdNumber)) {
            document.getElementById("govt_id_number-error").innerHTML = "Invalid Govt ID number";
            isValid = false;
          } else {
            document.getElementById("govt_id_number-error").innerHTML = "";
          }
        }

        return isValid;
      }

      // Helper function
      function isNumeric(event) {
        const key = event.keyCode || event.which;
        return /\d/.test(String.fromCharCode(key));
      }

  </script>

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->

</body>

</html>