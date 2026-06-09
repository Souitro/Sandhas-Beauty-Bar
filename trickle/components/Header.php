<?php
// header.php

// Sample cart structure (replace with DB or session logic)
$cartItems = $_SESSION['cart'] ?? [];
$cartCount = array_sum(array_column($cartItems, 'quantity'));
$cartTotal = 0;
foreach ($cartItems as $item) {
    $cartTotal += $item['price'] * $item['quantity'];
}
?>

<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                    <div class="icon-sparkles text-xl text-white"></div>
                </div>
                <h1 class="text-xl font-bold text-gradient" style="font-family:algerian; color: #ca00f7ff; font-size:30px;">SANDHAs BEAUTY BAR & SCENT</h1>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="#home" class="text-gray-700 hover:text-[var(--primary-color)] transition-colors">Home</a>
                <a href="#services" class="text-gray-700 hover:text-[var(--primary-color)] transition-colors">Services</a>
                <a href="#pricing" class="text-gray-700 hover:text-[var(--primary-color)] transition-colors">Pricing</a>
                <a href="#products" class="text-gray-700 hover:text-[var(--primary-color)] transition-colors">Products</a>
                <a href="#contact" class="text-gray-700 hover:text-[var(--primary-color)] transition-colors">Contact</a>
            </nav>

            <!-- Cart and Mobile Menu -->
            <div class="flex items-center space-x-4">
                <!-- Book Now Button -->
                <a href="#booking" class="hidden md:block btn-primary text-sm px-4 py-2" onclick="openModal()">Book Now</a>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-gray-700">
                    <div class="icon-menu text-xl"></div>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden py-4 border-t">
            <nav class="flex flex-col space-y-2">
                <a href="#home" class="py-2 text-gray-700 hover:text-[var(--primary-color)]">Home</a>
                <a href="#services" class="py-2 text-gray-700 hover:text-[var(--primary-color)]">Services</a>
                <a href="#products" class="py-2 text-gray-700 hover:text-[var(--primary-color)]">Products</a>
                <a href="#contact" class="py-2 text-gray-700 hover:text-[var(--primary-color)]">Contact</a>
            </nav>
        </div>
    </div>
</header>

<script>

function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
}
</script>