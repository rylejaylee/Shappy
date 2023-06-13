<?php include_once 'views/layouts/header.php' ?>

<h1>Edit Novel</h1>

<?php if (session()->has('error')) { ?>
    <?php echo session()->get('error') ?>
<?php } ?>

<form action="/novel/update?id=<?php echo $novel->id ?>" method="POST">
    <input type="hidden" name="novel_id" value="<?php echo $novel->id; ?>">
    <label for="title">Title</label>
    <input type="text" name="title" value="<?php echo old('title') ?? $novel->title ?>"><br>
    <label for="desc">Description</label>
    <textarea name="desc" id="desc" cols="30" rows="10"><?php echo old('desc') ?? $novel->description  ?></textarea>
    <input type="submit" value="update">
</form>
</body>


<?php include_once 'views/layouts/footer.php' ?>