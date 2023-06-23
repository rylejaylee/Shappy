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

                                <div class="d-flex justify-content-end">
                                    <a href="<?php echo url("chapters/create?novel_id=$novel->id") ?>" class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-add"></i> New Chapter
                                    </a>
                                </div>
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
                        <img src="<?php echo $novel->img ? img($novel->img) : img('novel_cover_default.png') ?>" alt="<?php echo $novel->title ?>" class="img-thumbnail" style="height:260px; width: 200px">
                        <?php if (is_authorized() && is_owner($novel->user_id)) : ?>
                            <button id="upload_cover" class="edit-button btn btn-primary btn-sm btn-floating m-1">
                                <i class="fas fa-image"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-center mt-2 mb-4">
                    <h5 class="fw-bold"><?php echo $novel->title ?></h5>
                    <a class="btn btn-primary" href="<?php echo url('chapters/read_first')."?novel=$novel->id" ?>">Start Reading</a>
                </div>

                <!-- Tabs navs -->
                <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="ex3-tab-1" data-mdb-toggle="tab" href="#ex3-tabs-1" role="tab" aria-controls="ex3-tabs-1" aria-selected="true">Details</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex3-tab-2" data-mdb-toggle="tab" href="#ex3-tabs-2" role="tab" aria-controls="ex3-tabs-2" aria-selected="false">Chapters</a>
                    </li>
                </ul>
                <!-- Tabs navs -->

                <!-- Tabs content -->
                <div class="tab-content" id="ex2-content">
                    <!-- tab details -->
                    <div class="tab-pane fade show active" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1">

                        <div class="text-center">
                            <span class="mt-2 d-flex justify-content-center">
                                <span class="rating_average" data-stars="<?php echo $novel->ratings_average ?>"></span>
                            </span>
                            <div class="my-2"><strong>Rating:</strong> <?php echo number_format($novel->ratings_average, 2) ?> / 5.00</small></div>

                            <div class="my-2"><strong>Title:</strong> <?php echo $novel->title ?></div>
                            <div class="my-2"><strong>Author:</strong> <?php echo $novel->name ?></div>
                            <div class="my-2"><strong>Date created:</strong> <?php echo date('m/d/Y', strtotime($novel->created_at)) ?></div>
                            <div class="my-2"><strong>Status:</strong> <?php echo $novel->status ?></div>
                            <div class="my-2"><strong>Chapters:</strong> <?php echo count($chapters) ?></div>
                            <div class="my-2"><strong>Category:</strong>
                                <a href="# " class="btn btn-success btn-rounded btn-sm"><?php echo $novel->category ?></a>
                            </div>
                        </div>

                        <hr class="hr">
                        <h3>Summary</h3>
                        <p>
                            <?php echo $novel->description ?>
                        </p>

                        <!-- add ratings -->
                        <hr class="hr">
                        <div class="my-3 row">
                            <div class="col-md-8 col-lg-6 col-xl-5">
                                <h3 class="mb-4">Ratings</h3>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mt-2">5
                                        <?php for ($i = 1; $i <= 5; $i++) {
                                            echo "<i class='fas fa-star text-warning me-2'></i>";
                                        } ?>
                                    </h5>
                                    <small class="text-muted">(<?php echo $ratings['rating_5'] ?> votes)</small>
                                </div>

                                <div class="progress mt-2">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $_ratings['rating_5'] ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mt-2">4
                                        <?php for ($i = 1; $i <= 4; $i++) {
                                            echo "<i class='fas fa-star text-warning me-2'></i>";
                                        } ?>
                                    </h5>
                                    <small class="text-muted">(<?php echo $ratings['rating_4'] ?> votes)</small>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $_ratings['rating_4'] ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>


                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mt-2">3
                                        <?php for ($i = 1; $i <= 3; $i++) {
                                            echo "<i class='fas fa-star text-warning me-2'></i>";
                                        } ?>
                                    </h5>
                                    <small class="text-muted">(<?php echo $ratings['rating_3'] ?> votes)</small>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $_ratings['rating_3'] ?>%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>


                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mt-2">2
                                        <?php for ($i = 1; $i <= 2; $i++) {
                                            echo "<i class='fas fa-star text-warning me-2'></i>";
                                        } ?>
                                    </h5>
                                    <small class="text-muted">(<?php echo $ratings['rating_2'] ?> votes)</small>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $_ratings['rating_2'] ?>%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mt-2">1
                                        <?php for ($i = 1; $i <= 1; $i++) {
                                            echo "<i class='fas fa-star text-warning me-2'></i>";
                                        } ?>
                                    </h5>
                                    <small class="text-muted">(<?php echo $ratings['rating_1'] ?> votes)</small>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $_ratings['rating_1'] ?>%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <?php if (is_authorized()) : ?>
                                    <button class="btn btn-warning mt-2" id="btn_rating">Rate Novel</button>
                                <?php else : ?>
                                    <a href="<?php echo url('auth/login') ?>">Login to rate novel</a>
                                <?php endif; ?>
                            </div>


                            <!-- comments -->
                            <hr class="hr mt-5">
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
                                <a href="<?php echo url('auth/login') ?>">Login to add comment</a>
                            <?php endif; ?>

                            <hr class="hr mt-4">

                            <!-- reviews list -->
                            <?php if (count($reviews)) : ?>
                                <?php foreach ($reviews as $review) : ?>
                                    <h5><?php echo $review->name ?></h5>
                                    <p><?php echo $review->comment ?></p>
                                    <small><?php echo $review->updated_at ?></small>
                                    <hr class="hr">
                                <?php endforeach; ?>
                            <?php else : ?>
                                <h5 class="text-muted text-center bg-light p-3">No comments yet.</h5>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- tab chapters -->
                    <div class="tab-pane fade" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">

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

                            <!-- pagination links -->
                            <div class="d-flex justify-content-center p-2 bg-light w-100">
                                <a href="<?php echo url('chapters/all?novel=' . $novel->slug) ?>" class="text-primary">View All</a>
                            </div>
                        <?php else : ?>
                            <h5 class="text-muted text-center bg-light p-3">No chapters added yet.</h5>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Tabs content -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h5><i class="fas fa-warning"></i> Confirm delete</h5>
                <hr class="hr">
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
    <div class="modal-dialog modal-dialog-centered">
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

