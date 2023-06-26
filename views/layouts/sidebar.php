<div class="card mt">
    <div class="card-body">
        <h5 class="card-title">
            Popular Novels
        </h5>

        <?php foreach ($popular as $_novel) : ?>
            <a href="<?php echo url("novel/fetch?novel=$_novel->slug") ?>">
                <div class="card mb-2 shadow-none bg-light">
                    <div class="card-body" style="padding:8px;">
                        <div class="d-flex">
                            <img class="me-2" src="<?php echo $_novel->img ? img($_novel->img) : img('novel_cover_default.png')  ?>" alt="Novel Image" style="height:75PX; width: 55px">
                            <div class="d-flex flex-column justify-content-between w-75">
                                <span class="text-dark fw-bold" style="overflow-x:hidden; white-space: nowrap;text-overflow: ellipsis;"><?php echo $_novel->title ?></span>
                                <small class="text-muted">
                                    <i class="fas fa-eye" style="font-size: 12px"></i> <?php echo number_format_short($_novel->total_views ?? 0) . " views" ?>
                                </small>
                                <div class="d-flex">
                                    <span class="rating_average d-flex" data-stars="<?php echo $_novel->average_rating ?>"></span>
                                    <small class=" text-muted" style="font-size: 12px">(<?php echo number_format($_novel->average_rating ?? 0, 2) ?>)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        <?php endforeach; ?>
        <div class="d-flex justify-content-center">
            <a href="<?php echo url("novels/list?order_by=views&order=desc&status=all") ?>" class="btn btn-primary btn-sm">see more</a>
        </div>

    </div>
</div>
<div class="card mt-3">
    <div class="card-body">
        <h5 class="card-title">
            Top-rated Novels
        </h5>

        <?php foreach ($top_rated as $_novel) : ?>
            <a href="<?php echo url("novel/fetch?novel=$_novel->slug") ?>">
                <div class="card mb-2 shadow-none bg-light">
                    <div class="card-body" style="padding:8px;">
                        <div class="d-flex">
                            <img class="me-2" src="<?php echo $_novel->img ? img($_novel->img) : img('novel_cover_default.png')  ?>" alt="Novel Image" style="height:75PX; width: 55px">
                            <div class="d-flex flex-column justify-content-between w-75">
                                <span class="text-dark fw-bold" style="overflow-x:hidden; white-space: nowrap;text-overflow: ellipsis;"><?php echo $_novel->title ?></span>
                                <small class="text-muted">
                                    <i class="fas fa-eye" style="font-size: 12px"></i> <?php echo number_format_short($_novel->total_views ?? 0) . " views" ?>
                                </small>
                                <div class="d-flex">
                                    <span class="rating_average d-flex" data-stars="<?php echo $_novel->average_rating ?>"></span>
                                    <small class=" text-muted" style="font-size: 12px">(<?php echo number_format($_novel->average_rating ?? 0, 2) ?>)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>

        <div class="d-flex justify-content-center">
            <a href="<?php echo url("novels/list?order_by=rating&order=desc&status=all") ?>" class="btn btn-primary btn-sm">see more</a>
        </div>

    </div>
</div>