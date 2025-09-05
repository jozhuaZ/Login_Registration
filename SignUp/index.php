<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="styles.css">
    
    <title>Sign Up</title>
</head>
<body>
    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="error-message poppins-default">
            <p>
            <?php 
                echo htmlspecialchars($_SESSION['flash_error']); 
                unset($_SESSION['flash_error']); // remove session variable after showing msg
            ?>
            </p>
        </div>
    <?php endif; ?>
    
    <h1>Sign Up</h1>

    <form action="sign_up.php" method="post" id="signupForm">
        <!-- Step 1 -->
        <div class="form-step active poppins-default">
            <h2>Personal Information</h2>
            <label>First Name</label>
            <input type="text" name="firstname" required>
            <label>Middle Name</label>
            <input type="text" name="middlename" required>
            <label>Last Name</label>
            <input type="text" name="lastname" required>
            <label>Contact Number</label>
            <input type="text" name="contact_number" placeholder="09123456789" maxlength="11" required>
            <label>Address</label>
            <input type="text" name="address" placeholder="Where we first met" required>
        </div>

        <!-- Step 2 -->
        <div class="form-step poppins-default">
            <h2>Account Information</h2>
            <label>Email</label>
            <input type="email" name="email" placeholder="sample@email.com" required>
            <label>Username</label>
            <input type="text" name="username" placeholder="sampleuser" required>
        </div>

        <!-- Step 3 -->
        <div class="form-step poppins-default">
            <h2>Secure Yourself</h2>
            <ul>
                <h3>Create a strong password</h3>
                <li>Keep your personal info safe</li>
                <li>Protect your emails, files, and other content</li>
                <li>Prevent someone else from getting in to your account</li>
            </ul>
            <label>Password</label>
            <input type="password" id="password" name="password" required>
            <label>Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <p id="passwordError" class="error"></p>
        </div>

        <!-- Navigation -->
        <div class="form-navigation poppins-default">
            <button class="button-sign-up" type="button" id="prevBtn" disabled>Previous</button>
            <button class="button-sign-up" type="button" id="nextBtn">Next</button>
            <button class="button-sign-up" type="submit" id="submitBtn" style="display:none;">Submit</button>
        </div>

        <p class="link-text">Already have an account? <a href="../SignIn/index.php">Sign In</a> instead.</p>
    </form>

    <script>
        const steps = document.querySelectorAll(".form-step");
        const nextBtn = document.getElementById("nextBtn");
        const prevBtn = document.getElementById("prevBtn");
        const submitBtn = document.getElementById("submitBtn");
        const signupForm = document.getElementById("signupForm");
        const passwordInput = document.getElementById("password");
        const confirmPasswordInput = document.getElementById("confirm_password");
        const passwordError = document.getElementById("passwordError");

        let currentStep = 0;

        function showStep(step) {
            steps.forEach((s, index) => {
                s.classList.toggle("active", index === step);
            });
            prevBtn.disabled = step === 0;
            nextBtn.style.display = step === steps.length - 1 ? "none" : "inline-block";
            submitBtn.style.display = step === steps.length - 1 ? "inline-block" : "none";
        }

        nextBtn.addEventListener("click", () => {
            const inputs = steps[currentStep].querySelectorAll("input");
            for (let input of inputs) {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    return;
                }
            }
            currentStep++;
            showStep(currentStep);
        });

        prevBtn.addEventListener("click", () => {
            currentStep--;
            showStep(currentStep);
        });

        signupForm.addEventListener("submit", (e) => {
            if (passwordInput.value !== confirmPasswordInput.value) {
                e.preventDefault();
                passwordError.textContent = "Passwords do not match!";
                confirmPasswordInput.focus();
            } else {
                passwordError.textContent = "";
            }
        });

        showStep(currentStep);
    </script>
</body>
</html>
