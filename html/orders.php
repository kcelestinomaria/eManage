<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Now - Gourmet Delights</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Include Header -->
    <?php include '../includes/header.html'; ?>

    <div class="container">
        <main>
            <h1>Order Now</h1>
            <form action="orders.php" method="post">
                <label for="item">Menu Item:</label>
                <select id="item" name="item" required>
                    <option value="starter">Starter</option>
                    <option value="main_course">Main Course</option>
                    <option value="dessert">Dessert</option>
                </select>
                <br>
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
                <br>
                <label for="details">Details:</label>
                <textarea id="details" name="details" required></textarea>
                <br>
                <input type="submit" value="Place Order">
            </form>
        </main>
    </div>

    <!-- Include Footer -->
    <?php include '../includes/footer.html'; ?>
</body>
</html>