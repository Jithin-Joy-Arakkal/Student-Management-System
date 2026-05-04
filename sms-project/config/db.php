<?php
$host = "aws-1-ap-northeast-1.pooler.supabase.com";   // 🔁 your Supabase host
$dbname = "postgres";
$user = "postgres.ezlrihbweqznymvwkwxm";
$pass = "s4csa24101109";          // 🔁 your Supabase password


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
