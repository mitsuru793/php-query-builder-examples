<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Example\Hydrahon\Model;
use Example\Hydrahon\Post;
use Example\Util\DbConfig;

function main()
{
    $env = new \Dotenv\Dotenv(__DIR__ . '/../');
    $env->overload();

    $config = new DbConfig();
    $pdo = $config->createPdo();
    Model::$pdo = $pdo;

    // ユーザー登録
    $author = new \Example\Hydrahon\User();
    $author->name = 'Mike';
    $author->save();

    // ユーザーが記事を作成
    $author = \Example\Hydrahon\User::findByName('Mike')[0];
    $post = new Post();
    $post->authorId = $author->id;
    $post->title = 'First Post';
    $post->content = 'Hello, everyone!';
    $post->status = Post::STATUS_PUBLIC;
    $post->save();

    // 記事を取得
    $post = Post::findById(1);
    // 作者を取得
    $author = $post->author();
}

main();
