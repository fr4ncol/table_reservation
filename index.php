<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Reservation</title>
</head>
<body>
    <h2>Table Reservation</h2>

    <?php
    // Database connection parameters
    $host = 'localhost';
    $dbname = 'test1';
    $username = 'postgres';
    $password = 'kupadupa';

    // Connect to the PostgreSQL database
    $db = pg_connect("host=$host dbname=$dbname user=$username password=$password");

    if (!$db) {
        die("Error: Unable to connect to the database.");
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle form submission for adding reservations
        $name = $_POST['name'];
        $email = pg_escape_string($_POST['email']);
        $date = pg_escape_string($_POST['date']);
        $time = pg_escape_string($_POST['time']);

        // Insert reservation data into the 'reservations' table
        $query = "INSERT INTO reservations (name, email, reservation_date, reservation_time) VALUES ('$name', '$email', '$date', '$time')";
        $result = pg_query($db, $query);

        if (!$result) {
            echo "Error: Unable to add reservation.";
        }
    }

    // Handle search form submission
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
        $searchName = $_GET['search'];

        // Search for reservations by name
        $searchQuery = "SELECT * FROM reservations WHERE name LIKE '%$searchName%'";
        $searchResult = pg_query($db, $searchQuery);

        if (!$searchResult) {
            echo "Error: Unable to perform search.";
        } else {
            $searchResults = pg_fetch_all($searchResult);
        }
    }
    ?>

    <!-- Form for adding reservations -->
    <form method="post" action="" autocomplete="off">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="time">Time:</label>
        <input type="time" name="time" required><br>

        <input type="submit" value="Submit">
    </form>

    <!-- Form for searching reservations by name -->
    <form method="get" action="" autocomplete="off">
        <label for="search">Search by Name:</label>
        <input type="text" name="search" required>
        <input type="submit" value="Search">
    </form>

    <?php
    // Display search results
    if (isset($searchResults)) {
        echo "<h3>Search Results:</h3>";
        echo "<ul>";
        foreach ($searchResults as $result) {
            echo "<li>{$result['name']} - {$result['email']} - {$result['reservation_date']} {$result['reservation_time']}</li>";
        }
        echo "</ul>";
    }

    // Display all reservations from the 'reservations' table
    $queryAll = "SELECT * FROM reservations";
    $resultAll = pg_query($db, $queryAll);

    if (!$resultAll) {
        echo "Error: Unable to fetch all reservations.";
    } else {
        $reservations = pg_fetch_all($resultAll);
        echo "<h3>All Reservations:</h3>";
        echo "<ul>";
        foreach ($reservations as $reservation) {
            echo "<li>{$reservation['name']} - {$reservation['email']} - {$reservation['reservation_date']} {$reservation['reservation_time']}</li>";
        }
        echo "</ul>";
    }

    // Close the database connection
    pg_close($db);
    ?>
</body>
</html>
