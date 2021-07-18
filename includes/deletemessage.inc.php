<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
$idwalk = $_GET["idwalk"];
$idmessage = $_GET["idmessage"];
deleteMessage($conn,$idwalk,$idmessage);