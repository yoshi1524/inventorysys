<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - iNVAX</title>
    <link rel="stylesheet" href="assets/faq.css">
    <link rel="shortcut icon" href="assets/Untitled__1_-removebg-preview.png" type="image/x-icon">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="assets/Untitled__1_-removebg-preview.png" alt="INVEXA Logo">
            <span>iNVAX</span>
        </div>
        <ul class="nav-links">
            <li><a href="landing.php"><img src="assets/building.png" alt="Home" title="Home"></a></li>
                    <li><a href="about.php"><img src="assets/think.png" alt="About Us" title="About Us"></a></li>
                    <li><a href="work.php"><img src="assets/info.png" alt="How It Works" title="How It Works"></a></li>
                    <li><a href="faq.php"><img src="assets/faq.png" alt="FAQs" title=" FAQs"></a></li>
        </ul>
    </nav>

    <!-- FAQ Section -->
    <section class="faq">
        <h1>Frequently Asked Questions</h1>
        <div class="faq-container">

            <div class="faq-item">
                <button class="faq-question">What is Invax? <span>+</span></button>
                <div class="faq-answer">
                    <p>Invax is an inventory management system designed for restaurants to track stock levels, reduce waste, and optimize operations.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">How does Invax help restaurants? <span>+</span></button>
                <div class="faq-answer">
                    <p>Invax automates inventory tracking, provides real-time analytics, and offers suggestions to reduce costs and improve efficiency.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">Does Invax integrate with other software? <span>+</span></button>
                <div class="faq-answer">
                    <p>No, Invax is a stand-alone system that does not integrate with popular POS systems and accounting software for seamless operations.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">Does it promote Data Integrity and Security Features? <span>+</span></button>
                <div class="faq-answer">
                <p>Yes, iNVAX implements user access controls, audit logs, and secure authentication to ensure data integrity and protect sensitive restaurant information.</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Invax. All Rights Reserved.</p>
    </footer>

    <script>
        // Toggle FAQ Answers
        document.querySelectorAll(".faq-question").forEach(button => {
            button.addEventListener("click", () => {
                const answer = button.nextElementSibling;
                const isActive = answer.classList.contains("active");

                // Close all other answers
                document.querySelectorAll(".faq-answer").forEach(a => a.classList.remove("active"));
                document.querySelectorAll(".faq-question span").forEach(s => s.textContent = "+");

                // Toggle current one
                if (!isActive) {
                    answer.classList.add("active");
                    button.querySelector("span").textContent = "-";
                }
            });
        });
    </script>

</body>
</html>
