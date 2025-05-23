<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>
<?php

use Aries\MiniFrameworkStore\Models\Category;
use Aries\MiniFrameworkStore\Models\Product;
use Carbon\Carbon;

$categories = new Category();
$product = new Product();

if (isset($_POST['submit'])) {
    if (!isLoggedIn()) {
        $message = "Guests are not allowed to add products. Please log in.";
    } else {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $image = $_FILES['image'];

        $targetFile = null;
        if ($image['error'] === UPLOAD_ERR_OK) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $imageName = uniqid() . '_' . basename($image["name"]);
            $targetFile = $targetDir . $imageName;
            move_uploaded_file($image["tmp_name"], $targetFile);
        }

        $product->insert([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'slug' => strtolower(str_replace(' ', '-', $name)),
            'image_path' => $targetFile,
            'category_id' => $category,
            'created_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now()
        ]);

        $message = "Product added successfully!";
    }
}

?>

<div class="container py-5 market-container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg p-4 market-card">
                <h2 class="text-center mb-4 market-heading">Add New Product</h2>
                <p class="text-center text-muted mb-4 market-subtext">Share your amazing products with the world.</p>
                <?php if (isset($message)): ?>
                    <div class="alert alert-success text-center market-alert" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <form action="add-product.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="product-name" class="form-label market-label">Product Name</label>
                        <input type="text" class="form-control form-control-lg market-input" id="product-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="product-description" class="form-label market-label">Description</label>
                        <textarea class="form-control form-control-lg market-textarea" id="product-description" name="description" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="product-price" class="form-label market-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text market-input-group-text">₱</span>
                            <input type="number" class="form-control form-control-lg market-input" id="product-price" name="price" step="0.01" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="product-category" class="form-label market-label">Category</label>
                        <select class="form-select form-select-lg market-select" id="product-category" name="category" required>
                            <option value="" selected disabled>Select Category</option>
                            <?php foreach($categories->getAll() as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="formFile" class="form-label market-label">Product Image</label>
                        <input class="form-control form-control-lg market-file-input" type="file" id="formFile" name="image" accept="image/*">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-lg market-btn" type="submit" name="submit">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for the Add Product page, consistent with Login page's theme */
    body {
        background-color: #f8f9fa; /* Light white/off-white background */
        color: #212529; /* Dark text for contrast */
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; /* Modern font */
    }

    /* Navbar - Use the same styling as defined in assets/css/styles.css for consistency */
    /* (No need to redefine here, it will be pulled from the header) */
    .navbar {
        /* Styles inherited from assets/css/styles.css */
    }

    /* Container for the form to give it a section feel */
    .market-container {
        /* ADJUSTED: Increased padding-top significantly to move content down */
        padding-top: 12rem !important; /* Adjust this value as needed */
        padding-bottom: 3rem !important;
    }

    /* Card Styling - Matching the login card */
    .market-card {
        background-color: #ffffff; /* White background for the form card */
        border: 1px solid #007bff; /* Blue border for the card */
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.1); /* Subtle blue shadow */
        border-radius: 0.5rem; /* Standard Bootstrap rounded corners */
        padding: 2.5rem; /* More internal padding */
    }

    /* Headings & Subtext */
    .market-heading {
        color: #007bff; /* Blue for the main heading */
        font-weight: bold;
        margin-bottom: 1rem;
        border-bottom: 2px solid #e9ecef; /* Light grey line below heading */
        padding-bottom: 0.5rem;
    }
    .market-subtext {
        color: #6c757d; /* Muted grey for subtext */
        font-style: italic;
        margin-bottom: 2rem;
    }

    /* Form Labels */
    .market-label {
        color: #007bff; /* Blue label text */
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    /* Form Inputs - Matching the login inputs */
    .market-input,
    .market-textarea,
    .market-select,
    .market-file-input {
        background-color: #ffffff; /* White background for inputs */
        color: #212529; /* Black text in input fields */
        border: 1px solid #007bff; /* Blue border for input fields */
        border-radius: 0.25rem; /* Standard Bootstrap rounding */
        padding: 0.8rem 1rem;
    }
    .market-input:focus,
    .market-textarea:focus,
    .market-select:focus,
    .market-file-input:focus {
        border-color: #0056b3; /* Darker blue on focus */
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }
    .market-input-group-text {
        background-color: #e9ecef; /* Light grey for the currency symbol background */
        color: #495057; /* Darker grey for the currency symbol */
        border: 1px solid #007bff;
        border-right: none;
        border-radius: 0.25rem 0 0 0.25rem;
        padding: 0.8rem 1rem;
    }
    .market-input-group-text + .market-input {
        border-left: none;
        border-radius: 0 0.25rem 0.25rem 0 !important;
    }

    /* Alert Message - Matching login page's success alert */
    .market-alert.alert-success {
        background-color: #d4edda; /* Light green background */
        color: #155724; /* Dark green text */
        border-color: #c3e6cb; /* Green border */
        border-radius: 0.25rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
    }
    /* If you also needed danger alerts here */
    .market-alert.alert-danger {
        background-color: #f8d7da; /* Light red background */
        border-color: #f5c6cb; /* Red border */
        color: #721c24; /* Dark red text */
        border-radius: 0.25rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
    }

    /* Submit Button - Matching login page's primary button */
    .market-btn {
        background-color: #007bff; /* Blue button background */
        color: #ffffff; /* White text */
        border: 1px solid #007bff; /* Blue border */
        border-radius: 0.25rem;
        padding: 0.8rem 1.5rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
    }
    .market-btn:hover {
        background-color: #0056b3; /* Darker blue on hover */
        border-color: #0056b3;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        color: #ffffff; /* Ensure text remains white */
    }
    .market-btn:active {
        background-color: #004085; /* Even darker blue on active */
        border-color: #004085;
        transform: translateY(0);
        box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
    }

    /* Placeholder text color */
    .form-control::placeholder,
    .market-select option:first-child { /* Target placeholder option text */
        color: #6c757d !important; /* Muted grey for placeholder */
    }
    /* Ensure the selected value in dropdown is visible and matches theme */
    .market-select {
        color: #212529 !important; /* Black text for selected value */
    }
</style>

<?php template('footer.php'); ?>