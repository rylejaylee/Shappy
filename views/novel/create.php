<?php include_once 'views/layouts/header.php' ?>

<h1>Create Novel</h1>

<?php if (session()->has('error')) { ?>
    <?php echo session()->get('error') ?>
<?php } ?>

<form action="/novel/store" method="POST" enctype="multipart/form-data">
    <label for="image">Select an image:</label>
    <input type="file" name="image" id="image"> <br>
    <label for="title">Title</label>
    <input type="text" name="title" value="<?php echo old('title') ?>"><br>
    <label for="desc">Description</label>
    <textarea name="desc" id="desc" cols="30" rows="10"><?php echo old('desc')  ?></textarea>
    <input type="submit" value="create" name="submit">
</form>

<?php include_once 'views/layouts/footer.php' ?>