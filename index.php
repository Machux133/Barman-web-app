<?php 
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bar";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ingredient_id'])) {
        $ingredient_id = intval($_POST['ingredient_id']);
        
        // Check if the ingredient is already in the available_ingredients table
        $check_sql = "SELECT * FROM available_ingredients WHERE ingredient_id = $ingredient_id";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) == 0) {
            // Insert the ingredient into available_ingredients table
            $sql = "INSERT INTO available_ingredients (ingredient_id) VALUES ($ingredient_id)";
            if (mysqli_query($conn, $sql)) {
                echo "Ingredient added to available ingredients.";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Ingredient is already available.";
        }
    } elseif (isset($_POST['remove_available_id'])) {
        $remove_available_id = intval($_POST['remove_available_id']);
        
        // Delete the ingredient from the available_ingredients table
        $sql = "DELETE FROM available_ingredients WHERE id = $remove_available_id";
        if (mysqli_query($conn, $sql)) {
            echo "Ingredient removed from available ingredients.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Fetch all ingredients
$ingredients = [];
$sql = "SELECT id, name FROM ingredients";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ingredients[] = $row;
    }
}

// Fetch available ingredients
$available_ingredients = [];
$sql = "SELECT ai.id as available_id, i.name as name, i.id as ingredient_id 
        FROM available_ingredients ai
        JOIN ingredients i ON ai.ingredient_id = i.id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $available_ingredients[] = $row;
    }
}

// Fetch cocktails
$cocktails = [];
$sql = "SELECT id, name, ingredients, recipe FROM cocktails";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cocktails[] = $row;
    }
}

// Get list of available ingredient IDs
$available_ingredient_ids = array_column($available_ingredients, 'ingredient_id');

// Filter cocktails that can be made with available ingredients
$makeable_cocktails = [];
foreach ($cocktails as $cocktail) {
    $cocktail_ingredient_ids = explode(',', $cocktail['ingredients']);
    if (!array_diff($cocktail_ingredient_ids, $available_ingredient_ids)) {
        $makeable_cocktails[] = $cocktail;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Available Ingredients and Cocktails</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='index.css'>
    <script src='main.js'></script>
</head>
<body>
    <a href="addIngredient.php"><input type="button" value="Add Ingredient"></a>
    <a href="addCocktail.php"><input type="button" value="Add Cocktail"></a>
    <h2>Ingredients</h2>
    <ul>
        <?php foreach ($ingredients as $ingredient): ?>
            <li>
                <?php echo htmlspecialchars($ingredient['name']); ?>
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="ingredient_id" value="<?php echo $ingredient['id']; ?>">
                    <input type="submit" value="Add to Available">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Available Ingredients</h2>
    <ul>
        <?php foreach ($available_ingredients as $available): ?>
            <li>
                <?php echo htmlspecialchars($available['name']); ?>
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="remove_available_id" value="<?php echo $available['available_id']; ?>">
                    <input type="submit" value="Remove">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Makeable Cocktails</h2>
    <ul>
        <?php foreach ($makeable_cocktails as $cocktail): ?>
            <li>
                <strong><?php echo htmlspecialchars($cocktail['name']); ?></strong>
                <p><?php echo htmlspecialchars($cocktail['recipe']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
