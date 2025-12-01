<?php
/**
 * Error Log Cleanup Script
 * Removes old error log entries to prevent log files from growing too large
 * Run this via cron job or manually
 */

$logFile = __DIR__ . '/error.log';
$maxSize = 10 * 1024 * 1024; // 10MB
$maxLines = 10000; // Keep last 10,000 lines

if (file_exists($logFile)) {
    $fileSize = filesize($logFile);
    $lines = file($logFile);
    
    echo "Current log file size: " . number_format($fileSize / 1024, 2) . " KB\n";
    echo "Current log lines: " . count($lines) . "\n";
    
    if ($fileSize > $maxSize || count($lines) > $maxLines) {
        // Keep only the last $maxLines
        $recentLines = array_slice($lines, -$maxLines);
        
        // Write back to file
        file_put_contents($logFile, implode('', $recentLines));
        
        echo "Log file cleaned up. Kept last " . count($recentLines) . " lines.\n";
        echo "New file size: " . number_format(filesize($logFile) / 1024, 2) . " KB\n";
    } else {
        echo "Log file is within limits. No cleanup needed.\n";
    }
} else {
    echo "Error log file not found.\n";
}
?>
