<?php include_once 'views/layouts/header.php' ?>

<div class="row d-flex justify-content-center">
    <div class="col-lg-8 mt-5">
        <div class="card">
            <div class="card-body">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo url() ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="/novel/fetch?novel=<?php echo $chapter->novel_slug ?>">
                                <?php echo $chapter->novel_title ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?php echo url('chapters/all?novel=' . $chapter->novel_slug) ?>">Chapter List</a></li>
                        <li class="breadcrumb-item "><?php echo $chapter->title ?></li>
                    </ol>
                </nav>


                <hr class="hr">

                <div class="text-center">
                    <h3><?php echo $chapter->title ?></h3>
                    <small class="text-muted me-2"><i class="fas fa-eye"></i> <?php echo number_format_short($chapter->views) ?> views</small>
                    <small class="text-muted"><i class="fas fa-clock"></i> <?php echo hummanDiff($chapter->updated_at) ?></small>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <?php if (is_authorized() && is_owner($chapter->user_id)) : ?>
                        <a href="<?php echo url("chapters/edit?id=$chapter->id") ?>" class="btn btn-primary btn-sm btn-floating me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button id="btn_delete" class="btn btn-outline-danger btn-sm btn-floating"><i class="fas fa-trash"></i></button>
                    <?php endif; ?>
                </div>
                <p><?php echo $chapter->content ?></p>

                <div class="d-flex justify-content-between align-items-center">
                    <?php if ($chapter->is_prev) : ?>
                        <a href="<?php echo url("chapters/fetch_prev?novel=$chapter->novel_id&chapter=$chapter->id") ?>" class="btn btn-primary">
                            <i class="fas fa-angles-left"></i>
                        </a>
                    <?php else : ?>
                        <button disabled class="btn btn-primary"> <i class="fas fa-angles-left"></i></button>
                    <?php endif; ?>

                    <form action="">
                        <select name="chapter" id="chapter_nav" class="form-select">
                            <?php foreach ($chapters as $_chapter) : ?>
                                <option value="<?php echo $_chapter->id ?>" <?php echo $_chapter->id == $chapter->id ? 'selected' : null ?>><?php echo $_chapter->title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>


                    <?php if ($chapter->is_next) : ?>
                        <a href="<?php echo url("chapters/fetch_next?novel=$chapter->novel_id&chapter=$chapter->id") ?>" class="btn btn-primary">
                            <i class="fas fa-angles-right"></i>
                        </a>
                    <?php else : ?>
                        <button disabled class="btn btn-primary"> <i class="fas fa-angles-right"></i></button>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- delete novel modal -->
<div class="modal fade" id="delete_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h5><i class="fas fa-warning"></i> Confirm delete</h5>
                <hr class="hr">
                <p>Are you sure you want to delete this chapter?</p>
                <hr class="hr">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary me-2" data-mdb-dismiss="modal">No</button>
                    <form id="delete_form">
                        <input type="hidden" name="chapter_id" value="<?php echo $chapter->id ?>">
                        <button type="submit" class="btn btn-danger">Yes! Delete Chapter</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/layouts/footer.php' ?>


<script>
    $(document).ready(function() {
        $("#chapter_nav").change(function() {
            const id = $(this).val();

            window.location = "<?php echo url('chapters/fetch?id=') ?>" + id;
        })

        $("#btn_delete").click(function() {
            $("#delete_modal").modal("show")
        })

        $("#delete_form").submit(function(e) {
            e.preventDefault();
            data = $(this).serialize();
            $.post("<?php echo url('chapters/delete') ?>", data, response => {
                if (response != '0') {
                    window.location = `<?php echo url('novel/fetch?novel=') ?>${response}`;
                }
            }).fail((xhr, status, error) => {
                console.log(xhr.responseText);
            });
        })
    })
</script>