<?php
if (
    array_key_exists('username', $_POST)
) {
    if (isset($_POST["username"])) {

        $result = $db->sql->query("
            select * from users 
            where 
                username = '{$_POST['username']}'
        ");

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
            $_SESSION["user_id"] = $user[0]['id'];
            $_SESSION["username"] = $user[0]['username'];
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


<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" action="?page=login" method="POST">
      <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
        <div class="mt-2">
          <input id="email" name="username" type="text" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
  
        </div>
        <div class="mt-2">
          <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
      No account?
      <a href="?page=register" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Sign up</a>
    </p>
    
  </div>
</div>
