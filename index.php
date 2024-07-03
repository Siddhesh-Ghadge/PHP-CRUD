<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body style="background: whitesmoke;">

<div class="container my-4 text-center">
    <h4 class="text-success">List of Users</h4>
    <a href="./create.php" class="btn btn-warning float-end mb-4"> + New User</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th></th>
                <th>Name</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Address</th>
                <th>Hobbies</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        <?php
        $server_name = "localhost";
        $username = "root";
        $database = "Users";

        // Create Connection
        $con = new mysqli($server_name, $username, "", $database);

        
        // Check Connection
        if($con->connect_error){
            die("Connection Failed ! " . $con->connect_error);
        }
      
        // Fetch Data from DB
        $sql = "SELECT * FROM Users";
        $result = $con->query($sql);

        if(!$result) {
            die("Invalid Query " . $con->connect_error);
        }

        // read data 

        if($result->num_rows == 0){

            echo '<div style="text-align: center; margin-top: 50px; background:red; color:#fff"><strong>Enter User Details first</strong></div>';

        }

        else {
            while($data = $result->fetch_assoc()){
                echo "
                <tr>
                    <td>$data[id]</td>
                    <td><img src='$data[display_pic]' height=70 width=80 style='border-radius:50%;'></img></td>
                    <td>$data[name]</td>
                    <td>$data[gender]</td>
                    <td>$data[dob]</td>
                    <td>$data[address]</td>
                    <td>$data[hobbies]</td>
                    <td>
                    <a href='/php-CRUD/view.php?id=$data[id]' class='btn btn-sm'><i class='bi bi-eye'></i></a> |
                    <a href='/php-CRUD/edit.php?id=$data[id]' class='btn btn-sm text-primary'><i class='bi bi-pen'></i></a> |
                    <a href='/php-CRUD/delete.php?id=$data[id]' class='btn btn-sm text-danger'><i class='bi bi-trash'></i></a>
                    </td>
                </tr>
                ";
            }
        }

   


        ?>
            
        </tbody>
    </table>
</div>

<!-- <footer class="footer">
    <h5>Developed by <a target="_blank" href="https://github.com/Hrishikesh-Bhorde">Hrishikesh Bhorde</a></h5>
</footer> -->
    
</body>
</html>