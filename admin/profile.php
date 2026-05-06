<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['admin_id'];

// Get user data
$stmt = $pdo->prepare("SELECT * FROM admin_users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$page_title = 'My Profile';
require_once 'includes/executive-header.php';
?>

<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="font-h1 text-h1 text-primary-container mb-2">My Profile</h1>
        <p class="text-body text-on-surface-variant">Manage your account settings and profile information</p>
    </div>

    <!-- Profile Picture Section -->
    <div class="bg-surface-container-lowest rounded-[18px] p-lg shadow-[0_2px_8px_rgba(26,39,68,0.08)] mb-6">
        <h2 class="font-h3 text-h3 text-primary-container mb-6">Profile Picture</h2>
        
        <div class="flex items-start gap-8">
            <!-- Current Profile Picture -->
            <div class="flex-shrink-0">
                <div id="profilePicturePreview" class="w-32 h-32 rounded-full overflow-hidden bg-gradient-to-br from-secondary to-primary-container flex items-center justify-center text-white font-bold text-4xl shadow-lg">
                    <?php if ($user['profile_picture']): ?>
                        <img src="../<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?php
                        $names = explode(' ', trim($user['name']));
                        echo strtoupper(substr($names[0], 0, 1));
                        if (isset($names[1])) echo strtoupper(substr($names[1], 0, 1));
                        ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Upload Controls -->
            <div class="flex-1">
                <div class="mb-4">
                    <p class="text-sm text-on-surface-variant mb-2">
                        Upload a profile picture. Recommended size: 400x400px. Max file size: 5MB.
                    </p>
                    <p class="text-xs text-on-surface-variant">
                        Supported formats: JPG, PNG, GIF, WebP
                    </p>
                </div>

                <div class="flex gap-3">
                    <label for="profilePictureInput" class="px-6 py-3 bg-primary text-on-primary rounded-[12px] font-ui-medium cursor-pointer hover:scale-102 transition-transform inline-block">
                        <span class="material-symbols-outlined text-[20px] align-middle mr-2">upload</span>
                        Upload Photo
                    </label>
                    <input type="file" id="profilePictureInput" accept="image/*" class="hidden">
                    
                    <?php if ($user['profile_picture']): ?>
                    <button id="deleteProfilePicture" class="px-6 py-3 bg-error-container text-on-error-container rounded-[12px] font-ui-medium hover:scale-102 transition-transform">
                        <span class="material-symbols-outlined text-[20px] align-middle mr-2">delete</span>
                        Remove Photo
                    </button>
                    <?php endif; ?>
                </div>

                <!-- Upload Progress -->
                <div id="uploadProgress" class="mt-4 hidden">
                    <div class="w-full bg-surface-container-high rounded-full h-2 overflow-hidden">
                        <div id="uploadProgressBar" class="bg-primary h-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <p id="uploadStatus" class="text-sm text-on-surface-variant mt-2"></p>
                </div>

                <!-- Messages -->
                <div id="uploadMessage" class="mt-4 hidden"></div>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="bg-surface-container-lowest rounded-[18px] p-lg shadow-[0_2px_8px_rgba(26,39,68,0.08)]">
        <h2 class="font-h3 text-h3 text-primary-container mb-6">Profile Information</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-ui-medium text-on-surface mb-2">Name</label>
                <div class="px-4 py-3 bg-surface-container-high rounded-[10px] text-on-surface">
                    <?php echo htmlspecialchars($user['name']); ?>
                </div>
            </div>

            <div>
                <label class="block text-sm font-ui-medium text-on-surface mb-2">Email</label>
                <div class="px-4 py-3 bg-surface-container-high rounded-[10px] text-on-surface">
                    <?php echo htmlspecialchars($user['email']); ?>
                </div>
            </div>

            <div>
                <label class="block text-sm font-ui-medium text-on-surface mb-2">Role</label>
                <div class="px-4 py-3 bg-surface-container-high rounded-[10px] text-on-surface capitalize">
                    <?php echo htmlspecialchars($user['role']); ?>
                </div>
            </div>

            <div>
                <label class="block text-sm font-ui-medium text-on-surface mb-2">Member Since</label>
                <div class="px-4 py-3 bg-surface-container-high rounded-[10px] text-on-surface">
                    <?php echo date('F j, Y', strtotime($user['created_at'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('profilePictureInput');
    const preview = document.getElementById('profilePicturePreview');
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadProgressBar = document.getElementById('uploadProgressBar');
    const uploadStatus = document.getElementById('uploadStatus');
    const uploadMessage = document.getElementById('uploadMessage');
    const deleteBtn = document.getElementById('deleteProfilePicture');

    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validate file type
        if (!file.type.match('image.*')) {
            showMessage('Please select an image file', 'error');
            return;
        }

        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            showMessage('File size must be less than 5MB', 'error');
            return;
        }

        uploadProfilePicture(file);
    });

    // Upload profile picture
    function uploadProfilePicture(file) {
        const formData = new FormData();
        formData.append('profile_picture', file);

        // Show progress
        uploadProgress.classList.remove('hidden');
        uploadMessage.classList.add('hidden');
        uploadProgressBar.style.width = '0%';
        uploadStatus.textContent = 'Uploading...';

        const xhr = new XMLHttpRequest();

        // Progress handler
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                uploadProgressBar.style.width = percentComplete + '%';
                uploadStatus.textContent = `Uploading... ${Math.round(percentComplete)}%`;
            }
        });

        // Completion handler
        xhr.addEventListener('load', function() {
            uploadProgress.classList.add('hidden');
            
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    showMessage(response.message, 'success');
                    // Update preview
                    preview.innerHTML = `<img src="../${response.profile_picture}?t=${Date.now()}" alt="Profile" class="w-full h-full object-cover">`;
                    // Reload page to show delete button
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMessage(response.message, 'error');
                }
            } else {
                showMessage('Upload failed. Please try again.', 'error');
            }
        });

        // Error handler
        xhr.addEventListener('error', function() {
            uploadProgress.classList.add('hidden');
            showMessage('Upload failed. Please try again.', 'error');
        });

        xhr.open('POST', 'api/upload-profile-picture.php');
        xhr.send(formData);
    }

    // Delete profile picture
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to remove your profile picture?')) {
                return;
            }

            fetch('api/delete-profile-picture.php', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                showMessage('Failed to delete profile picture', 'error');
            });
        });
    }

    // Show message helper
    function showMessage(message, type) {
        uploadMessage.className = `mt-4 px-4 py-3 rounded-[10px] ${
            type === 'success' 
                ? 'bg-tertiary-container text-on-tertiary-container' 
                : 'bg-error-container text-on-error-container'
        }`;
        uploadMessage.textContent = message;
        uploadMessage.classList.remove('hidden');
    }
});
</script>

<?php require_once 'includes/executive-footer.php'; ?>
