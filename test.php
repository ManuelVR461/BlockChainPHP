<?php
require_once("core/blockchain.php");

$session_options= array('use_only_cookies'=>1,'read_and_close'=>true,'session.auto_start'=>1);        
if(!isset($_SESSION)) {
    session_start($session_options);  
} 

$bc = new BlockChain;

if(!isset($_SESSION['datalogin']['bc'])) $_SESSION['datalogin']['bc'] = $bc;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test BlockChain</title>
    <link rel="stylesheet" href="./statics/css/bootstrap.min.css">
    <link rel="stylesheet" href="./statics/css/font-awesome.min.css">
    <link rel="stylesheet" href="./statics/css/main.css">
</head>
<body>
    <header>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">BlockChain PHP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <a class="nav-link" href="#">Wallet <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link menus"  id="Minar" href="#"  title="Minar Todos las transacciones en MemoryPool">Minar</a>
            </li>
            <li class="nav-item">
            <a class="nav-link menus" href="#" id="listablocks">Lista de Bloques</a>
            </li>
            <li class="nav-item">
                <a class="nav-link menus" href="#" id="test1" tabindex="-1" aria-disabled="true" title="Test Class Block">Test1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link menus" href="#" id="test2" tabindex="-1" aria-disabled="true" title="Test Class BlockChain">Test2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link menus" href="#" id="test3" tabindex="-1" aria-disabled="true" title="Test Method isValidChain into BlockChain">Test3</a>
            </li>
            <li class="nav-item">
                <a class="nav-link menus" href="#" id="test4" tabindex="-1" aria-disabled="true" title="Test Method replaceChain into BlockChain">Test4</a>
            </li>
            <li class="nav-item">
                <a class="nav-link menus" href="#" id="test5" tabindex="-1" aria-disabled="true" title="Test Method Sign into Transaction">Test5</a>
            </li>
            <li class="nav-item">
                <a class="nav-link menus" href="#" id="test6" tabindex="-1" aria-disabled="true" title="Test Method AddOrUdpdate into MemoryPool">Test6</a>
            </li>
            <li class="nav-item">
                <a class="nav-link menus" href="#" id="test7" tabindex="-1" aria-disabled="true" title="Test Method Create Transaction into Wallet">Test7</a>
            </li>
            <li class="nav-item">
                <a class="nav-link menus" href="#" id="Limpiar" tabindex="-1" aria-disabled="true" title="Clean BlockChain">Limpiar</a>
            </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
        </div>
    </nav>
    </header>

    <main role="main">
        <br>
        <br>
        <br>
        <div class="container marketing">

            <div class="row featurette">
                <div class="col-md-8 order-md-2 CuadroListas" style="height:450px;">
                     
                </div>
                <div class="col-md-4 order-md-1 Formulario" style="background:#383838;">
                    <form action="" method="post" class="form" id="formAjax">
                        <div class="form-group">
                            <label for="monto">Monto:</label>
                            <input type="text" class="form-control" name="monto" id="monto">
                        </div>
                        <div class="form-group">
                            <label for="receptor">Wallet del Receptor:</label>
                            <input type="text" class="form-control" name="receptor" id="receptor">
                        </div>
                        <div class="form-group">
                            <input type="button" class="form-control btn btn-secondary" name="" id="enviar" value="Enviar">
                        </div>
                    </form>
                </div>
            </div>
            <hr class="featurette-divider">
            

        </div><!-- /.container -->


        <!-- FOOTER -->
        <footer class="container">
            <p class="float-right"><a href="#">BitGamesLP</a></p>
            <p>&copy; 2020 Personal, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
        </footer>
    </main>
    <script src="./statics/js/jquery-3.4.1.min.js"></script>
    <script src="./statics/js/popper.min.js"></script>
    <script src="./statics/js/main.js"></script>
</body>
</html>