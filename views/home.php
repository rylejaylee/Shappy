<?php include_once 'views/layouts/header.php' ?>

<?php if (session()->has('success')) : ?>
    <?php echo session()->get('success') ?>
<?php endif; ?>

<div class="d-flex">
    <?php foreach ($data['novels'] as $novel) : ?>
        <a class="novel-card" href="/novel/fetch?novel=<?php echo $novel->slug ?>">
            <img src="<?php echo $novel->img ? img($novel->img) : img('novel_cover_default.png')  ?>" alt="<?php echo $novel->title ?>" height="250" width="170">
            <h3><?php echo $novel->title ?></h3>
            <h5><?php echo $novel->created_at ?></h5>
        </a>
    <?php endforeach; ?>
</div>

<?php include_once 'views/layouts/footer.php' ?>