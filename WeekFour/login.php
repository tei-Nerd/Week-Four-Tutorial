<form method="post">
    Username: <input type="text" name="user"><br>
    Password: <input type="password" name="pass"><br>
    <button>Login</button>
</form>

<?php
if (!empty($_POST)) {
    $u = $_POST['user'];
    $p = $_POST['pass'];

    if ($u === "admin" && $p === "1234@admin") {
        echo "<h3>Welcome Admin</h3>";
    } else {
        echo "<p style='color:red;'>Invalid credentials</p>";
    }
}
?>
