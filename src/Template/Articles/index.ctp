<h1>記事一覧</h1>
<?php
    $total = [];
    $total02 = [];
    foreach ($query as $row):
        $total[] = $row->title;//記事総数用
        $total02[] = $row->user_id;//投稿記事数用
    endforeach;
    $this->set('total',$total);
    $total02 = array_count_values($total02);
    if(isset($name1)){
        $i = $list01[$name1];
    };
?>

<?php
    if(is_null($user1)) {
        echo $this->Html->link('ログイン', ['controller'=>'Users','action'=>'login']);
    } else {
        echo 'ようこそ！ ' . h($name1) . ' さん。 ' . 'あなたの投稿した記事は　' . h($total02[$i]) . '件あります。';
        echo $this->Html->link('ログアウト', ['controller'=>'Users','action'=>'logout']);
    };
?>

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
        $total[] = $row->title;//記事総数用
    endforeach;
    echo '<h4>記事の総数：' . count($total) . '</h4>';
?>
<br>

    
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