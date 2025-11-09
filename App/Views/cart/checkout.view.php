<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card checkout-card">
                <div class="card-header bg-custom-dark text-center py-4">
                    <h2 class="mb-0 text-accent">
                        <i class="bi bi-cart-check me-2"></i>Order Confirmation
                    </h2>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Please review your order before proceeding with the purchase.
                    </div>

                    <h4 class="text-accent mb-3">Order Summary</h4>
                    
                    <?php foreach ($params['cart'] as $product): ?>
                        <div class="cart-item-confirm mb-3 p-3 rounded">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="<?= '/Public/assets/products/' . $product['image'] ?>" 
                                         class="img-fluid rounded" 
                                         alt="<?= $product['name'] ?>"
                                         style="max-height: 60px;">
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1"><?= $product['name'] ?></h6>
                                    <small class="text-muted"><?= $product['description'] ?></small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="badge bg-primary fs-6">Qty: <?= $product['qty'] ?></span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <strong><?= number_format($product['price'], 2) ?>€</strong>
                                </div>
                                <div class="col-md-2 text-end">
                                    <strong class="text-success"><?= number_format($product['price'] * $product['qty'], 2) ?>€</strong>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="total-section mt-4 p-3 rounded bg-custom-dark">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="text-accent mb-0">Total Amount:</h4>
                            </div>
                            <div class="col-md-6 text-end">
                                <h3 class="text-success mb-0"><?= number_format($params['totalCartImport'], 2) ?>€</h3>
                            </div>
                        </div>
                    </div>

                    <div class="action-buttons mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="/cart" class="btn btn-outline-secondary btn-lg w-100">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Cart
                                </a>
                            </div>
                            <div class="col-md-6">
                                <form action="/cart/validate" method="POST" id="confirmForm">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-check-circle me-2"></i>Confirm Purchase
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('confirmForm').addEventListener('submit', function(e) {
    if (!confirm('Are you sure you want to proceed with this purchase?')) {
        e.preventDefault();
    }
});
</script>