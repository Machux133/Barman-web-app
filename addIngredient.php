<?php 
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bar";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ingredient_name'])) {
        $ingredient_name = mysqli_real_escape_string($conn, $_POST['ingredient_name']);
        $sql = "INSERT INTO ingredients (name) VALUES ('$ingredient_name')";
        if (mysqli_query($conn, $sql)) {
            echo "New ingredient added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_id'])) {
        $delete_id = intval($_POST['delete_id']);
        $sql = "DELETE FROM ingredients WHERE id = $delete_id";
        if (mysqli_query($conn, $sql)) {
            echo "Ingredient deleted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

$ingredients = [];
$sql = "SELECT id, name FROM ingredients";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $ingredients[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Add Ingredient</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='ingredient.css'>
    <script src='main.js'></script>
</head>
<body>
    <form method="POST" action="">
        <label for="ingredient_name">Ingredient Name:</label>
        <input type="text" id="ingredient_name" name="ingredient_name" required>
        <input type="submit" value="Add Ingredient">
    </form>

    <h2>Current Ingredients</h2>
    <ul>
        <?php foreach ($ingredients as $ingredient): ?>
            <li>
                <?php echo htmlspecialchars($ingredient['name']); ?>
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?php echo $ingredient['id']; ?>">
                    <input type="submit" value="Remove">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php"><input type="button" value="Back"></a>
</body>
</html>
