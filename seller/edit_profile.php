<?php
require 'php/ping_test.php';
session_start();


include 'constants/session_config.php';
if (!$is_logged_in){
    header("Location: login.php");
    exit;
}
include("../auth/database.php");
$conn = mysqli_connect($host, $username, $password, "shoeswap");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user = $_SESSION['s_user'];

// Fetch user details from database
$sql = "SELECT * FROM seller WHERE USERNAME = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<style>
    body {
        background-image: url('images/shoe.avif');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        min-height: 100vh;
    }
</style>
<body class="bg-light">
<div class="container my-5">
    <div class="card shadow">
        <div class="card-header  text-white" style="background-color:#213555 ;">
            <h3>Edit Profile</h3>
        </div>
        <div class="card-body">
            <form action="update_profile.php" method="POST">
                <div class="form-row">
                <div class="form-group col-md-6">
                    <label><strong>First Name</strong></label>
                    <input name="fname" class="form-control" value="<?php echo $row['FNAME']; ?>" maxlength="15">
                </div>
                <div class="form-group col-md-6">
                    <label><strong>Last Name</strong></label>
                    <input name="lname" class="form-control" value="<?php echo $row['LNAME']; ?>" maxlength="15">
                </div>
                </div>
                <div class="form-group">
                    <label><strong>Email</strong></label>
                    <input name="email" class="form-control" value="<?php echo $row['EMAIL_ID'] ?>" maxlength="50">
                </div>
                <div class="form-group">
                    <label><strong>Phone</strong></label>
                    <input name="phone" class="form-control" value="<?php echo $row['PHONE_NUMBER'] ?>" maxlength="10">
                </div>
                <div class="form-row">
                <div class="form-group col-md-6">
                    <label><strong>Govt. ID Type</strong></label>
                    <select name="govt_id_type" id="govt_id_type" class="form-control" required onchange="document.getElementById('govt_id_num').value=''">
                            <?php
                            $id_proofs = ["Aadhar Card", "Voter Card", "PAN Card", "Passport"];
                            foreach ($id_proofs as $ids) {
                                $selected = ($ids == $row['GOVT_ID_TYPE']) ? 'selected' : '';
                                echo "<option value=\"$ids\" $selected>$ids</option>";
                            }
                            ?>
                        </select>
                </div>
                <div class="form-group col-md-6">
                    <label><strong>ID Number</strong></label>
                    <input name="govt_id_num" id="govt_id_num" class="form-control" maxlength="12" required
                    value="<?php echo $row['ID_NUMBER'] ?>">
                </div>
                </div>

                <div class="form-row">
                <div class="form-group col-md-6">
                    <label><strong>Address</strong></label>
                    <input name="address" class="form-control" value="<?php echo $row['ADDRESS'] ?>" maxlength="30">
                </div>
                <div class="form-group col-md-6">
                    <label><strong>City</strong></label>
                    <input name="city" class="form-control" value="<?php echo $row['CITY'] ?>" maxlength="30">
                </div>
                </div>
                <div class="form-row">
                <div class="form-group col-md-6">
                    <label><strong>PIN Code</strong></label>
                    <input name="pin" class="form-control" value="<?php echo $row['PIN'] ?>" maxlength="6">
                </div>
                <div class="form-group col-md-6">
                    <label><strong>Security Question</strong></label>
                    <input name="security" class="form-control" value="<?php echo $row['SECURITY_QUES'] ?>" maxlength="4">
                </div>
                </div>
                <button class="btn btn-success" type="submit">Update Profile</button>
                <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>