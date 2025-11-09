<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- CANVI: method="POST" i action="/product/search" -->
            <form action="/product/search" method="POST" class="mb-4">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search products by name or description..." 
                           value="<?= htmlspecialchars($params['search_query'] ?? '') ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mt-3 text-center">
    <p class="from-label mb-3 text-success fw-bold fs-6">
        <?php
        if (isset($params['messageCart'])) {
            echo $params['messageCart'];
        }
        ?>
    </p>
</div>

<div class="row g-4 p-4">
   <?php foreach ($params['products'] as $product): ?>
       <div class="col-md-3">
           <div class="card h-100">
               <img src="<?php echo '/Public/assets/products/' . $product['image'] ?>" class="card-img-top img-fluid w-25 d-block mx-auto mt-2" alt="Nombre del Producto">
               <div class="card-body">
                   <form action="/cart/addItemsToCart" method="post">
                       <h5 class="card-title"><?php echo $product['name']; ?></h5>
                       <p class="card-text"><?php echo $product['description']; ?></p>
                       <p class="card-text"><?php echo number_format($product['price'], 2); ?>€</p>
                       <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                       <div class="content-center">
                           <input type="submit" name="addCart" value="Add to cart" class="btn btn-success">
                       </div>
                   </form>
               </div>
           </div>
       </div>
   <?php endforeach; ?>
</div>