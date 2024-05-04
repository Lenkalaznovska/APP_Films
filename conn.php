<?php
// Nastavení připojení k databázi
$servername = "localhost"; 
$username = ""; 
$password = ""; 
$dbname = "filmy"; 

// Připojení k databázi pomocí MySQLi
$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); // Nastavení kódování pro UTF-8

// Kontrola, zda bylo připojení úspěšné
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Funkce pro získání asociativního pole výsledků dotazu
function fetchAssoc($sql, $conn) {
    $result = mysqli_query($conn, $sql);
    $pole = mysqli_fetch_array($result, MYSQLI_ASSOC);
    return $pole;
}

// Funkce pro získání indexovaného pole výsledků dotazu
function fetch($sql, $conn) {
    $result = mysqli_query($conn, $sql);
    $pole = mysqli_fetch_array($result, MYSQLI_NUM);
    return $pole;
}

// Funkce pro získání všech výsledků dotazu jako asociativního pole
function fetchAll($sql, $conn) {
    $result = mysqli_query($conn, $sql);
    $pole = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $pole;
}

// Funkce pro provedení akce v databázi (insert, update, delete)
function akce($sql, $conn) {
    if (mysqli_query($conn, $sql)) {
        return true; // Úspěšné provedení akce
    } else {
        return false; // Neúspěšné provedení akce
    }
}
?>
