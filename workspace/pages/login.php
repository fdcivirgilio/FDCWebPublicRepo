<?php
if (array_key_exists('username', $_POST)) {
    if (isset($_POST["username"])) {
        
        $result = $db->sql->query("
            select * from user 
            where 
            user_name = '{$_POST['username']}'");
        
        // - if has data, get user info and login!
        if ($result->num_rows > 0) {
            $user = $result->fetch_all(MYSQLI_ASSOC);
            $password = password_verify(trim($_POST["password"]), $user[0]["password"]);
            if (!$password) {
                echo "password is wrong!!";
                die();
                
            }
            
            // set login to true
            $_SESSION["is_logged_in"] = true;
            $_SESSION["user_id"] = $user[0]['user_id'];
            $_SESSION["user_name"] = $user[0]['user_name'];
            $_SESSION["first_name"] = $user[0]['first_name'];
            $_SESSION["last_name"] = $user[0]['last_name'];
            $_SESSION["last_login_time"] = time();
           
            // redirect to another page
            echo "<script>
                window.location.href = '?page=home';
            </script>";
            die();

        } else {
            echo "ID: {$_POST["username"]} does not exist!";
        }

    } else {
        echo "Invalid username or password";
    }
}
?>
<style>
    .container-fluid {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
    .container {
        width: 100px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>

<div class="container-fluid">
    <div class="container">
        <h2>Login Form</h2>
        <form action="?page=login" method="POST">
            <div class="form-group">
                <label for="username">User Name:</label>
                <input type="text" class="form-control" name="username" placeholder="Enter User Name">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

