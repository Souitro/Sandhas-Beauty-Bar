<?php


$services = [];
$TIME_SLOTS = ['09:00 AM', '10:30 AM', '12:00 PM', '01:30 PM', '03:00 PM', '04:30 PM'];

$sql = "SELECT name, description, price, duration, icon FROM services WHERE visible = 1 ORDER BY id ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = [
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => number_format($row['price'], 2),
            'duration' => $row['duration'],
            'icon' => $row['icon'] ?? 'star'
        ];
    }
}


?>

<section id="services" class="section-padding bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Services</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Experience the perfect blend of nail artistry and luxury fragrances
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($services as $service): ?>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-[var(--background-light)] rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-[var(--primary-color)] transition-colors duration-300">
                        <div class="fas fa-<?= htmlspecialchars($service['icon']) ?> text-2xl text-[var(--primary-color)] group-hover:text-white transition-colors duration-300"></div>
                    </div>
                    <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($service['name']) ?></h3>
                    <p class="text-gray-600 mb-4"><?= htmlspecialchars($service['description']) ?></p>
                    <p class="text-[var(--primary-color)] font-semibold">From R<?= htmlspecialchars($service['price']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Single Book Now Button -->
        <div class="text-center mt-12">
            <button class="btn-primary" onclick="openModal()">Book Now</button>
        </div>
    </div>
</section>

