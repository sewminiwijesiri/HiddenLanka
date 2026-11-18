<?php
/**
 * Hidden Lanka - Admin Tours Management
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

if (isset($_GET['msg']) && $_GET['msg'] === 'added') {
    $success_msg = "Tour package added successfully!";
}

// Handle Tour Operations (Edit, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    // 2. EDIT TOUR
    if ($action === 'edit') {
        $id = intval($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $subtitle = '';
        $description = trim($_POST['description'] ?? '');
        $badge = trim($_POST['badge'] ?? '');
        $duration = trim($_POST['duration'] ?? '');
        $price = trim($_POST['price'] ?? 'Custom Rates');
        $places = trim($_POST['places'] ?? '');
        $existing_image = $_POST['existing_image'] ?? '';
        
        // Handle Image Upload
        $image_path = $existing_image; // keep original by default
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['image'];
            if ($file['error'] === UPLOAD_ERR_OK) {
                $fileName = $file['name'];
                $fileTmpPath = $file['tmp_name'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'tour_' . time() . '_' . md5($fileName) . '.' . $fileExtension;
                    $uploadFileDir = __DIR__ . '/assets/images/tours/';
                    
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    
                    $dest_path = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $image_path = 'assets/images/tours/' . $newFileName;
                        // Optional: delete old image if it's not a seeded one (b1, b2, b3)
                        if (!empty($existing_image) && !preg_match('/\/b[123]\.jpg$/', $existing_image) && file_exists(__DIR__ . '/' . $existing_image)) {
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
            if ($id > 0 && !empty($title) && !empty($description) && !empty($places)) {
                $stmt = $db_conn->prepare("UPDATE tours SET title = ?, subtitle = ?, description = ?, badge = ?, image_path = ?, duration = ?, price = ?, places = ? WHERE id = ?");
                $stmt->bind_param("ssssssssi", $title, $subtitle, $description, $badge, $image_path, $duration, $price, $places, $id);
                if ($stmt->execute()) {
                    $success_msg = "Tour package updated successfully!";
                } else {
                    $error_msg = "Database error: Failed to update tour package.";
                }
                $stmt->close();
            } else {
                $error_msg = "Please fill in all required fields.";
            }
        }
    }
    
    // 3. DELETE TOUR
    elseif ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        $image_to_delete = $_POST['image_path'] ?? '';
        
        if ($id > 0) {
            $stmt = $db_conn->prepare("DELETE FROM tours WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $success_msg = "Tour package deleted successfully!";
                // Optional: delete file if not seeded
                if (!empty($image_to_delete) && !preg_match('/\/b[123]\.jpg$/', $image_to_delete) && file_exists(__DIR__ . '/' . $image_to_delete)) {
                    unlink(__DIR__ . '/' . $image_to_delete);
                }
            } else {
                $error_msg = "Failed to delete tour package.";
            }
            $stmt->close();
        }
    }
}

// Fetch all tours for listing
$tours_result = $db_conn->query("SELECT * FROM tours ORDER BY created_at DESC");
$tours = [];
if ($tours_result) {
    while ($row = $tours_result->fetch_assoc()) {
        $tours[] = $row;
    }
}

// Handle Fetching for Edit Mode
$edit_tour = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    $edit_id = intval($_GET['id'] ?? 0);
    if ($edit_id > 0) {
        $stmt = $db_conn->prepare("SELECT * FROM tours WHERE id = ?");
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 1) {
            $edit_tour = $res->fetch_assoc();
        }
        $stmt->close();
    }
}

$pageTitle = 'Manage Tours';
$pageDesc = 'Create, update and delete guided tours.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main style="background: var(--color-sand-bg); min-height: 85vh; padding: 3rem 0;">
    <div class="container" style="max-width: 1600px; width: 96%;">
        
        <!-- Dashboard Layout Grid (Sidebar + Content) -->
        <div style="display: grid; grid-template-columns: 230px 1fr; gap: 2rem; align-items: start;" class="db-grid">
            
            <!-- Sidebar Panel -->
            <?php require_once __DIR__ . '/includes/admin_sidebar.php'; ?>

            <!-- Main Content Area -->
            <div class="reveal" style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Welcome Title Header -->
                <?php require_once __DIR__ . '/includes/admin_header_card.php'; ?>
                
                <!-- Status Messages -->
                <?php if (!empty($success_msg)): ?>
                    <div style="background: rgba(37, 211, 102, 0.1); border-left: 4px solid #25D366; color: #1EBE5A; padding: 1.25rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.92rem;">
                        ✓ <?php echo htmlspecialchars($success_msg); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_msg)): ?>
                    <div style="background: rgba(235, 94, 67, 0.1); border-left: 4px solid var(--color-coral); color: #b7321a; padding: 1.25rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.92rem;">
                        ⚠ <?php echo htmlspecialchars($error_msg); ?>
                    </div>
                <?php endif; ?>

                <!-- EDIT MODE FORM -->
                <?php if ($edit_tour): ?>
                    <div style="background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); padding: 2.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 1.25rem; margin-bottom: 1.75rem;">
                            <h2 class="heading-md" style="margin: 0; font-size: 1.4rem;">Edit Tour Package</h2>
                            <a href="admin_tours.php" class="btn btn-outline" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;">Cancel & Return</a>
                        </div>

                        <form action="admin_tours.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?php echo $edit_tour['id']; ?>">
                            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($edit_tour['image_path']); ?>">

                            <div>
                                <label class="form-label">Tour Title <span style="color:var(--color-coral)">*</span></label>
                                <input type="text" name="title" required value="<?php echo htmlspecialchars($edit_tour['title']); ?>" class="form-input">
                            </div>

                            <div class="form-grid-3">
                                <div>
                                    <label class="form-label">Badge Label (e.g. Most Popular)</label>
                                    <input type="text" name="badge" value="<?php echo htmlspecialchars($edit_tour['badge']); ?>" class="form-input">
                                </div>
                                <div>
                                    <label class="form-label">Duration <span style="color:var(--color-coral)">*</span></label>
                                    <input type="text" name="duration" required value="<?php echo htmlspecialchars($edit_tour['duration']); ?>" class="form-input" placeholder="e.g. Full Day (8 Hours)">
                                </div>
                                <div>
                                    <label class="form-label">Price <span style="color:var(--color-coral)">*</span></label>
                                    <input type="text" name="price" required value="<?php echo htmlspecialchars($edit_tour['price']); ?>" class="form-input" placeholder="e.g. Custom Rates">
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Description / Highlights <span style="color:var(--color-coral)">*</span></label>
                                <textarea name="description" required rows="4" class="form-textarea"><?php echo htmlspecialchars($edit_tour['description']); ?></textarea>
                            </div>

                            <div>
                                <label class="form-label">Places Visited (Comma-separated list) <span style="color:var(--color-coral)">*</span></label>
                                <textarea name="places" required rows="2" class="form-textarea" placeholder="Place A, Place B, Place C"><?php echo htmlspecialchars($edit_tour['places']); ?></textarea>
                            </div>

                            <div>
                                <label class="form-label">Replace Tour Background Image</label>
                                <div style="display: flex; gap: 1.5rem; align-items: center;">
                                    <?php if (!empty($edit_tour['image_path'])): ?>
                                        <div style="width: 120px; height: 80px; border-radius: var(--radius-sm); overflow: hidden; border: 1px solid var(--color-sand-border);">
                                            <img src="<?php echo htmlspecialchars($edit_tour['image_path']); ?>" style="width:100%; height:100%; object-fit:cover;">
                                        </div>
                                    <?php endif; ?>
                                    <div style="flex: 1;">
                                        <input type="file" name="image" class="form-input" style="padding: 0.6rem;">
                                        <span style="font-size: 0.8rem; color: var(--color-text-muted);">Leave empty to retain existing image. Allowed: JPG, PNG, WEBP. Max 4MB.</span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" style="align-self: flex-start; margin-top: 1rem;">Save Package Updates</button>
                        </form>
                    </div>

                <!-- DEFAULT LIST & ADD MODE -->
                <?php else: ?>
                    
                    <!-- Table Section: List Tours -->
                    <div style="background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); padding: 2.25rem 2rem;">
                        <div class="db-card-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
                            <h2 class="heading-md" style="margin: 0; font-size: 1.3rem;">Active Tour Packages (<?php echo count($tours); ?>)</h2>
                            <a href="admin_tours_add" class="btn btn-secondary" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;">＋ Add Tour Package</a>
                        </div>
                        
                        <?php if (empty($tours)): ?>
                            <p style="color: var(--color-text-muted); text-align: center; padding: 2rem 0;">No active tours found. Create one by clicking 'Add Tour Package'!</p>
                        <?php else: ?>
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.92rem;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid var(--color-sand-border); color: var(--color-teal-dark); font-weight: 700;">
                                            <th style="padding: 0.85rem 0.5rem; width: 90px;">Photo</th>
                                            <th style="padding: 0.85rem 1rem; max-width: 440px;">Tour Package Details</th>
                                            <th style="padding: 0.85rem 1rem; width: 220px;">Duration & Price</th>
                                            <th style="padding: 0.85rem 0.5rem; width: 220px; text-align: right;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($tours as $t): ?>
                                            <tr style="border-bottom: 1px solid var(--color-sand-border);">
                                                <td style="padding: 1rem 0.5rem;">
                                                    <div style="width: 80px; height: 55px; border-radius: 6px; overflow: hidden; border: 1px solid var(--color-sand-border);">
                                                        <img src="<?php echo htmlspecialchars($t['image_path']); ?>" style="width:100%; height:100%; object-fit:cover;">
                                                    </div>
                                                </td>
                                                <td style="padding: 1rem;">
                                                    <div style="font-weight: 700; color: var(--color-teal-dark); font-size: 1.05rem; display: flex; align-items: center; gap: 0.5rem;">
                                                        <?php echo htmlspecialchars($t['title']); ?>
                                                        <?php if (!empty($t['badge'])): ?>
                                                            <span style="font-size: 0.65rem; background: var(--color-coral); color: white; padding: 0.15rem 0.45rem; border-radius: var(--radius-full);"><?php echo htmlspecialchars($t['badge']); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.4rem; max-width: 440px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo htmlspecialchars($t['description']); ?></div>
                                                </td>
                                                <td style="padding: 1rem; color: var(--color-text-muted);">
                                                    <div>⏳ <strong><?php echo htmlspecialchars($t['duration']); ?></strong></div>
                                                    <div style="color: var(--color-coral); font-weight: 700; font-size: 0.95rem; margin-top: 0.2rem;">🏷 <?php echo htmlspecialchars($t['price']); ?></div>
                                                </td>
                                                <td style="padding: 1rem 0.5rem; text-align: right; vertical-align: middle;">
                                                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                                        <button type="button" 
                                                                onclick="previewTourCard(this)" 
                                                                data-title="<?php echo htmlspecialchars($t['title']); ?>" 
                                                                data-badge="<?php echo htmlspecialchars($t['badge']); ?>" 
                                                                data-image="<?php echo htmlspecialchars($t['image_path']); ?>" 
                                                                data-duration="<?php echo htmlspecialchars($t['duration']); ?>" 
                                                                data-price="<?php echo htmlspecialchars($t['price']); ?>" 
                                                                data-desc="<?php echo htmlspecialchars($t['description']); ?>" 
                                                                data-places="<?php echo htmlspecialchars($t['places']); ?>" 
                                                                class="btn btn-outline" 
                                                                style="padding: 0.45rem 0.85rem; font-size: 0.8rem; border-radius: var(--radius-sm); border-color: var(--color-teal-medium); color: var(--color-teal-dark);">
                                                            View
                                                        </button>
                                                        <a href="admin_tours.php?action=edit&id=<?php echo $t['id']; ?>" class="btn btn-outline" style="padding: 0.45rem 0.85rem; font-size: 0.8rem; border-radius: var(--radius-sm); border-color: var(--color-gold); color: var(--color-teal-medium);">Edit</a>
                                                        
                                                        <form action="admin_tours.php" method="POST" style="margin:0; display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this tour package permanently?');">
                                                            <input type="hidden" name="action" value="delete">
                                                            <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                                                            <input type="hidden" name="image_path" value="<?php echo htmlspecialchars($t['image_path']); ?>">
                                                            <button type="submit" class="btn btn-primary" style="padding: 0.45rem 0.85rem; font-size: 0.8rem; border-radius: var(--radius-sm); box-shadow: none;">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>

    <!-- Tour Preview Modal -->
    <div id="previewTourModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 760px; width: 95%; padding: 0; overflow: hidden; border: none;">
            <span class="modal-close" onclick="closeModal('previewTourModal')" style="z-index: 10; color: var(--color-white); text-shadow: 0 2px 4px rgba(0,0,0,0.5);">&times;</span>
            
            <div class="villa-card" style="margin: 0; box-shadow: none; border-radius: 0;">
                <div class="grid-2" style="gap: 0;">
                    
                    <!-- Card Header -->
                    <div id="prevHeader" class="villa-card-header" style="height: 100%; min-height: 250px; padding: 2rem 1.75rem; justify-content: center; background-size: cover; background-repeat: no-repeat; background-position: center center;">
                        <span id="prevBadge" class="villa-badge" style="display: none;"></span>
                        <h2 id="prevTitle" style="color: var(--color-white); font-size: 1.65rem; margin-bottom: 0.5rem; text-shadow: 0 2px 8px rgba(0,0,0,0.3); line-height: 1.25;"></h2>
                    </div>

                    <!-- Card Body -->
                    <div class="villa-card-body" style="padding: 1.75rem 2rem; background: var(--color-white);">
                        <h3 class="heading-md" style="font-size: 1.15rem; margin-bottom: 0.75rem;">Tour Highlights</h3>
                        <p id="prevDesc" style="color: var(--color-text-muted); margin-bottom: 1rem; font-size: 0.88rem; line-height: 1.5;"></p>
                        
                        <h4 style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Places You'll Visit:</h4>
                        <ul id="prevPlacesList" class="amenities-list" style="gap: 0.35rem 0.5rem;">
                            <!-- Populated by JS -->
                        </ul>

                        <div class="villa-price" style="margin-top: 1.1rem; padding-top: 0.75rem; border-top: 1px solid var(--color-sand-border);">
                            <div>
                                <span id="prevDuration" style="font-size: 0.78rem; color: var(--color-text-muted);"></span>
                                <div id="prevPrice" class="price-val" style="font-size: 1.25rem;"></div>
                            </div>
                            <button class="btn btn-whatsapp" style="pointer-events: none; opacity: 0.7; padding: 0.5rem 1rem; font-size: 0.85rem;">
                                Book via WhatsApp
                            </button>
                        </div>
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

    /* Popup Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(4, 36, 40, 0.45);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .modal-overlay.active {
        display: flex;
        opacity: 1;
    }
    .modal-content {
        background: var(--color-white);
        border-radius: var(--radius-md);
        padding: 2.25rem 2.5rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        transform: translateY(-20px);
        transition: transform 0.25s ease;
        border: 1px solid var(--color-sand-border);
    }
    .modal-overlay.active .modal-content {
        transform: translateY(0);
    }
    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1.25rem;
        font-size: 1.8rem;
        font-weight: 700;
        cursor: pointer;
        color: var(--color-text-muted);
        transition: var(--transition-fast);
    }
    .modal-close:hover {
        color: var(--color-coral);
    }

    @media (max-width: 992px) {
        .db-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
        }
    }
</style>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = 'flex';
            // Force reflow for CSS transition
            modal.offsetHeight;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('active');
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.opacity = '';
            }, 250);
            document.body.style.overflow = '';
        }
    }
    
    function previewTourCard(button) {
        const title = button.getAttribute('data-title');
        const badge = button.getAttribute('data-badge');
        const image = button.getAttribute('data-image');
        const duration = button.getAttribute('data-duration');
        const price = button.getAttribute('data-price');
        const desc = button.getAttribute('data-desc');
        const placesStr = button.getAttribute('data-places');
        
        // Set Header Background
        const header = document.getElementById('prevHeader');
        header.style.backgroundImage = `linear-gradient(135deg, rgba(4, 36, 40, 0.35) 0%, rgba(4, 36, 40, 0.85) 100%), url('${image}')`;
        
        // Handle alignment exception dynamically
        if (title.toLowerCase().indexOf('ella') !== -1) {
            header.style.backgroundPosition = 'center bottom';
        } else {
            header.style.backgroundPosition = 'center center';
        }
        
        // Set Badge
        const badgeSpan = document.getElementById('prevBadge');
        if (badge && badge.trim() !== '') {
            badgeSpan.innerText = badge;
            badgeSpan.style.display = 'inline-block';
            if (badge === 'Most Popular') {
                badgeSpan.style.backgroundColor = 'var(--color-coral)';
                badgeSpan.style.color = 'var(--color-white)';
            } else {
                badgeSpan.style.backgroundColor = 'var(--color-gold)';
                badgeSpan.style.color = 'var(--color-teal-dark)';
            }
        } else {
            badgeSpan.style.display = 'none';
        }
        
        document.getElementById('prevTitle').innerText = title;
        document.getElementById('prevDesc').innerText = desc;
        document.getElementById('prevDuration').innerText = 'Duration: ' + duration;
        document.getElementById('prevPrice').innerText = price;
        
        // Set Places Visited List
        const placesList = document.getElementById('prevPlacesList');
        placesList.innerHTML = '';
        
        const places = placesStr.split(',');
        places.forEach(place => {
            place = place.trim();
            if (place) {
                const li = document.createElement('li');
                li.className = 'amenity-chip';
                li.innerHTML = '📍 ' + place;
                placesList.appendChild(li);
            }
        });
        
        openModal('previewTourModal');
    }
    
    // Close modal when clicking outside content area
    window.addEventListener('click', function(e) {
        const modals = document.querySelectorAll('.modal-overlay');
        modals.forEach(modal => {
            if (e.target === modal) {
                closeModal(modal.id);
            }
        });
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
