<?php
/**
 * Hidden Lanka - Admin Login
 */
session_start();
require_once __DIR__ . '/includes/db.php';

// Handle Logout (if accessed directly)
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['admin_logged_in']);
    unset($_SESSION['admin_username']);
    session_destroy();
    header("Location: login.php");
    exit();
}

// Redirect to dashboard if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}

$error = '';

// Handle Login Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        // Query the admin credentials
        $stmt = $db_conn->prepare("SELECT username, password_hash FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            // Verify password using bcrypt hash check
            if (password_verify($password, $row['password_hash'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $row['username'];
                header("Location: admin.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}

$pageTitle = 'Admin Login';
$pageDesc = 'Admin access portal for Hidden Lanka.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main style="background: var(--color-sand-bg); min-height: 70vh; display: flex; align-items: center; padding: 4rem 0;">
    <div class="container">
        
        <!-- Login Form Card -->
        <div class="reveal" style="max-width: 380px; margin: 0 auto; background: var(--color-white); border-radius: var(--radius-md); padding: 2.5rem 2.25rem; border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-lg);">
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <div style="width: 50px; height: 50px; background: var(--color-teal-light); color: var(--color-teal-main); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem; border: 1px solid rgba(6, 60, 64, 0.1);">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </div>
                <h1 class="heading-md" style="color: var(--color-teal-dark); margin: 0; font-size: 1.35rem;">Admin Portal</h1>
                <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-top: 0.2rem;">Sign in to access your dashboard</p>
            </div>

            <?php if (!empty($error)): ?>
                <div style="background: rgba(235, 94, 67, 0.1); border-left: 4px solid var(--color-coral); color: #b7321a; padding: 0.85rem; border-radius: var(--radius-sm); margin-bottom: 1.25rem; font-size: 0.85rem; font-weight: 600;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
                <div>
                    <label for="username" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Username</label>
                    <input type="text" id="username" name="username" required style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); font-family: var(--font-body); font-size: 0.92rem; background-color: var(--color-sand-bg); outline: none; transition: var(--transition-fast);">
                </div>

                <div>
                    <label for="password" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" required style="width: 100%; padding: 0.75rem 3rem 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); font-family: var(--font-body); font-size: 0.92rem; background-color: var(--color-sand-bg); outline: none; transition: var(--transition-fast);">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--color-text-muted); display: flex; align-items: center; justify-content: center; padding: 0.25rem;">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-secondary" style="width: 100%; margin-top: 0.25rem; padding: 0.75rem 1.25rem; font-size: 0.92rem;">Login to Dashboard</button>
            </form>
        </div>
        
    </div>
</main>

<style>
    input:focus {
        border-color: var(--color-teal-medium) !important;
        box-shadow: 0 0 0 3px rgba(14, 94, 101, 0.15);
        background-color: var(--color-white) !important;
    }
</style>

<script>
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    const svg = button.querySelector('svg');
    
    if (input.type === 'password') {
        input.type = 'text';
        // Eye Off SVG
        svg.innerHTML = `
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
        `;
    } else {
        input.type = 'password';
        // Eye SVG
        svg.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        `;
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
