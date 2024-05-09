<?php 

// Database configuration
//$host = 'db'; // This should match the service name defined in your docker-compose.yml
//$dbname = 'php_docker';
//$username = 'php_docker';
//$password = 'php_docker';
//$table_name = "php_docker_table";

// Connect to MySQL database
$connect = mysqli_connect('db', 'php_docker', 'passwordpassword', 'php_docker');
$table_name = "phTest";
// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define your query
$query = "SELECT * FROM $table_name";

// Execute the query
$response = mysqli_query($connect, $query);

// Check if query executed successfully
if ($response) {
    echo "<strong>$table_name:</strong>";
    
    // Fetch and display data
    while ($row = mysqli_fetch_assoc($response)) {
        echo "<p>Title: " . $row['title'] . "</p>";
        echo "<p>Body: " . $row['body'] . "</p>";
        echo "<p>Date Created: " . $row['day_created'] . "</p>";
    }
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($connect);
}

// Close the connection
mysqli_close($connect);
?>
