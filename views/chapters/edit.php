<?php include_once 'views/layouts/header.php' ?>

<h1>Edit Chapter</h1>
<?php if (session()->has('error')) { ?>
    <?php echo session()->get('error') ?>
<?php } ?>
<form action="/chapters/update" method="POST">
    <label for="title">Title</label>
    <input type="hidden" name="chapter_id" value="<?php echo $chapter->id ?>">
    <input type="text" name="title" value="<?php echo old('title') ?? $chapter->title ?>"><br>
    <label for="content">Content</label>
    <textarea name="content" id="content" cols="30" rows="10"><?php echo old('content') ?? $chapter->content  ?></textarea>
    <input type="submit" value="update" name="submit">
</form>

<?php include_once 'views/layouts/footer.php' ?>