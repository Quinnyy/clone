<?php
    include("scripts/Header.php");
    ?>
    <main>
        <form action="register" method="post">
            <input type="text" name="email" placeholder="email"></br>
            <input type="text" name="username" placeholder="username"></br>
            <input type="password" name="password" placeholder="password"></br>
            <p><input type="submit" value="Submit"></p>
        </form>
    </main>

    <?
    include("scripts/Footer.php");

        //ini_set('display_errors', 1);
        //ini_set('display_startup_errors', 1);
        //error_reporting(E_ALL);

        include("scripts/dbconnect.php");

        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (checkUsers($username, $db)) {
            $sql = "INSERT INTO port_users (email, username, password) VALUES ('$email', '$username', '$password')";

            if (mysqli_query($db, $sql)) {
                echo "New record created succesfully";

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            }

            mysqli_close($db);
        } elseif ($email == '' || $username == '' || $password == ''){
            echo "Please enter an email, username and password";
        }
        else{
            echo "User already exists";
        }

        function checkUsers($username, $db)
        {
            $sql = "SELECT username FROM port_users";
            $result = mysqli_query($db, $sql);

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                if ($row['username'] == $username) {
                    return false;
                }
            }
            return true;
        }
?>