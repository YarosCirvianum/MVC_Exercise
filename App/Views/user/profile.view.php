<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card profile-card">
                <div class="card-header bg-custom-dark text-center py-4">
                    <h2 class="mb-0 text-accent">My Profile</h2>
                </div>
                <div class="card-body p-4">
                    <!-- Profile Image Section -->
                    <div class="text-center mb-4">
                        <div class="profile-image-container position-relative d-inline-block">
                            <img src="<?= isset($params['user']['image']) ? '/Public/assets/avatar/' . $params['user']['image'] : '/Public/assets/avatar/default.png' ?>" 
                                 class="profile-image-large rounded-circle border border-3 border-accent" 
                                 alt="Profile Picture"
                                 id="profileImagePreview">
                            <label for="profileImage" class="profile-image-overlay rounded-circle">
                                <div class="overlay-content">
                                    <i class="bi bi-camera-fill fs-1"></i>
                                    <small class="d-block mt-1">Change Photo</small>
                                </div>
                            </label>
                            <input type="file" 
                                   id="profileImage" 
                                   name="profile_image" 
                                   class="d-none" 
                                   accept="image/*">
                        </div>
                    </div>

                    <form action="/user/edit" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <!-- Current Info Display (Readonly) -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currentUsername" class="form-label">Current Username</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="currentUsername" 
                                           value="<?= $params['user']['username'] ?? '' ?>" 
                                           readonly>
                                    <div class="form-text">Username cannot be changed</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currentEmail" class="form-label">Current Email</label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="currentEmail" 
                                           value="<?= $params['user']['mail'] ?? '' ?>" 
                                           readonly>
                                    <div class="form-text">Email cannot be changed</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 border-secondary">

                        <!-- Password Change Section -->
                        <h5 class="text-accent mb-2">Change Password</h5> <!-- 👈 Canviat mb-3 a mb-2 -->
                        <div class="form-text mb-3"> <!-- 👈 Afegit mb-3 -->
                            <small class="text-light">Leave blank to keep current password</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="currentPassword" class="form-label">Current Password</label>
                                    <input type="password" 
                                           name="current_password" 
                                           class="form-control" 
                                           id="currentPassword" 
                                           placeholder="Enter current password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" 
                                           name="new_password" 
                                           class="form-control" 
                                           id="newPassword" 
                                           placeholder="Enter new password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" 
                                           name="confirm_password" 
                                           class="form-control" 
                                           id="confirmPassword" 
                                           placeholder="Confirm new password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- 👈 ELIMINAT: El "Leave blank" que estava aquí duplicat -->
                            </div>
                        </div>

                        <!-- Hidden field for image -->
                        <input type="hidden" name="current_image" value="<?= $params['user']['image'] ?? 'default.png' ?>">

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="/product" class="btn btn-outline-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>

                        <!-- Messages Section -->
                        <div class="mt-4">
                            <?php if (isset($params['error'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= $params['error'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($params['success'])): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= $params['success'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>