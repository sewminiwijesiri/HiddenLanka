<?php
/**
 * Hidden Lanka - Admin Gallery Management
 * Handles adding, editing, listing and deleting gallery images.
 */
session_start();
require_once __DIR__ . '/includes/db.php';

// Security Check: Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$success_msg = '';
$error_msg = '';

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'added') {
        $success_msg = "Image added to the gallery successfully!";
    } elseif ($_GET['msg'] === 'updated') {
        $success_msg = "Gallery image updated successfully!";
    } elseif ($_GET['msg'] === 'deleted') {
        $success_msg = "Image removed from the gallery successfully!";
    }
}

// Handle Gallery Operations (Add, Edit, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    // 1. ADD GALLERY IMAGE
    if ($action === 'add') {
        $title = '';
        $caption = '';
        
        $image_path = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['image'];
            if ($file['error'] === UPLOAD_ERR_OK) {
                $fileName = $file['name'];
                $fileTmpPath = $file['tmp_name'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'gallery_' . time() . '_' . md5($fileName) . '.' . $fileExtension;
                    $uploadFileDir = __DIR__ . '/assets/images/gallery/';
                    
                    // Create folder if it doesn't exist
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    
                    $dest_path = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $image_path = 'assets/images/gallery/' . $newFileName;
                    } else {
                        $error_msg = "Error moving the uploaded file to destination folder.";
                    }
                } else {
                    $error_msg = "Invalid file extension. Only JPG, JPEG, PNG, and WEBP files are allowed.";
                }
            } else {
                $error_msg = "File upload failed with error code: " . $file['error'];
            }
        } else {
            $error_msg = "Please select an image file to upload.";
        }
        
        if (empty($error_msg) && !empty($image_path)) {
            $stmt = $db_conn->prepare("INSERT INTO gallery (title, caption, image_path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $caption, $image_path);
            if ($stmt->execute()) {
                header("Location: admin_gallery.php?msg=added");
                exit();
            } else {
                $error_msg = "Database error: Failed to save gallery item.";
                // Clean up the uploaded image if DB insert fails
                if (file_exists(__DIR__ . '/' . $image_path)) {
                    unlink(__DIR__ . '/' . $image_path);
                }
            }
            $stmt->close();
        }
    }
    
    // 2. EDIT GALLERY IMAGE
    elseif ($action === 'edit') {
        $id = intval($_POST['id'] ?? 0);
        $title = '';
        $caption = '';
        $existing_image = $_POST['existing_image'] ?? '';
        
        $image_path = $existing_image; // Keep existing path by default
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['image'];
            if ($file['error'] === UPLOAD_ERR_OK) {
                $fileName = $file['name'];
                $fileTmpPath = $file['tmp_name'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'gallery_' . time() . '_' . md5($fileName) . '.' . $fileExtension;
                    $uploadFileDir = __DIR__ . '/assets/images/gallery/';
                    
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    
                    $dest_path = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $image_path = 'assets/images/gallery/' . $newFileName;
                        
                        // Delete old file if it exists and is not a default system asset
                        if (!empty($existing_image) && file_exists(__DIR__ . '/' . $existing_image)) {
                            // Don't delete seeded images starting with "WhatsApp Image" if they are shared/cached
                            // but standard dashboard deletes to save space. We can delete standard uploads safely.
                            unlink(__DIR__ . '/' . $existing_image);
                        }
                    } else {
                        $error_msg = "Error saving replacement image.";
                    }
                } else {
                    $error_msg = "Invalid file type. Only JPG, JPEG, PNG, and WEBP allowed.";
                }
            }
        }
        
        if (empty($error_msg) && $id > 0) {
            $stmt = $db_conn->prepare("UPDATE gallery SET title = ?, caption = ?, image_path = ? WHERE id = ?");
            $stmt->bind_param("sssi", $title, $caption, $image_path, $id);
            if ($stmt->execute()) {
                header("Location: admin_gallery.php?msg=updated");
                exit();
            } else {
                $error_msg = "Database error: Failed to update gallery item.";
            }
            $stmt->close();
        }
    }
    
    // 3. DELETE GALLERY IMAGE
    elseif ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        $image_to_delete = $_POST['image_path'] ?? '';
        
        if ($id > 0) {
            $stmt = $db_conn->prepare("DELETE FROM gallery WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                // Delete physical image file
                if (!empty($image_to_delete) && file_exists(__DIR__ . '/' . $image_to_delete)) {
                    unlink(__DIR__ . '/' . $image_to_delete);
                }
                header("Location: admin_gallery.php?msg=deleted");
                exit();
            } else {
                $error_msg = "Failed to remove gallery item from database.";
            }
            $stmt->close();
        }
    }
}

