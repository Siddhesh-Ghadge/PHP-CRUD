<?php
$server_name = "localhost";
$username = "root";  
$dbname = "Users";    

// Create connection
$conn = new mysqli($server_name, $username, "", $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user data based on ID
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $name = $data['name'];
        $display_pic = $data['display_pic'];
    } else {
        echo "User not found.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Delete user record
    $sql = "DELETE FROM users WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header("Location: /php-CRUD/index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .profile-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }
        .form-control-static {
            padding: 0.375rem 0.75rem;
            margin-bottom: 0;
            line-height: 1.5;
            color: #495057;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body style="background: whitesmoke;">
    <div class="container p-2" style="max-width: 500px; margin-top:10%;">
        <h4 class="text-danger text-center">Confirm Delete</h4>
        <p class="text-center">Are you sure you want to delete the following user?</p>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3 text-center">
                <label for="name" class="form-label"><strong>Name:</strong>
                <p class="form-control-static"><?php echo $name; ?></p></label>
               
            </div>
                <div class="mb-3 text-center">
                    <img src="<?php echo $display_pic; ?>" alt="Profile Image" class="profile-image">
                </div>
            <a href="/php-CRUD/index.php" class="btn btn-secondary float-start">No</a>
            <button type="submit" class="btn btn-danger float-end">Yes</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzq8Y5Rk1Uy5eD7U6H6A9tRSa4gHT9aPPh/nOkk0OxdE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-QGIRoyWhmZ7QbcG3n8I5uMIlp2N2Ts9pno6pbXYd1j9C2VFek/h0oeQ6TrR9kkmT" crossorigin="anonymous"></script>
</body>
</html>
