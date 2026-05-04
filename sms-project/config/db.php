<?php
$host = "aws-1-ap-northeast-1.pooler.supabase.com";   // 🔁 replace with your host
$dbname = "postgres";
$user = "postgres.ezlrihbweqznymvwkwxm";
$pass = "s4csa24101109";          // 🔁 replace

try {
    $conn = new PDO(
        "pgsql:host=$host;port=5432;dbname=$dbname;sslmode=require",
        $user,
        $pass
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
