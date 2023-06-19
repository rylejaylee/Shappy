<?php include_once 'views/layouts/header.php' ?>

<div class="row d-flex justify-content-center">

    <div class="col-lg-6 mt-5">
        <div class="card">
            <div class="card-header">
                <h3>New Novels</h3>
            </div>
            <div class="card-body">
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
                        <a class="text-dark mb-2 me-2" href="<?php echo url("novel/fetch?novel=$novel->slug") ?>">
                            <div class="card" style="width:140px; height:300px;">
                                <img src="<?php echo $novel->img ? img($novel->img) : img('novel_cover_default.png')  ?>" alt="<?php echo $novel->title ?>" class="card-img-top" style="height:180px;">
                                <div class="card-body p-2">
                                    <div class="d-flex flex-column justify-content-between h-100 w-100">
                                        <h6 class="card-title" data-mdb-toggle="tooltip" title="<?php echo $novel->title ?>">
                                            <?php echo excerpt($novel->title, 28) ?>
                                        </h6>

                                        <div>
                                            <small class="text-primary">
                                                <i class="fas fa-book-open"></i> <?php echo $novel->category ?>
                                            </small> <br />
                                            <div class="text-muted" style="font-size: 12px">
                                                <i class="fas fa-clock"></i>
                                                <?php echo hummanDiff($novel->updated_at) ?>
                                            </div>
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


</div>

<?php include_once 'views/layouts/footer.php' ?>