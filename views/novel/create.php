<?php include_once 'views/layouts/header.php' ?>


<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-lg-4">
        <div class="card mt-5">
            <div class="card-body">
                <h1 class="card-title text-primary text-center">Create Novel</h1>
                <hr class="hr">
                <?php if (session()->has('error')) { ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-triangle-exclamation me-2"></i>
                        <div>
                            <?php echo session()->get('error') ?>
                        </div>
                    </div>
                <?php } ?>

                <form action="<?php echo url('novel/store') ?>" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label">Novel Cover</label>
                        <input class="form-control" type="file" name="image">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" placeholder="Your new novel title" name="title" value="<?php echo old('title') ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Summary</label>
                        <textarea class="form-control" id="editor" name="desc" rows="3"><?php echo old('desc') ?? '' ?></textarea>
                    </div>
                    <select class="form-select" aria-label="Default select example" name="category">
                        <option selected value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id ?>"><?php echo $category->category ?></option>
                        <?php endforeach; ?>
                    </select>
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
        plugins: 'lists, link, image, media, emoticons',
        toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
        menubar: false,
    });
</script>