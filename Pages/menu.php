<?php
session_start();

// Database configuration
include("../db.php");

// Check if a search query is set
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query
$query = "SELECT * FROM cuisine_items";
if (!empty($searchQuery)) {
    $query .= " WHERE cuisine_type LIKE ?";
}

// Prepare statement
$stmt = mysqli_prepare($conn, $query);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die("Prepare failed: " . mysqli_error($conn));
}

// Bind parameters if search query is present
if (!empty($searchQuery)) {
    $searchParam = '%' . $searchQuery . '%';
    mysqli_stmt_bind_param($stmt, "s", $searchParam);
}

// Execute the statement
mysqli_stmt_execute($stmt);

// Get result
$result = mysqli_stmt_get_result($stmt);

// Check if result retrieval was successful
if ($result === false) {
    die("Execute failed: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Styles/header.css">
  <link rel="stylesheet" href="../Styles/menu.css" />
  <link rel="stylesheet" href="../Styles/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <title>The Gallery Café - Menu</title>
</head>
<body>
  <!-- header section -->
  <?php include ("../Components/header.php"); ?>

    <!-- search bar -->
    <div class="search-container">
        <form method="GET" action="menu.php">
            <input type="text" name="search" id="search-input" placeholder="Search by cuisine type (e.g., Sri Lankan, Chinese)" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <?php if (!empty($searchQuery)): ?>
           
    <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="search-item" data-cuisine="' . htmlspecialchars($row['cuisine_type']) . '">';
                        echo '<h2>' . htmlspecialchars($row['cuisine_type']) . '</h2>';
                        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>.....No cuisine-type found.....!</p>';
                }
                ?>
            </div>
        <?php endif; ?>

  <!-- menu-container -->
  <div class="menu-container">
    <h1>Our Menu</h1>


    <a href="./beverages.php" style="text-decoration: none;">
      <div id="beverages" class="menu-section">
        <h2>Beverages</h2>
      </div>
    </a>

    <!-- generate menu items here -->
    <div id="menu-items" class="menu-items"></div>


    <!-- cuisine items -->
    <div class="cuisine-grid">
    
      <?php 
      $allCuisinesQuery = "SELECT * FROM cuisine_items";
      $allCuisinesResult = $conn->query($allCuisinesQuery);

      while ($cuisine = $allCuisinesResult->fetch_assoc()): ?>
        <div class="cuisine-item" onclick="showCuisine('<?php echo htmlspecialchars(strtolower($cuisine['cuisine_type'])); ?>')">
          <img src="data:image/jpeg;base64,<?php echo base64_encode($cuisine['image']); ?>" alt="<?php echo htmlspecialchars($cuisine['cuisine_type']); ?>" />
          <h2><?php echo htmlspecialchars($cuisine['cuisine_type']); ?></h2>
        </div>
      <?php endwhile; ?>
    </div>  
    </div>

  <!-- footer-section -->
  <?php include ("../Components/footer.php"); ?>

  <script src="../Scripts/menu.js"></script>
</body>

</html>