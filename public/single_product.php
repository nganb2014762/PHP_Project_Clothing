<?php

include_once __DIR__ . '/partials/header.php';

require_once __DIR__ . '/partials/connect.php'; 
?>

<!-- single-product -->
 <section class="single-product my-5 pt-5">
     <div class="row mt-5">
         <div class="col-lg-4 col-md-6 col-sm-12">
             <img class="img-fluid w-100 pb-1" src="img/collection/1.jpg" alt="" id="mainImg" />
             <div class="small-img-group">
                 <div class="small-img-col">
                     <img src="img/collection/2.jpg" width="100%" alt="" class="small-img">
                 </div>

                 <div class="small-img-col">
                     <img src="img/collection/3.jpg" width="100%" alt="" class="small-img">
                 </div>

                 <div class="small-img-col">
                     <img src="img/collection/4.jpg" width="100%" alt="" class="small-img">
                 </div>

                 <div class="small-img-col">
                     <img src="img/collection/1.jpg" width="100%" alt="" class="small-img">
                 </div>
             </div>
         </div>

         <div class="col-lg-6 col-md-12 col-12">
             <h6>Women</h6>
             <h2 class="py-4">Women's Fashion</h2>
             <h2>155$</h2>
             <input type="number" value="1" />
             <button class="buy-btn">Add To Cart</button>
             <h4 class="mt-5 mb-5">Product details</h4>
             <span>
                 The details of this product will be displayed shortly
                 The details of this product will be displayed shortly
                 The details of this product will be displayed shortly
                 The details of this product will be displayed shortly
                 The details of this product will be displayed shortly
             </span>
         </div>
     </div>
 </section>





 <!-- Related Products-->
 <section id="related-products" class="pt-5">
     <div class="container">
         <div class="title text-center">
             <h2 class="position-relative d-inline-block">Related Products</h2>
         </div>

         <div class="row g-0">
             <div class="collection-list mt-4 row gx-0 gy-3">
                 <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                     <div class="collection-img position-relative">
                         <img src="img/collection/1.jpg" class="w-100">
                     </div>
                     <div class="text-center">
                         <div class="rating mt-3">
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                         </div>
                         <p class="text-capitalize mt-3 mb-1">gray shirt</p>
                         <span class="fw-bold d-block">$ 45.50</span>
                         <a href="#" class="btn btn-primary mt-3">Add to Cart</a>
                     </div>
                 </div>

                 <div class="col-md-6 col-lg-4 col-xl-3 p-2 feat">
                     <div class="collection-img position-relative">
                         <img src="img/collection/2.jpg" class="w-100">
                     </div>
                     <div class="text-center">
                         <div class="rating mt-3">
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                         </div>
                         <p class="text-capitalize mt-3 mb-1">gray shirt</p>
                         <span class="fw-bold d-block">$ 45.50</span>
                         <a href="#" class="btn btn-primary mt-3">Add to Cart</a>
                     </div>
                 </div>

                 <div class="col-md-6 col-lg-4 col-xl-3 p-2 new">
                     <div class="collection-img position-relative">
                         <img src="img/collection/3.jpg" class="w-100">
                     </div>
                     <div class="text-center">
                         <div class="rating mt-3">
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                         </div>
                         <p class="text-capitalize mt-3 mb-1">gray shirt</p>
                         <span class="fw-bold d-block">$ 45.50</span>
                         <a href="#" class="btn btn-primary mt-3">Add to Cart</a>
                     </div>
                 </div>

                 <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                     <div class="collection-img position-relative">
                         <img src="img/collection/4.jpg" class="w-100">
                     </div>
                     <div class="text-center">
                         <div class="rating mt-3">
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                             <span class="text-primary"><i class="fas fa-star"></i></span>
                         </div>
                         <p class="text-capitalize mt-3 mb-1">gray shirt</p>
                         <span class="fw-bold d-block">$ 45.50</span>
                         <a href="#" class="btn btn-primary mt-3">Add to Cart</a>
                     </div>
                 </div>
             </div>
         </div>

         <nav aria-label="Page navigation example" class="pt-5">
             <ul class="pagination justify-content-end">
                 <li class="page-item">
                     <a class="" href="#">See All</a>
                 </li>
             </ul>
         </nav>
     </div>
 </section>
 <!-- end of collection -->



<?php

include_once __DIR__ . '/partials/footer.php';