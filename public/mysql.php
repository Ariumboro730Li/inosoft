<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "100Jutaperbulan", "apotek_khozin");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Execute the query
$sql = "SELECT * FROM detail_pembelian LIMIT 1000";
$result = mysqli_query($conn, $sql);
// var_dump(mysqli_fetch_assoc($result));
// exit();

// Fetch rows as associative arrays
while ($row = mysqli_fetch_assoc($result)) {
    if ($row["id_detail"] == 1) {
        echo "id_detail: " . $row["id_detail"] . ", : " . $row["id_pasien"] . "<br>";
    }

    var_dump($row["id_detail"], 2);

    if ($row["id_detail"] === 2) {
        echo $row["id_detail"];
    }
}

// Close the connection
mysqli_close($conn);

?>
