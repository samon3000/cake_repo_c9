

<?php if ($username === 'sally'): ?>
   <h3>やあ、Sally</h3>
<?php elseif ($username === 'joe'): ?>
   <h3>やあ、Joe</h3>
<?php else: ?>
   <h3>やあ、知らない人</h3>
<?php endif; ?>
<?= var_dump($username); ?>
<br>
<?= print_r($username); ?>
<br>
<?= is_null($username); ?>
<br>

<?php
echo h($articles);
echo "<br/>" ;
echo h(is_object($articles));

class MyArrayObject extends ArrayObject
{
    public function count()
    {
        echo 'count処理が呼び出されました：';
        return parent::count();
    }
}

$arrayobj = new MyArrayObject($articles);

echo "<ul>";
foreach ($arrayobj as $key => $value) {
    echo '<li>' . $key . ":" . $value .'</li>';
}
echo "</ul>";

echo h($arrayobj);
echo "<br/>" ;
echo h(is_object($arrayobj));
echo "<br/>" ;

echo "<pre>" ;
// Debugger::dump($arrayobj);
echo "</pre>" ;

echo count($arrayobj);
?>




