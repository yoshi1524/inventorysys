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
            <li><a href="landing.html"><img src="assets/building.png" alt="Home" title="Home"></a></li>
                    <li><a href="about.html"><img src="assets/think.png" alt="About Us" title="About Us"></a></li>
                    <li><a href="work.html"><img src="assets/info.png" alt="How It Works" title="How It Works"></a></li>
                    <li><a href="faq.html"><img src="assets/faq.png" alt="FAQs" title=" FAQs"></a></li>
        </ul>
    </nav>

    <!-- FAQ Section -->
    <section class="faq">
        <h1>Frequently Asked Questions</h1>
        <div class="faq-container">

            <div class="faq-item">
                <button class="faq-question">What is Invax? <span>+</span></button>
                <div class="faq-answer">
                    <p>Invax is an AI-powered inventory management system designed for restaurants to track stock levels, reduce waste, and optimize operations.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">How does Invax help restaurants? <span>+</span></button>
                <div class="faq-answer">
                    <p>Invax automates inventory tracking, provides real-time analytics, and offers AI-powered suggestions to reduce costs and improve efficiency.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">Can I access Invax on mobile? <span>+</span></button>
                <div class="faq-answer">
                    <p>Yes! Invax is fully responsive and accessible from desktops, tablets, and smartphones.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">Does Invax integrate with other software? <span>+</span></button>
                <div class="faq-answer">
                    <p>Yes, Invax integrates with popular POS systems and accounting software for seamless operations.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">How much does it cost? <span>+</span></button>
                <div class="faq-answer">
                    <p>Invax offers flexible pricing plans based on your restaurant size. Visit our Pricing page for details.</p>
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
