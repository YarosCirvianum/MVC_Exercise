<div class="container mt-4">
    <h2 class="text-accent mb-4">
        <i class="bi bi-clock-history me-2"></i>Order History
    </h2>

    <?php if (empty($params['orders'])): ?>
        <div class="text-center py-5">
            <i class="bi bi-cart-x text-secondary" style="font-size: 4rem;"></i>
            <h3 class="text-secondary mt-3">No Orders Yet</h3>
            <p class="text-muted">You haven't placed any orders yet.</p>
            <a href="/product" class="btn btn-primary btn-lg mt-3">
                <i class="bi bi-bag me-2"></i>Start Shopping
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($params['orders'] as $order): ?>
                <div class="col-12 mb-4">
                    <div class="card order-history-card">
                        <div class="card-header bg-custom-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-accent">
                                <i class="bi bi-receipt me-2"></i>Order #<?= $order['id'] ?>
                            </h5>
                            <span class="badge bg-primary fs-6">
                                <i class="bi bi-calendar me-1"></i><?= $order['date'] ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <?php foreach ($order['products'] as $product): ?>
                                <div class="order-item row align-items-center mb-2 py-2 border-bottom">
                                    <div class="col-md-1">
                                        <img src="<?= '/Public/assets/products/' . $product['image'] ?>" 
                                             class="img-fluid rounded" 
                                             alt="<?= $product['name'] ?>"
                                             style="max-height: 50px;">
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="mb-1"><?= $product['name'] ?></h6>
                                        <small class="text-muted"><?= $product['description'] ?></small>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <span class="badge bg-secondary">Qty: <?= $product['qty'] ?></span>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <strong><?= number_format($product['price'], 2) ?>€</strong>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <strong class="text-success"><?= number_format($product['price'] * $product['qty'], 2) ?>€</strong>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <div class="order-total mt-3 pt-3 border-top">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="text-accent">Order Total:</h5>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <h4 class="text-success"><?= number_format($order['total'], 2) ?>€</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>