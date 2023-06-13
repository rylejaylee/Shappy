<?php include_once 'views/layouts/header.php' ?>

<h1>Add new</h1>
<?php if (session()->has('error')) { ?>
    <?php echo session()->get('error') ?>
<?php } ?>
<form action="/chapters/store" method="POST">
    <input type="hidden" name="novel_id" value="<?php echo $novel_id ?>">
    <label for="title">Title</label>
    <input type="text" name="title" value="<?php echo old('title') ?>"><br>
    <label for="content">Content</label>
    <textarea name="content" id="content" cols="30" rows="10"><?php echo old('content')  ?></textarea>
    <input type="submit" value="create" name="submit">
</form>

<?php include_once 'views/layouts/footer.php' ?>