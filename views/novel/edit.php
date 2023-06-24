<?php include_once 'views/layouts/header.php' ?>


<?php include_once 'views/layouts/header.php' ?>


<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-lg-4">
        <div class="card mt-5">
            <div class="card-body">
                <h1 class="card-title text-primary text-center">Update Novel</h1>
                <hr class="hr">
                <?php if (session()->has('error')) { ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-triangle-exclamation me-2"></i>
                        <div>
                            <?php echo session()->get('error') ?>
                        </div>
                    </div>
                <?php } ?>

                <form action="<?php echo url("novel/update") ?>" method="POST">
                    <input type="hidden" name="novel_id" value="<?php echo $novel->id ?>">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="<?php echo old('title') ?? $novel->title ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Summary</label>
                        <textarea class="form-control" id="editor" name="desc" rows="3"><?php echo old('desc') ?? $novel->description  ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Categories</label>
                        <br />
                        <?php foreach ($categories as $category) : ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $category->id ?>" id="<?php echo $category->id ?>"  
                                    <?php echo in_array($category->id, array_values($novel->categories)) ? 'checked' : '' ?>
                                />
                                <label class="form-check-label" for="<?php echo $category->id ?>">
                                    <?php echo $category->category ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <input type="submit" value="update" name="submit" class="mt-3 btn btn-primary btn-block btn-lg">
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