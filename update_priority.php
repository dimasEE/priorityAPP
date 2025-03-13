<?php
// Set proper content type for JSON response
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Only POST requests are allowed']);
    exit;
}

// Get the raw POST data
$json = file_get_contents('php://input');

// Validate JSON
$data = json_decode($json);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Invalid JSON: ' . json_last_error_msg()]);
    exit;
}

// The file path to write to
$file = 'priority.json';

// Write the updated JSON to the file
$result = file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

if ($result === false) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'Failed to write to file. Check permissions.']);
    exit;
}

// Return success response
echo json_encode(['success' => true, 'message' => 'Data updated successfully']);
?>