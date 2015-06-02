<?php
/*
 *  Имя базы данных
 */
global $tableName;
$tableName = 'goods';
/*
 *  Подключение к базе данных
 */
function databaseConnect($dbName){
    $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, $dbName);
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
/*
 *  Разорвать соединение с базой данных
 */
function databaseDisconnect($conn){
    mysqli_close($conn);
}
/*
 * Получить все записи
 * $limit количесиво записей
 * $offset смещение
 * $sort правила сортировки
 */
function databaseGetAll($conn,$limit = LIMIT_ON_PAGE,$offset = 0,$sort = null)
{
    global $tableName;
    
    if(!empty($sort) && isset($sort[0]) && isset($sort[1]))
    {
        $sort = 'ORDER BY '.$sort[0].' '.strtoupper($sort[1]);
    }
    else
    {
        $sort = '';
    }    
    
    $sql = "SELECT * FROM ".$tableName." JOIN (SELECT id FROM ".$tableName." ".$sort." LIMIT ".$limit." OFFSET ".$offset.") as b ON b.id = ".$tableName.".id";
    
    $result = mysqli_query($conn, $sql);
    if($result)
    {    
        while($row = $result->fetch_array()){
            $returnArray[] = $row;
        }
    }
    
    return (isset($returnArray)) ? $returnArray : false;
}

/*
 * Количество записей в базе данных
 */
function databaseGetCount($conn)
{
    global $tableName;
    $goods_count = getCacheRecord($tableName.'_count');
    
    if(!empty($goods_count))
    {
        return $goods_count;
    }
    else
    {
        $sql = "SELECT COUNT(id) as count FROM ".$tableName;
        $result = mysqli_query($conn, $sql); 
        $result = $result->fetch_array();
        setCacheRecord('goods_count', $result['count']);
        return $result['count'];
    }
}

/*
 * Сохранение в базу данных
 * $data сохраняемые значения
 */
function databaseSave($conn,&$data)
{
    global $tableName;
    
    $name = strip_tags($data['name']);
    $name = htmlspecialchars($name);
    $name= mysql_escape_string($name);

    $description = strip_tags($data['description']);
    $description = htmlspecialchars($description);
    $description= mysql_escape_string($description);

    $url = strip_tags($data['url']);
    $url = htmlspecialchars($url);
    $url= mysql_escape_string($url);

    $price = strip_tags($data['price']);
    $price = htmlspecialchars($price);
    $price= mysql_escape_string($price);
    
    if(is_numeric($price) && $description && $url && $name){
        
        $sql = "INSERT INTO ".$tableName." (name,description,price,url) VALUES ('".$name."','".$description."',".$price.",'".$url."')";
        $result = mysqli_query($conn, $sql); 
        
        $count = getCacheRecord($tableName.'_count');
        $count = setCacheRecord($tableName.'_count',$count+1);
        
        return $result; 
    }   
    
    return false;
}
/*
 * Обновление данных в базе данных
 * $data изменяемое значения
 */
function databaseEdit($conn,&$data)
{
    global $tableName;
    
    $value = strip_tags($data['value']);
    $value = htmlspecialchars($value);
    $value= mysql_escape_string($value);
    
        
    if( $data['name'] == 'price' && !is_numeric($data['value']) )
    {
        return false;
    }    
    
    $sql = 'UPDATE '.$tableName.' SET '.$data['name'].'="'.$value.'" WHERE id='.$data['id'];
    $result = mysqli_query($conn, $sql);
    
    return $result;
}
/*
 * Удаление записи из базы данных
 * $id идентификатор изменяемой записи
 */
function databaseDelete($conn,$id)
{
    global $tableName;
    
    $sql = "DELETE FROM ".$tableName." WHERE id = ".$id;
    $result = mysqli_query($conn, $sql); 
    $count = getCacheRecord($tableName.'_count');
    $count = setCacheRecord($tableName.'_count',$count-1);
}
