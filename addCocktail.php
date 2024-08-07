<?php 
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bar";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && isset($_POST['ingredients']) && isset($_POST['recipe'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $ingredients_array = $_POST['ingredients']; // Array of ingredient IDs
        $ingredients = implode(',', $ingredients_array); // Convert array to comma-separated string
        $ingredients = mysqli_real_escape_string($conn, $ingredients); // Escape the comma-separated string
        $recipe = mysqli_real_escape_string($conn, $_POST['recipe']);
        
        // Insert the cocktail into the cocktails table
        $sql = "INSERT INTO cocktails (name, ingredients, recipe) VALUES ('$name', '$ingredients', '$recipe')";
        if (mysqli_query($conn, $sql)) {
            echo "Cocktail added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Fetch all ingredients to show in the form
$ingredients = [];
$sql = "SELECT id, name FROM ingredients";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ingredients[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Add Cocktail</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='cocktail.css'>
    <script src='main.js'></script>
</head>
<body>
    <h2>Add Cocktail</h2>
    <form method="POST" action="">
        <label for="name">Cocktail Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="ingredients">Ingredients:</label><br>
        <?php foreach ($ingredients as $ingredient): ?>
            <input type="checkbox" id="ingredient_<?php echo $ingredient['id']; ?>" name="ingredients[]" value="<?php echo $ingredient['id']; ?>">
            <label for="ingredient_<?php echo $ingredient['id']; ?>"><?php echo htmlspecialchars($ingredient['name']); ?></label><br>
        <?php endforeach; ?><br>
        
        <label for="recipe">Recipe:</label><br>
        <textarea id="recipe" name="recipe" required></textarea><br><br>
        
        <input type="submit" value="Add Cocktail">
    </form>
    <a href="index.php"><input type="button" value="Back"></a>
</body>
</html>
