<?php
declare(strict_types=1);

const ROOT = __DIR__ . '/../../';

require_once ROOT . '/vendor/autoload.php';

use Example\Hydrahon\Model;
use Example\Hydrahon\Post;
use Example\Hydrahon\PostStatus;
use Example\Hydrahon\User;
use Example\Util\DbConfig;

function main()
{
    $env = new \Dotenv\Dotenv(ROOT);
    $env->overload();

    $config = new DbConfig();
    $pdo = $config->createPdo();
    Model::$pdo = $pdo;

    // ユーザー登録
    $author = new User();
    $author->name = 'Mike';
    $author->save();

    // ユーザーが記事を作成
    $author = User::findByName('Mike')[0];
    $post = new Post();
    $post->authorId = $author->id;
    $post->title = 'First Post';
    $post->content = 'Hello, everyone!';
    $post->status = new PostStatus(PostStatus::PUBLIC);
    $post->save();

    // 記事を取得
    $post = Post::findById(1);
    // 作者を取得
    $author = $post->author();
}

main();
