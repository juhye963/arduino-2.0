<?php
function DB_conn()
{
    $db_type="mysql";
    $db_host="localhost";
    $db_name="arduino";
    $db_user="sample";
    $db_pass="password";

    $dsn="$db_type:host=$db_host;dbname=$db_name;charset=utf8";

    try
    {   $pdo=new PDO($dsn,$db_user,$db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    }
    catch(PDOException $Exception)
    {   die('error:'.$Exception->getMessage());    } 
    
    return $pdo; 
}
?>