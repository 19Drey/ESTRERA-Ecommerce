<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>
<?php

use Aries\MiniFrameworkStore\Models\Product;

$products = new Product();

$amounLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amounLocale, NumberFormatter::CURRENCY);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light white/off-white background */
            color: #212529; /* Dark text for contrast */
        }
        .container {
            /* You might want to remove padding if it's causing issues with your layout */
        }
        .fade-in-section {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 1s forwards;
            animation-delay: 0.2s; /* Delay for a nice effect */
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .text-center.display-4.fw-bold {
            color: #007bff; /* Blue for the main welcome heading */
        }

        .lead {
            color: #495057; /* Slightly darker grey for the lead text */
        }

        h2.text-primary {
            color: #007bff !important; /* Ensure blue for the "Products" heading */
        }

        .card {
            border: 1px solid #007bff; /* Blue border for product cards */
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.1); /* Subtle blue shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px); /* Slight lift on hover */
            box-shadow: 0 8px 16px rgba(0, 123, 255, 0.2); /* More prominent shadow on hover */
        }

        .card-img-top {
            max-height: 200px; /* Adjust as needed */
            object-fit: cover;
            border-bottom: 1px solid #dee2e6; /* Light grey separator for image */
        }

        .card-title {
            color: #212529; /* Black for product titles */
        }

        .card-subtitle.text-success {
            color: #28a745 !important; /* Keep price green for success/positive indication */
            font-weight: bold;
        }

        .card-text {
            color: #343a40; /* Dark grey for product description */
        }

        .btn-primary {
            background-color: #007bff; /* Blue button background */
            border-color: #007bff; /* Blue button border */
            color: white; /* White text for the button */
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745; /* Green button background */
            border-color: #28a745; /* Green button border */
            color: white; /* White text for the button */
        }

        .btn-success:hover {
            background-color: #218838; /* Darker green on hover */
            border-color: #1e7e34;
        }

        /* Animation for cards if you want them to fade in individually */
        .animate-card {
            animation: fadeInCard 0.5s forwards;
            opacity: 0;
        }

        @keyframes fadeInCard {
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container my-5 fade-in-section">
        <div class="row align-items-center mb-4">
            <div class="col-md-12">
                <h1 class="text-center display-4 fw-bold mb-3">Welcome to the Market Store</h1>
                <p class="text-center lead">Your Market products your needs is here !</p>
            </div>
        </div>
        <div class="row">
            <h2 class="mb-4 fw-semibold text-primary">Products</h2>
            <?php foreach($products->getAll() as $product): ?>
            <div class="col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch">
                <div class="card w-100 animate-card">
                    <img src="<?php echo $product['image_path'] ?>" class="card-img-top" alt="...">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-2"><?php echo $product['name'] ?></h5>
                        <h6 class="card-subtitle mb-2 text-success"><?php echo $formattedAmount = $pesoFormatter->formatCurrency($product['price'], 'PHP') ?></h6>
                        <p class="card-text flex-grow-1"><?php echo $product['description'] ?></p>
                        <div class="mt-3 d-flex gap-2">
                            <a href="product.php?id=<?php echo $product['id'] ?>" class="btn btn-primary flex-fill">View Product</a>
                            <a href="#" class="btn btn-success add-to-cart flex-fill" data-productid="<?php echo $product['id'] ?>" data-quantity="1">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php template('footer.php'); ?>