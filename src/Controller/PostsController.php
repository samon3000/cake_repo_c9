<?php
// src/Controller/ArticlesController.php

namespace App\Controller;


class PostsController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // FlashComponent をインクルード
        $this->Auth->allow(['tags']);
    }
    
    public function index()
    {
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
        
        $username = 'sally';
        $this->set('username', $username);
        // $this->set($username);
    }
    public function view()
    {
        $post = ['title' => 'kkk', 'slider' => 'ggg', 'id' => 54, 'memo' => 'rrr'];
        $this->set('post', $post);
    }
    
    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->data());

            // user_id の決め打ちは一時的なもので、あとで認証を構築する際に削除されます。
            // $article->user_id = 1;
            $article->user_id = $this->Auth->user('id');

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        // タグのリストを取得
        $tags = $this->Articles->Tags->find('list');
        // ビューコンテキストに tags をセット
        $this->set('tags', $tags);
        $this->set('article', $article);
    }
    
    public function edit($slug)
    {
        $article = $this->Articles->findBySlug($slug)
            ->contain('Tags') // 関連づけられた Tags を読み込む
            ->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->data(), [
                // 追加でuser_idの更新を無効化
                'accessibleFields' => ['user_id' => false]
            ]);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }
        // タグのリストを取得
        $tags = $this->Articles->Tags->find('list');
        // ビューコンテキストに tags をセット
        $this->set('tags', $tags);
        $this->set('article', $article);
    }
    
    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);
    
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been deleted.', $article->title));
            return $this->redirect(['action' => 'index']);
        }
    }
    
    public function tags()
    {
        $tags = $this->request->Param('pass');
        $articles = $this->Articles->find('tagged', [
            'tags' => $tags
        ]);
        $this->set([
            'articles' => $articles,
            'tags' => $tags
        ]);
    }
    
    public function isAuthorized($user)
    {
        $action = $this->request->Param('action');
        // add tags アクションは、ログインユーザーに常時許可する。
        if (in_array($action, ['add', 'tags'])) {
            return true;
        }
        // 他のすべてのアクションにはスラッグが必要。
        $slug = $this->request->Param('pass.0');
        if (!$slug) {
            return false;
        }
        // 記事が現在のユーザーに属していることを確認します。
        $article = $this->Articles->findBySlug($slug)->first();
        return $article->user_id === $user['id'];
    }
}