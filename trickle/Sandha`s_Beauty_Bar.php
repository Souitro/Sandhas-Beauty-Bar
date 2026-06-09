<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandhas Beauty Bar & Scent - Nail Tech & Perfumes</title>
    <meta name="description" content="Premium nail tech services and luxury perfumes. Discover beautiful nail designs and exquisite fragrances for every occasion.">
    <meta name="keywords" content="nail tech, perfumes, nail art, manicure, pedicure, luxury fragrances, beauty, nail salon">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://resource.trickle.so/vendor_lib/unpkg/lucide-static@0.516.0/font/lucide.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #ec4899;
            --secondary-color: #8b5cf6;
            --accent-color: #f59e0b;
            --background-light: #fdf2f8;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: #e974aeff;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: opacity 0.2s ease-in-out;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }
        section{
            margin-bottom:7px;
        }

        /* Add other styles as needed */
    </style>
</head>
<body>

    <?php include 'components/Header.php'; ?>
    <?php include 'components/db.php'; ?>
    <?php include 'components/Hero.php'; ?>
    <?php include 'components/ProductGrid.php'; ?>
    <?php include 'components/Services.php'; ?>
    <?php include 'components/BookingModal.php'; ?>
    <?php include 'components/PricingSection.php'; ?>
    <?php include 'components/ContactSection.php'; ?>
    <?php include 'components/Footer.php'; $conn->close();?>

</body>
</html>