<div class="modal fade" id="rating_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h5><i class="fas fa-face-smile"></i> Rate novel</h5>
                <hr class="hr">

                <form id="rating_form" data-method="post">
                    <p class="text-center" id="rating_text">Add you rating to novel, <strong><?php echo $novel->title ?></strong>!</p>
                    <input type="hidden" name="novel_id" value="<?php echo $novel->id ?>">
                    <input type="hidden" name="rating_id" value="0">
                    <div class="d-flex justify-content-center">
                        <div class="rating">
                            <label>
                                <input type="radio" name="stars" value="1" />
                                <span class="icon"><i class="fas fa-star"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="stars" value="2" />
                                <span class="icon"><i class="fas fa-star"></i></span>
                                <span class="icon"><i class="fas fa-star"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="stars" value="3" />
                                <span class="icon"><i class="fas fa-star"></i></span>
                                <span class="icon"><i class="fas fa-star"></i></span>
                                <span class="icon"><i class="fas fa-star"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="stars" value="4" />
                                <span class="icon"><i class="fas fa-star"></i></span>
                                <span class="icon"><i class="fas fa-star"></i></span>
                                <span class="icon"><i class="fas fa-star"></i></span>
                                <span class="icon"><i class="fas fa-star"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="stars" value="5" />
                                <span class="icon"><i class="fas fa-star"></i></span>
                                <span class="icon"><i class="fas fa-star"></i></span>
                                <span class="icon"><i class="fas fa-star"></i></span>
                                <span class="icon"><i class="fas fa-star"></i></span>
                                <span class="icon"><i class="fas fa-star"></i></span>
                            </label>
                        </div>
                    </div>
                    <br />
                    <button type="submit" class="btn btn-primary btn mt-2 btn-block" id="rating_btn">Add Rating</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'views/layouts/footer.php' ?>

<script>
    $(document).ready(() => {
        add_rating_stars();

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

        $("#btn_rating").click(function() {
            data = {
                'novel_id': <?php echo $novel->id ?>
            }

            $.post("<?php echo url('rating/user_rating') ?>", data, response => {
                // console.log(response)
                rating = JSON.parse(response);
                rate = rating['rating']
                rating_id = rating['id']
                if (Number(rate)) {
                    $(`input[name="stars"][value="${rate}"]`).prop('checked', true)
                    $(`input[name="rating_id"]`).val(rating_id)
                    $('#rating_form').data('method', 'update');
                    $('#rating_btn').text('Update Rating');
                    $('#rating_text').text(`You have already rated this novel with ${rate} stars...`);

                }
            }).fail((xhr, status, error) => {
                console.log(xhr.responseText);
            });

            $("#rating_modal").modal('show')
        })

        $("#rating_form").submit(function(e) {
            e.preventDefault();
            data = $(this).serialize();
            method = $('#rating_form').data('method');

            if (method == 'post') {
                $.post("<?php echo url('rating/store') ?>", data, response => {

                    window.location = '<?php echo url("novel/fetch?novel=$novel->slug") ?>';

                }).fail((xhr, status, error) => {
                    console.log(xhr.responseText);
                });
            } else if (method == 'update') {
                $.post("<?php echo url('rating/update') ?>", data, response => {

                    window.location = '<?php echo url("novel/fetch?novel=$novel->slug") ?>';

                }).fail((xhr, status, error) => {
                    console.log(xhr.responseText);
                });
            }

        })

        function add_rating_stars() {
            let rating_average = $(".rating_average")

            let stars_data = rating_average.attr('data-stars')
            let stars = stars_data.split('.');

            result = '';
            // add the full stars
            for (let index = 0; index < Number(stars[0]); index++) {
                result += '<i class="fas fa-star text-warning me-2"></i>';
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

            rating_average.html(result);
        }
    })
</script>