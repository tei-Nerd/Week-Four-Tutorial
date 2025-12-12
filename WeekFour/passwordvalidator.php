<form method="post">
Password: <input type="password" name="pass">
<button>Check</button>
</form>

<?php
if (isset($_POST['pass'])) {
    $p = $_POST['pass'];
    $errors = [];

    if (strlen($p) < 8) $errors[] = "Minimum 8 characters required";
    if (!preg_match('/[0-9]/', $p)) $errors[] = "Must include at least one number";
    if (!preg_match('/[\W]/', $p)) $errors[] = "Must include at least one special character";

    if (empty($errors)) {
        echo "<p style='color:green;'>Password is Strong!</p>";
    } else {
        foreach ($errors as $e) {
            echo "<p style='color:red;'>$e</p>";
        }
    }
}
?>
