<?php
    require_once 'model/AuthorRepository.php';
    require_once 'model/Database.php';

    $db = new Database();

    $rep_author = new AuthorRepository($db);

    if(isset($_GET['id_author']) && is_numeric($_GET['id_author'])) {
        $author = $rep_author->getByID((int)$_GET['id_author']);
        if(isset($_GET['action']) && $_GET['action'] === "remove") {
            if ($rep_author->remove((int)$author['id_author'])) {
                header("Location: admin.php");
                die();
            }
            header("Location: admin.php?error");
            die();
        }
    }

    if(!empty($_POST)) {
        if(empty($rep_author->getByID((int)$_POST['id'])))
            $rep_author->add($_POST);
        else
            $rep_author->update($_POST);
        header("Location: admin.php");
        die();
    }

    $title = (isset($author) ? "Edit" : "Add")." Author";

    require_once 'layout.html';
?>
<?= $head ?>
<body>
    <?= $nav ?>
    
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
        <div class="overlay">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>Administrace</h1>
                        <span class="subheading">Autora</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <form method="POST">
                    <input hidden name="id" value="<?= isset($author) == true ? $author['id'] : "" ?>" >

                    <div class="control-group">
                        <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" required data-validation-required-message="Fill name." name="name" value="<?= isset($author) == true ? $author['name'] : "" ?>">
                        <p class="help-block text-danger"></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="form-group">
                        <label>Surname</label>
                        <input type="text" class="form-control" required data-validation-required-message="Fill surname." name="surname" value="<?= isset($author) == true ? $author['surname'] : "" ?>">
                        <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Save</button>
                        <a href="admin.php" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>            
    </div>
    <?= $script ?>
    <?= $foot ?>
</body>
</html>