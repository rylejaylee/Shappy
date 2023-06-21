<?php include_once 'views/layouts/header.php' ?>

<div class="row d-flex justify-content-center">
    <div class="col-lg-8 mt-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo url() ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="/novel/fetch?novel=<?php echo $chapter->novel_slug ?>">
                                    <?php echo $chapter->novel_title ?>
                                </a>
                            </li>
                            <li class="breadcrumb-item "><?php echo $chapter->title ?></li>
                        </ol>
                    </nav>
                    <div class="d-flex">
                        <?php if (is_authorized() && is_owner($chapter->user_id)) : ?>
                            <a href="<?php echo url("chapters/edit?id=$chapter->id") ?>" class="btn btn-primary btn-sm btn-floating me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button id="btn_delete" class="btn btn-outline-danger btn-sm btn-floating"><i class="fas fa-trash"></i></button>
                        <?php endif; ?>
                    </div>
                </div>

                <hr class="hr">

                <div class="text-center">
                    <h3><?php echo $chapter->title ?></h3>
                    <small class="text-muted"><?php echo $chapter->updated_at ?></small>
                </div>

                <p><?php echo $chapter->content ?></p>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary">
                        << previous</button>
                            <button class="btn btn-primary">next >></button>
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