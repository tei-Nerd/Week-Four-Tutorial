<form method="post">
    Enter a sentence: <input type="text" name="sentence">
    <button>Count</button>
</form>

<?php
if (isset($_POST['sentence'])) {
    $s = strtolower($_POST['sentence']);
    $vowels = 0;
    $chars = ['a', 'e', 'i', 'o', 'u'];

    for ($i = 0; $i < strlen($s); $i++) {
        if (in_array($s[$i], $chars)) {
            $vowels++;
        }
    }

    echo "Total vowels: $vowels";
}
?>
