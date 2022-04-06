<?php
require_once 'config/database.php';
require_once 'functions.php';

if (checkSearchInput('search')) {
    $search = explode(' ', $_POST['search']);
    $count = count($search);

    $searchResult = fetchSearchResult($search, $count);

    $products = fetchBySearch($link, 'products', $searchResult);;

    file_put_contents('files/temp.txt', toJSON($products));

} else {
    $products = fetchAll($link, 'products');
    file_put_contents('files/temp.txt', '');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Document</title>
</head>

<body>
    <div class="products">
        <div class="container">
            <form class="form" method="POST" action="">
                <input type="text" class="form-control" id="search" name="search">
                <button type="submit" class="btn btn-outline-secondary">Поиск</button>
            </form>

            <div class="products__table">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Брэнд</th>
                            <th scope="col">Артикул</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Количество</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($products as $product) { ?>
                            <tr>
                                <th scope="row"><?= $product['id'] ?></th>
                                <td><?= $product['title'] ?></td>
                                <td class="table__brand"><?= strtoupper($product['brand']) ?></td>
                                <td><?= $product['article'] ?></td>
                                <td><?= $product['price'] ?> руб.</td>
                                <td class="table__qty">
                                    <?= $product['qty'] ?> шт.
                                    <input type="hidden" id="g<?=$product['id']?>" value="<?=$product['offer_code']?>">
                                </td>
                                
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>

            <?if (checkSearchInput('search')) require_once 'includes/json.php';?>
        </div>
    </div>

</body>

</html>