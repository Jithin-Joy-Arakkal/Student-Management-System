<?php
$conn = pg_connect("host=localhost dbname=sms user=postgres password=1234");

if(!$conn){
    die("Connection failed: " . pg_last_error());
}
?>