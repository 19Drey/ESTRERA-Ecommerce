<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>
<?php

use Aries\MiniFrameworkStore\Models\User;
use Carbon\Carbon;

$user = new User();

if(isset($_POST['submit'])) {
    $registered = $user->register([
        'name' => $_POST['full-name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'created_at' => Carbon::now('Asia/Manila'),
        'updated_at' => Carbon::now('Asia/Manila')
    ]);
}

if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

?>

<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card border-0 rounded-lg shadow-lg">
                <div class="card-body p-5">
                    <h2 class="text-center text-dark mb-4">Register Account</h2>
                    <h3 class="text-center success-message mb-4"><?php echo isset($registered) ? 'You have successfully registered! You may now <a href="login.php" class="text-primary">login</a>' : ''; ?></h3>
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="full-name" class="form-label text-secondary">Full Name</label>
                            <input name="full-name" type="text" class="form-control form-control-lg rounded" id="full-name" aria-describedby="full-name-help">
                            <div id="full-name-help" class="form-text text-muted">Please enter your full name.</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary">Email Address</label>
                            <input name="email" type="email" class="form-control form-control-lg rounded" id="email" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-secondary">Password</label>
                            <input name="password" type="password" class="form-control form-control-lg rounded" id="password">
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-dark btn-lg rounded">Register</button>
                        </div>
                        <p class="mt-3 text-center text-muted">Already have an account? <a href="login.php" class="text-primary">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa; /* Light background */
        color: #212529; /* Dark text for light mode */
    }
    .min-vh-100 {
        min-height: 100vh; /* Ensures content is vertically centered on full viewport */
    }
    .card {
        border: 1px solid #e0e0e0;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); /* Soft shadow */
    }
    .form-control {
        border: 1px solid #ced4da;
    }
    .form-control:focus {
        border-color: #000; /* Black border on focus */
        box-shadow: none;
    }
    .btn-dark {
        background-color: #343a40; /* Dark button */
        border-color: #343a40;
    }
    .btn-dark:hover {
        background-color: #23272b;
        border-color: #23272b;
    }
    .text-muted {
        color: #6c757d !important;
    }
    .text-secondary {
        color: #6c757d !important; /* Consistent secondary text color */
    }
    .text-primary {
        color: #007bff !important; /* Bootstrap primary blue for links */
    }
    .success-message {
        color: #28a745; /* Green for success messages */
        font-size: 1.1rem;
    }

    /* Dark Mode Styles */
    @media (prefers-color-scheme: dark) {
        body {
            background-color: #212529; /* Dark background */
            color: #f8f9fa; /* Light text */
        }
        .card {
            background-color: #343a40;
            border: 1px solid #495057;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.3);
        }
        .text-dark {
            color: #f8f9fa !important; /* Light text for dark headings */
        }
        .text-secondary {
            color: #adb5bd !important; /* Lighter secondary text */
        }
        .form-control {
            background-color: #495057;
            color: #f8f9fa;
            border: 1px solid #495057;
        }
        .form-control:focus {
            border-color: #ced4da;
            background-color: #495057;
            color: #f8f9fa;
        }
        .form-text {
            color: #adb5bd !important;
        }
        .btn-dark {
            background-color: #f8f9fa;
            color: #212529;
            border-color: #f8f9fa;
        }
        .btn-dark:hover {
            background-color: #e9ecef;
            border-color: #e9ecef;
            color: #212529;
        }
        .text-primary {
            color: #0dcaf0 !important; /* Lighter blue for links in dark mode */
        }
        a.text-primary:hover {
            color: #ced4da !important;
        }
        .success-message {
            color: #28a745; /* Still green, but ensure visibility */
        }
    }
</style>

<?php template('footer.php'); ?>