// Fetch all gallery images
$gallery_res = $db_conn->query("SELECT * FROM gallery ORDER BY created_at DESC");
$gallery_items = [];
if ($gallery_res) {
    while ($row = $gallery_res->fetch_assoc()) {
        $gallery_items[] = $row;
    }
}

// Fetch single item for edit mode
$edit_item = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $edit_id = intval($_GET['id'] ?? 0);
    if ($edit_id > 0) {
        $stmt = $db_conn->prepare("SELECT * FROM gallery WHERE id = ?");
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 1) {
            $edit_item = $res->fetch_assoc();
        }
        $stmt->close();
    }
}

$pageTitle = 'Manage Gallery';
$pageDesc = 'Admin dashboard for adding, editing, and deleting photo gallery items.';
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
                
                <!-- Status Messages -->
                <?php if (!empty($success_msg)): ?>
                    <div style="background: rgba(46, 204, 113, 0.1); border-left: 4px solid #2ecc71; color: #27ae60; padding: 1.25rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.92rem;">
                        ✓ <?php echo htmlspecialchars($success_msg); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_msg)): ?>
                    <div style="background: rgba(235, 94, 67, 0.1); border-left: 4px solid var(--color-coral); color: #b7321a; padding: 1.25rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.92rem;">
                        ⚠ <?php echo htmlspecialchars($error_msg); ?>
                    </div>
                <?php endif; ?>

                <!-- EDIT MODE VIEW -->
                <?php if ($edit_item): ?>
                    <div style="background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); padding: 2.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 1.25rem; margin-bottom: 1.75rem;">
                            <h2 class="heading-md" style="margin: 0; font-size: 1.4rem;">Edit Gallery Image Details</h2>
                            <a href="admin_gallery.php" class="btn btn-outline" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;">Cancel & Return</a>
                        </div>
                        
                        <form action="admin_gallery.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?php echo $edit_item['id']; ?>">
                            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($edit_item['image_path']); ?>">
                            

                            
                            <div>
                                <label class="form-label" style="display: block; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem; font-size: 0.9rem;">Replace Image File</label>
                                <div style="display: flex; gap: 1.5rem; align-items: center; flex-wrap: wrap;">
                                    <?php if (!empty($edit_item['image_path'])): ?>
                                        <div style="width: 120px; height: 90px; border-radius: var(--radius-sm); overflow: hidden; border: 1px solid var(--color-sand-border); background: #eee;">
                                            <img src="<?php echo htmlspecialchars($edit_item['image_path']); ?>" style="width:100%; height:100%; object-fit:cover;">
                                        </div>
                                    <?php endif; ?>
                                    <div style="flex: 1; min-width: 250px;">
                                        <input type="file" name="image" class="form-input" style="padding: 0.55rem;">
                                        <span style="font-size: 0.8rem; color: var(--color-text-muted); display: block; margin-top: 0.35rem;">Leave empty to keep current image. Allowed: JPG, PNG, WEBP. Max 5MB.</span>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" style="align-self: flex-start; margin-top: 1rem; padding: 0.75rem 2rem;">Save Image Changes</button>
                        </form>
                    </div>

                <!-- STANDARD LIST & QUICK UPLOAD VIEW -->
                <?php else: ?>
                    <div style="background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); padding: 2.25rem 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
                            <h2 class="heading-md" style="margin: 0; font-size: 1.3rem; color: var(--color-teal-dark);">Gallery Image Database (<?php echo count($gallery_items); ?>)</h2>
                            <button type="button" onclick="openUploadModal()" class="btn btn-secondary" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;">＋ Upload Photo</button>
                        </div>
                        
                        <?php if (empty($gallery_items)): ?>
                            <p style="color: var(--color-text-muted); text-align: center; padding: 4rem 0;">No images in the gallery database yet. Click 'Upload Photo' to add some!</p>
                        <?php else: ?>
                            <div class="admin-gallery-grid">
                                <?php foreach ($gallery_items as $item): ?>
                                    <div class="admin-gallery-card">
                                        <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="Gallery Image">
                                        <form action="admin_gallery.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this gallery image permanently?');" class="admin-delete-form">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                            <input type="hidden" name="image_path" value="<?php echo htmlspecialchars($item['image_path']); ?>">
                                            <button type="submit" class="admin-delete-btn" title="Delete Image">
                                                <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>

