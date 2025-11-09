<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5"> <!-- Login wodth colums -->
            <h2 class="text-center mb-4">User Login</h2>
            <form action="/user/login" method="POST" class="border border-secondary p-4 rounded">
                <div class="mb-3">
                    <label for="username" class="form-label">Introduce the username:</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username..." required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Introduce the password:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password..."  required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

                <!-- Errors control -->
                <div class="mt-3 text-center">
                    <p class="from-label mb-3 text-danger fw-bold fs-4">
                        <?php
                        //codi php de control d'errors
                        if (isset($params['error'])) {
                            echo $params['error'];
                        }
                        ?>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>