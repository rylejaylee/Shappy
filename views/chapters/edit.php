<?php include_once 'views/layouts/header.php' ?>


<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-lg-4">
        <div class="card mt-5">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h1 class="card-title text-primary text-center">Edit Chapter</h1>
                    <button class="btn btn-danger btn-floating" data-mdb-toggle="tooltip" title="Delete Chapter" id="btn_delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <hr class="hr">
                <?php if (session()->has('error')) { ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-triangle-exclamation me-2"></i>
                        <div>
                            <?php echo session()->get('error') ?>
                        </div>
                    </div>
                <?php } ?>

                <form action="<?php echo url('chapters/update') ?>" method="POST">
                    <input type="hidden" name="chapter_id" value="<?php echo $chapter->id ?>">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" placeholder="Your new novel title" name="title" value="<?php echo old('title') ?? $chapter->title ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                        <textarea class="form-control" id="editor" name="content" rows="3"><?php echo old('content') ?? $chapter->content ?></textarea>
                    </div>
                    <input type="submit" value="update" name="submit" class="mt-3 btn btn-primary btn-block btn-lg">
                </form>
                <hr class="hr">
                <p>
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
        tinymce.init({
            selector: 'textarea#editor',
            skin: 'bootstrap',
            plugins: 'lists, link, image, media',
            toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
            menubar: false,
        });

        $("#btn_delete").click(function() {
            $("#delete_modal").modal("show")
        })

        $("#delete_form").submit(function(e) {
            e.preventDefault();
            data = $(this).serialize();
            $.post("<?php echo url('chapters/delete') ?>", data, response => {
                if(response != '0') {
                    window.location = `<?php echo url('novel/fetch?novel=') ?>${response}`;
                }
            }).fail((xhr, status, error) => {
                console.log(xhr.responseText);
            });
        })
    })
</script>