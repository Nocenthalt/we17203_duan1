<?php

// function connection()
// {
//     try {
//         $conn = new PDO("mysql:host=localhost; dbname=xshop; charset=utf8", "root", "");
//         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         return $conn;
//     } catch (PDOException $e) {
//         throw $e;
//     }
// }


// kết nối với database
function connection()
{
    $dburl = "mysql:host=localhost;dbname=xshop;charset=utf8";
    $dbuser = "root";
    $dbpass = "";

    try {
        $conn = new PDO($dburl, $dbuser, $dbpass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function get_data_all($sql)
{
    $conn = connection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// thực thi câu lệnh sql
function pdo_execute($sql)
{
    $sql_vals = array_slice(func_get_args(), 1);
    try {
        $conn = connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute(...$sql_vals);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        echo "<br>" . "Execution failed: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

// minified version of pdo_execute
function pdo_exec($a) { try { $b=connection();$c=$b->prepare($a);$c->execute(...array_slice(func_get_args(),1));$d=$c->fetch(PDO::FETCH_ASSOC);return $d; } catch (PDOException $e) { echo "<br>Execution failed: {$e->getMessage()}"; } finally { $conn=null; } }

// lấy dữ liệu
function pdo_query($sql, $params = null)
{
    $conn = connection();

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    } catch (PDOException $e) {
        echo "<br>" . "Query failed: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}

// lấy dữ liệu một hàng
function pdo_query_once($sql, $params = null)
{
    $conn = connection();

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    } catch (PDOException $e) {
        throw "Query failed: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}



?>