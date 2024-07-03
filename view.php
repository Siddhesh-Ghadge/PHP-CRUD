<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body style="background: whitesmoke;">
    <div class="container mt-5">
<a class="btn btn-secondary mb-2" href="/php-CRUD/index.php">Back to List</a>
<?php
        // Check if ID is provided via GET request
        if(isset($_GET['id'])) {
            // Database connection

            $server_name = "localhost";
            $username = "root";  
            $dbname = "Users";    

            $conn = new mysqli($server_name, $username, "", $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute SQL query to fetch user data
            $id = $_GET['id'];
            $sql = "SELECT * FROM users WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($data = $result->fetch_assoc()) {
                    echo "
    <div class='card'>
    <span style='text-align:end;' >
    <a href='/php-CRUD/edit.php?id=$data[id]' class='btn btn-primary'><i class='bi bi-pen'></i></a>
    </span>
          
      <div class='card-body text-center'>
        <img src='$data[display_pic]' alt='Profile Image' class='rounded-circle mb-3' style='width: 150px; height: 150px;'>
        <h3 class='card-title'><mark> $data[name]</mark></h3>
        <p class='card-text'><strong>Gender:</strong> $data[gender]</p>
        <p class='card-text'><strong><i class='bi bi-geo-alt-fill'></i></strong> $data[address]</p>
        <h5 class='card-text'>Hobbies</h5>
        <b>$data[hobbies]</b>
        <p class='card-text text-end'>Last Updated at : <em> $data[reg_date]</em></p>
      </div>
    </div>
 ";
               
                }

               
            } else {
                echo "No user found with the provided ID.";
            }

            // Close database connection
            $conn->close();
        } else {
            echo "No ID provided.";
        }
        ?>



</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-p1/O1hgd0O8mIAAzlAvh5AOepI8+0Oj+aT+/FYxl3JZdfwJ41ET/E1BjKToUgfGb" crossorigin="anonymous"></script>
</body>
</html>
