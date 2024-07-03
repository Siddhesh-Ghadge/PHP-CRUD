<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background: whitesmoke;">
    <div class="container mt-2 p-2">
        <h4 class="text-success text-center">Create a new User</h4>
        <form method="post" enctype="multipart/form-data">
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
            </div>

            <div class="row">
                <!-- Gender -->
                <div class="mb-3 col-md-6">
                    <label class="form-label">Gender:</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="male" name="gender" value="Male" required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="female" name="gender" value="Female" required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
                <!-- Date of Birth -->
                <div class="mb-3 col-md-6">
                    <label for="dob" class="form-label">Date of Birth:</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                </div>
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="4" required></textarea>
            </div>

            <!-- Hobbies -->
            <div class="mb-3">
                <label for="hobbies" class="form-label">Hobbies: <small class="text-success">(ctrl + click for multiple selection)</small></label>
                <select class="form-select" id="hobbies" name="hobbies[]" multiple required>
                    <option value="Reading">Reading</option>
                    <option value="Traveling">Traveling</option>
                    <option value="Swimming">Swimming</option>
                    <option value="Gaming">Gaming</option>
                    <option value="Cooking">Cooking</option>
                    <option value="Gardening">Gardening</option>
                    <option value="Photography">Photography</option>
                    <option value="Writing">Writing</option>
                    <option value="Drawing">Drawing</option>
                    <option value="Painting">Painting</option>
                    <option value="Hiking">Hiking</option>
                    <option value="Cycling">Cycling</option>
                    <option value="Fishing">Fishing</option>
                    <option value="Crafting">Crafting</option>
                    <option value="Dancing">Dancing</option>
                    <option value="Singing">Singing</option>
                    <option value="Watching Movies">Watching Movies</option>
                </select>
            </div>

            <!-- Profile Image -->
            <div class="mb-3">
                <label for="profile_img" class="form-label">Profile Image: <small class="text-success">(File must be under 500 KB)</small></label>
                <input type="file" class="form-control" id="profile_img" name="profile_img" accept=".png, .jpg, .jpeg" required>
            </div>

            <button type="submit" class="btn btn-warning">+ Create</button>
            <button type="reset" class="btn btn-danger">Reset</button>
            <a href="/php-CRUD/index.php" class="btn btn-secondary float-end">Back to List</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzq8Y5Rk1Uy5eD7U6H6A9tRSa4gHT9aPPh/nOkk0OxdE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-QGIRoyWhmZ7QbcG3n8I5uMIlp2N2Ts9pno6pbXYd1j9C2VFek/h0oeQ6TrR9kkmT" crossorigin="anonymous"></script>
</body>
</html>

<?php
ob_start();

$server_name = "localhost";
$username = "root";  
$dbname = "Users";    


$conn = new mysqli($server_name, $username, "", $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $hobbies = implode(", ", $_POST['hobbies']); 


    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    $check = getimagesize($_FILES["profile_img"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }


    if ($_FILES["profile_img"]["size"] > 500000) { // 500 KB
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

  
    if ($uploadOk == 0) {
        echo "\n Sorry, your file was not uploaded.";

    } else {
        if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file)) {
            // File upload successful, insert data into database
            $sql = "INSERT INTO users (name, gender, dob, address, hobbies, display_pic)
            VALUES ('$name', '$gender', '$dob', '$address', '$hobbies', '$target_file')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                header("Location: /php-CRUD/index.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $conn->close();
}

?>
