<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? $_GET['country'] : '';

if (!empty($country)) {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => '%' . $country . '%']);
} else {
    $stmt = $conn->query("SELECT * FROM countries");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<ul>
<?php if (count($results) > 0): ?>
    <?php foreach ($results as $row): ?>
        <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
    <?php endforeach; ?>
<?php else: ?>
    <li>No countries found.</li>
<?php endif; ?>
</ul>