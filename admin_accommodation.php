<?php
/**
 * Hidden Lanka - Admin Accommodations Management
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
        $success_msg = "Accommodation room added successfully!";
    } elseif ($_GET['msg'] === 'updated') {
        $success_msg = "Accommodation room updated successfully!";
    }
}

// Handle Room Operations (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        $image_to_delete = $_POST['image_path'] ?? '';
        
        if ($id > 0) {
            $stmt = $db_conn->prepare("DELETE FROM accommodations WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $success_msg = "Room package deleted successfully!";
                
                // Delete uploaded room image if it exists and is not a default layout asset
                if (!empty($image_to_delete) && file_exists(__DIR__ . '/' . $image_to_delete)) {
                    unlink(__DIR__ . '/' . $image_to_delete);
                }
            } else {
                $error_msg = "Failed to delete room package.";
            }
            $stmt->close();
        }
    }
}

// Fetch all accommodations for listing
$rooms = [];
$res = $db_conn->query("SELECT * FROM accommodations ORDER BY id ASC");
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $rooms[] = $row;
    }
}

$pageTitle = 'Manage Villa Accommodations';
$pageDesc = 'Hidden Lanka - Villa Accommodations Administration Board';
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
                    <div style="background: rgba(46, 204, 113, 0.1); border-left: 4px solid #2ecc71; color: #27ae60; padding: 1.25rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.92rem; margin-bottom: 1.5rem;">
                        ✓ <?php echo htmlspecialchars($success_msg); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_msg)): ?>
                    <div style="background: rgba(235, 94, 67, 0.1); border-left: 4px solid var(--color-coral); color: #b7321a; padding: 1.25rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.92rem; margin-bottom: 1.5rem;">
                        ⚠ <?php echo htmlspecialchars($error_msg); ?>
                    </div>
                <?php endif; ?>

                <!-- Table Section: List Rooms -->
                <div style="background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); padding: 2.25rem 2rem;">
                    <div class="db-card-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
                        <h2 class="heading-md" style="margin: 0; font-size: 1.3rem;">Villa Accommodations (<?php echo count($rooms); ?>)</h2>
                        <a href="admin_accommodation_add" class="btn btn-secondary" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;">＋ Add Accommodation Type</a>
                    </div>
                    
                    <?php if (empty($rooms)): ?>
                        <p style="color: var(--color-text-muted); text-align: center; padding: 2rem 0;">No villa accommodations found. Create one by clicking 'Add Accommodation Type'!</p>
                    <?php else: ?>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.92rem;">
                                <thead>
                                    <tr style="border-bottom: 2px solid var(--color-sand-border); color: var(--color-teal-dark); font-weight: 700;">
                                        <th style="padding: 0.75rem 0.5rem; width: 90px;">Photo</th>
                                        <th style="padding: 0.75rem 1rem;">Accommodation Title & Badge</th>
                                        <th style="padding: 0.75rem 1rem; width: 180px;">Booking Price</th>
                                        <th style="padding: 0.75rem 0.5rem; text-align: right; width: 220px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rooms as $index => $r): ?>
                                        <tr style="border-bottom: 1px solid var(--color-sand-border);">
                                            <td style="padding: 1rem 0.5rem;">
                                                <div style="width: 80px; height: 55px; border-radius: 6px; overflow: hidden; border: 1px solid var(--color-sand-border); display: flex; align-items: center; justify-content: center; background: <?php echo !empty($r['image_path']) ? 'none' : (($index % 2 === 0) ? 'linear-gradient(135deg, var(--color-teal-dark) 0%, var(--color-teal-medium) 100%)' : 'linear-gradient(135deg, #0A4D52 0%, #0E6970 100%)'); ?>;">
                                                    <?php if (!empty($r['image_path'])): ?>
                                                        <img src="<?php echo htmlspecialchars($r['image_path']); ?>" style="width:100%; height:100%; object-fit:cover;">
                                                    <?php else: ?>
                                                        <span style="font-size: 0.65rem; color: rgba(255,255,255,0.7); font-weight:700;">GRADIENT</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td style="padding: 1rem;">
                                                <div style="font-weight: 700; color: var(--color-teal-dark); font-size: 1.05rem; display: flex; align-items: center; gap: 0.5rem;">
                                                    <?php echo htmlspecialchars($r['title']); ?>
                                                    <?php if (!empty($r['badge'])): ?>
                                                        <span style="font-size: 0.65rem; background: <?php echo ($r['badge'] === 'Premium Comfort') ? 'var(--color-gold)' : 'var(--color-teal-light)'; ?>; color: var(--color-teal-dark); padding: 0.15rem 0.45rem; border-radius: var(--radius-full); font-weight:700;"><?php echo htmlspecialchars($r['badge']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.4rem; max-width: 550px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo htmlspecialchars($r['subtitle']); ?></div>
                                            </td>
                                            <td style="padding: 1rem; color: var(--color-text-muted);">
                                                <div style="color: var(--color-coral); font-weight: 700; font-size: 0.95rem;">🏷 <?php echo htmlspecialchars($r['price']); ?></div>
                                            </td>
                                            <td style="padding: 1rem 0.5rem; text-align: right; vertical-align: middle;">
                                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                                    <button type="button" 
                                                            onclick="previewAccommodationCard(this, <?php echo $index; ?>)" 
                                                            data-title="<?php echo htmlspecialchars($r['title']); ?>" 
                                                            data-subtitle="<?php echo htmlspecialchars($r['subtitle']); ?>" 
                                                            data-badge="<?php echo htmlspecialchars($r['badge']); ?>" 
                                                            data-image="<?php echo htmlspecialchars($r['image_path']); ?>" 
                                                            data-price="<?php echo htmlspecialchars($r['price']); ?>" 
                                                            data-desc="<?php echo htmlspecialchars($r['description']); ?>" 
                                                            data-amenities="<?php echo htmlspecialchars($r['amenities']); ?>" 
                                                            class="btn btn-outline" 
                                                            style="padding: 0.45rem 0.85rem; font-size: 0.8rem; border-radius: var(--radius-sm); border-color: var(--color-teal-medium); color: var(--color-teal-dark);">
                                                        View
                                                    </button>
                                                    <a href="admin_accommodation_edit.php?id=<?php echo $r['id']; ?>" class="btn btn-outline" style="padding: 0.45rem 0.85rem; font-size: 0.8rem; border-radius: var(--radius-sm); border-color: var(--color-gold); color: var(--color-teal-medium);">Edit</a>
                                                    
                                                    <form action="admin_accommodation.php" method="POST" style="margin:0; display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this room type permanently?');">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                                                        <input type="hidden" name="image_path" value="<?php echo htmlspecialchars($r['image_path']); ?>">
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

            </div>

        </div>
    </div>

    <!-- Room Preview Modal -->
    <div id="previewRoomModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 760px; width: 95%; padding: 0; overflow: hidden; border: none;">
            <span class="modal-close" onclick="closeModal('previewRoomModal')" style="z-index: 10; color: var(--color-white); text-shadow: 0 2px 4px rgba(0,0,0,0.5);">&times;</span>
            
            <div class="villa-card" style="margin: 0; box-shadow: none; border-radius: 0;">
                <div class="grid-2" style="gap: 0;">
                    
                    <!-- Card Header -->
                    <div id="prevHeader" class="villa-card-header" style="height: 100%; min-height: 250px; padding: 2rem 1.75rem; justify-content: center; background-size: cover; background-repeat: no-repeat; background-position: center center;">
                        <span id="prevBadge" class="villa-badge" style="display: none;"></span>
                        <h2 id="prevTitle" style="color: var(--color-white); font-size: 1.65rem; margin-bottom: 0.35rem; text-shadow: 0 2px 8px rgba(0,0,0,0.3); line-height: 1.25;"></h2>
                        <p id="prevSubtitle" style="font-size: 0.9rem; color: rgba(255,255,255,0.9); margin: 0; text-shadow: 0 1px 4px rgba(0,0,0,0.3);"></p>
                    </div>

                    <!-- Card Body -->
                    <div class="villa-card-body" style="padding: 1.75rem 2rem; background: var(--color-white);">
                        <h3 class="heading-md" style="font-size: 1.15rem; margin-bottom: 0.75rem;">Room Highlights</h3>
                        <p id="prevDesc" style="color: var(--color-text-muted); margin-bottom: 1rem; font-size: 0.88rem; line-height: 1.5;"></p>
                        
                        <h4 style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Amenities Included:</h4>
                        <ul id="prevAmenitiesList" class="amenities-list" style="gap: 0.35rem 0.5rem;">
                            <!-- Populated by JS -->
                        </ul>

                        <div class="villa-price" style="margin-top: 1.1rem; padding-top: 0.75rem; border-top: 1px solid var(--color-sand-border);">
                            <div>
                                <span style="font-size: 0.78rem; color: var(--color-text-muted);">Direct Host Booking</span>
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
            modal.offsetHeight; // Force reflow
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
    
    function previewAccommodationCard(button, index) {
        const title = button.getAttribute('data-title');
        const subtitle = button.getAttribute('data-subtitle');
        const badge = button.getAttribute('data-badge');
        const image = button.getAttribute('data-image');
        const price = button.getAttribute('data-price');
        const desc = button.getAttribute('data-desc');
        const amenitiesStr = button.getAttribute('data-amenities');
        
        // Set Header Background (Photo vs fallback loop gradient)
        const header = document.getElementById('prevHeader');
        if (image && image.trim() !== '') {
            header.style.backgroundImage = `linear-gradient(135deg, rgba(4, 36, 40, 0.35) 0%, rgba(4, 36, 40, 0.85) 100%), url('${image}')`;
        } else {
            if (index % 2 === 0) {
                header.style.backgroundImage = `linear-gradient(135deg, var(--color-teal-dark) 0%, var(--color-teal-medium) 100%)`;
            } else {
                header.style.backgroundImage = `linear-gradient(135deg, #0A4D52 0%, #0E6970 100%)`;
            }
        }
        
        // Set Badge
        const badgeSpan = document.getElementById('prevBadge');
        if (badge && badge.trim() !== '') {
            badgeSpan.innerText = badge;
            badgeSpan.style.display = 'inline-block';
            if (badge === 'Premium Comfort') {
                badgeSpan.style.backgroundColor = 'var(--color-gold)';
                badgeSpan.style.color = 'var(--color-teal-dark)';
            } else {
                badgeSpan.style.backgroundColor = 'var(--color-teal-light)';
                badgeSpan.style.color = 'var(--color-teal-dark)';
            }
        } else {
            badgeSpan.style.display = 'none';
        }
        
        document.getElementById('prevTitle').innerText = title;
        document.getElementById('prevSubtitle').innerText = subtitle;
        document.getElementById('prevDesc').innerText = desc;
        document.getElementById('prevPrice').innerText = price;
        
        // Set Amenities List
        const amenitiesList = document.getElementById('prevAmenitiesList');
        amenitiesList.innerHTML = '';
        
        const amenities = amenitiesStr.split(',');
        amenities.forEach(amenity => {
            amenity = amenity.trim();
            if (amenity) {
                const li = document.createElement('li');
                li.className = 'amenity-chip';
                li.innerHTML = '✓ ' + amenity;
                amenitiesList.appendChild(li);
            }
        });
        
        openModal('previewRoomModal');
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
