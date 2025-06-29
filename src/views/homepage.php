<?php
if (session_status() === PHP_SESSION_NONE) {
    require __DIR__ . '/../../config/session.php';
}

$loged = isset($_SESSION['id_user']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        /* Use Inter font */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
            scrollbar-width: none;
        }
        /* Simple animation for sections */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">

    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-indigo-600">CleanlyGo</a>
            <div class="hidden md:flex space-x-6 items-center">
                <a href="#home" class="text-gray-600 hover:text-indigo-600 transition duration-300">Home</a>
                <a href="#services" class="text-gray-600 hover:text-indigo-600 transition duration-300">Services</a>
                
                <?php if ($loged): ?>
                    <a href="/pelanggan/layanan" class="text-gray-600 hover:text-indigo-600 transition duration-300">Buat Pesanan</a>
                    <a href="/pelanggan/pesanan" class="text-gray-600 hover:text-indigo-600 transition duration-300 font-medium">Pesanan Saya</a>
                <?php endif; ?>

                <a href="#about" class="text-gray-600 hover:text-indigo-600 transition duration-300">About Us</a>
                <a href="#help" class="text-gray-600 hover:text-indigo-600 transition duration-300">Help</a>
                <a href=<?= $loged ? "/pelanggan/settings" : "/auth"?> class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300"><?= $loged ? 'Settings' : 'Login' ?></a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </nav>
        <div id="mobile-menu" class="md:hidden hidden bg-white pb-4">
            <a href="#home" class="block px-6 py-2 text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition duration-300">Home</a>
            <a href="#services" class="block px-6 py-2 text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition duration-300">Services</a>
            <?php if ($loged): ?>
                
                <a href="/pelanggan/layanan" class="block px-6 py-2 text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition duration-300">Buat Pesanan</a>
                <a href="/pelanggan/pesanan" class="block px-6 py-2 text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition duration-300 font-medium">Pesanan Saya</a>
            <?php endif; ?>

            <a href="#about" class="block px-6 py-2 text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition duration-300">About Us</a>
            <a href="#help" class="block px-6 py-2 text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition duration-300">Help</a>
            <a href=<?= $loged ? "/pelanggan/settings" : "/auth"?> class="block mx-6 my-2 bg-indigo-600 text-white text-center px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-300"><?= $loged ? 'Settings' : 'Login' ?></a>
        </div>
    </header>

    <main>
        <section id="home" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20 md:py-32">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">Pembersihan Mudah & Pemindahan Tanpa Hambatan</h1>
                <p class="text-lg md:text-xl mb-8 text-indigo-100">Mitra tepercaya Anda untuk rumah yang berkilau dan bebas stres.</p>
                <a href=<?= $loged ? "/pelanggan/layanan" : "/auth"?> class="bg-white text-indigo-600 font-semibold px-8 py-3 rounded-md hover:bg-gray-100 transition duration-300 text-lg">Pesan Sekarang</a>
            </div>
        </section>

        <section id="services" class="py-16 md:py-24 bg-white fade-in">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Jasa Kami</h2>
                <div class="grid md:grid-cols-2 gap-10">
                    <div class="bg-gray-50 p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                        <div class="text-indigo-600 mb-4">
                           <i class="fas fa-broom fa-3x"></i> </div>
                        <h3 class="text-2xl font-semibold mb-3 text-gray-700">Pembersihan Profesional</h3>
                        <p class="text-gray-600 mb-4">Dari perawatan rutin hingga pembersihan menyeluruh, kami akan membuat ruangan Anda bersih tanpa noda. Kami menawarkan layanan pembersihan perumahan, komersial, dan khusus yang disesuaikan dengan kebutuhan Anda.</p>
                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                            <li>Pembersihan Rumah Standar</li>
                            <li>Pembersihan Mendalam</li>
                            <li>Pembersihan Pindahan / Pindah Rumah</li>
                            <li>Pembersihan Kantor & Komersial</li>
                        </ul>
                         <a href="#help" class="inline-block mt-6 text-indigo-600 hover:text-indigo-800 font-medium transition duration-300">Pelajari lebih lanjut &rarr;</a>
                    </div>
                    <div class="bg-gray-50 p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                         <div class="text-purple-600 mb-4">
                            <i class="fas fa-truck-moving fa-3x"></i> </div>
                        <h3 class="text-2xl font-semibold mb-3 text-gray-700">Pemindahan yang Dapat Diandalkan</h3>
                        <p class="text-gray-600 mb-4">Biar kami yang menangani pekerjaan berat. Tim kami yang berpengalaman memastikan barang-barang Anda dipindahkan dengan aman dan efisien, baik di seluruh kota atau di dekatnya.</p>
                         <ul class="list-disc list-inside text-gray-600 space-y-1">
                            <li>Pemindahan Tempat Tinggal Lokal</li>
                            <li>Layanan Pengemasan & Pembongkaran</li>
                            <li>Bantuan Bongkar Muat</li>
                            <li>Perakitan / Pembongkaran Furnitur</li>
                        </ul>
                         <a href="#help" class="inline-block mt-6 text-purple-600 hover:text-purple-800 font-medium transition duration-300">Pelajari Lebih Lanjut &rarr;</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="py-16 md:py-24 bg-gray-100 fade-in">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-gray-800">Tentang CleanlyGo</h2>
                 <p class="max-w-3xl mx-auto text-gray-600 text-lg mb-8">
                 Didirikan di Surakarta, CleanlyGo lahir dari keinginan untuk menyediakan layanan pembersihan dan pindahan yang andal dan berkualitas tinggi untuk komunitas kami. Kami bangga dengan profesionalisme, perhatian terhadap detail, dan memperlakukan rumah dan barang-barang Anda dengan sangat hati-hati. Tim kami terlatih, diasuransikan, dan berdedikasi untuk membuat hidup Anda lebih mudah.
                </p>
                <div class="flex justify-center space-x-4">
                     <span class="inline-block bg-indigo-100 text-indigo-800 text-sm font-medium mr-2 px-3 py-1 rounded-full">Reliable</span>
                     <span class="inline-block bg-purple-100 text-purple-800 text-sm font-medium mr-2 px-3 py-1 rounded-full">Professional</span>
                     <span class="inline-block bg-green-100 text-green-800 text-sm font-medium mr-2 px-3 py-1 rounded-full">Insured</span>
                     <span class="inline-block bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">Local</span>
                </div>
            </div>
        </section>

        <section id="help" class="py-16 md:py-24 bg-white fade-in">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-10 text-gray-800">Bantuan</h2>
                <div class="max-w-lg mx-auto bg-gray-50 p-8 rounded-lg shadow-md">
                    <p class="text-center text-gray-600 mb-6">Jika ada kendala atau sesuatu yang perlu ditanyakan dapat mengisi formulir dibawah ini.</p>
                    <form id="help-form">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-medium mb-2">Nama</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Nama lengkap">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Email valid">
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block text-gray-700 font-medium mb-2">Pesan</label>
                            <textarea id="message" name="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tulis pesan disini..."></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="bg-indigo-600 text-white font-semibold px-8 py-3 rounded-md hover:bg-indigo-700 transition duration-300 w-full md:w-auto">Kirim</button>
                        </div>
                    </form>
                     <div id="form-message" class="mt-4 text-center"></div>
                     <div class="mt-10 text-center text-gray-600">
                        <p class="mb-2">Atau dapat menghubungi:</p>
                        <p><i class="fas fa-phone mr-2 text-indigo-600"></i> 081234567890</p>
                        <p><i class="fas fa-envelope mr-2 text-indigo-600"></i> info@cleanlygo.com</p>
                        <p><i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i> Surakarta, Jawa Tengah, Indonesia</p>
                     </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-gray-300 py-8">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; <span id="current-year"></span> CleanlyGo. All rights reserved.</p>
            <p class="text-sm mt-2">Mitra pembersih dan pindahan terpercaya Anda di Surakarta.</p>
             </div>
    </footer>

    <script>
        // --- Mobile Menu Toggle ---
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when a link is clicked
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        // --- Set Current Year in Footer ---
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // --- Basic Form Handling (Placeholder) ---
        const contactForm = document.getElementById('help-form');
        const formMessage = document.getElementById('form-message');

        contactForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent actual form submission

            // Basic validation check (Tailwind handles required fields visually)
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;

            if (name && email && message) {
                // Simulate successful submission
                formMessage.textContent = 'Terima kasih. Kami akan menghubungi kembali melalui email.';
                formMessage.className = 'mt-4 text-center text-green-600 font-medium';
                contactForm.reset(); // Clear the form
            } else {
                // This message might not appear if 'required' attribute works,
                // but good as a fallback.
                formMessage.textContent = 'Tolong isi semua.';
                formMessage.className = 'mt-4 text-center text-red-600 font-medium';
            }

             // Clear the message after a few seconds
            setTimeout(() => {
                formMessage.textContent = '';
                formMessage.className = 'mt-4 text-center';
            }, 5000);

            // In a real application, you would send the form data to a server here
            // using fetch() or XMLHttpRequest.
            console.log('Form submitted (simulation)');
            // Example:
            // const formData = new FormData(contactForm);
            // fetch('/your-server-endpoint', { method: 'POST', body: formData })
            //   .then(response => response.json())
            //   .then(data => { console.log('Success:', data); /* Handle success */ })
            //   .catch((error) => { console.error('Error:', error); /* Handle error */ });
        });

        // --- Intersection Observer for Fade-in Animation ---
        const faders = document.querySelectorAll('.fade-in');
        const appearOptions = {
            threshold: 0.3, // Trigger when 30% of the element is visible
            rootMargin: "0px 0px -50px 0px" // Adjust trigger margin if needed
        };

        const appearOnScroll = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    return;
                } else {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target); // Stop observing once visible
                }
            });
        }, appearOptions);

        faders.forEach(fader => {
            appearOnScroll.observe(fader);
        });

    </script>

</body>
</html>