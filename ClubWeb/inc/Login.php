 <?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include("scripts/header.php");
    ?>
    <main>
        <form action="login" method="post">
            <input type="text" name="username" placeholder="username"></br>
            <input type="password" name="password" placeholder="password"></br>
            <p><input type="submit" value="Submit"></p>
        </form>
    </main>
    <?
    include("scripts/footer.php");
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("scripts/dbconnect.php");
    $username = $_POST["username"];
    $password = $_POST["password"];

    function checklogin($username, $password, $db)
    {
        $sql = "SELECT * FROM port_users WHERE username='" . $username . "' and
password='" . $password . "'";
        $result = $db->query($sql);
        while ($row = $result->fetch_array()) {
            return true;
        }
        return false;
    }
    function checkAccessLevel($username,$db)
    {
            $access = "SELECT access_LevelID FROM port_users WHERE username = '$username'";
            $ID = $db->query($access);
            while ($row = $ID->fetch_array()) {
                return true;
            }
            return false;
    }

    if (checkAccessLevel($username, $password, $db)) {
        session_start();
        $_SESSION['accessLevelID'] = $accessLevel;
    }
    
    if (checklogin($username, $password, $db)) {
        session_start();
        $_SESSION['username'] = $username;
        session_write_close();
        header("location:./");
    } else {
        header("location:login");
    }

} else {
// this is impossible
    print('whoops');
}
?>