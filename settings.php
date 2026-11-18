<?php
/**
 * Hidden Lanka - Admin Settings (Reset Credentials)
 */
session_start();
require_once __DIR__ . '/includes/db.php';

// Security Check: Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$success_user = '';
$error_user = '';
$success_pass = '';
$error_pass = '';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Update Username
    if (isset($_POST['action_type']) && $_POST['action_type'] === 'update_username') {
        $new_username = trim($_POST['new_username'] ?? '');
        
        if (!empty($new_username)) {
            // Check if username is already taken by another admin
            $stmt = $db_conn->prepare("SELECT id FROM admins WHERE username = ? AND username != ?");
            $stmt->bind_param("ss", $new_username, $_SESSION['admin_username']);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($res->num_rows > 0) {
                $error_user = "Username is already taken by another administrator.";
            } else {
                // Update username
                $update_stmt = $db_conn->prepare("UPDATE admins SET username = ? WHERE username = ?");
                $update_stmt->bind_param("ss", $new_username, $_SESSION['admin_username']);
                
                if ($update_stmt->execute()) {
                    $_SESSION['admin_username'] = $new_username;
                    $success_user = "Username updated successfully!";
                } else {
                    $error_user = "Database error updating username.";
                }
                $update_stmt->close();
            }
            $stmt->close();
        } else {
            $error_user = "Username cannot be empty.";
        }
    }
    
    // 2. Update Password
    if (isset($_POST['action_type']) && $_POST['action_type'] === 'update_password') {
        $current_pass = $_POST['current_password'] ?? '';
        $new_pass = $_POST['new_password'] ?? '';
        $confirm_pass = $_POST['confirm_password'] ?? '';
        
        if (!empty($current_pass) && !empty($new_pass) && !empty($confirm_pass)) {
            if ($new_pass !== $confirm_pass) {
                $error_pass = "New password and confirmation do not match.";
            } else {
                // Fetch the current hash
                $stmt = $db_conn->prepare("SELECT password_hash FROM admins WHERE username = ?");
                $stmt->bind_param("s", $_SESSION['admin_username']);
                $stmt->execute();
                $res = $stmt->get_result();
                
                if ($res->num_rows === 1) {
                    $row = $res->fetch_assoc();
                    
                    // Verify the current password
                    if (password_verify($current_pass, $row['password_hash'])) {
                        // Hash the new password using secure bcrypt
                        $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
                        
                        $update_stmt = $db_conn->prepare("UPDATE admins SET password_hash = ? WHERE username = ?");
                        $update_stmt->bind_param("ss", $new_hash, $_SESSION['admin_username']);
                        
                        if ($update_stmt->execute()) {
                            $success_pass = "Password updated successfully!";
                        } else {
                            $error_pass = "Database error updating password.";
                        }
                        $update_stmt->close();
                    } else {
                        $error_pass = "Incorrect current password.";
                    }
                } else {
                    $error_pass = "Admin account check failed.";
                }
                $stmt->close();
            }
        } else {
            $error_pass = "All password fields are required.";
        }
    }
}

