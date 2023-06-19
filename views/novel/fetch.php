<?php include_once 'views/layouts/header.php'; ?>

<div class="row d-flex justify-content-center mt-5">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <!-- header -->
                <div class="d-flex justify-content-between">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo url() ?>">Home</a></li>
                            <li class="breadcrumb-item "><?php echo $novel->title ?></li>
                        </ol>
                    </nav>

                    <?php if (is_authorized() && is_owner($novel->user_id)) : ?>
                        <div>
                            <div class="d-flex">
                                <a href="<?php echo url("novel/edit?id=$novel->id") ?>" class="btn btn-sm btn-primary btn-floating me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="delete_form">
                                    <input type="hidden" name="id" id="novel_id" value="<?php echo $novel->id; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-floating">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <hr class="hr">
                <?php if (session()->has('success')) : ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <?php echo session()->get('success') ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')) { ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-triangle-exclamation me-2"></i>
                        <div>
                            <?php echo session()->get('error') ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="d-flex justify-content-center">
                    <div class="image-container">
                        <img src="<?php echo $novel->img ? img($novel->img) : img('novel_cover_default.png') ?>" alt="<?php echo $novel->title ?>" height="170" width="120">
                        <?php if (is_authorized() && is_owner($novel->user_id)) : ?>
                            <button id="upload_cover" class="edit-button btn btn-primary btn-sm btn-floating m-1">
                                <i class="fas fa-image"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-center">
                    <div class="my-2"><a href="# " class="btn btn-warning btn-rounded btn-sm"><?php echo $novel->category ?></a></div>
                    <div class="my-2"><strong>Title:</strong> <?php echo $novel->title ?></div>
                    <div class="my-2"><strong>Author:</strong> <?php echo $novel->name ?></div>
                    <div class="my-2"><strong>Date created:</strong> <?php echo date('m/d/Y', strtotime($novel->created_at)) ?></div>
                </div>
                <hr class="hr">
                <h3>Summary</h3>
                <p>
                    <?php echo $novel->description ?>
                </p>


                <hr class="hr">
                <?php if (is_authorized() && is_owner($novel->user_id)) : ?>
                    <div class="d-flex justify-content-end">
                        <a href="<?php echo url("chapters/create?novel_id=$novel->id") ?>" class="btn btn-primary">
                            <i class="fas fa-add"></i> New Chapter
                        </a>
                    </div>
                <?php endif; ?>


                <!-- list of chapters -->
                <?php if (count($chapters)) : ?>
                    <?php foreach ($chapters as $chapter) : ?>
                        <div class="d-flex justify-content-between align-items-center bg-light mt-2">
                            <div class="p-2  my-2">
                                <a href="<?php echo url("chapters/fetch?id=$chapter->id") ?>" class="text-dark">
                                    <span class="text-primary fw-bold"><?php echo $chapter->title ?></span>
                                    <small class="text-muted"><?php echo hummanDiff($chapter->updated_at) ?></small>
                                </a>

                            </div>
                            <?php if (is_authorized() && is_owner($novel->user_id)) : ?>
                                <div>
                                    <div class="d-flex">
                                        <a href="<?php echo url("chapters/edit?id=$chapter->id") ?>" class="btn btn-sm btn-outline-primary btn-floating me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <h5 class="text-muted text-center bg-light p-3">No chapters added yet.</h5>
                <?php endif; ?>

                <!-- add ratings -->

                <!-- reviews -->

                <h3>Comments</h3>
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
                    <h5 class="text-muted text-center bg-light p-3">No comments yet.</h5>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5><i class="fas fa-warning"></i> Confirm delete</h5>
                <p>Are you sure you want to delete this novel?</p>
                <hr class="hr">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary me-2" data-mdb-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="delete_novel">Yes! Delete Novel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="upload_cover_modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5><i class="fas fa-image"></i> Upload new cover</h5>
                <hr class="hr">

                <form enctype="multipart/form-data" method="POST" id="upload_cover_form">
                    <input type="hidden" name="novel_id" value="<?php echo $novel->id ?>">
                    <div class="mb-3">
                        <label class="form-label">Choose image file</label>
                        <input class="form-control" type="file" name="image">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/layouts/footer.php' ?>

<script>
    $(document).ready(() => {
        $("#delete_form").submit(function(e) {
            e.preventDefault();
            $("#delete_modal").modal('show');
        })

        $("#upload_cover").click(function() {
            $("#upload_cover_modal").modal('show');
        })

        $("#delete_novel").click(function() {
            let data = $('#delete_form').serialize();

            $.post("<?php echo url('novel/delete') ?>", data, response => {
                if (Number(response)) {
                    window.location = '<?php echo url() ?>';
                }
            }).fail((xhr, status, error) => {
                console.log(xhr.responseText);
            });
        })

        $("#upload_cover_form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo url('novel/upload_cover') ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    window.location = '<?php echo url("novel/fetch?novel=$novel->slug") ?>';
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        })
    })
</script>