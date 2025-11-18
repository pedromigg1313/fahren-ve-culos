<div class="carousel-item">
    <div class="card card-compra shadow-hover position-relative">
        <img src="<?php echo $img; ?>" class="card-img-top" alt="">
        <div class="card-body pb-1">
            <div class="row mb-4">
                <a href="pagina-venda.php" class="text-decoration-none text-dark stretched-link">
                    <h5 class="card-title fw-bold mb-0 text-uppercase"><?php echo $nome; ?></h5>
                </a>
                <p class="card-text text-uppercase text-secondary small"><?php echo $info; ?></p>
            </div>
            <p class="card-text h5 fw-bold mb-0"><?php echo $preco; ?></p>
            <div class="row">
                <div class="col-6">
                    <p class="card-text text-secondary small text-truncate"><?php echo $ano; ?></p>
                </div>
                <div class="col-6">
                    <p class="card-text text-end text-secondary small text-truncate"><?php echo $km; ?> km</p>
                </div>
            </div>
        </div>
        <div class="card-footer border-top-0 bg-body">
            <div class="row">
                <div class="col d-flex align-items-center gap-2 text-secondary">
                    <i class="bi bi-geo-alt-fill"></i>
                    <p class="card-text small"><?php echo $loc; ?></p>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn p-0 position-relative favoritar favoritar-danger">
                        <i class="bi bi-heart text-secondary"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>