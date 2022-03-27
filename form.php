<?php
//отключение вывода ошибок на экран
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
header('Content-Type: text/html; charset=UTF-8'); // Отправляем браузеру правильную кодировку UTF-8 без BOM.


$errors=FALSE;
if(empty($_POST['name'])){
    
    $errors=TRUE;
}
if(empty($_POST['email'])){
    
    $errors=TRUE;
}

if (empty($_POST['date'])) {
  
    $errors = TRUE;
}


if(empty($_POST['gender'])){
  
    $errors=TRUE;
}

switch($_POST['gender']) {
    case 'women': {
        $gender='women';
        break;
    }
    case 'men':{
        $gender='men';
        break;
    }
};

if (empty($_POST['body'])) {
    $errors = TRUE;
}

switch($_POST['body']) {
    case 'one': {
        $body='one';
        break;
    }
    case 'two':{
        $body='two';
        break;
    }
    case 'three':{
        $body='three';
        break;
    }
    case 'four':{
        $body='four';
        break;
    }
    case 'five':{
        $body='five';
        break;
    }
};

if (empty($_POST['force'])) {
   
    $errors = TRUE;
}
$power1=in_array('1',$_POST['force']) ? '1' : '0';//Проверяет, присутствует ли в массиве значение (что в чем)
$power2=in_array('2',$_POST['force']) ? '1' : '0';
$power3=in_array('3',$_POST['force']) ? '1' : '0';

if (empty($_POST['bio'])){
   
    $errors= TRUE;
}


// Сохранение в базу данных.
$user='u47495';
$pass='9466229';
$db = new PDO("mysql:host=localhost;dbname=u47495",$user,$pass,array(PDO::ATTR_PERSISTENT => true)); //пример соединения с MySQL при помощи PDO
//Постоянные соединения не закрываются в конце скрипта, а кэшируются и повторно используются, когда другой сценарий запрашивает соединение, используя те же учетные данные.

//Запросы к конкретной базе данных функциями: prepare+execute.
    $stmt = $db->prepare("INSERT INTO application SET name = ?,email=?,date =?,gender=?,body=?,life=?,teleport=?,fly=?,bio=?");
 //Prepare(); В качестве параметра она принимает SQL запрос, но в нем, вместо переменных используются метки, в виде знака вопроса ‘?’ 
 //подготовленные выражения-SQL запрос, в котором вместо переменной ставится специальный маркер (?), для которых важен порядок передаваемых переменных

 // Чтобы  получить данные, надо исполнить этот запрос, предварительно передав в него переменные. Передать можно метод execute(), передав ему массив с переменными:
if( $stmt -> execute(array($_POST['name'],$_POST['email'],$_POST['date'],$gender,$body,$power1,$power2,$power3,$_POST['bio']))){
    $massage="Данные сохранены!";
}else{
    $massage="Возникла ошибка!";
}

$response=['massage'=>$massage];//отправка сообщения от php в js
header('Content-typy: application/json');
echo json_encode($response);
?>
