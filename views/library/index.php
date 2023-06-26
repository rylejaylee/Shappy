<?php include_once 'views/layouts/header.php' ?>
<?php
function status_color($status)
{
    return $status == 'completed' ? 'success' : ($status == 'ongoing' ? 'primary' : 'danger');
}
?>
<div class="row d-flex justify-content-center mt-5">

    <div class="col-md-7 col-lg-8 col-xl-6 col-xxl-6">

        <div class="card">
            <div class="card-header">
                <h3>My Library</h3>
            </div>
            <div class="card-body">
                <?php if (is_authorized()) : ?>
                    <?php if (count($novels)) : ?>
                        <div class="d-flex justify-content-center flex-wrap">
                            <?php foreach ($novels as $novel) : ?>
                                <?php include './views/novel/novel_card.php' ?>
                            <?php endforeach; ?>
                        </div>

                    <?php else : ?>
                        <div class="alert alert-secondary text-center">
                            No Novels Added Yet
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="alert alert-secondary text-center">
                        <a class="btn btn-primary" href="<?php echo url("auth/login") ?>">Login to add novels in library</a>
                    </div>
                <?php endif; ?>
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

                let stars_data = $(element).attr('data-stars');
                let stars = stars_data.split('.');

                result = '';
                // add the full stars
                for (let index = 0; index < Number(stars[0]); index++) {
                    result += '<i class="fas fa-star text-warning me-1"></i>';
                }
                // add the half star
                if (Number(stars[1] > 0)) {
                    result += '<i class="fas fa-star-half-stroke text-warning me-1"></i>';
                }

                // add the blank stars
                let blank_stars = Math.floor(5.0 - stars_data)
                for (let index = 0; index < blank_stars; index++) {
                    result += '<i class="fa-regular fa-star text-warning me-1"></i>';
                }

                $(element).html(result);
            }
        }
    })
</script>