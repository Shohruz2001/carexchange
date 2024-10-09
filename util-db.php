<?php
function get_db_connection(){
    // Create connection
    $conn = new mysqli('mis4013sj-db.mysql.database.azure.com', 'sjmis4013', 'password1!', 'my_mis4013database');
    
    // Check connection
    if ($conn->connect_error) {
      return false;
    }
    return $conn;
}
?>