$pageTitle = 'Admin Settings';
$pageDesc = 'Reset credentials and configure admin access settings.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main style="background: var(--color-sand-bg); min-height: 85vh; padding: 3rem 0;">
    <div class="container" style="max-width: 1600px; width: 96%;">
        
        <!-- Dashboard Layout Grid (Sidebar + Content) -->
        <div style="display: grid; grid-template-columns: 230px 1fr; gap: 2rem; align-items: start;" class="db-grid">
            
            <!-- Sidebar Panel (Admin Settings link active) -->
            <?php require_once __DIR__ . '/includes/admin_sidebar.php'; ?>

            <!-- Settings Content Panel -->
            <div class="reveal" style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Welcome Title Header -->
                <?php require_once __DIR__ . '/includes/admin_header_card.php'; ?>
                

                <div class="grid-2" style="align-items: start; gap: 2rem;">
                    
                    <!-- Box 1: Update Username -->
                    <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 2.5rem 2rem; border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm);">
                        <h3 class="heading-sm" style="color: var(--color-teal-dark); margin-bottom: 0.25rem;">Change Username</h3>
                        <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-bottom: 1.75rem;">Modify the login identifier for this administrator session.</p>
                        
                        <?php if (!empty($success_user)): ?>
                            <div style="background: var(--color-teal-light); border-left: 4px solid var(--color-teal-main); color: var(--color-teal-dark); padding: 0.85rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 0.88rem; font-weight: 600;">
                                <?php echo $success_user; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($error_user)): ?>
                            <div style="background: rgba(235, 94, 67, 0.1); border-left: 4px solid var(--color-coral); color: #b7321a; padding: 0.85rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 0.88rem; font-weight: 600;">
                                <?php echo $error_user; ?>
                            </div>
                        <?php endif; ?>

                        <form action="settings.php" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <input type="hidden" name="action_type" value="update_username">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Current Username</label>
                                <input type="text" value="<?php echo htmlspecialchars($_SESSION['admin_username']); ?>" disabled style="width: 100%; padding: 0.8rem 1.1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); background-color: #f1ede4; color: var(--color-text-muted); font-family: var(--font-body); font-size: 0.9rem; cursor: not-allowed; outline: none;">
                            </div>
                            
                            <div>
                                <label for="new_username" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">New Username</label>
                                <input type="text" id="new_username" name="new_username" required placeholder="e.g. newadmin" style="width: 100%; padding: 0.8rem 1.1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); background-color: var(--color-sand-bg); font-family: var(--font-body); font-size: 0.9rem; color: var(--color-text-dark); outline: none; transition: var(--transition-fast);">
                            </div>
                            
                            <button type="submit" class="btn btn-secondary" style="align-self: flex-start; margin-top: 0.5rem; padding: 0.7rem 1.25rem; font-size: 0.88rem;">Update Username</button>
                        </form>
                    </div>

                    <!-- Box 2: Update Password -->
                    <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 2.5rem 2rem; border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm);">
                        <h3 class="heading-sm" style="color: var(--color-teal-dark); margin-bottom: 0.25rem;">Reset Password</h3>
                        <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-bottom: 1.75rem;">Modify the login passkey. Requires current password verification.</p>
                        
                        <?php if (!empty($success_pass)): ?>
                            <div style="background: var(--color-teal-light); border-left: 4px solid var(--color-teal-main); color: var(--color-teal-dark); padding: 0.85rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 0.88rem; font-weight: 600;">
                                <?php echo $success_pass; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($error_pass)): ?>
                            <div style="background: rgba(235, 94, 67, 0.1); border-left: 4px solid var(--color-coral); color: #b7321a; padding: 0.85rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; font-size: 0.88rem; font-weight: 600;">
                                <?php echo $error_pass; ?>
                            </div>
                        <?php endif; ?>

                        <form action="settings.php" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <input type="hidden" name="action_type" value="update_password">
                            
                            <div>
                                <label for="current_password" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Current Password</label>
                                <div style="position: relative;">
                                    <input type="password" id="current_password" name="current_password" required style="width: 100%; padding: 0.8rem 3rem 0.8rem 1.1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); background-color: var(--color-sand-bg); font-family: var(--font-body); font-size: 0.9rem; color: var(--color-text-dark); outline: none; transition: var(--transition-fast);">
                                    <button type="button" onclick="togglePasswordVisibility('current_password', this)" style="position: absolute; right: 0.85rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--color-text-muted); display: flex; align-items: center; justify-content: center; padding: 0.25rem;">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="new_password" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">New Password</label>
                                <div style="position: relative;">
                                    <input type="password" id="new_password" name="new_password" required style="width: 100%; padding: 0.8rem 3rem 0.8rem 1.1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); background-color: var(--color-sand-bg); font-family: var(--font-body); font-size: 0.9rem; color: var(--color-text-dark); outline: none; transition: var(--transition-fast);">
                                    <button type="button" onclick="togglePasswordVisibility('new_password', this)" style="position: absolute; right: 0.85rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--color-text-muted); display: flex; align-items: center; justify-content: center; padding: 0.25rem;">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="confirm_password" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Confirm New Password</label>
                                <div style="position: relative;">
                                    <input type="password" id="confirm_password" name="confirm_password" required style="width: 100%; padding: 0.8rem 3rem 0.8rem 1.1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); background-color: var(--color-sand-bg); font-family: var(--font-body); font-size: 0.9rem; color: var(--color-text-dark); outline: none; transition: var(--transition-fast);">
                                    <button type="button" onclick="togglePasswordVisibility('confirm_password', this)" style="position: absolute; right: 0.85rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--color-text-muted); display: flex; align-items: center; justify-content: center; padding: 0.25rem;">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </button>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-secondary" style="align-self: flex-start; margin-top: 0.5rem; padding: 0.7rem 1.25rem; font-size: 0.88rem;">Update Password</button>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>
</main>

<style>
    .db-nav-link:hover {
        background: rgba(255,255,255,0.05);
        color: var(--color-white) !important;
        transform: translateX(4px);
    }
    .db-logout-link:hover {
        background: rgba(235, 94, 67, 0.08);
        transform: translateX(4px);
    }
    .db-nav-link, .db-logout-link {
        transition: var(--transition-fast);
    }
    input:focus {
        border-color: var(--color-teal-medium) !important;
        box-shadow: 0 0 0 3px rgba(14, 94, 101, 0.15);
        background-color: var(--color-white) !important;
    }

    @media (max-width: 992px) {
        .db-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
        }
    }
</style>

<script>
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    const svg = button.querySelector('svg');
    
    if (input.type === 'password') {
        input.type = 'text';
        // Eye Off SVG (Slash through eye)
        svg.innerHTML = `
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
        `;
    } else {
        input.type = 'password';
        // Eye SVG (Open eye)
        svg.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        `;
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