<!-- Upload Modal Overlay -->
<div id="uploadModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(4, 20, 22, 0.6); z-index: 100000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-lg); padding: 2.25rem 2rem; width: 90%; max-width: 420px; position: relative; animation: modalZoomIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
        <span onclick="closeUploadModal()" style="position: absolute; top: 15px; right: 20px; font-size: 1.8rem; cursor: pointer; color: var(--color-text-muted); font-weight: bold; line-height: 1; transition: var(--transition-fast);" onmouseover="this.style.color='var(--color-coral)'" onmouseout="this.style.color='var(--color-text-muted)'">&times;</span>
        <h3 class="heading-md" style="margin-top: 0; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 0.75rem; margin-bottom: 1.5rem; font-size: 1.25rem; color: var(--color-teal-dark);">＋ Upload New Photo</h3>
        
        <form action="admin_gallery.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.25rem;">
            <input type="hidden" name="action" value="add">
            
            <div>
                <label class="form-label" style="display: block; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.35rem; font-size: 0.85rem;">Select Image File <span style="color: var(--color-coral);">*</span></label>
                <input type="file" name="image" required class="form-input" style="padding: 0.5rem; font-size: 0.82rem;">
                <span style="font-size: 0.78rem; color: var(--color-text-muted); display: block; margin-top: 0.25rem;">Allowed: JPG, PNG, WEBP. Max 5MB.</span>
            </div>
            
            <button type="submit" class="btn btn-secondary" style="margin-top: 0.5rem; width: 100%; padding: 0.7rem;">Publish to Gallery</button>
        </form>
    </div>
</div>

<script>
    function openUploadModal() {
        document.getElementById('uploadModal').style.display = 'flex';
    }
    function closeUploadModal() {
        document.getElementById('uploadModal').style.display = 'none';
    }
    window.onclick = function(event) {
        var modal = document.getElementById('uploadModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>

<style>
    /* Admin Gallery Card Grid */
    .admin-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 1.5rem;
    }
    .admin-gallery-card {
        position: relative;
        aspect-ratio: 1 / 1;
        border-radius: var(--radius-sm);
        overflow: hidden;
        border: 1px solid var(--color-sand-border);
        box-shadow: var(--shadow-sm);
        background: #eee;
        transition: var(--transition);
    }
    .admin-gallery-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--color-coral);
    }
    .admin-gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .admin-delete-form {
        position: absolute;
        bottom: 8px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        z-index: 10;
        opacity: 0.85;
        transition: var(--transition-fast);
    }
    .admin-gallery-card:hover .admin-delete-form {
        opacity: 1;
    }
    .admin-delete-btn {
        background: rgba(235, 94, 67, 0.95);
        color: white;
        border: none;
        border-radius: var(--radius-sm);
        padding: 0.4rem 0.75rem;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        transition: var(--transition-fast);
    }
    .admin-delete-btn:hover {
        background: var(--color-coral-hover);
        transform: scale(1.05);
    }

    /* Modal Zoom In Keyframes */
    @keyframes modalZoomIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Standard admin form element styling fallbacks if needed */
    .form-label {
        font-family: var(--font-body);
    }
    .form-input, .form-textarea {
        width: 100%;
        font-family: var(--font-body);
        font-size: 0.92rem;
        border: 1px solid var(--color-sand-border);
        border-radius: var(--radius-sm);
        padding: 0.75rem 0.85rem;
        outline: none;
        background-color: var(--color-sand-bg);
        transition: var(--transition-fast);
    }
    .form-input:focus, .form-textarea:focus {
        border-color: var(--color-teal-medium);
        background-color: var(--color-white);
        box-shadow: 0 0 0 3px rgba(14, 94, 101, 0.08);
    }
    .form-textarea {
        resize: vertical;
    }
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
