try {
    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );

    // Make PDO throw exceptions on errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // (Optional) fetch associative arrays by default
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Optional debug (remove in final submission)
    // echo "Connected to Supabase successfully!";

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
