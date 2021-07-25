<?php

if(file_exists(stream_resolve_include_path('../../config.php'))) {
    require_once('../../config.php');
}
if(file_exists(stream_resolve_include_path('../config.php'))) {
    require_once('../config.php');
}

global $CONFIG;

$conn = mysqli_connect(
    $CONFIG->server_name,
    $CONFIG->db_username,
    $CONFIG->db_password,
    $CONFIG->db_name
);

if(!$conn)
{
    die("Nie udało się połączyć z bazą: " . mysqli_connect_error());
}
