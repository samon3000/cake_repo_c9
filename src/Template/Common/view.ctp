<!-- src/Template/Common/view.ctp -->
<h1><?= $this->fetch('title') ?></h1>
<?= $this->fetch('content') ?>

<div class="actions">
    <h3>関連アクション</h3>
    <ul>
    <?= $this->fetch('sidebar') ?>
    </ul>
</div>