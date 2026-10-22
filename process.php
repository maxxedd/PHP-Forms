<?php
// Initialize variables for form preservation & results
$result = "";
$name = "";
$email = "";
$message = "";
$rating = "5";

// Only process when form is submitted via POST[cite: 3]
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submittedName = trim($_POST["name"] ?? "");
    $submittedEmail = trim($_POST["email"] ?? "");
    $submittedMessage = trim($_POST["message"] ?? "");
    $submittedRating = trim($_POST["rating"] ?? "5");

    // Server-side validation[cite: 2]
    if ($submittedName === "" || $submittedEmail === "" || $submittedMessage === "" || $submittedRating === "") {
        $result = "<div class='alert error'><p>Please go back and fill in all fields.</p></div>";
        // Retain values if validation fails (sticky form)[cite: 3]
        $name = $submittedName;
        $email = $submittedEmail;
        $message = $submittedMessage;
        $rating = $submittedRating;
    } elseif (!filter_var($submittedEmail, FILTER_VALIDATE_EMAIL) && !str_contains($submittedEmail, '@')) {
        $result = "<div class='alert error'><p>Please enter a valid email address.</p></div>";
        $name = $submittedName;
        $email = $submittedEmail;
        $message = $submittedMessage;
        $rating = $submittedRating;
    } elseif (mb_strlen($submittedMessage) < 10) {
        $result = "<div class='alert error'><p>Your message must be at least 10 characters long.</p></div>";
        $name = $submittedName;
        $email = $submittedEmail;
        $message = $submittedMessage;
        $rating = $submittedRating;
    } else {
        // Successful submission: Build summary with current date[cite: 2, 3]
        $currentDate = date("F j, Y, g:i a");
        
        $result = "
        <div class='success-card'>
            <div class='success-icon'>✓</div>
            <h2>Thank you, " . htmlspecialchars($submittedName) . "!</h2>
            <p class='submission-meta'>Submitted on: <strong>" . htmlspecialchars($currentDate) . "</strong></p>
            <p>We received your message:</p>
            <blockquote>\"" . nl2br(htmlspecialchars($submittedMessage)) . "\"</blockquote>
            <p style='margin-top: 12px;'><strong>Rating given:</strong> " . htmlspecialchars($submittedRating) . " / 5 ⭐</p>
            <p>We will reply to <strong>" . htmlspecialchars($submittedEmail) . "</strong>.</p>
        </div>";
        
        // Input fields remain blank ($name, $email, $message are empty strings) as requested!
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Hub - ICT123 Lab 5</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="wrapper">
    <div class="container">
        <div class="header-content">
            <h1>Feedback Hub</h1>
            <p class="subtitle">We value your experience. Let us know your thoughts!</p>
        </div>

        <!-- Show error alerts if validation fails -->
        <?php if (!empty($result) && str_contains($result, 'alert error')) echo $result; ?>

        <!-- Form posts to itself (process.php) -->
        <form id="feedback" method="post" action="process.php">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>" placeholder="e.g. Alex Smith">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" name="email" id="email" value="<?= htmlspecialchars($email) ?>" placeholder="e.g. alex@example.com">
            </div>

            <div class="form-group">
                <label for="message">Message (at least 10 characters)</label>
                <textarea name="message" id="message" placeholder="Type your feedback here..."><?= htmlspecialchars($message) ?></textarea>
            </div>

            <div class="form-group">
                <label for="rating">Satisfaction Rating</label>
                <select name="rating" id="rating">
                    <option value="5" <?= ($rating == '5') ? 'selected' : '' ?>>5 ⭐ - Excellent</option>
                    <option value="4" <?= ($rating == '4') ? 'selected' : '' ?>>4 ⭐ - Very Good</option>
                    <option value="3" <?= ($rating == '3') ? 'selected' : '' ?>>3 ⭐ - Good</option>
                    <option value="2" <?= ($rating == '2') ? 'selected' : '' ?>>2 ⭐ - Fair</option>
                    <option value="1" <?= ($rating == '1') ? 'selected' : '' ?>>1 ⭐ - Poor</option>
                </select>
            </div>

            <!-- Client-side error message placeholder -->
            <p id="error"></p>

            <button type="submit">Send Feedback</button>
        </form>
    </div>

    <!-- Thank You Card displayed BELOW the form card upon successful submission -->
    <?php if (!empty($result) && str_contains($result, 'success-card')) echo $result; ?>
</div>

<script src="app.js"></script>
</body>
</html>