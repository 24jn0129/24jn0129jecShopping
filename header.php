<?php
     require_once './helpers/MemberDAO.php';
     require_once './helpers/CartDAO.php';

     if(session_status() === PHP_SESSION_NONE){
        session_start();
     }


     if(!empty($_SESSION['member'])){
        $member = $_SESSION['member'];
        $cartDAO = new CartDAO();
        $num = $cartDAO->get_cart_num($member->memberid);
     }
?>
<header>
    <link href="./css/HeaderStyle.css" rel="stylesheet">

    <div id="logo">    
    <a href="index.php">
        <img src="images/JecShoppingLogo.svg" alt="JecShopping ロゴ"> 
    </a> 
    </div>
    <div id="link">
        <form action="index.php" method="GET">
        <input type="text" name="keyword">
        <input type="submit" value="検索"><br>
        <?php if (isset($member)) : ?>
            <?= $member->membername ?>さん
            <a href="cart.php">カート(<?= $num['sum'] ?>)</a>
            <a href="logout.php">ログアウト</a>
        <?php else: ?>
        <a href="login.php">ログイン</a>
        <?php endif; ?>
    </div>
    <div id="clear">
    <hr>
    </div>
</header>




