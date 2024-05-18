<?php

$category = input::get("category");

if (empty($category)) {
    $category = "service";
    $products = DB::conn()->query("SELECT * FROM items WHERE i_type = 'service'")->results();
}

$active_service = "";
$active_product = "";
$active_discount = "";

if ($category == "service") {
    $active_service = "active";
    $products = DB::conn()->query("SELECT * FROM items WHERE i_type = 'service'")->results();
} else if ($category == "product") {
    $active_product = "active";
    $products = DB::conn()->query("SELECT * FROM items WHERE i_type = 'product'")->results();
} else if ($category == "discount") {
    $active_discount = "active";
    $products = DB::conn()->query("SELECT * FROM items WHERE i_type = 'discount'")->results();
}

?>
<style>
    .avatar {
        vertical-align: middle;
        width: 35px;
        height: 35px;
        border-radius: 50%;
    }

    .bg-default,
    .btn-default {
        background-color: #f2f3f8;
    }

    .btn-error {
        color: #ef5f5f;
    }
</style>
<!-- custom style -->
<?php
// $products = DB::conn()->query("SELECT * FROM items WHERE c_id IN (SELECT cu_clinic FROM clinic_user WHERE cu_user = ?)")->results();



$no = 1;
?>
<section class="header-main">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3">
                <div class="brand-wrap">


                </div> <!-- brand-wrap.// -->
            </div>
            <div class="col-lg-6 col-sm-6">
                <!--  <form action="#" class="search-wrap">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form> --> <!-- search-wrap .end// -->
            </div> <!-- col.// -->
            <!-- col.// -->
        </div> <!-- row.// -->
    </div> <!-- container.// -->
</section>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y-sm bg-default ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 card padding-y-sm">
                <ul class="nav bg radius nav-pills nav-fill mb-3 bg" role="tablist">
                    <li class="nav-item" id="service-tab">
                        <a class="nav-link <?= $active_service ?> show" href="<?= PORTAL ?>billing/pos-system?category=service">
                            <i class="fa fa-tags"></i>Service
                        </a>
                    </li>
                    <li class="nav-item" id="service-tab">
                        <a class="nav-link <?= $active_product ?> show" href="<?= PORTAL ?>billing/pos-system?category=product">
                            <i class="fa fa-tags"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item" id="service-tab">
                        <a class="nav-link <?= $active_discount ?>  show" href="<?= PORTAL ?>billing/pos-system?category=discount">
                            <i class="fa fa-tags"></i>Diskaun
                        </a>
                    </li>
                </ul>
                <!-- produk kategori -->
                <span id="items product">

                    <div class="row">
                        <?php foreach ($products as $i) { ?>
                            <div class="col-md-2">
                                <figure class="card card-product">

                                    <div class="img-wrap" style="height:200px;">
                                        <img src="<?= PORTAL ?>assets/images/<?= $i->i_image ?>" style="width: 100%; height:200px;">
                                    </div>
                                    <figcaption class="info-wrap">
                                        <a href="#" class="title"><?= $i->i_name ?></a>
                                        <div class="action-wrap">
                                            <a href="#" class="btn btn-primary btn-sm float-right"> <i class="fa fa-cart-plus"></i> Add </a>
                                            <div class="price-wrap h5">
                                                <span class="price-new">$1280</span>
                                            </div>
                                        </div>
                                    </figcaption>
                                </figure>
                            </div>
                        <?php
                        }
                        ?>
                    </div> <!-- row.// -->
                </span>
            </div>
        </div>
        <!-- section cart -->
        <div class="row">
            <div class="col-md-12 card">

                <span id="cart">
                    <table class="table table-hover shopping-cart-wrap">
                        <thead class="text-muted">
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col" width="120">Qty</th>
                                <th scope="col" width="120">Price (RM)</th>
                                <th scope="col" class="text-right" width="200">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <figure class="media">
                                        <div class="img-wrap"><img src="assets/images/items/1.jpg" class="img-thumbnail img-xs"></div>
                                        <figcaption class="media-body">
                                            <h6 class="title text-truncate" contenteditable="true" style="background-color: white;">Product name </h6>
                                        </figcaption>
                                    </figure>
                                </td>
                                <td class="text-center">
                                    <div class="m-btn-group m-btn-group--pill btn-group mr-2" role="group" aria-label="...">
                                        <button type="button" class="m-btn btn btn-default"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="m-btn btn btn-default" disabled>3</button>
                                        <button type="button" class="m-btn btn btn-default"><i class="fa fa-plus"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <div class="price-wrap">
                                        <var class="price" contenteditable="true" style="background-color: white;">$145</var>
                                    </div> <!-- price-wrap .// -->
                                </td>
                                <td class="text-right">
                                    <a href="#" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </span>
                <!-- card.// -->
                <div class="box">

                    <dl class="dlist-align">
                        <dt>Discount:</dt>
                        <dd class="text-left"><a href="#">0%</a></dd>
                    </dl>
                    <dl class="dlist-align">
                        <dt>Sub Total:</dt>
                        <dd class="text-left">$215</dd>
                    </dl>
                    <dl class="dlist-align">
                        <dt>Total: </dt>
                        <dd class="text-left h4 b"> $215 </dd>
                    </dl>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#" class="btn  btn-default btn-error btn-lg btn-block"><i class="fa fa-times-circle "></i> Cancel </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="btn  btn-primary btn-lg btn-block"><i class="fa fa-shopping-bag"></i> Charge </a>
                        </div>
                    </div>
                </div> <!-- box.// -->
            </div>
        </div>
    </div><!-- container //  -->
</section>

<?php
Page::append(
    <<<SCRIPT
<script>
console.log('adasdasd')
$(document).ready(function() {
	
});

</script>
SCRIPT
);
