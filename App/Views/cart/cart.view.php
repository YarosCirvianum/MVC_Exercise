<div class="container mt-4">
    <?php if (!$params['empty_cart']): ?>
        <h2 class="mb-4 text-accent">
            <i class="bi bi-cart3 me-2"></i>Hi, <?= $params['user']['username']; ?>! Your Shopping Cart
        </h2>

        <div class="row">
            <?php foreach ($params['cart'] as $key => $productCart): ?>
                <div class="col-12 mb-3">
                    <div class="card h-100 cart-item">
                        <div class="row g-0">
                            <div class="col-md-2 d-flex align-items-center justify-content-center p-3">
                                <img src="<?= '/Public/assets/products/' . $productCart['image'] ?>" 
                                     class="img-fluid rounded" 
                                     alt="<?= $productCart['name'] ?>" 
                                     style="max-height: 80px; width: auto;">
                            </div>
                            <div class="col-md-10">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <h5 class="card-title text-accent"><?= $productCart['name'] ?></h5>
                                            <p class="card-text text-muted small mb-0"><?= $productCart['description'] ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="card-text fw-bold text-success mb-0">
                                                <?= number_format($productCart['price'], 2) ?>€
                                            </p>
                                            <small class="text-muted">each</small>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <span class="me-3 fw-bold">Quantity:</span>
                                                <span class="badge bg-primary fs-6 me-3"><?= $productCart['qty'] ?></span>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <form action="/cart/updateCart" method="post" class="d-inline">
                                                        <input type="hidden" name="id" value="<?= $productCart['id'] ?>">
                                                        <button type="submit" name="operation" value="+" class="btn btn-success" title="Increase quantity">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </form>
                                                    <form action="/cart/updateCart" method="post" class="d-inline">
                                                        <input type="hidden" name="id" value="<?= $productCart['id'] ?>">
                                                        <button type="submit" name="operation" value="-" class="btn btn-warning" title="Decrease quantity">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <h6 class="text-accent mb-0">
                                                Subtotal: <?= number_format($productCart['price'] * $productCart['qty'], 2) ?>€
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card total-section">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h3 class="mb-0 text-accent">Total Amount:</h3>
                                <p class="text-muted mb-0">Including all items</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <h2 class="text-success mb-0"><?= number_format($params['totalCartImport'], 2) ?>€</h2>
                            </div>
                            <div class="col-md-3 text-end">
                                <a href="/cart/confirm" class="btn btn-primary btn-lg">
                                    <i class="bi bi-bag-check me-2"></i>Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="text-center py-5 empty-cart-message">
            <i class="bi bi-cart-x text-secondary" style="font-size: 4rem;"></i>
            <h1 class="text-secondary mt-3">Hi, <?= $params['user']['username']; ?>!</h1>
            <p class="fs-4 text-secondary">Your cart is empty...</p>
            <a href="/product" class="btn btn-primary btn-lg mt-3">
                <i class="bi bi-bag me-2"></i>Back to the Store
            </a>
        </div>
    <?php endif; ?>
</div>