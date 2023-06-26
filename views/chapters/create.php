<?php include_once 'views/layouts/header.php' ?>


<div class="row d-flex justify-content-center align-items-center">
    <div class="col-lg-4">
        <div class="card mt-5">
            <div class="card-body">
                <h1 class="card-title text-primary text-center">Create Chapter</h1>
                <hr class="hr">
                <?php if (session()->has('error')) { ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-triangle-exclamation me-2"></i>
                        <div>
                            <?php echo session()->get('error') ?>
                        </div>
                    </div>
                <?php } ?>

                <form action="<?php echo url('chapters/store') ?>" method="POST">
                    <input type="hidden" name="novel_id" value="<?php echo $novel_id ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" placeholder="Your new novel title" name="title" value="<?php echo old('title') ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                        <textarea class="form-control" id="editor" name="content" rows="3"></textarea>
                    </div>
                    <input type="submit" value="create" name="submit" class="mt-3 btn btn-primary btn-block btn-lg">
                </form>
            </div>
        </div>
    </div>
</div>


<?php include_once 'views/layouts/footer.php' ?>

<script>
    tinymce.init({
        selector: 'textarea#editor',
        skin: 'bootstrap',
        plugins: 'lists, link, image, media',
        toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
        menubar: false,
    });
</script>
