<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4"> Registre d'usuari</h2>
            <form action="/user/store" method="POST" class="border p-4 bg-light">
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'usuari: </label>
                    <input type="text" name="username" class="form-control" placeholder="Regex del nom usuari" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contrasenya: </label>
                    <input type="password" name="pass1" class="form-control" placeholder="Regex de la contrasenya"  required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"> Contrasenya:</label>
                    <input type="password" name="pass2" class="form-control" placeholder="Regex de la contrasenya" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Email:  </label>
                    <input type="text" name="mail" class="form-control" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary"> Envia</button>
                </div>
                <!-- control error -->
                <div class="mt-3 text-center">
                    <p class="from-label mb-3 text-danger fw-bold fs-6">
                        <?php
                         if (isset($params['error'])) {
                            echo $params['error'];
                        }
                        ?>
                    </p>
                    <p class="from-label mb-3 text-success fw-bold fs-6">
                        <?php
                        //codi per mostrar "usuari creat correctament"
                        ?>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>