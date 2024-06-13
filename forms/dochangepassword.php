<?php
session_start();
include "../db_connect.php";

// Ensure the user is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}


// Get the form data
$new_password = trim($_POST['newpassword']);
$confirm_password = trim($_POST['cfmpassword']);

// Validate input
if (empty($email) || empty($new_password) || empty($confirm_password)) {
    header("Location: change_password.php?error=Please fill in all fields.");
    exit();
}

// Check if passwords match
if ($new_password !== $confirm_password) {
    header("Location: change_password.php?error=Passwords do not match.");
    exit();
}



// Hash the new password
// $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update the password in the database
    $stmt = $conn->prepare("UPDATE patient SET patient_password = ? WHERE patient_email = ? AND patient_id = ?");
    $stmt->bind_param("ssi", $new_password, $email, $_SESSION['patient_id']);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        // Password updated successfully
        $message = "Password updated successfully";
    } else {
        // No rows updated (could be wrong email or patient_id)
        $message = "An error occurred while updating the password";
    }
    $stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Change Password</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>

<!--navbar-->
<?php include '../navbar.php'; ?>

<div class="container mt-5">
    <?php
    if (isset($_GET['error'])) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    if (isset($_GET['message'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
    }
    ?>
</div>

<section class=" d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12 col-lg-6 text-black right-col">
                <div class="form-container-password">
                    <form id="passwordForm" method="post" action="dochangepassword.php">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" value="<?php echo htmlspecialchars($patient_name); ?>" hidden/>
                        </div>
                        <h2 class="text">Change Password</h2>
                        <br>
                        <div class="form-outline mb-4">
                        <div class="input-text">New Password:</div><input type="password" id="idPassword" class="form-control form-control-lg" placeholder="Password" name="newpassword" required/>
                        </div>
                        <div class="form-outline mb-4">
                        <div class="input-text">Confirm Password:</div><input type="password" id="idPasswordConfirm" class="form-control form-control-lg" placeholder="Password" name="cfmpassword" required/>
                        </div>
                        <br>
                        <div class="row mt-3">
                            <div class="col-6">
                            <a href="../index.php" class="btn back-btn">Back</a>
                            </div>
                            <div class="col-6">
                                <button type="submit" id="saveButton" class="btn save-btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<br>


</body>

</html>

