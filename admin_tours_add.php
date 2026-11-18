<?php
/**
 * Hidden Lanka - Add Tour Package
 */
session_start();
require_once __DIR__ . '/includes/db.php';

// Security Check: Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$error_msg = '';

// Handle Add Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $subtitle = ''; // empty subtitle as requested earlier
    $description = trim($_POST['description'] ?? '');
    $badge = trim($_POST['badge'] ?? '');
    $duration = trim($_POST['duration'] ?? '');
    $price = trim($_POST['price'] ?? 'Custom Rates');
    $places = trim($_POST['places'] ?? '');
    
    // Handle Image Upload
    $image_path = 'assets/images/tours/b1.jpg'; // default
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['image'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = $file['name'];
            $fileTmpPath = $file['tmp_name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            
            // Validate extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = 'tour_' . time() . '_' . md5($fileName) . '.' . $fileExtension;
                $uploadFileDir = __DIR__ . '/assets/images/tours/';
                
                // Create dir if not exists
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                
                $dest_path = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $image_path = 'assets/images/tours/' . $newFileName;
                } else {
                    $error_msg = "Error moving the uploaded file to destination.";
                }
            } else {
                $error_msg = "Invalid file extension. Allowed: JPG, JPEG, PNG, WEBP.";
            }
        }
    }
    
    if (empty($error_msg)) {
        if (!empty($title) && !empty($description) && !empty($places)) {
            $stmt = $db_conn->prepare("INSERT INTO tours (title, subtitle, description, badge, image_path, duration, price, places) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $title, $subtitle, $description, $badge, $image_path, $duration, $price, $places);
            if ($stmt->execute()) {
                header("Location: admin_tours.php?msg=added");
                exit();
            } else {
                $error_msg = "Database error: Failed to add tour package.";
            }
            $stmt->close();
        } else {
            $error_msg = "Please fill in all required fields.";
        }
    }
}

$pageTitle = 'Add Tour Package';
$pageDesc = 'Create a new guided tour package.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main style="background: var(--color-sand-bg); min-height: 85vh; padding: 3rem 0;">
    <div class="container" style="max-width: 1600px; width: 96%;">
        
        <!-- Dashboard Layout Grid -->
        <div style="display: grid; grid-template-columns: 230px 1fr; gap: 2rem; align-items: start;" class="db-grid">
            
            <!-- Sidebar Panel -->
            <?php require_once __DIR__ . '/includes/admin_sidebar.php'; ?>

            <!-- Content Panel -->
            <div class="reveal" style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Welcome Title Header -->
                <?php require_once __DIR__ . '/includes/admin_header_card.php'; ?>
                
                <?php if (!empty($error_msg)): ?>
                    <div style="background: rgba(235, 94, 67, 0.1); border-left: 4px solid var(--color-coral); color: #b7321a; padding: 1.25rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.92rem; margin-bottom: 1.5rem;">
                        ⚠ <?php echo htmlspecialchars($error_msg); ?>
                    </div>
                <?php endif; ?>

                <div style="background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); padding: 2.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 1.25rem; margin-bottom: 1.75rem;">
                        <h2 class="heading-md" style="margin: 0; font-size: 1.4rem;">Create New Tour Package</h2>
                        <a href="admin_tours.php" class="btn btn-outline" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;">Cancel & Return</a>
                    </div>
                    
                    <form action="admin_tours_add.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div>
                            <label class="form-label">Tour Title <span style="color:var(--color-coral)">*</span></label>
                            <input type="text" name="title" required class="form-input" placeholder="e.g. Southern Coast Exploration">
                        </div>

                        <div class="form-grid-3">
                            <div>
                                <label class="form-label">Badge Label (e.g. Most Popular)</label>
                                <input type="text" name="badge" class="form-input" placeholder="e.g. Most Popular">
                            </div>
                            <div>
                                <label class="form-label">Duration <span style="color:var(--color-coral)">*</span></label>
                                <input type="text" name="duration" required class="form-input" placeholder="e.g. Full Day (8 Hours)">
                            </div>
                            <div>
                                <label class="form-label">Price <span style="color:var(--color-coral)">*</span></label>
                                <input type="text" name="price" required class="form-input" placeholder="e.g. Custom Rates or $50 / Day">
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Description / Highlights <span style="color:var(--color-coral)">*</span></label>
                            <textarea name="description" required rows="4" class="form-textarea" placeholder="Detail the tour attractions, activities, transportation details and refreshments provided..."></textarea>
                        </div>

                        <div>
                            <label class="form-label">Places Visited (Comma-separated list) <span style="color:var(--color-coral)">*</span></label>
                            <textarea name="places" required rows="2" class="form-textarea" placeholder="Hiriketiya Surf Bay, Secret Beach Mirissa, Dondra Head Lighthouse"></textarea>
                        </div>

                        <div>
                            <label class="form-label">Tour Background Image</label>
                            <input type="file" name="image" class="form-input" style="padding: 0.6rem;">
                            <span style="font-size: 0.8rem; color: var(--color-text-muted);">Leave empty to use the default placeholder image. Allowed: JPG, JPEG, PNG, WEBP. Max 4MB.</span>
                        </div>

                        <button type="submit" class="btn btn-primary" style="align-self: flex-start; margin-top: 1rem; width: 200px;">Create Tour Package</button>
                    </form>
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
    
    /* Form Styles */
    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--color-teal-dark);
        margin-bottom: 0.4rem;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-sm);
        border: 1px solid var(--color-sand-border);
        font-family: var(--font-body);
        font-size: 0.92rem;
        background-color: var(--color-sand-bg);
        outline: none;
        transition: var(--transition-fast);
    }
    .form-input:focus, .form-textarea:focus {
        border-color: var(--color-teal-medium);
        background-color: var(--color-white);
        box-shadow: 0 0 0 3px rgba(14, 94, 101, 0.1);
    }
    .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: var(--radius-sm);
        border: 1px solid var(--color-sand-border);
        font-family: var(--font-body);
        font-size: 0.92rem;
        background-color: var(--color-sand-bg);
        outline: none;
        transition: var(--transition-fast);
        resize: vertical;
    }

    @media (max-width: 992px) {
        .db-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
        }
    }
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
