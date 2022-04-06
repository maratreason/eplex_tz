<?php

/**
 * @param $str
 * @return bool
 */
function checkSearchInput($str)
{
    return isset($_POST[$str]) && $_POST[$str] != '';
}

/**
 * @param array $search
 * @param int $count
 * @return array
 */
function fetchSearchResult($search, $count)
{
    $searchResult = [];
    $i = 0;

    foreach($search as $word) {
        $i++;
        $word = htmlspecialchars($word, ENT_QUOTES);

        if ($i < $count) {
            $searchResult[] = "CONCAT (`title`, `article`, `brand`) LIKE '%$word%' OR ";
        } else {
            $searchResult[] = "CONCAT (`title`, `article`, `brand`) LIKE '%$word%'";
        }
    }

    return $searchResult;
}

/**
 * @param [type] $products
 * @return json
 */
function toJSON($products)
{
    return json_encode($products, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
}

/**
 * @param mysqli $link
 * @param string $table
 * @return array
 */
function fetchAll($link, $table)
{
    $query = "SELECT * FROM `$table`";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($products = []; $row = mysqli_fetch_assoc($result); $products[] = $row);

    return $products;
}

/**
 * @param mysqli $link
 * @param string $table
 * @param array $array
 * @return array
 */
function fetchBySearch($link, $table, $array)
{
    $query = "SELECT * FROM `$table` WHERE " . implode("", $array);
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($products = []; $row = mysqli_fetch_assoc($result); $products[] = $row);

    return $products;
}
