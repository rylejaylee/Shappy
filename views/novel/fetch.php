<?php include_once 'views/layouts/header.php'; ?>

<div class="row d-flex justify-content-center mt-5">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">

                <?php if (session()->has('success')) : ?>
                    <?php echo session()->get('success') ?>
                <?php endif; ?>

                <h1 class="card-title">
                    <h1><?php echo $novel->title ?></h1>
                </h1>


                <img src="<?php echo $novel->img ? img($novel->img) : img('novel_cover_default.png') ?>" alt="<?php echo $novel->title ?>" height="170" width="120">

                <h5 class="my-2">Author: <?php echo $novel->name ?></h5>
                <p>
                    <?php echo $novel->description ?>
                </p>

                <small><?php echo $novel->updated_at ?></small>

                <?php if (is_authorized() && is_owner($novel->user_id)) : ?>
                    <a href="<?php echo url("novel/edit?id=$novel->id") ?>">edit</a>
                    <form id="delete_form">
                        <input type="hidden" name="id" id="novel_id" value="<?php echo $novel->id; ?>">
                        <input type="submit" value="delete">
                    </form>
                    <hr>

                    <a href="<?php echo url("chapters/create?novel_id=$novel->id") ?>">Add Chapter</a>
                <?php endif; ?>


                <!-- list of chapters -->
                <?php if (count($chapters)) : ?>
                    <?php foreach ($chapters as $chapter) : ?>
                        <h5>
                            <a href="<?php echo url("chapters/fetch?id=$chapter->id") ?>"><?php echo $chapter->title ?></a>
                            <small><?php echo $chapter->updated_at ?></small>
                        </h5>
                    <?php endforeach; ?>
                <?php else : ?>
                    <h3>No chapters added yet.</h3>
                <?php endif; ?>

                <!-- add ratings -->

                <!-- reviews -->
                <hr class="hr">
                <h3>Reviews</h3>
                <?php if (session()->has('error')) : ?>
                    <p class="text-danger"><?php echo session()->get('error') ?></p>
                <?php endif; ?>

                <?php if (is_authorized()) : ?>
                    <form action="<?php echo url('reviews/store') ?>" method="POST">
                        <div class="form-outline">
                            <textarea class="form-control" name="comment" id="comment" rows="4" placeholder="Enter your comment here..."></textarea> <br>
                            <label class="form-label" for="comment">Your Comment</label>
                        </div>

                        <input type="hidden" name="novel_id" value="<?php echo $novel->id ?>">
                        <div class="d-flex justify-content-end">
                            <input type="submit" value="submit" name="submit" class="btn btn-primary mt-3">
                        </div>
                    </form>
                <?php else : ?>
                    <a href="<?php echo url('auth/login') ?>">Login to add review</a>
                <?php endif; ?>

                <hr class="hr">

                <!-- reviews list -->
                <?php if (count($reviews)) : ?>
                    <?php foreach ($reviews as $review) : ?>
                        <h5><?php echo $review->name ?></h5>
                        <p><?php echo $review->comment ?></p>
                        <small><?php echo $review->updated_at ?></small>
                        <hr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <h3>No reviews.</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/layouts/footer.php' ?>

<script>
    $(document).ready(() => {
        $("#delete_form").submit(function(e) {
            e.preventDefault();

            if (confirm("Are you sure you want to delete this novel?")) {
                let data = $(this).serialize();

                $.post("<?php echo url('novel/delete') ?>", data, response => {
                    if (Number(response)) {
                        window.location = '<?php echo url() ?>';
                    }
                }).fail((xhr, status, error) => {
                    console.log(xhr.responseText);
                });
            }
        })
    })
</script>