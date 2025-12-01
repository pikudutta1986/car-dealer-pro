<?php
/**
 * Error Log Monitor
 * Simple script to view recent error logs
 * Access: /logs/monitor.php (for admin use only)
 */

// Security check - only allow admin access
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] == '') {
    http_response_code(403);
    die('Access denied. Admin login required.');
}

$logFile = __DIR__ . '/../logs/error.log';
$lines = 100; // Number of recent lines to show

if (isset($_GET['lines'])) {
    $lines = max(10, min(1000, (int)$_GET['lines']));
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Error Log Monitor - Car Dealer Pro</title>
    <style>
        body { font-family: 'Courier New', monospace; margin: 0; padding: 20px; background: #1e1e1e; color: #f0f0f0; }
        .header { background: #2d2d2d; padding: 15px; margin: -20px -20px 20px -20px; border-bottom: 2px solid #007acc; }
        .controls { margin-bottom: 20px; }
        .controls a { color: #007acc; text-decoration: none; margin-right: 15px; padding: 5px 10px; background: #333; border-radius: 3px; }
        .controls a:hover { background: #444; }
        .log-container { background: #000; padding: 15px; border-radius: 5px; max-height: 70vh; overflow-y: auto; }
        .log-line { margin: 2px 0; padding: 2px 0; }
        .log-line.error { color: #ff6b6b; }
        .log-line.warning { color: #ffd93d; }
        .log-line.notice { color: #6bcf7f; }
        .log-line.info { color: #4dabf7; }
        .timestamp { color: #888; }
        .no-logs { text-align: center; color: #666; padding: 50px; }
        .refresh-btn { background: #007acc; color: white; border: none; padding: 8px 15px; border-radius: 3px; cursor: pointer; }
        .refresh-btn:hover { background: #005a9e; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Error Log Monitor</h1>
        <p>Car Dealer Pro - Recent Error Logs</p>
    </div>
    
    <div class="controls">
        <a href="?lines=50">Last 50 lines</a>
        <a href="?lines=100">Last 100 lines</a>
        <a href="?lines=500">Last 500 lines</a>
        <button class="refresh-btn" onclick="location.reload()">Refresh</button>
        <span style="float: right; color: #888;">Showing last <?php echo $lines; ?> lines</span>
    </div>
    
    <div class="log-container">
        <?php
        if (file_exists($logFile)) {
            $logContent = file_get_contents($logFile);
            $logLines = explode("\n", $logContent);
            $recentLines = array_slice($logLines, -$lines);
            
            if (empty(array_filter($recentLines))) {
                echo '<div class="no-logs">No recent error logs found.</div>';
            } else {
                foreach ($recentLines as $line) {
                    if (trim($line) == '') continue;
                    
                    $cssClass = 'log-line';
                    if (strpos($line, 'Fatal Error') !== false || strpos($line, 'ERROR') !== false) {
                        $cssClass .= ' error';
                    } elseif (strpos($line, 'Warning') !== false || strpos($line, 'WARNING') !== false) {
                        $cssClass .= ' warning';
                    } elseif (strpos($line, 'Notice') !== false || strpos($line, 'NOTICE') !== false) {
                        $cssClass .= ' notice';
                    } else {
                        $cssClass .= ' info';
                    }
                    
                    // Extract timestamp
                    if (preg_match('/^\[([^\]]+)\]/', $line, $matches)) {
                        $timestamp = $matches[1];
                        $message = substr($line, strlen($matches[0]));
                        echo '<div class="' . $cssClass . '"><span class="timestamp">[' . $timestamp . ']</span> ' . htmlspecialchars($message) . '</div>';
                    } else {
                        echo '<div class="' . $cssClass . '">' . htmlspecialchars($line) . '</div>';
                    }
                }
            }
        } else {
            echo '<div class="no-logs">Error log file not found.</div>';
        }
        ?>
    </div>
    
    <script>
        // Auto-refresh every 30 seconds
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
