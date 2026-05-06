<?php
/**
 * PHP Configuration Check
 * 
 * This will show you what PHP extensions are available
 * DELETE THIS FILE after checking!
 */

echo "<h2>PHP Configuration Check</h2>";
echo "<hr>";

// PHP Version
echo "<h3>PHP Version</h3>";
echo "<p><strong>Version:</strong> " . phpversion() . "</p>";
echo "<hr>";

// Check Database Extensions
echo "<h3>Database Extensions</h3>";

$extensions = [
    'pdo' => 'PDO (PHP Data Objects)',
    'pdo_mysql' => 'PDO MySQL Driver',
    'mysqli' => 'MySQLi Extension',
    'mysql' => 'MySQL Extension (deprecated)',
];

echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>Extension</th><th>Status</th></tr>";

foreach ($extensions as $ext => $name) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? '✓ Loaded' : '✗ Not Loaded';
    $color = $loaded ? 'green' : 'red';
    echo "<tr>";
    echo "<td>$name</td>";
    echo "<td style='color: $color; font-weight: bold;'>$status</td>";
    echo "</tr>";
}

echo "</table>";
echo "<hr>";

// Recommendation
echo "<h3>Recommendation</h3>";

if (extension_loaded('pdo') && extension_loaded('pdo_mysql')) {
    echo "<p style='color: green;'>✓ PDO and PDO MySQL are available. Use the standard includes/db.php</p>";
} elseif (extension_loaded('mysqli')) {
    echo "<p style='color: orange;'>⚠ Only MySQLi is available. You need to:</p>";
    echo "<ol>";
    echo "<li>Use fix-charset-mysqli.php instead of fix-database-charset.php</li>";
    echo "<li>Contact hosting provider to enable PDO MySQL extension</li>";
    echo "<li>Or modify your code to use MySQLi instead of PDO</li>";
    echo "</ol>";
} else {
    echo "<p style='color: red;'>✗ No MySQL extensions are available!</p>";
    echo "<p>Contact your hosting provider immediately to enable either:</p>";
    echo "<ul>";
    echo "<li>PDO with PDO MySQL driver (recommended)</li>";
    echo "<li>MySQLi extension</li>";
    echo "</ul>";
}

echo "<hr>";

// Other useful extensions
echo "<h3>Other Important Extensions</h3>";

$other_extensions = [
    'mbstring' => 'Multibyte String',
    'json' => 'JSON',
    'session' => 'Session',
    'fileinfo' => 'File Info (for uploads)',
    'gd' => 'GD (image processing)',
];

echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>Extension</th><th>Status</th></tr>";

foreach ($other_extensions as $ext => $name) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? '✓ Loaded' : '✗ Not Loaded';
    $color = $loaded ? 'green' : 'red';
    echo "<tr>";
    echo "<td>$name</td>";
    echo "<td style='color: $color; font-weight: bold;'>$status</td>";
    echo "</tr>";
}

echo "</table>";
echo "<hr>";

// Full PHP Info (commented out for security)
echo "<h3>Full PHP Info</h3>";
echo "<p><a href='?phpinfo=1'>Click here to view full PHP info</a></p>";

if (isset($_GET['phpinfo'])) {
    phpinfo();
}

echo "<hr>";
echo "<p style='color: red; font-weight: bold;'>⚠ DELETE THIS FILE AFTER CHECKING!</p>";
?>
