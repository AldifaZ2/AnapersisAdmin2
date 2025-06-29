<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- CSS STYLES --- */
        :root {
            --primary-color: #4f46e5; /* indigo-600 */
            --secondary-color: #9333ea; /* purple-600 */
            --background-color: #f9fafb; /* gray-50 */
            --text-color: #1f2937; /* gray-800 */
            --box-color: #eef2ff; /* indigo-50 */
            --box-border-color: #c7d2fe; /* indigo-200 */
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            overflow: hidden;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
            position: relative;
        }

        .main-content h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .main-content h2 {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .main-content p {
            font-size: clamp(0.9rem, 2.5vw, 1.1rem);
            line-height: 1.6;
            margin-bottom: 2rem;
            color: #4b5563; /* gray-600 */
        }
        
        /* --- The Interactive Box --- */
        .box-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 2rem auto;
            cursor: pointer;
            perspective: 1000px; /* For 3D transformations */
        }
        
        .box {
            width: 100%;
            height: 100%;
            position: absolute;
            transform-style: preserve-3d;
            transition: transform 0.5s ease-in-out;
        }
        
        .box:hover {
            transform: translateY(-10px);
        }
        
        .box-face {
            position: absolute;
            width: 200px;
            height: 200px;
            background-color: var(--box-color);
            border: 2px solid var(--box-border-color);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .front  { transform: translateZ(100px); }
        .back   { transform: translateZ(-100px) rotateY(180deg); }
        .right  { transform: rotateY(90deg) translateZ(100px); }
        .left   { transform: rotateY(-90deg) translateZ(100px); }
        .bottom { transform: rotateX(-90deg) translateZ(100px); }

        /* The box top/lid */
        .top { 
            transform: rotateX(90deg) translateZ(100px);
            transform-origin: bottom;
            transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Bouncy transition */
        }

        /* --- Box Tape & Label --- */
        .tape {
            position: absolute;
            background-color: rgba(209, 213, 219, 0.6); /* gray-300 with opacity */
            width: 60px;
            height: 220px;
            top: -10px;
            left: 70px;
            transform: rotateZ(90deg);
        }
        
        .fragile-sticker {
            position: absolute;
            width: 100px;
            height: 60px;
            background: white;
            border: 2px dashed #ef4444; /* red-500 */
            transform: rotate(-10deg) translateZ(101px); /* slight pop out */
            top: 50px;
            left: -10px;
            color: #ef4444; /* red-500 */
            font-weight: 600;
        }
        .fragile-sticker span {
            display: block;
        }
        .fragile-sticker .icon {
            font-size: 24px;
            line-height: 1;
        }
        
        /* --- State Changes on Click --- */
        .box-container.open .top {
            transform: rotateX(170deg) translateZ(100px); /* Flap opens wide */
        }
        
        .box-container.open .box {
            transform: translateY(-20px) rotateY(360deg); /* Box spins and lifts */
        }

        /* --- The Hidden Links --- */
        .hidden-links {
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: opacity 0.5s 0.5s ease, transform 0.5s 0.5s ease; /* Delay transition */
            margin-top: -180px; /* Position it where the box was */
            padding-top: 180px; /* Push content down to account for margin */
        }
        
        .box-container.open ~ .hidden-links {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .hidden-links p {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .nav-links a {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #4338ca; /* indigo-700 */
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* Cleaning sparkle effect */
        .sparkle {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: var(--secondary-color);
            border-radius: 50%;
            pointer-events: none;
            opacity: 0;
            animation: sparkle-anim 0.8s ease-out;
        }

        @keyframes sparkle-anim {
            0% { transform: scale(0); opacity: 1; }
            80% { transform: scale(1.5); opacity: 0.5; }
            100% { transform: scale(2); opacity: 0; }
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="main-content">
            <h1>404: Page Not Found</h1>
            <h2>Looks like this page got packed up!</h2>
            <p>We've moved things around and tidied up, but the page you're looking for seems to be misplaced. Don't worry, let's unpack a solution.</p>
        </div>

        <div class="box-container" id="interactiveBox">
            <div class="box">
                <div class="box-face top">
                    <div class="tape"></div>
                </div>
                <div class="box-face bottom"></div>
                <div class="box-face front">
                    <div class="fragile-sticker">
                        <span class="icon">📦</span>
                        <span>WEBSITE</span>
                    </div>
                </div>
                <div class="box-face back"></div>
                <div class="box-face left"></div>
                <div class="box-face right"></div>
            </div>
        </div>

        <div class="hidden-links" id="navLinks">
            <p>There we go! Here are some useful places:</p>
            <nav class="nav-links">
                <a href="/">Homepage</a>
                <a href="/services">Our Services</a>
                <a href="/contact">Contact Us</a>
            </nav>
        </div>
    </div>

    <script>
        // --- JAVASCRIPT LOGIC ---
        
        document.addEventListener('DOMContentLoaded', () => {
            const boxContainer = document.getElementById('interactiveBox');
            const mainContent = document.querySelector('.main-content');

            boxContainer.addEventListener('click', () => {
                // Prevent multiple clicks while animating
                if (boxContainer.classList.contains('open')) return;

                // Add 'open' class to trigger animations
                boxContainer.classList.add('open');
                
                // Change the main text after a short delay
                setTimeout(() => {
                    mainContent.querySelector('h2').textContent = 'Phew, all unpacked!';
                    mainContent.querySelector('p').style.display = 'none';
                }, 400);

                // Create some cleaning "sparkles" for a nice touch
                createSparkles(boxContainer.getBoundingClientRect());
            });

            function createSparkles(rect) {
                const sparkleCount = 15;
                for (let i = 0; i < sparkleCount; i++) {
                    const sparkle = document.createElement('div');
                    sparkle.classList.add('sparkle');
                    document.body.appendChild(sparkle);

                    // Position sparkles randomly around the box area
                    const x = rect.left + Math.random() * rect.width;
                    const y = rect.top + Math.random() * rect.height;

                    sparkle.style.left = `${x}px`;
                    sparkle.style.top = `${y}px`;
                    
                    // Randomize animation delay for a better effect
                    sparkle.style.animationDelay = `${Math.random() * 0.5}s`;

                    // Remove sparkle from DOM after animation ends
                    sparkle.addEventListener('animationend', () => {
                        sparkle.remove();
                    });
                }
            }
        });
    </script>

</body>
</html>