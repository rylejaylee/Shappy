<?php include_once 'views/layouts/header.php' ?>

<div class="row d-flex justify-content-center">

    <div class="col-lg-6 mt-5">
        <div class="bg-white p-3 card">
            <?php if (session()->has('success')) : ?>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>
                        <?php echo session()->get('success') ?>
                    </div>
                </div>

            <?php endif; ?>

            <div class="d-flex justify-content-center flex-wrap">
                <?php foreach ($data['novels'] as $novel) : ?>

                    <a class="text-dark mx-2 my-2" href="<?php echo url("novel/fetch?novel=$novel->slug") ?>">
                        <div class="card" style="width:200px; height:300px;">
                            <img src="<?php echo $novel->img ? img($novel->img) : img('novel_cover_default.png')  ?>" alt="<?php echo $novel->title ?>" class="card-img-top" style="height:180px;">
                            <div class="card-body p-2">
                                <div class="d-flex flex-column justify-content-between h-100 w-100">
                                    <h6 class="card-title" data-mdb-toggle="tooltip" title="<?php echo $novel->title ?>">
                                        <?php echo excerpt($novel->title, 38) ?>
                                    </h6>
                                    <div>
                                        <small class="text-primary"><?php echo $novel->category ?></small> <br>
                                        <small class="text-muted"><?php echo $novel->created_at ?></small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </a>

                <?php endforeach; ?>
            </div>
        </div>
    </div>


</div>

<?php include_once 'views/layouts/footer.php' ?>