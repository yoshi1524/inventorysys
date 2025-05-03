<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNVAX</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/land.css">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Brush+Script&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="assets/Untitled__1_-removebg-preview.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Parisienne&display=swap" rel="stylesheet">

</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="assets/Untitled__1_-removebg-preview.png" alt="BGMC">
            <h2>iNVAX</h2>
        </div>
                <ul class="nav-links">
                    <li><a href="landing.php"><img src="assets/building.png" alt="Home" title="Home"></a></li>
                    <li><a href="about.php"><img src="assets/think.png" alt="About Us" title="About Us"></a></li>
                    <li><a href="work.php"><img src="assets/info.png" alt="How It Works" title="How It Works"></a></li>
                    <li><a href="faq.php"><img src="assets/faq.png" alt="FAQs" title=" FAQs"></a></li>
                    <li><button onclick="openModal('loginModal')" class="login-btn">Login</button></li>
                    <li><button onclick="openModal('registrationModal')" class="login-btn">Add Account</button></li>

                </ul>
    </nav>
                        <div id="loginModal" class="modal">
                            <div class="modal-content">
                            <span class="close" onclick="closeModal('loginModal')">&times;</span>
                                <h2>Login</h2>
                                <form>
                                <label for="login-email">Email</label>
                                <input type="email" id="login-email" name="login-email" required>

                                <label for="login-password">Password</label>
                                <input type="password" id="login-password" name="login-password" required>

                                <button type="submit">Login</button>
                                </form>
                            </div>
                        </div>
                            <div id="registrationModal" class="modal">
                            <div class="modal-content">
                            <span class="close" onclick="closeModal('registrationModal')">&times;</span>
                                <h2>Register</h2>
                                <form>
                                <label for="fullname">Full Name</label>
                                <input type="text" id="fullname" name="fullname" required>

                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" required>

                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" required>

                                <button type="submit">Sign Up</button>
                                </form>
                            </div>
                        </div>

<!--tech logo-->
    <section class="huhu">
        <div class="content-g">
            <img src="assets/site-footer-shape-1.avif" alt="">
        </div>
        <div class="content-g">
            "REVOLUTIONIZE <br>
            <span>your</span>
            RESTAURANT'S INVENTORY MANAGEMENT"
            <p>Transform the way you track, manage, and optimize your restaurant's inventory—effortless, efficient, and future-ready</p>
        </div>
    </section>
    <!--footer-->
    <footer class="footer">
        <div class="footer-content">
                <p>&copy; 2025 iNVAX. All Rights Reserved.</p>
            <ul class="footer-links">
                <li><a href="#" onclick="openModal('privacyModal')">Privacy Policy</a></li>
                <li><a href="#" onclick="openModal('termsModal')">Terms of Service</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
    </footer>

    <!-- Privacy Policy Modal -->
<div id="privacyModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('privacyModal')">&times;</span>
        <h2>Privacy Policy</h2>
        <p>Welcome to Invexa! These Terms of Service outline the rules and regulations for using our restaurant inventory management platform. By accessing or using our service, you agree to comply with these terms. If you do not agree, please do not use our service."
<br>
** User Accounts & Responsibilities**
<br>
Users must provide accurate information when signing up.
Responsibilities for keeping account credentials secure.
What happens if someone misuses their account?
<br>Example:

"Users are responsible for maintaining the security of their accounts. Any activity conducted under their account will be their responsibility. If unauthorized access occurs, users must notify us immediately."
<br>
<strong>** Acceptable Use Policy**</strong>
<br>
Users cannot misuse the system (e.g., hacking, fraud, spam).
No illegal or prohibited activities.
Prohibited content (e.g., harmful, misleading, or offensive materials).
<br>Example:

"You agree not to misuse Invexa’s services, including engaging in fraudulent activities, hacking, distributing malware, or violating any laws."
<br>
** Payment & Subscription (If Applicable)**
<br>
Subscription details (monthly/yearly).
Refund policies and cancellations.
Late payments or failed transactions.
<br>Example:
"Payments are billed on a recurring basis. Users may cancel at any time, but no refunds will be provided for the remaining subscription period."
<br>
** Data Privacy & Security**
<br>
What data Invexa collects and how it is used.
How user data is protected.
Reference to the Privacy Policy.
<br>Example:

"Invexa collects and processes personal and business data to provide better inventory management. We do not sell user data to third parties. For more details, please see our Privacy Policy."
<br>
**Service Availability & Downtime**
<br>
Invexa does not guarantee 100% uptime.
Explanation of planned maintenance or system outages.
<br>Example:

