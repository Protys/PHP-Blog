<?php
    require_once 'model/CategoryRepository.php';
    require_once 'model/Database.php';

    $db = new Database();

    $rep_category = new CategoryRepository($db);

    if(isset($_GET['id_category']) && is_numeric($_GET['id_category'])) {
        $category = $rep_category->getByID((int)$_GET['id_category']);
        if(isset($_GET['action']) && $_GET['action'] === "remove") {
            if ($rep_category->remove((int)$category['id_category'])) {
                header("Location: admin.php");
                die();
            }
            header("Location: admin.php?error");
            die();
        }
    }

    if(!empty($_POST)) {
        if(empty($rep_category->getByID((int)$_POST['id'])))
            $rep_category->add($_POST);
        else
            $rep_category->update($_POST);
        header("Location: admin.php");
        die();
    }

    $title = (isset($category) ? "Edit" : "Add")." Category";

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
                        <span class="subheading">Kategorie</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <form method="POST">
                    <input hidden name="id" value="<?= isset($category) == true ? $category['id'] : "" ?>" >

                    <div class="control-group">
                        <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" required data-validation-required-message="Fill name." name="name" value="<?= isset($category) == true ? $category['name'] : "" ?>">
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