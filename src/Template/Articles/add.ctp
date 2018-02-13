<h1>記事の追加</h1>
<?php
    echo $this->Form->create($article);
    // 今はユーザーを直接記述
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('title',['type'=>'text','placeholder'=>'title']);
    echo $this->Form->control('body', ['type' => 'textarea','placeholder'=>'article']);
    // echo $this->Form->control('tags._ids', ['options' => $tags]);
    echo $this->Form->control('tag_string', ['type' => 'text','placeholder'=>'tag','width'=>'50%']);
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>