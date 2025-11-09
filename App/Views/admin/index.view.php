<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-accent">
            <i class="bi bi-speedometer2 me-2"></i>Admin Panel
        </h2>
        <a href="/admin/create" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Product
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-custom-dark">
            <h5 class="mb-0 text-accent">Product Management</h5>
        </div>
        <div class="card-body">
            <?php if (empty($params['products'])): ?>
                <p class="text-center text-muted">No products found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($params['products'] as $product): ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= htmlspecialchars($product['description']) ?></td>
                                    <td><?= number_format($product['price'], 2) ?>€</td>
                                    <td>
                                        <a href="/admin/edit/<?= $product['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="/admin/delete/<?= $product['id'] ?>" class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
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