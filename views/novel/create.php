<?php include_once 'views/layouts/header.php' ?>


<div class="row d-flex justify-content-center align-items-center">
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
                        <textarea class="form-control" id="editor" name="desc" rows="7"><?php echo old('desc') ?? '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Categories</label>
                        <br />
                        <?php foreach ($categories as $category) : ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $category->id ?>" id="<?php echo $category->id ?>" />
                                <label class="form-check-label" for="<?php echo $category->id ?>">
                                    <?php echo $category->category ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>



                    <input type="submit" value="create" name="submit" class="mt-3 btn btn-primary btn-block btn-lg">
                </form>
            </div>
        </div>
    </div>
</div>


<?php include_once 'views/layouts/footer.php' ?>
