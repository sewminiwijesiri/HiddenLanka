<?php
/**
 * Hidden Lanka - Edit Accommodation Room
 */
session_start();
require_once __DIR__ . '/includes/db.php';

// Security Check: Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: admin_accommodation.php");
    exit();
}

// Fetch Room Details
$stmt = $db_conn->prepare("SELECT * FROM accommodations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$room = $res->fetch_assoc();
$stmt->close();

if (!$room) {
    header("Location: admin_accommodation.php");
    exit();
}

$error_msg = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $badge = trim($_POST['badge'] ?? '');
    $price = trim($_POST['price'] ?? 'Inquire Rates');
    $amenities = trim($_POST['amenities'] ?? '');
    $existing_image = $_POST['existing_image'] ?? '';
    
    // Handle Image Upload
    $image_path = $existing_image; // Keep original photo by default
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
                    
                    // Delete old room photo if it exists
                    if (!empty($existing_image) && file_exists(__DIR__ . '/' . $existing_image)) {
                        unlink(__DIR__ . '/' . $existing_image);
                    }
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
            $stmt = $db_conn->prepare("UPDATE accommodations SET title = ?, subtitle = ?, description = ?, badge = ?, image_path = ?, amenities = ?, price = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $title, $subtitle, $description, $badge, $image_path, $amenities, $price, $id);
            if ($stmt->execute()) {
                // Delete selected gallery images
                if (isset($_POST['delete_gallery']) && is_array($_POST['delete_gallery'])) {
                    foreach ($_POST['delete_gallery'] as $img_id) {
                        $img_id = intval($img_id);
                        $res_g_del = $db_conn->query("SELECT * FROM accommodation_images WHERE id = $img_id AND accommodation_id = " . intval($id));
                        if ($res_g_del && $res_g_del->num_rows > 0) {
                            $g_del_row = $res_g_del->fetch_assoc();
                            $path_to_del = __DIR__ . '/' . $g_del_row['image_path'];
                            if (file_exists($path_to_del)) {
                                unlink($path_to_del);
                            }
                            $db_conn->query("DELETE FROM accommodation_images WHERE id = $img_id");
                        }
                    }
                }
                
                // Count current gallery images to determine how many more can be uploaded (limit 10)
                $curr_g_res = $db_conn->query("SELECT COUNT(*) as count FROM accommodation_images WHERE accommodation_id = " . intval($id));
                $curr_g_row = $curr_g_res->fetch_assoc();
                $curr_g_count = $curr_g_row['count'];
                $slots_left = 10 - $curr_g_count;
                
                // Handle new gallery uploads up to remaining slots
                if (isset($_FILES['gallery_images']) && $_FILES['gallery_images']['error'][0] !== UPLOAD_ERR_NO_FILE && $slots_left > 0) {
                    $gallery_files = $_FILES['gallery_images'];
                    $total_uploaded = count($gallery_files['name']);
                    $limit = min($total_uploaded, $slots_left);
                    
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
                                $g_newFileName = 'gallery_' . $id . '_' . time() . '_' . md5($g_fileName) . '_' . $i . '.' . $g_fileExtension;
                                $g_dest_path = $uploadFileDir . $g_newFileName;
                                
                                if (move_uploaded_file($g_fileTmpPath, $g_dest_path)) {
                                    $g_path = 'assets/images/accommodation/' . $g_newFileName;
                                    $stmt_img->bind_param("is", $id, $g_path);
                                    $stmt_img->execute();
                                }
                            }
                        }
                    }
                    $stmt_img->close();
                }
                
                header("Location: admin_accommodation.php?msg=updated");
                exit();
            } else {
                $error_msg = "Database error: Failed to update accommodation.";
            }
            $stmt->close();
        } else {
            $error_msg = "Please fill in all required fields.";
        }
    }
}

