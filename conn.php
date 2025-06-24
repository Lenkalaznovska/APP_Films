<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Vytvoření připojení
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Nastavení znakového kódování na UTF-8
$conn->set_charset("utf8");

// Kontrola připojení
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Funkce pro načtení jednoho záznamu jako asociativní pole
function fetchAssoc($sql, $conn) {
    $result = mysqli_query($conn, $sql);
    if ($result) {
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        return null;
    }
}

// Funkce pro načtení jednoho záznamu jako numerické pole
function fetch($sql, $conn) {
    $result = mysqli_query($conn, $sql);
    if ($result) {
        return mysqli_fetch_array($result, MYSQLI_NUM);
    } else {
        return null;
    }
}

// Funkce pro načtení všech záznamů jako asociativní pole
function fetchAll($sql, $conn) {
    $result = mysqli_query($conn, $sql);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Funkce pro vykonání SQL dotazu (např. INSERT, UPDATE, DELETE)
function akce($sql, $conn) {
    return mysqli_query($conn, $sql);
}
?>
