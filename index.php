<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Voting System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #f4f4f4;
            color: #333;
        }

        /* NAVIGATION BAR */
        /* NAVIGATION BAR */
nav {
    background: rgba(0, 0, 0, 0.92);
    color: white;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.nav-container {
    max-width: 1200px;
    margin: auto;
    padding: 15px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.brand {
    font-size: 24px;
    font-weight: bold;
    color: #00bcd4;
    letter-spacing: 1px;
}

.nav-links {
    list-style: none;
    display: flex;
    gap: 25px;
}

.nav-links li a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    position: relative;
    padding: 5px 0;
    transition: color 0.3s ease;
}

.nav-links li a::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    height: 2px;
    width: 0%;
    background: #00bcd4;
    transition: width 0.3s;
}

.nav-links li a:hover {
    color: #00bcd4;
}

.nav-links li a:hover::after {
    width: 100%;
}

/* Mobile Menu */
#menu-toggle {
    display: none;
}

.menu-icon {
    display: none;
    font-size: 28px;
    cursor: pointer;
}

@media (max-width: 768px) {
    .nav-container {
        flex-wrap: wrap;
    }

    .menu-icon {
        display: block;
        color: white;
    }

    .nav-links {
        flex-direction: column;
        width: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.95);
        padding: 15px 0;
        margin-top: 15px;
        border-radius: 0 0 10px 10px;
    }

    #menu-toggle:checked + .menu-icon + .nav-links {
        display: flex;
    }

    .nav-links li {
        text-align: center;
        padding: 10px 0;
    }
}

        .hero {
            height: 100vh;
            background: url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            text-align: center;
            color: white;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            padding: 20px;
            animation: fadeIn 2s ease-in;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
        }

        .hero a {
            padding: 12px 30px;
            background: #00bcd4;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .hero a:hover {
            background: #0288a4;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        section {
            padding: 60px 20px;
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .steps {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .step {
            width: 300px;
            background: white;
            margin: 15px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .step:hover {
            transform: translateY(-10px);
        }

        /* Countdown */
        .countdown {
            display: flex;
            justify-content: center;
            gap: 30px;
            font-size: 24px;
            color: #333;
        }

        .countdown div {
            text-align: center;
        }

        /* Testimonials */
        .testimonials {
            background: #f0f8ff;
            padding: 60px 20px;
        }

        .testimonial-container {
            display: flex;
            gap: 20px;
            overflow-x: auto;
        }

        .testimonial {
            flex: 0 0 300px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            animation: fadeIn 1s ease;
        }

        .testimonial h4 {
            margin-bottom: 10px;
            color: #007BFF;
        }

        .testimonial p {
            font-size: 14px;
        }

        /* Contact */
        .contact form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 500px;
            margin: auto;
        }

        .contact input, .contact textarea {
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .contact button {
            background: #00bcd4;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background: #222;
            color: white;
        }

        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }

            .steps, .testimonial-container {
                flex-direction: column;
                align-items: center;
            }

            .countdown {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-container">
        <div class="brand">🗳️ eVote</div>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>
        <ul class="nav-links">
            <li><a href="#how">How It Works</a></li>
            <li><a href="#countdown">Countdown</a></li>
            <li><a href="#testimonials">Testimonials</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </div>
</nav>


    <div class="hero">
        <div class="hero-content">
            <h1>Welcome to the Online Voting System</h1>
            <p>Secure. Transparent. Easy to Use. Cast your vote with confidence from anywhere.</p>
            <a href="login.php">Get Started</a>
        </div>
    </div>

    <section id="how">
        <h2>How It Works</h2>
        <div class="steps">
            <div class="step">
                <h3>Step 1</h3>
                <p>Login or register to access the election dashboard.</p>
            </div>
            <div class="step">
                <h3>Step 2</h3>
                <p>Choose the ongoing election and view candidates.</p>
            </div>
            <div class="step">
                <h3>Step 3</h3>
                <p>Submit your vote securely and get confirmation instantly.</p>
            </div>
        </div>
    </section>

    <section id="countdown">
        <h2>Election Starts In</h2>
        <div class="countdown" id="timer">
            <div><span id="days">0</span><br>Days</div>
            <div><span id="hours">0</span><br>Hours</div>
            <div><span id="minutes">0</span><br>Minutes</div>
            <div><span id="seconds">0</span><br>Seconds</div>
        </div>
    </section>

    <section id="testimonials" class="testimonials">
        <h2>What Voters Say</h2>
        <div class="testimonial-container">
            <div class="testimonial">
                <h4>Rahul Verma</h4>
                <p>“It was the easiest voting experience I’ve ever had. Loved the transparency.”</p>
            </div>
            <div class="testimonial">
                <h4>Priya Sharma</h4>
                <p>“The system is secure and very intuitive. I was done in less than 2 minutes.”</p>
            </div>
            <div class="testimonial">
                <h4>Akash Mehta</h4>
                <p>“No queues, no travel — just a few clicks from home. Amazing!”</p>
            </div>
        </div>
    </section>

    <section id="contact" class="contact">
        <h2>Contact Us</h2>
        <form>
            <input type="text" placeholder="Your Name" required>
            <input type="email" placeholder="Your Email" required>
            <textarea rows="4" placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </section>

    <footer>
        &copy; <?= date('Y') ?> Online Voting System | All Rights Reserved
    </footer>

    <script>
        // Countdown Timer Script
        const endDate = new Date("June 30, 2025 23:59:59").getTime();

        const timer = setInterval(() => {
            const now = new Date().getTime();
            const diff = endDate - now;

            if (diff <= 0) {
                clearInterval(timer);
                document.getElementById("timer").innerHTML = "Election has started!";
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById("days").innerText = days;
            document.getElementById("hours").innerText = hours;
            document.getElementById("minutes").innerText = minutes;
            document.getElementById("seconds").innerText = seconds;
        }, 1000);
    </script>

</body>
</html>
