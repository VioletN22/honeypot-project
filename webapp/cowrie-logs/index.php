<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violet's Honeypot Logs</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Violet's Honeypot Logs</h1>

    <nav>
        <ul>
            <li><a href="#login-attempts">Login Attempts</a></li>
            <li><a href="common_user_pass.php">Common Usernames and Passwords</a></li>
            <li><a href="#charts">Charts & Trends</a></li>
        </ul>
    </nav>

    <h2>Cowrie.log (Text Logs)</h2>

    <pre>
        <?php echo file_get_contents('cowrie.log'); ?>
    </pre>

    <h2>Cowrie.json (Structured Logs)</h2>
    <pre>
        <?php echo file_get_contents('cowrie.json'); ?>
    </pre>

    <h2>Login Attempts</h2>
    
        <div class = "table-container">
            <table>
                <thead>
                    <tr>
                        <th class = "time-column">Time</th>
                        <th class = "username-column">Username</th>
                        <th class = "password-column">Password</th>
                        <th class = "source-ip-column">Source IP</th>
                        <th class = "success-column">Success</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                // Database connection settings
                $servername = "localhost";
                $username = "cowrie_user";  // Your DB username
                $password = "Violet1234*";  // Your DB password
                $dbname = "honeypot_logs";  // Your database name

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to retrieve log data
                $sql = "SELECT * FROM login_attempts ORDER BY timestamp DESC LIMIT 100";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row in table rows
                    while($row = $result->fetch_assoc()) {
                        $row_class = $row["success"] ? "success-row" : "";  // Add class if success is Yes
                        echo "<tr class='" . htmlspecialchars($row_class) . "'>";
                        echo "<td>" . htmlspecialchars($row["timestamp"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["password"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["src_ip"]) . "</td>";
                        echo "<td>" . ($row["success"] ? "Yes" : "No") . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No logs found</td></tr>";
                }

                // Close the connection
                $conn->close();
                ?>
                </tbody>
            </table>
        </div>
        <h2 id="charts">Charts & Trends (Coming Soon)</h2>
</body>
</html>
