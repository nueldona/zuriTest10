<?php 
include './config.php';
$conn = db();
$sql = "CREATE TABLE students (
    id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    full_names VARCHAR(120) NOT NULL,
    email VARCHAR(60) NOT Null,
    gender VARCHAR(10),
    country VARCHAR(32) NOT NULL,
    password VARCHAR(25) NOT NULL
    -- data_of_birth TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn) {
    if (mysqli_query($conn, $sql)) {
        echo "students table created successfully";
    }else {
        echo "Error creating students table: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>