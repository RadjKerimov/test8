<?php
  session_start();
  require('sql.php');
  require('../function.php');
  $id = $_POST['id'];
  $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
  $pass = trim(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
  $pass2 = trim(filter_var($_POST['confirmpass'], FILTER_SANITIZE_STRING));
  
  //Получаем данные если есть такой пользователь с email
  $result = get_user_by_email($email, $pdo);



 if ($pass != $pass2) {
    set_flash_message('danger', 'Пароли не совпали!');
    redirect_to("../security.php?id=$id");
    die;
  } 
  
  if ($result['email'] == $email || !isset($result['email']) ) {
    $return = update_security($id, $email, $pass, $pdo);

    unset($_SESSION['email']);
    set_flash_message('email', $email);
    set_flash_message('success', 'Профиль успешно обновлен!');
    redirect_to("../page_profile.php?id=$id");
  }else{
    set_flash_message('danger', 'Такой Email занят!');
    redirect_to("../security.php?id=$id");
    die; 
  }



