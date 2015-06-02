<?php
/*
 *  ��� ���� ������
 */
global $tableName;
$tableName = 'goods';
/*
 *  ����������� � ���� ������
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
 *  ��������� ���������� � ����� ������
 */
function databaseDisconnect($conn){
    mysqli_close($conn);
}
/*
 * �������� ��� ������
 * $limit ���������� �������
 * $offset ��������
 * $sort ������� ����������
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
 * ���������� ������� � ���� ������
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
 * ���������� � ���� ������
 * $data ����������� ��������
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
 * ���������� ������ � ���� ������
 * $data ���������� ��������
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
 * �������� ������ �� ���� ������
 * $id ������������� ���������� ������
 */
function databaseDelete($conn,$id)
{
    global $tableName;
    
    $sql = "DELETE FROM ".$tableName." WHERE id = ".$id;
    $result = mysqli_query($conn, $sql); 
    $count = getCacheRecord($tableName.'_count');
    $count = setCacheRecord($tableName.'_count',$count-1);
}
