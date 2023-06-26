<?php include_once 'views/layouts/header.php' ?>


<?php include_once 'views/layouts/header.php' ?>


<div class="row d-flex justify-content-center align-items-center">
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
                        <textarea class="form-control" id="editor" name="desc" rows="7"><?php echo old('desc') ?? $novel->description  ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Categories</label>
                        <br />
                        <?php foreach ($categories as $category) : ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $category->id ?>" id="<?php echo $category->id ?>" <?php echo in_array($category->id, array_values($novel->categories)) ? 'checked' : '' ?> />
                                <label class="form-check-label" for="<?php echo $category->id ?>">
                                    <?php echo $category->category ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="status">Novel Status</label>
                        <br />
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="ongoing" value="ongoing" <?php echo $novel->status == 'ongoing' ? "checked" : null ?> />
                            <label class="form-check-label text-info" for="ongoing">Ongoing</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="completed" value="completed" <?php echo $novel->status == 'completed' ? "checked" : null ?> />
                            <label class="form-check-label text-success" for="completed">Completed</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="hiatus" value="hiatus" <?php echo $novel->status == 'hiatus' ? "checked" : null ?> />
                            <label class="form-check-label text-danger" for="hiatus">Hiatus</label>
                        </div>
                    </div>

                    <input type="submit" value="update" name="submit" class="mt-3 btn btn-primary btn-block btn-lg">
                </form>
            </div>
        </div>
    </div>
</div>


<?php include_once 'views/layouts/footer.php' ?>