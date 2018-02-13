<h1>ログイン</h1>
<?= $this->Form->create() ?>
<?= $this->Form->control('email',['type'=>'text','placeholder'=>'email']) ?>
<?= $this->Form->control('password',['type'=>'text','placeholder'=>'password']) ?>
<?= $this->Form->button('ログイン') ?>
<?= $this->Form->end() ?>