$pageTitle = 'Edit Villa Accommodation';
$pageDesc = 'Edit existing accommodation entry details.';
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
                        <h2 class="heading-md" style="margin: 0; font-size: 1.4rem;">Edit Villa Accommodation</h2>
                        <a href="admin_accommodation.php" class="btn btn-outline" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;">Cancel & Return</a>
                    </div>
                    
                    <form action="admin_accommodation_edit.php?id=<?php echo $room['id']; ?>" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($room['image_path']); ?>">
 
                        <div class="form-grid-2">
                            <div>
                                <label class="form-label">Accommodation Title <span style="color:var(--color-coral)">*</span></label>
                                <input type="text" name="title" required class="form-input" value="<?php echo htmlspecialchars($room['title']); ?>" placeholder="e.g. Deluxe Garden Suite">
                            </div>
                            <div>
                                <label class="form-label">Subtitle Description <span style="color:var(--color-coral)">*</span></label>
                                <input type="text" name="subtitle" required class="form-input" value="<?php echo htmlspecialchars($room['subtitle']); ?>" placeholder="e.g. Spacious pool-view suite with outdoor garden patio.">
                            </div>
                        </div>

                        <div class="form-grid-2">
                            <div>
                                <label class="form-label">Badge Label (e.g. Premium Comfort)</label>
                                <input type="text" name="badge" class="form-input" value="<?php echo htmlspecialchars($room['badge']); ?>" placeholder="e.g. Family Friendly">
                            </div>
                            <div>
                                <label class="form-label">Booking Price <span style="color:var(--color-coral)">*</span></label>
                                <input type="text" name="price" required class="form-input" value="<?php echo htmlspecialchars($room['price']); ?>" placeholder="e.g. $45 / Night or Inquire Rates">
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Highlights / Long Description <span style="color:var(--color-coral)">*</span></label>
                            <textarea name="description" required rows="4" class="form-textarea" placeholder="Detail the accommodation configuration, beds layout, balcony aspects..."><?php echo htmlspecialchars($room['description']); ?></textarea>
                        </div>

                        <div>
                            <label class="form-label">What's Included (Comma-separated list) <span style="color:var(--color-coral)">*</span></label>
                            <textarea name="amenities" required rows="2" class="form-textarea" placeholder="Air Conditioning, King Size Bed, Private Jacuzzi..."><?php echo htmlspecialchars($room['amenities']); ?></textarea>
                        </div>

                        <div>
                            <label class="form-label">Accommodation Photo (Background Image)</label>
                            <?php if (!empty($room['image_path'])): ?>
                                <div style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 1rem;">
                                    <img src="<?php echo htmlspecialchars($room['image_path']); ?>" style="width: 100px; height: 65px; border-radius: var(--radius-sm); object-fit: cover; border: 1px solid var(--color-sand-border);">
                                    <span style="font-size: 0.85rem; color: var(--color-text-muted);">Current Photo active. Upload a new file below to replace it.</span>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="image" class="form-input" style="padding: 0.6rem;">
                            <span style="font-size: 0.8rem; color: var(--color-text-muted);">Leave empty to retain the current image or default looping gradient. Allowed: JPG, PNG, WEBP. Max 4MB.</span>
                        </div>

                        <!-- Existing Gallery Images -->
                        <?php
                            $gallery_res = $db_conn->query("SELECT * FROM accommodation_images WHERE accommodation_id = " . intval($room['id']) . " ORDER BY id ASC");
                            $gallery_count = ($gallery_res) ? $gallery_res->num_rows : 0;
                        ?>
                        <div>
                            <label class="form-label">Current Gallery Photos (<?php echo $gallery_count; ?> of 10)</label>
                            <?php if ($gallery_count > 0): ?>
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
                                    <?php while ($g_img = $gallery_res->fetch_assoc()): ?>
                                        <div style="position: relative; border: 1px solid var(--color-sand-border); border-radius: var(--radius-sm); overflow: hidden; height: 90px; background: #031c1f; display: flex; align-items: center; justify-content: center;">
                                            <img src="<?php echo htmlspecialchars($g_img['image_path']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                            <div style="position: absolute; top: 5px; right: 5px;">
                                                <label style="background: rgba(235, 94, 67, 0.95); color: white; padding: 3px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: bold; cursor: pointer; display: inline-flex; align-items: center; gap: 3px; box-shadow: 0 1px 4px rgba(0,0,0,0.25);">
                                                    <input type="checkbox" name="delete_gallery[]" value="<?php echo $g_img['id']; ?>" style="margin: 0; transform: scale(0.95);">
                                                    Delete
                                                </label>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <p style="font-size: 0.85rem; color: var(--color-text-muted); margin-bottom: 1rem;">No gallery photos uploaded yet.</p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="form-label">Upload New Gallery Photos (Slideshow - Up to 10 total)</label>
                            <input type="file" name="gallery_images[]" multiple class="form-input" style="padding: 0.6rem;" accept="image/*">
                            <span style="font-size: 0.8rem; color: var(--color-text-muted);">Upload additional photos to the slideshow. The total gallery limit is 10 images. Allowed: JPG, JPEG, PNG, WEBP. Max 4MB per image.</span>
                        </div>

                        <button type="submit" class="btn btn-primary" style="align-self: flex-start; margin-top: 1rem; width: auto; padding: 0.75rem 2.25rem;">Save Changes</button>
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
