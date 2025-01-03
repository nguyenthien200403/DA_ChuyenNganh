<?php
    ob_start();
    session_start();
    if(isset($_SESSION['username'])) {
        header('Location: Admin/index.php');
    }
    ob_end_flush()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="text-center">Login</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button name="btn_submit" type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>

    <?php
        if(isset($_POST['btn_submit'])) {
            if(isset($_POST['username']) && isset($_POST['password'])) {
                
                $username = $_POST['username'];
                $password = $_POST['password'];
        
                $_SESSION['username'] = $username;
                // Hardcoded credentials for demonstration purposes
                $valid_username = 'admin';
                $valid_password = 'admin';
        
                if ($username === $valid_username && $password === $valid_password) {
                    echo '<div class="alert alert-success text-center">Login successful!</div>';
                    // Redirect to the admin page
                    header('Location: admin/home.php');
                    exit();
                } else {
                    echo '<div class="alert alert-danger text-center">Invalid username or password.</div>';
                }
                
            }
        }
    ?>
</body>
</html>