<form method="post">
    Full Name: <input type="text" name="full"><br>
    Email: <input type="text" name="email"><br>
    <button>Submit</button>
</form>

<?php
if (!empty($_POST)) {
    if ($_POST['full'] == "" || $_POST['email'] == "") {
        echo "<p style='color:red;'>Error: All fields are required!</p>";
    } else {
        echo "<p style='color:green;'>All good!</p>";
    }
}
?>
