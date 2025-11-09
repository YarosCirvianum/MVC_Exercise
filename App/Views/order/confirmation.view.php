<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card confirmation-card text-center">
                <div class="card-header bg-success text-white py-4">
                    <h2 class="mb-0">
                        <i class="bi bi-check-circle-fill me-2"></i>Order Confirmed!
                    </h2>
                </div>
                <div class="card-body p-5">
                    <div class="success-icon mb-4">
                        <i class="bi bi-bag-check-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h3 class="text-success mb-3">Thank You for Your Purchase!</h3>
                    
                    <p class="lead mb-4">
                        Your order has been successfully processed. A confirmation email has been sent to 
                        <strong><?= $params['user']['mail'] ?></strong> with all the details.
                    </p>

                    <div class="order-details mb-4 p-3 rounded">
                        <h5 class="text-accent mb-3">What's Next?</h5>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-envelope-check text-primary me-2"></i>Check your email for order confirmation</li>
                            <li><i class="bi bi-clock-history text-primary me-2"></i>View your order history anytime</li>
                            <li><i class="bi bi-cart-plus text-primary me-2"></i>Continue shopping for more great products</li>
                        </ul>
                    </div>

                    <div class="action-buttons">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="/product" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-bag me-2"></i>Continue Shopping
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="/cart/history" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="bi bi-clock-history me-2"></i>View Order History
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>