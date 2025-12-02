<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? trim($_GET['country']) : '';
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

if ($lookup === 'cities') {
    if (!empty($country)) {
        $stmt = $conn->prepare("
            SELECT cities.name AS city_name, cities.district, cities.population, countries.name AS country_name
            FROM cities 
            INNER JOIN countries ON cities.country_code = countries.code 
            WHERE countries.name LIKE :country
            ORDER BY cities.population DESC
        ");
        $stmt->execute(['country' => '%' . $country . '%']);
    }else{
        $stmt = $conn->query("
            SELECT cities.name AS city_name, cities.district, cities.population, countries.name AS country_name
            FROM cities 
            INNER JOIN countries ON cities.country_code = countries.code 
            ORDER BY cities.population DESC
        ");
    }
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    if (count($results) > 0) {
      if (!empty($country)) {
          echo '<h3>Cities in countries matching "' . htmlspecialchars($country) . '"</h3>';
      }else{
          echo '<h3>All Cities</h3>';
      }
        echo '<table class="cities-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>District</th>';
        echo '<th>Population</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
            
        foreach ($results as $row) {
          echo '<tr>';
          echo '<td>' . htmlspecialchars($row['city_name']) . '</td>';
          echo '<td>' . htmlspecialchars($row['district']) . '</td>';
          echo '<td>' . number_format($row['population']) . '</td>';
          echo '</tr>';
        }
            
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No cities found.</p>';
    }
} else {
    if (!empty($country)) {
        $stmt = $conn->prepare("
            SELECT name, continent, independence_year, head_of_state 
            FROM countries 
            WHERE name LIKE :country
            ORDER BY name
        ");
        $stmt->execute(['country' => '%' . $country . '%']);
    } else {
        $stmt = $conn->query("
            SELECT name, continent, independence_year, head_of_state 
            FROM countries 
            ORDER BY name
        ");
    }
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($results) > 0) {
        if (!empty($country)) {
            echo '<h3>Countries matching "' . htmlspecialchars($country) . '"</h3>';
        } else {
            echo '<h3>All Countries</h3>';
        }
        
        echo '<table class="countries-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>Continent</th>';
        echo '<th>Independence</th>';
        echo '<th>Head of State</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['continent']) . '</td>';
            echo '<td>' . ($row['independence_year'] ? htmlspecialchars($row['independence_year']) : '—') . '</td>';
            echo '<td>' . ($row['head_of_state'] ? htmlspecialchars($row['head_of_state']) : '—') . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No countries found</p>';
    }
}
?>