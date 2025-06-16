<?php
require 'php/ping_test.php';
session_start();
if ($_SESSION["status"] === "active") {
    include('auth/database.php');
    $userId = $_SESSION['userId'];

    $query = "SELECT * FROM user WHERE userid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Step Up Your Style</title>
    <link rel="icon" href="images/icons/webisite_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .form-container {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .form-title {
            color: #213555;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background-color: #213555;
            border: none;
        }
        .btn-primary:hover {
            background-color: #EB5B00;
        }
        .custom-select-wrapper {
            position: relative;
        }
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
<?php include('constants/navbar_other.php'); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-container">
                <h2 class="form-title text-center">Edit Profile</h2>
                <form action="update_profile.php" method="POST">
                    <div class="form-group">
                        <label for="fname"><strong>First Name</strong></label>
                        <input type="text" class="form-control" name="fname" id="fname" value="<?= htmlspecialchars($user['FNAME']); ?>" required maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="lname"><strong>Last Name</strong></label>
                        <input type="text" class="form-control" name="lname" id="lname" value="<?= htmlspecialchars($user['LNAME']); ?>" required maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="lname"><strong>Email</strong></label>
                        <input type="text" class="form-control" name="email" id="email" value="<?= htmlspecialchars($user['EMAIL_ID']); ?>" required maxlength="50">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 custom-select-wrapper">
                            <label for="state"><strong>State</strong></label>
                            <select name="state" id="state" class="form-control" required onchange="loadCities()">
                                <?php
                                $states = ["West Bengal", "Maharashtra", "Karnataka", "Tamil Nadu", "Delhi"];
                                foreach ($states as $state) {
                                    $selected = ($state == $user['STATE']) ? 'selected' : '';
                                    echo "<option value=\"$state\" $selected>$state</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 custom-select-wrapper">
                            <label for="city"><strong>City</strong></label>
                            <select name="city" id="city" class="form-control" required>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pin"><strong>PIN Code</strong></label>
                            <input type="text" class="form-control" name="pin" id="pin" value="<?= htmlspecialchars($user['PIN']); ?>" required maxlength="6">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone_number"><strong>Phone Number</strong></label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number" value="<?= htmlspecialchars($user['PHONE_NUMBER']); ?>" required maxlength="10">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="security_ques"><strong>Security Question</strong></label>
                        <input type="text" class="form-control" name="security_ques" id="security_ques" value="<?= htmlspecialchars($user['SECURITY_QUES']); ?>" required maxlength="4">
                    </div>

                    <div class="form-group text-right d-flex justify-content-end">
                        <a href="profile.php" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('constants/footer.php'); ?>

<script>
  const stateCityMap = {
"West Bengal": [
  "Kolkata", "Asansol", "Durgapur", "Siliguri", "Howrah", "Bardhaman", "Malda",
  "Kharagpur", "Berhampore", "Jalpaiguri", "Haldia", "Bankura", "Raiganj",
  "Cooch Behar", "Habra", "Ranaghat", "Krishnanagar", "Purulia", "Balurghat",
  "Alipurduar", "Chinsurah", "Serampore", "Barrackpore", "Bhatpara", "Tamluk",
  "Dankuni", "Uluberia", "Basirhat", "Naihati", "Rishra", "Kanchrapara",
  "Bongaon", "Barasat", "Dum Dum", "New Town", "Salt Lake", "Belgharia",
  "Sodepur", "Midnapore", "Bolpur", "Katwa", "Bishnupur", "Arambagh"
],
"Maharashtra": [
  "Mumbai", "Pune", "Nagpur", "Nashik", "Thane", "Aurangabad", "Solapur",
  "Amravati", "Kolhapur", "Navi Mumbai", "Kalyan-Dombivli", "Vasai-Virar",
  "Sangli", "Jalgaon", "Akola", "Latur", "Ahmednagar", "Dhule", "Chandrapur",
  "Parbhani", "Ichalkaranji", "Jalna", "Bhiwandi", "Panvel", "Satara", 
  "Beed", "Yavatmal", "Nanded", "Wardha", "Ratnagiri"
],
"Karnataka": [
  "Bengaluru", "Mysuru", "Mangaluru", "Hubballi", "Dharwad", "Belagavi",
  "Kalaburagi", "Ballari", "Vijayapura", "Tumakuru", "Bidar", "Shivamogga",
  "Raichur", "Davangere", "Hassan", "Bagalkot", "Udupi", "Kolar", "Chikkamagaluru",
  "Karwar", "Chitradurga", "Mandya", "Hospet", "Ramanagara", "Gadag", "Bijapur"
],
"Tamil Nadu": [
  "Chennai", "Coimbatore", "Madurai", "Salem", "Tiruchirappalli", "Tirunelveli",
  "Erode", "Vellore", "Thoothukudi", "Nagercoil", "Thanjavur", "Dindigul",
  "Cuddalore", "Karur", "Kanchipuram", "Rajapalayam", "Pudukkottai", "Hosur",
  "Nagapattinam", "Sivakasi", "Pollachi", "Namakkal", "Tiruppur", "Ariyalur"
],
"Delhi": [
  "New Delhi", "Dwarka", "Rohini", "Saket", "Karol Bagh", "Lajpat Nagar",
  "Connaught Place", "Chanakyapuri", "Mayur Vihar", "Vasant Kunj",
  "Janakpuri", "South Extension", "Greater Kailash", "Rajouri Garden",
  "Kalkaji", "Pitampura", "Okhla", "Tilak Nagar", "Shahdara", "Nehru Place",
  "Civil Lines", "Preet Vihar", "Punjabi Bagh", "Mehrauli", "Burari"
]
  };

  const userState = "<?= addslashes($user['STATE']) ?>";
  const userCity = "<?= addslashes($user['CITY']) ?>";

  function loadCities() {
    const stateSelect = document.getElementById("state");
    const citySelect = document.getElementById("city");
    const selectedState = stateSelect.value;

    citySelect.innerHTML = '<option value="" disabled>Select your city</option>';

    if (stateCityMap[selectedState]) {
      stateCityMap[selectedState].forEach(city => {
        const selected = city === userCity ? "selected" : "";
        const option = `<option value="${city}" ${selected}>${city}</option>`;
        citySelect.insertAdjacentHTML("beforeend", option);
      });
    }
  }

  // Trigger initial load on page ready
  window.addEventListener("DOMContentLoaded", () => {
    loadCities();
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>
