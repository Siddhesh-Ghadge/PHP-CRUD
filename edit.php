<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background: whitesmoke;">
    <div class="container mt-2 p-2">
        <h4 class="text-success text-center">Edit User</h4>

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

        // Fetch user data based on ID
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM users WHERE id='$id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $name = $data['name'];
                $gender = $data['gender'];
                $dob = $data['dob'];
                $address = $data['address'];
                $hobbies_array = explode(", ", $data['hobbies']);
                $display_pic = $data['display_pic'];
            } else {
                echo "User not found.";
                exit();
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $dob = $_POST['dob'];
            $address = $_POST['address'];
            $hobbies = implode(", ", $_POST['hobbies']); // Convert hobbies array to string

            // Handle file upload if a new file is selected
            if (!empty($_FILES["profile_img"]["tmp_name"])) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["profile_img"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["profile_img"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["profile_img"]["size"] > 500000) { // 500 KB
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file)) {
                        $display_pic = $target_file;
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }

            // Update data in database
            $sql = "UPDATE users SET name='$name', gender='$gender', dob='$dob', address='$address', hobbies='$hobbies', display_pic='$display_pic' WHERE id='$id'";

            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
                header("Location: /php-CRUD/index.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
        ?>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>

            <div class="row">
                <!-- Gender -->
                <div class="mb-3 col-md-6">
                    <label class="form-label">Gender:</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="male" name="gender" value="Male" <?php if ($gender == 'Male') echo 'checked'; ?> required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="female" name="gender" value="Female" <?php if ($gender == 'Female') echo 'checked'; ?> required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
                <!-- Date of Birth -->
                <div class="mb-3 col-md-6">
                    <label for="dob" class="form-label">Date of Birth:</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $dob; ?>" required>
                </div>
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="4"><?php echo $address; ?></textarea>
            </div>

            <!-- Hobbies -->
            <div class="mb-3">
                <label for="hobbies" class="form-label">Hobbies: <small class="text-success">(ctrl + click for multiple selection)</small></label>
                <select class="form-select" id="hobbies" name="hobbies[]" multiple required>
                    <option value="Reading" <?php if (in_array("Reading", $hobbies_array)) echo 'selected'; ?>>Reading</option>
                    <option value="Traveling" <?php if (in_array("Traveling", $hobbies_array)) echo 'selected'; ?>>Traveling</option>
                    <option value="Swimming" <?php if (in_array("Swimming", $hobbies_array)) echo 'selected'; ?>>Swimming</option>
                    <option value="Gaming" <?php if (in_array("Gaming", $hobbies_array)) echo 'selected'; ?>>Gaming</option>
                    <option value="Cooking" <?php if (in_array("Cooking", $hobbies_array)) echo 'selected'; ?>>Cooking</option>
                    <option value="Gardening" <?php if (in_array("Gardening", $hobbies_array)) echo 'selected'; ?>>Gardening</option>
                    <option value="Photography" <?php if (in_array("Photography", $hobbies_array)) echo 'selected'; ?>>Photography</option>
                    <option value="Writing" <?php if (in_array("Writing", $hobbies_array)) echo 'selected'; ?>>Writing</option>
                    <option value="Drawing" <?php if (in_array("Drawing", $hobbies_array)) echo 'selected'; ?>>Drawing</option>
                    <option value="Painting" <?php if (in_array("Painting", $hobbies_array)) echo 'selected'; ?>>Painting</option>
                    <option value="Hiking" <?php if (in_array("Hiking", $hobbies_array)) echo 'selected'; ?>>Hiking</option>
                    <option value="Cycling" <?php if (in_array("Cycling", $hobbies_array)) echo 'selected'; ?>>Cycling</option>
                    <option value="Fishing" <?php if (in_array("Fishing", $hobbies_array)) echo 'selected'; ?>>Fishing</option>
                    <option value="Crafting" <?php if (in_array("Crafting", $hobbies_array)) echo 'selected'; ?>>Crafting</option>
                    <option value="Dancing" <?php if (in_array("Dancing", $hobbies_array)) echo 'selected'; ?>>Dancing</option>
                    <option value="Singing" <?php if (in_array("Singing", $hobbies_array)) echo 'selected'; ?>>Singing</option>
                    <option value="Watching Movies" <?php if (in_array("Watching Movies", $hobbies_array)) echo 'selected'; ?>>Watching Movies</option>
                </select>
            </div>

            <!-- Profile Image -->
            <div class="mb-3">
                <label for="profile_img" class="form-label">Profile Image: <small class="text-success">(File must be under 500 KB)</small></label>
                <input type="file" class="form-control" id="profile_img" name="profile_img" accept=".png, .jpg, .jpeg">
                <?php if (!empty($display_pic)) { ?>
                    <p>Current Image: <br><img src="<?php echo $display_pic; ?>" alt="Profile Image" width="100"></p>
                <?php } ?>
            </div>

            <button type="submit" class="btn btn-warning">Save Changes</button>
            <a href="/php-CRUD/index.php" class="btn btn-secondary float-end">Back to List</a>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzq8Y5Rk1Uy5eD7U6H6A9tRSa4gHT9aPPh/nOkk0OxdE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-QGIRoyWhmZ7QbcG3n8I5uMIlp2N2Ts9pno6pbXYd1j9C2VFek/h0oeQ6TrR9kkmT" crossorigin="anonymous"></script>
</body>
</html>
