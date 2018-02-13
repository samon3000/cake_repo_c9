<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;
use Cake\ORM\Query;


class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Tags');
        
        
    }
    
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->tag_string) {
            $entity->tags = $this->_buildTags($entity->tag_string);
        }
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);
            // スラグをスキーマで定義されている最大長に調整
            $entity->slug = substr($sluggedTitle, 0, 191);
        }
    }
    
    protected function _buildTags($tagString)
    {
        //タグをトリミング
        $newTags = array_map('trim', explode(',', $tagString));
        //空のタグを削除
        $newTags = array_filter($newTags);
        //重複するタグの削除
        $newTags = array_unique($newTags);
        
        $out = [];
        $query = $this->Tags->find()->where(['Tags.title In' => $newTags]);
        
        //新しいタグのリストから既存のタグを削除
        foreach ($query->extract('title') as $existing) {
            $index = array_search($existing, $newTags);
            if ($index !==false) {
                unset($newTags[$index]);
            }
        }
        //既存のタグを追加
        foreach ($query as $tag) {
            $out[] = $tag;
        }
        //新しいタグを追加
        foreach ($newTags as $tag) {
            $out[] = $this->Tags->newEntity(['title' => $tag]);
        }
        return $out;
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('title')
            ->minLength('title', 10)
            ->maxLength('title', 255)
    
            ->notEmpty('body')
            ->minLength('body', 10);
    
        return $validator;
    }
    
    public function findTagged(Query $query, array $options)
    {
        $columns = [
            'Articles.id', 'Articles.user_id', 'Articles.title',
            'Articles.body', 'Articles.published', 'Articles.created',
            'Articles.slug',
        ];
        $query = $query
            ->select($columns)
            ->distinct($columns);
        if (empty($options['tags'])) {
            //無指定の時は無タグの記事を探す。
            $query->leftJoinWith('Tags')
                ->where(['Tags.title IS' => null]);
        } else {
            $query->innerJoinWith('Tags')
                ->where(['Tags.title IN' => $options['tags']]);
        }
        return $query->group(['Articles.id']);
    }
}