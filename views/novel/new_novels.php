<?php include_once 'views/layouts/header.php' ?>
<?php
function status_color($status)
{
    return $status == 'completed' ? 'success' : ($status == 'ongoing' ? 'primary' : 'danger');
}
?>
<div class="row d-flex justify-content-center mt-5">

    <div class="col-md-7 col-lg-8 col-xl-6 col-xxl-6">

        <?php if (session()->has('success')) : ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <div>
                    <?php echo session()->get('success') ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">

                <h3 class="card-title">Novel List</h3>
                <hr class="hr">

                <form class="d-flex mb-4 justify-content-between" id="filter_form" method="GET">
                    <div>
                        <label for="order_by">Order By</label>
                        <select class="form-select form-select-sm form-inline" id="order_by" name="order_by">
                            <option value="date" <?php echo $_GET['order_by'] == 'date' ? 'selected' : null ?>>Date</option>
                            <option value="name" <?php echo $_GET['order_by'] == 'name' ? 'selected' : null ?>>Name</option>
                            <option value="rating" <?php echo $_GET['order_by'] == 'rating' ? 'selected' : null ?>>Rating</option>
                            <option value="views" <?php echo $_GET['order_by'] == 'views' ? 'selected' : null ?>>Views</option>
                        </select>
                    </div>
                    <div>
                        <label for="order">Order</label>
                        <select class="form-select form-select-sm" id="order" name="order">
                            <option value="desc" <?php echo $_GET['order'] == 'desc' ? 'selected' : null ?>>Descending</option>
                            <option value="asc" <?php echo $_GET['order'] == 'asc' ? 'selected' : null ?>>Ascending</option>
                        </select>
                    </div>
                    <div>
                        <label for="status">Status</label>
                        <select class="form-select form-select-sm" id="status" name="status">
                            <option value="all" <?php echo $_GET['status'] == 'all' ? 'selected' : null ?>>All</option>
                            <option value="completed" <?php echo $_GET['status'] == 'completed' ? 'selected' : null ?>>Completed</option>
                            <option value="hiatus" <?php echo $_GET['status'] == 'hiatus' ? 'selected' : null ?>>Hiatus</option>
                            <option value="ongoing" <?php echo $_GET['status'] == 'ongoing' ? 'selected' : null ?>>Ongoing</option>
                        </select>
                    </div>
                </form>

                <div>
                    <?php foreach ($novels as $novel) : ?>

                        <div class="card mb-3 shadow-none">
                            <div class="row g-0">
                                <div class="col-lg-3 col-xl-3 col-xxl-2">

                                    <div class="d-flex justify-content-center">
                                        <div class="image-container">
                                            <img class="novel-img-2" src="<?php echo $novel->img ? img($novel->img) : img('novel_cover_default.png')  ?>" alt="<?php echo $novel->title ?>">
                                            <span class="novel-status badge rounded-pill badge-<?php echo status_color($novel->status) ?> m-2">
                                                <?php echo $novel->status ?>
                                            </span>
                                        </div>
                                    </div>

                                    <span class="rating_average d-flex justify-content-center my-2" data-stars="<?php echo $novel->average_rating ?>"></span>
                                    <div class="d-flex justify-content-center">
                                        <div class="btn btn-primary btn-md mt btn-lg-block mt-1 mb-md-4  mb-lg-0">
                                            Add to library
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-xl-9 col-xxl-10">
                                    <div class="ms-3">
                                        <h5 class="card-title"><?php echo $novel->title ?></h5>
                                        <div class="d-flex tex-muted">
                                            <div class="me-2" style="font-size: 12px">
                                                <i class="fas fa-eye"></i>
                                                <?php echo number_format_short($novel->total_views ?? 0) . " views" ?>
                                            </div>
                                            <div class="me-2" style="font-size: 12px">
                                                <i class="fas fa-clock"></i>
                                                <?php echo hummanDiff($novel->updated_at) ?>
                                            </div>

                                            <div class="me-2" style="font-size: 12px">
                                                <i class="fas fa-book-open"></i>
                                                <?php echo $novel->chapters_count ?? 0 ?> ch.
                                            </div>
                                        </div>

                                        <div>
                                            <?php foreach (json_decode($novel->categories) as$category) : ?>
                                                <a class="btn btn-info btn-sm btn-rounded mt-2 shadow-none py-1 px-2" style="font-size: 12px">
                                                    <?php echo $category?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                        <p class="card-text">
                                            <?php echo excerpt($novel->description, 1000) ?>
                                            <a href="<?php echo url("novel/fetch?novel=$novel->slug") ?>">show more</a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr class="hr">
                    <?php endforeach; ?>

                    <div class="d-flex justify-content-center p-2 bg-light w-100">
                        <nav><?php echo $links ?></nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5 col-lg-4 col-xl-4 col-xxl-3">
        <?php include_once './views/layouts/sidebar.php'  ?>
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

        $("select").change(function() {
            $("#filter_form").submit();
        })

    })
</script>