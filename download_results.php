<?php
session_start();
include('../db.php');

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Set headers to download file as CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=results.csv');

// Output buffer
$output = fopen('php://output', 'w');

// Write CSV column headers
fputcsv($output, ['Candidate Name', 'Vote Count']);

// Fetch results
$stmt = $pdo->query("
    SELECT c.name, COUNT(v.id) AS vote_count
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    GROUP BY c.id
    ORDER BY vote_count DESC
");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [$row['name'], $row['vote_count']]);
}

fclose($output);
exit();
