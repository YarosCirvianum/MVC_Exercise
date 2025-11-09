<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">User Register</h2>
            <form action="/user/store" method="POST" enctype="multipart/form-data" class="border border-secondary p-4 rounded bg-custom-light">
                <div class="mb-3">
                    <label for="username" class="form-label">Introduce the username:</label>
                    <input type="text" name="username" class="form-control" placeholder="Username..." required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Introduce the password:</label>
                    <input type="password" name="pass1" class="form-control" placeholder="Password..." required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Confirm the password:</label>
                    <input type="password" name="pass2" class="form-control" placeholder="Password..." required>
                </div>
                <div class="mb-3">
                    <label for="mail" class="form-label">Email:</label>
                    <input type="email" name="mail" class="form-control" placeholder="email@example.com" required>
                </div>
                
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Profile Image (optional):</label>
                    <input type="file" name="profile_image" class="form-control custom-file-input" accept="image/jpeg,image/png,image/gif">
                    <div class="form-text text-muted-custom">
                        <small>Allowed formats: JPG, PNG, GIF. Max size: 2MB</small>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                
                <div class="mt-3 text-center">
                    <?php if (isset($params['error'])): ?>
                        <p class="from-label mb-3 text-danger fw-bold fs-6">
                            <?= $params['error'] ?>
                        </p>
                    <?php endif; ?>
                    <?php if (isset($params['success'])): ?>
                        <p class="from-label mb-3 text-success fw-bold fs-6">
                            <?= $params['success'] ?>
                        </p>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>