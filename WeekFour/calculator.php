<form method="post">
    Number 1: <input type="number" name="n1"><br>
    Number 2: <input type="number" name="n2"><br>
    Operation (add/subtract/multiply/divide): 
    <input type="text" name="op">
    <button>Calculate</button>
</form>

<?php
if (!empty($_POST)) {
    $a = $_POST['n1'];
    $b = $_POST['n2'];
    $op = $_POST['op'];

    switch ($op) {
        case "add": echo $a + $b; break;
        case "subtract": echo $a - $b; break;
        case "multiply": echo $a * $b; break;
        case "divide": echo $b != 0 ? $a / $b : "Cannot divide by zero"; break;
        default: echo "Invalid Operation";
    }
}
?>
