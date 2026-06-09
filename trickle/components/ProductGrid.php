<?php
require_once 'db.php';

$categories = [
    ['id' => 'all', 'name' => 'All Products'],
    ['id' => 'nails', 'name' => 'Nail Products'],
    ['id' => 'perfumes', 'name' => 'Perfumes']
];

// Get selected category from URL
$selectedCategory = $_GET['category'] ?? 'all';

// Fetch products from database
$PRODUCTS_DATA = [];

if ($selectedCategory === 'all') {
    $sql = "SELECT id, name, description, price, image_url AS image, category, likes FROM products WHERE visible = 1 ORDER BY created_at DESC";
    $result = $conn->query($sql);
} else {
    $stmt = $conn->prepare("SELECT id, name, description, price, image_url AS image, category, likes FROM products WHERE category = ? AND visible = 1 ORDER BY created_at DESC");
    $stmt->bind_param("s", $selectedCategory);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
}

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $PRODUCTS_DATA[] = $row;
    }
}

?>

<section id="products" class="section-padding bg-gray-50" style="background-color: #f8c6dfff; color:#fff;">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Our Products</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
                Discover our carefully curated collection of nail products and luxury perfumes
            </p>

            <!-- Category Filter -->
            <div class="flex flex-wrap justify-center gap-4">
                <?php foreach ($categories as $category): ?>
                    <a href="?category=<?= $category['id'] ?>"
                        class="px-6 py-2 rounded-full font-medium transition-all duration-200
                        <?= $selectedCategory === $category['id']
                            ? 'bg-[var(--primary-color)] text-white'
                            : 'bg-white text-gray-700 hover:bg-[var(--primary-color)] hover:text-white' ?>">
                        <?= $category['name'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php if (!empty($PRODUCTS_DATA)): ?>
                <?php foreach ($PRODUCTS_DATA as $product): ?>
                    <?php include 'ProductCard.php'; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-12 col-span-full">
                    <p class="text-gray-500">No products found in this category.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>