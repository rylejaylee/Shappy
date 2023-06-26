<div class="me-2 mb-2">
    <a class="text-dark" href="<?php echo url("novel/fetch?novel=$novel->slug") ?>">
        <div class="card">
            <div class="image-container">
                <img src="<?php echo $novel->img ? img($novel->img) : img('novel_cover_default.png')  ?>" alt="<?php echo $novel->title ?>" class="card-img-top novel-img">
                <span class="novel-status badge rounded-pill badge-<?php echo status_color($novel->status) ?> m-2">
                    <?php echo $novel->status ?>
                </span>
            </div>
            <div class="card-body p-2 novel-card">
                <div class="d-flex flex-column justify-content-between h-100 w-100">
                    <div>
                        <span class="rating_average d-flex justify-content-center mb-2" data-stars="<?php echo $novel->average_rating ?>"></span>
                        <h6 class="card-title" data-mdb-toggle="tooltip" title="<?php echo $novel->title ?>">
                            <?php echo excerpt($novel->title, 34) ?>
                        </h6>
                    </div>

                    <div>
                        <div class=" text-primary" style="font-size: 12px">
                            <i class="fas fa-eye"></i>
                            <?php echo number_format_short($novel->total_views ?? 0) . " views" ?>
                        </div>
                        <div class="text-muted" style="font-size: 12px">
                            <i class="fas fa-clock"></i>
                            <?php echo hummanDiff($novel->updated_at) ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </a>
</div>