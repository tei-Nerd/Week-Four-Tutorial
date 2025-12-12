<form method="post">
    Enter a word: <input type="text" name="word">
    <button>Reverse</button>
</form>

<?php
if (isset($_POST['word'])) {
    $w = $_POST['word'];
    $rev = "";

    for ($i = strlen($w) - 1; $i >= 0; $i--) {
        $rev .= $w[$i];
    }

    echo "Reversed: $rev";
}
?>