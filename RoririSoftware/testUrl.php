<?php
// Assume you have the full URL from the $_SERVER array or any URL
$fullUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Parse the URL
$parsedUrl = parse_url($fullUrl);

// Get different components
$scheme = $parsedUrl['scheme']; // http or https
$host = $parsedUrl['host']; // example.com
$path = $parsedUrl['path']; // /path/to/page
$query = $parsedUrl['query'] ?? ''; // Query string, if present

echo "Protocol: " . $scheme . "<br>";
echo "Host: " . $host . "<br>";
echo "Path: " . $path . "<br>";
echo "Query: " . $query . "<br>";
?>
