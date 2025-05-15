<?php
session_start();
include('../db.php');

// Ensure only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $electionId = $_GET['id'];

    try {
        // Start a transaction to ensure integrity
        $pdo->beginTransaction();

        // Delete all votes associated with the election
        $stmt = $pdo->prepare("DELETE FROM votes WHERE election_id = ?");
        $stmt->execute([$electionId]);

        // Now delete the election
        $stmt = $pdo->prepare("DELETE FROM elections WHERE id = ?");
        $stmt->execute([$electionId]);

        // Commit the transaction
        $pdo->commit();

        $_SESSION['message'] = "Election deleted successfully!";
        header('Location: view_elections.php'); // Redirect to view elections page
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        $pdo->rollBack();
        $_SESSION['message'] = "Error: Could not delete election. Please try again.";
    }
}
?>
