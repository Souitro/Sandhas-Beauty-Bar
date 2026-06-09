<div class="product-card">
    <div class="relative">
        <img 
            src="components/img/<?= htmlspecialchars($product['image']) ?>" 
            alt="<?= htmlspecialchars($product['name']) ?>" 
            class="w-full h-48 object-cover"
        />
        <div class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-md">
            <button 
                class="icon-heart text-gray-400 hover:text-[var(--primary-color)] cursor-pointer transition-colors like-btn" 
                data-id="<?= $product['id'] ?>"
                title="Like this product"
            ></button>
        </div>
    </div>

    <div class="p-6">
        <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($product['name']) ?></h3>
        <p class="text-gray-600 text-sm mb-4"><?= htmlspecialchars($product['description']) ?></p>

        <div class="flex justify-between items-center">
            <span class="text-2xl font-bold text-[var(--primary-color)]">
                R<?= number_format($product['price'], 2) ?>
            </span>
            <span class="text-sm text-gray-600">❤️ <?= $product['likes'] ?? 0 ?> likes</span>
        </div>
    </div>
</div>