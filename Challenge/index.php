<?php
$result = "";
$name = "";
$email = "";
$message = "";
$rating = "5";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submittedName = trim($_POST["name"] ?? "");
    $submittedEmail = trim($_POST["email"] ?? "");
    $submittedMessage = trim($_POST["message"] ?? "");
    $submittedRating = trim($_POST["rating"] ?? "5");

    if ($submittedName === "" || $submittedEmail === "" || $submittedMessage === "" || $submittedRating === "") {
        $result = "<div class='alert error'><p>Please go back and fill in all fields.</p></div>";
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
    <style>
        :root {
            --bg-gradient-start: #0f172a;
            --bg-gradient-end: #1e1b4b;
            --card-bg: rgba(255, 255, 255, 0.85);
            --card-border: rgba(255, 255, 255, 0.4);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --primary-glow: rgba(99, 102, 241, 0.3);
            --input-bg: rgba(248, 250, 252, 0.8);
            --input-border: #cbd5e1;
            --error-bg: rgba(254, 242, 242, 0.9);
            --error-border: #fecaca;
            --error-text: #dc2626;
            --success-bg: rgba(240, 253, 244, 0.9);
            --success-border: #bbf7d0;
            --success-text: #166534;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
            color: var(--text-main);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .wrapper {
            width: 100%;
            max-width: 540px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .container {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            transition: transform 0.3s ease;
        }

        .container:hover {
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.2) inset;
        }

        .header-content {
            text-align: center;
            margin-bottom: 32px;
        }

        h1 {
            font-size: 1.75rem;
            margin: 0 0 8px 0;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.025em;
        }

        .subtitle {
            font-size: 0.925rem;
            color: var(--text-muted);
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 8px;
            color: #334155;
            letter-spacing: 0.01em;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 12px 16px;
            background-color: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            font-size: 0.95rem;
            color: var(--text-main);
            box-sizing: border-box;
            font-family: inherit;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        input:hover, select:hover, textarea:hover {
            border-color: #94a3b8;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px var(--primary-glow);
        }

        textarea {
            resize: vertical;
            min-height: 110px;
        }

        #error {
            color: var(--error-text);
            font-size: 0.825rem;
            margin-top: 6px;
            font-weight: 500;
            min-height: 18px;
        }

        button[type="submit"] {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, #4338ca 100%);
            color: white;
            border: none;
            padding: 14px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px var(--primary-glow);
            margin-top: 8px;
        }

        button[type="submit"]:hover {
            background: linear-gradient(135deg, #4f46e5 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        button[type="submit"]:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px var(--primary-glow);
        }

        /* Feedback / Alert Cards Styling */
        .alert.error {
            background-color: var(--error-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--error-border);
            color: var(--error-text);
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            font-weight: 500;
            animation: shake 0.4s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        }

        .success-card {
            background: var(--success-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--success-border);
            color: var(--success-text);
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(22, 101, 52, 0.1);
            animation: fadeIn 0.5s ease-out forwards;
        }

        .success-icon {
            width: 36px;
            height: 36px;
            background-color: #22c55e;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 12px;
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.3);
        }

        .success-card h2 {
            margin: 0 0 4px 0;
            font-size: 1.25rem;
            color: #14532d;
        }

        .submission-meta {
            font-size: 0.775rem;
            color: #3f6212;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        blockquote {
            background: rgba(255, 255, 255, 0.6);
            border-left: 4px solid #22c55e;
            margin: 12px 0;
            padding: 12px 16px;
            border-radius: 0 8px 8px 0;
            font-style: italic;
            color: #1e293b;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-3px, 0, 0); }
            40%, 60% { transform: translate3d(3px, 0, 0); }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="container">
        <div class="header-content">
            <h1>Mekamaxxedd Feedback Hub</h1>
            <p class="subtitle">We value your experience. Let us know your thoughts!</p>
        </div>

        <?php if (!empty($result) && str_contains($result, 'alert error')) echo $result; ?>

        <form id="feedback" method="post" action="">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" name="name" id="name" placeholder="e.g. Meka Maxxedd">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" name="email" id="email" placeholder="e.g. maxxedd@meka.com">
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

            <p id="error"></p>

            <button type="submit">Send Feedback</button>
        </form>
    </div>

    <?php if (!empty($result) && str_contains($result, 'success-card')) echo $result; ?>
</div>

<script>
const form = document.querySelector("#feedback");
const error = document.querySelector("#error");

form.addEventListener("submit", (e) => {
    const name = document.querySelector("#name").value.trim();
    const email = document.querySelector("#email").value.trim();
    const message = document.querySelector("#message").value.trim();

    error.textContent = "";

    if (name === "" || email === "" || message === "") {
        e.preventDefault(); 
        error.textContent = "Please fill in all fields.";
    } else if (!email.includes("@")) {
        e.preventDefault();
        error.textContent = "Please enter a valid email address.";
    } else if (message.length < 10) {
        e.preventDefault();
        error.textContent = "Your message must be at least 10 characters long.";
    }
});
</script>

</body>
</html>