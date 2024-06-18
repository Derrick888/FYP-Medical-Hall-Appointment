<?php 
session_start();
include "db_connect.php";
?>

<?php 
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

$query = "SELECT * FROM patient WHERE patient_id = ?";
$edit_patient_stmt = mysqli_prepare($conn, $query);


if (!$edit_patient_stmt) {
    die("Failed to prepare statement");
} else{
    mysqli_stmt_bind_param($edit_patient_stmt, 's', $_GET['patient_id']);
    mysqli_stmt_execute($edit_patient_stmt);
    $edit_patient_result = mysqli_stmt_get_result($edit_patient_stmt);

    if(mysqli_num_rows($edit_patient_result) > 0){
        if($row = mysqli_fetch_assoc($edit_patient_result)){
            $patient_id = $row['patient_id'];
            $patient_name = $row['patient_name'];
            $dob = $row['patient_dob'];
            $patient_phoneNo = $row['patient_phoneNo'];
            $patient_email = $row['patient_email'];
            $patient_status = $row['patient_status'];
            $patient_password = $row['patient_password'];
        }

    } else{
        $_SESSION['message'] = "Patient not found.";
        header("Location: patientDetails.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Patient Details</title>
     <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
</head>
<body>
    <section class="patient">
        <div class="patient-box">
            <div class="profile-details">
                <i class="bi bi-person-circle"></i>
                <h2 class=""><?php echo $patient_name ?></h2>
            </div>
            <form action="doEditPatient.php" method="POST">
                <div class="form-group">
                    <input type="text" name="patient_id" class="form-control" value="<?php echo $patient_id ?>" hidden>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo $patient_phoneNo ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="text" name="dob" id="dob" class="form-control" value="<?php echo $dob ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="appointment_time">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $patient_email ?>">
                </div>

                <!-- <div class="form-group">
                    <label for="appointment_status">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" value="<?php echo $patient_password ?>">
                </div> -->
                <div class="buttons">
                    <button class="btn back-btn">Back</button>
                    <button type="submit" name="submit" class="btn save-btn">Save</button>
                </div>
        </div>
    </section>
</body>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>
</script>
</html>