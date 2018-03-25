<?php
    require_once 'model/ArticleRepository.php';
    require_once 'model/Database.php';

    $db = new Database();

    $rep_article = new ArticleRepository($db);

    $id_article = (int)($_GET['id_article']);

    $article = $rep_article->getByID($id_article);

    $title = $article['title'];

    require_once 'layout.html';
?>
<?= $head ?>
<body>
    <?= $nav ?>
    <header class="masthead" style="background-image: url('img/post-bg.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="post-heading">
              <h1><?= $article['title'] ?></h1>
              <span class="meta">Přidal(a)
                <a href="#"><?= $article['author'] ?></a>
                dne <?= $article['date'] ?></span>
            </div>
          </div>
        </div>
      </div>
    </header>
    <article>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <?= $article['text'] ?>
            </div>
        </div>
      </div>
    </article>
    <?= $script ?>
    <?= $foot ?>
</body>
</html>