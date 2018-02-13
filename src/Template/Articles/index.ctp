<h1>記事一覧</h1>

<table>
    <tr class="inu">
        <th class="inu"><?= $this->Html->link('記事の追加', ['action' => 'add'], ['class'=>'oni']) ?></th>
        <th class="inu"><?= $this->Html->
        link('新規ユーザー登録', ['controller' => 'users', 'action' => 'add'], ['class'=>'oni']) ?></th>
    <tr>
<table>

<?php
    $total = [];
    foreach ($query as $row):
        $total[] = $row->title;
    endforeach;
    echo '記事の総数：' . count($total);
?>
<br>

<?= h($kook['momo']) ?>
<br>
<?= h($kook['gogo']) ?>
    
<table>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('title','タイトル') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_id','投稿者') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created','作成日時') ?></th>
        <th>ACTION</th>
    </tr>

    <!-- ここで、$articles クエリーオブジェクトを繰り返して、記事の情報を出力します -->

    <?php foreach ($articles as $article): ?>
    
    <tr>
        <td>
            <?= $this->Html->link($article->title, ['action' => 'view', $article->slug]) ?>
        </td>
        <td>
            <?= $this->Html->link($article->user_id, ['action' => 'view', $article->slug]) ?>
        </td>
        <td>
            <?= $article->created->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $this->Html->link('編集', ['action' => 'edit', $article->slug]) ?>
            <?= $this->Form->postLink(
                '削除',
                ['action' => 'delete', $article->slug],
                ['confirm' => 'よろしいですか?'])
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>