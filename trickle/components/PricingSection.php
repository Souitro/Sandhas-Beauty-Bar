<?php
include 'db.php';

// Fetch Nail Services
$NAIL_SERVICES = [];
$serviceQuery = "SELECT id, service_name AS name, price, description, duration FROM service_pricing WHERE category = 'nails' ORDER BY id ASC";
$serviceResult = $conn->query($serviceQuery);

if ($serviceResult && $serviceResult->num_rows > 0) {
    while ($row = $serviceResult->fetch_assoc()) {
        $NAIL_SERVICES[] = $row;
    }
}

// Fetch Package Deals
$PACKAGE_DEALS = [];
$dealQuery = "SELECT title, price, description, button_label FROM package_deals ORDER BY id ASC";
$dealResult = $conn->query($dealQuery);

if ($dealResult && $dealResult->num_rows > 0) {
    while ($deal = $dealResult->fetch_assoc()) {
        $PACKAGE_DEALS[] = $deal;
    }
}
?>

<section id="pricing" class="section-padding bg-white"style="background-color: #f8c6dfff;">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4"style="color: #faf6f8ff;">Service Pricing</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Professional nail services with transparent pricing
            </p>
        </div>

        <!-- Nail Services Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($NAIL_SERVICES)): ?>
                <?php foreach ($NAIL_SERVICES as $service): ?>
                    <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold"><?= htmlspecialchars($service['name']) ?></h3>
                            <span class="text-2xl font-bold text-[var(--primary-color)]">R<?= number_format($service['price'], 2) ?></span>
                        </div>
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($service['description']) ?></p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <div class="icon-clock text-sm mr-2"></div>
                            <span><?= htmlspecialchars($service['duration']) ?></span>
                        </div>
                        <a href="#booking" class="w-full btn-primary text-center block" onclick="openModal()">Book Now</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-500 col-span-full" style="color:red;">No nail services found.</p>
            <?php endif; ?>
        </div>

        <!-- Package Deals -->
        <div class="mt-16 bg-[var(--background-light)] rounded-xl p-8">
            <h3 class="text-2xl font-bold mb-6 text-center">Package Deals</h3>
            <div class="grid md:grid-cols-2 gap-8">
                <?php if (!empty($PACKAGE_DEALS)): ?>
                    <?php foreach ($PACKAGE_DEALS as $deal): ?>
                        <div class="text-center">
                            <h4 class="text-xl font-semibold mb-2"><?= htmlspecialchars($deal['title']) ?></h4>
                            <p class="text-3xl font-bold text-[var(--primary-color)] mb-2">R<?= number_format($deal['price'], 2) ?></p>
                            <p class="text-gray-600 mb-4"><?= htmlspecialchars($deal['description']) ?></p>
                            <a href="#booking" class="btn-primary" onclick="openModal()"><?= htmlspecialchars($deal['button_label']) ?></a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-500 col-span-full" style="color:red;">No package deals available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>