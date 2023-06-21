<?php include_once 'views/layouts/header.php' ?>
<?php
function status_color($status)
{
    return $status == 'completed' ? 'success' : ($status == 'ongoing' ? 'primary' : 'danger');
}
?>
<div class="row d-flex justify-content-center">

    <div class="col-lg-6 mt-5">

        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <div>
                    <?php echo session()->get('success') ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h3>New Novels</h3>
            </div>
            <div class="card-body">

                <div class="d-flex justify-content-center flex-wrap">
                    <?php foreach ($novels as $novel) : ?>
                        <div class="me-2 mb-2 novel-card">
                            <a class="text-dark" href="<?php echo url("novel/fetch?novel=$novel->slug") ?>">
                                <div class="card">
                                    <div class="image-container">
                                        <img src="<?php echo $novel->img ? img($novel->img) : img('novel_cover_default.png')  ?>" alt="<?php echo $novel->title ?>" class="card-img-top" style="height:180px;">
                                        <span class="novel-status badge rounded-pill badge-<?php echo status_color($novel->status) ?> m-2">
                                            <?php echo $novel->status ?>
                                        </span>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="d-flex flex-column justify-content-between h-100 w-100">
                                            <span class="rating_average d-flex justify-content-center" data-stars="<?php echo $novel->average_rating ?>"></span>
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
                        </div>
                    <?php endforeach; ?>
                </div>


                <div class="d-flex justify-content-center p-2 bg-light w-100">
                    <a href="<?php echo url('novels/new') ?>" class="text-primary">View All</a>
                </div>
            </div>
        </div>
    </div>


</div>

<?php include_once 'views/layouts/footer.php' ?>

<script>
    $(document).ready(function() {

        add_rating_stars();

        function add_rating_stars() {
            let rating_average = $(".rating_average")

            for (let index = 0; index < rating_average.length; index++) {
                const element = rating_average[index];

                let stars_data = $(element).data('stars');
                let stars = stars_data.split('.');

                result = '';
                // add the full stars
                for (let index = 0; index < Number(stars[0]); index++) {
                    result += '<i class="fas fa-star text-warning me-1"></i>';
                }
                // add the half star
                if (Number(stars[1] > 0)) {
                    result += '<i class="fas fa-star-half-stroke text-warning me-2"></i>';
                }

                // add the blank stars
                let blank_stars = Math.floor(5.0 - stars_data)
                for (let index = 0; index < blank_stars; index++) {
                    result += '<i class="fa-regular fa-star text-warning me-2"></i>';
                }

                $(element).html(result);
            }
        }
    })
</script>