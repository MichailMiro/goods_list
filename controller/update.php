<?php
/*
 * �������������� ������ � ���� ������
 */
$conn = databaseConnect(DB_NAME);
$data = [
        'name' => $_POST['name'],
        'value' => $_POST['value'],
        'id' => $_POST['pk'],
        ];
databaseEdit($conn,$data);
databaseDisconnect($conn);
   
echo true;