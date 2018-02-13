<!-- src/Template/Posts/view.ctp -->
<?php
$this->extend('/Common/view');

$this->assign('title', $post->title);

$this->start('sidebar');

echo var_dump($post['title']);
echo '<br>';
echo var_dump($post);
?>
<li>
<?php
echo $this->Html->link('edit', [
    'action' => 'edit',
    $post->id
]);
?>
</li>
<?php $this->end(); ?>

// 残りの内容は親ビューの 'content' ブロックとして使用可能です。
<?= h($post->body) ?>