<?php
include_once '../../../../inc/settings.php';
include_once '../../../../inc/dbconnect.php';

// Get the compilation ID from the request
$compilationId = $_POST['id'];

// SQL Query to get the products
$sql = "SELECT products FROM compilations WHERE id = $compilationId";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // Output data of the first row (assuming ID is unique)
    $row = $result->fetch_assoc();
    echo $row['products'];
} else {
    echo "0 results";
}
$mysqli->close();