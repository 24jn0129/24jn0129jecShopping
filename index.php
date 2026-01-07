<?php
  require_once './helpers/GoodsGroupDAO.php';
  require_once './helpers/GoodsDAO.php';
  
  $goodsGroupDAO = new GoodsGroupDAO();
  $goodsGroup_list = $goodsGroupDAO->get_goodsgroup();

  $goodsDAO = new GoodsDAO();

  if(isset($_GET['groupcode'])){

    $groupcode = $_GET['groupcode'];
    $goods_list = $goodsDAO->get_goods_by_groupcode($groupcode);
  }
  elseif(isset($_GET['keyword'])){
    $keyword = $_GET['keyword'];
    $goods_list = $goodsDAO->get_goods_by_keyword($keyword); 
  }
  else{
    $goods_list = $goodsDAO->get_recommend_goods();
  }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="uft-8" />
        <title>JecShopping</title>
        <link href="./css/IndexStyle.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include "header.php"; ?>

        <table id="goodsgroup">
            <?php foreach($goodsGroup_list as $goodsgroup) : ?>
            <tr>
                <td>
                    <a href="index.php?groupcode=<?= $goodsgroup->groupcode ?>">
                        <?= $goodsgroup->groupname ?>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?= htmlentities("検索結果：$keyword",ENT_QUOTES,'UTF-8'); ?>

        <div id="goodslist">
        <?php foreach($goods_list as $goods) : ?>
            <table align="left" style="margin-bottom:30px">
                <tr>
                    <td>
                        <a href="goods.php?goodscode=<?= $goods->goodscode ?> ">
                        <img src="images/goods/<?= $goods->goodsimage ?>">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="goods.php?goodscode=<?= $goods->goodscode ?>" >
                        <?= $goods->goodsname ?>
                        </a>
                    </td>
                </tr>
                <tr>
                <tr>
                    <td>
                        ￥<?= number_format($goods->price) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= $goods->recommend? "おすすめ" : " " ?>
                    </td>
                </tr>
            </table>
            <?php endforeach ?>
        </div>
    </body>
</html>