"We strive to keep Invexa available 24/7. However, occasional downtime may occur due to maintenance, technical issues, or factors beyond our control."
<br>
**Intellectual Property**
<br>
Clarify that Invexa owns the software, branding, and content.
Users cannot copy, resell, or modify the platform.
<br>Example:

"All trademarks, service marks, and intellectual property on Invexa are owned by us. You may not copy, distribute, or modify any part of our platform without permission."
<br>
**Limitation of Liability**
<br>
Invexa is not responsible for business losses, errors, or financial damages caused by using the service.
<br>Example:

"Invexa is provided 'as is' without any warranties. We are not liable for any business losses, data inaccuracies, or service disruptions."
<br>
**Termination of Accounts**
<br>
Conditions under which Invexa can suspend or terminate accounts.
Violations of the terms that lead to account removal.
<br>Example:

"We reserve the right to suspend or terminate accounts that violate these Terms of Service, including fraudulent activity or misuse."
<br>
** Changes to Terms**
<br>
Invexa can update the Terms of Service.
Users will be notified of significant changes.
<br>Example:

"We may update these Terms from time to time. Continued use of Invexa after changes means you accept the updated terms."</p>
    </div>
</div>

<!-- Terms of Service Modal -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('termsModal')">&times;</span>
        <h2>Terms of Service</h2>
        <p>"Welcome to Invexa! These Terms of Service govern your use of our restaurant inventory management platform. By accessing our website, you agree to abide by these terms."
<br>
            🔹 2. User Responsibilities
            Explain what users can and cannot do on your platform.
            Prohibit illegal activities, hacking, misuse of the system, etc.
            <br>Example:
            "Users must not attempt to gain unauthorized access, misuse the platform, or violate any laws while using Invexa's services."
            <br>
            🔹 3. Account Registration & Security
            If users need to register, explain the process.
            State that users must provide accurate information.
            Warn against sharing login credentials.
           <br> Example:
            "Users are responsible for maintaining the confidentiality of their accounts. Any unauthorized use should be reported immediately."
            <br>
            🔹 4. Payments & Subscription (If Applicable)
            If you offer paid plans, mention pricing, billing, refunds, and cancellations.
            State whether fees are refundable or not.
            <br>Example:
            "Subscription fees are billed monthly. Refunds are not provided unless stated otherwise."
            <br>
            🔹 5. Intellectual Property Rights
            State that all content, logos, and software belong to Invexa.
            Prohibit users from copying, distributing, or modifying the website’s content.
           <br> Example:
            "All trademarks, logos, and content on this website are the exclusive property of Invexa. Unauthorized use is strictly prohibited."
            <br>
            🔹 6. Termination of Accounts
            Describe when and why you can ban or suspend users.
            Mention violations such as fraud, abuse, or breaking your terms.
           <br> Example:
            "Invexa reserves the right to terminate or suspend any account that violates our Terms of Service without prior notice."
            <br>
            🔹 7. Limitation of Liability
            Protect your business from lawsuits if something goes wrong.
            State that you’re not responsible for service interruptions, data loss, etc.
           <br> Example:
            "Invexa is not liable for any damages, data loss, or disruptions resulting from the use of our services."
            <br>
            🔹 8. Privacy Policy
            Mention that users must also agree to your Privacy Policy.
            Link to your Privacy Policy for handling user data.
           <br> Example:
            "By using our platform, you also agree to our Privacy Policy, which explains how we collect and use your data."
            <br>
            🔹 9. Governing Law
            Mention which country’s laws apply in case of legal issues.
           <br> Example:
            "These Terms of Service are governed by the laws of [Your Country/State]. Any disputes must be resolved in the courts of [Your Location]."
            <br>
            🔹 10. Changes to These Terms
            State that you can update the Terms and users should check for changes.
           <br> Example:
            "Invexa may update these Terms at any time. Continued use of our services after changes means acceptance of the new terms."</p>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }
    
    // Close modal if user clicks outside of it
    window.onclick = function(event) {
        let modals = document.querySelectorAll(".modal");
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    };
    function openModal(id) {
  document.getElementById(id).style.display = "block";
}

function closeModal(id) {
  document.getElementById(id).style.display = "none";
}

// Optional: Close modal when clicking outside of it
window.onclick = function(event) {
  const loginModal = document.getElementById("loginModal");
  const registrationModal = document.getElementById("registrationModal");

  if (event.target === loginModal) {
    loginModal.style.display = "none";
  } else if (event.target === registrationModal) {
    registrationModal.style.display = "none";
  }
};
</script>
    
</body>
</html>