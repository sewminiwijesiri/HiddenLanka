<?php
/**
 * Hidden Lanka - Add Accommodation Room
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
    $subtitle = trim($_POST['subtitle'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $badge = trim($_POST['badge'] ?? '');
    $price = trim($_POST['price'] ?? 'Inquire Rates');
    $amenities = trim($_POST['amenities'] ?? '');
    
    // Handle Image Upload
    $image_path = ''; // empty by default (uses gradient fallbacks)
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
                $newFileName = 'room_' . time() . '_' . md5($fileName) . '.' . $fileExtension;
                $uploadFileDir = __DIR__ . '/assets/images/accommodation/';
                
                // Create dir if not exists
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                
                $dest_path = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $image_path = 'assets/images/accommodation/' . $newFileName;
                } else {
                    $error_msg = "Error moving the uploaded file to destination.";
                }
            } else {
                $error_msg = "Invalid file extension. Allowed: JPG, JPEG, PNG, WEBP.";
            }
        }
    }
    
    if (empty($error_msg)) {
        if (!empty($title) && !empty($subtitle) && !empty($description) && !empty($amenities)) {
            $stmt = $db_conn->prepare("INSERT INTO accommodations (title, subtitle, description, badge, image_path, amenities, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $title, $subtitle, $description, $badge, $image_path, $amenities, $price);
            if ($stmt->execute()) {
                $new_accommodation_id = $db_conn->insert_id;
                
                // Handle Gallery Images Upload (Up to 10)
                if (isset($_FILES['gallery_images']) && $_FILES['gallery_images']['error'][0] !== UPLOAD_ERR_NO_FILE) {
                    $gallery_files = $_FILES['gallery_images'];
                    $total_uploaded = count($gallery_files['name']);
                    
                    // Limit to 10 images max
                    $limit = min($total_uploaded, 10);
                    
                    $uploadFileDir = __DIR__ . '/assets/images/accommodation/';
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    
                    $stmt_img = $db_conn->prepare("INSERT INTO accommodation_images (accommodation_id, image_path) VALUES (?, ?)");
                    
                    for ($i = 0; $i < $limit; $i++) {
                        if ($gallery_files['error'][$i] === UPLOAD_ERR_OK) {
                            $g_fileName = $gallery_files['name'][$i];
                            $g_fileTmpPath = $gallery_files['tmp_name'][$i];
                            $g_fileNameCmps = explode(".", $g_fileName);
                            $g_fileExtension = strtolower(end($g_fileNameCmps));
                            
                            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                            if (in_array($g_fileExtension, $allowedExtensions)) {
                                $g_newFileName = 'gallery_' . $new_accommodation_id . '_' . time() . '_' . md5($g_fileName) . '_' . $i . '.' . $g_fileExtension;
                                $g_dest_path = $uploadFileDir . $g_newFileName;
                                
                                if (move_uploaded_file($g_fileTmpPath, $g_dest_path)) {
                                    $g_path = 'assets/images/accommodation/' . $g_newFileName;
                                    $stmt_img->bind_param("is", $new_accommodation_id, $g_path);
                                    $stmt_img->execute();
                                }
                            }
                        }
                    }
                    $stmt_img->close();
                }
                
                header("Location: admin_accommodation.php?msg=added");
                exit();
            } else {
                $error_msg = "Database error: Failed to add accommodation.";
            }
            $stmt->close();
        } else {
            $error_msg = "Please fill in all required fields.";
        }
    }
}

$pageTitle = 'Add Villa Accommodation';
$pageDesc = 'Create a new villa accommodation type.';
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
                        <h2 class="heading-md" style="margin: 0; font-size: 1.4rem;">Add Villa Accommodation</h2>
                        <a href="admin_accommodation.php" class="btn btn-outline" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;">Cancel & Return</a>
                    </div>
                    
                    <form action="admin_accommodation_add.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div class="form-grid-2">
                            <div>
                                <label class="form-label">Accommodation Title <span style="color:var(--color-coral)">*</span></label>
                                <input type="text" name="title" required class="form-input" placeholder="e.g. Deluxe Garden Suite">
                            </div>
                            <div>
                                <label class="form-label">Subtitle Description <span style="color:var(--color-coral)">*</span></label>
                                <input type="text" name="subtitle" required class="form-input" placeholder="e.g. Spacious pool-view suite with outdoor garden patio.">
                            </div>
                        </div>

                        <div class="form-grid-2">
                            <div>
                                <label class="form-label">Badge Label (e.g. Premium Comfort)</label>
                                <input type="text" name="badge" class="form-input" placeholder="e.g. Family Friendly">
                            </div>
                            <div>
                                <label class="form-label">Booking Price <span style="color:var(--color-coral)">*</span></label>
                                <input type="text" name="price" required class="form-input" value="Inquire Rates" placeholder="e.g. $45 / Night or Inquire Rates">
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Highlights / Long Description <span style="color:var(--color-coral)">*</span></label>
                            <textarea name="description" required rows="4" class="form-textarea" placeholder="Detail the accommodation configuration, beds layout, balcony aspects, and view profiles..."></textarea>
                        </div>

                        <div>
                            <label class="form-label">What's Included (Comma-separated list) <span style="color:var(--color-coral)">*</span></label>
                            <textarea name="amenities" required rows="2" class="form-textarea" placeholder="Air Conditioning, King Size Bed, Private Jacuzzi, Smart TV, Mini Fridge"></textarea>
                        </div>

                        <div>
                            <label class="form-label">Accommodation Photo (Background Image)</label>
                            <input type="file" name="image" class="form-input" style="padding: 0.6rem;">
                            <span style="font-size: 0.8rem; color: var(--color-text-muted);">Leave empty to use default looping gradient background. Allowed: JPG, PNG, WEBP. Max 4MB.</span>
                        </div>

                        <div>
                            <label class="form-label">Gallery Photos (Slideshow - Up to 10 images)</label>
                            <input type="file" name="gallery_images[]" multiple class="form-input" style="padding: 0.6rem;" accept="image/*">
                            <span style="font-size: 0.8rem; color: var(--color-text-muted);">Select up to 10 images for the slideshow viewer. Allowed: JPG, JPEG, PNG, WEBP. Max 4MB per image.</span>
                        </div>

                        <button type="submit" class="btn btn-primary" style="align-self: flex-start; margin-top: 1rem; width: auto; padding: 0.75rem 2.25rem;">Create Accommodation Type</button>
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
