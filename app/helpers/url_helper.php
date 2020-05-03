<?php

function redirect($page='')
{
    header('location:' . URLROOT . '/' . $page);
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function convertDayBack($day){
    switch($day){
        case 'Samedi':
          $day = 'Saturday';
          break;
        case 'Dimanche':
          $day = 'Sunday';
          break;
        case 'Lundi':
          $day = 'Monday';
          break;
        case 'Mardi':
          $day = 'Tuesday';
          break;
        case 'Mercredi':
          $day = 'Wednesday';
          break;
        case 'Jeudi':
          $day = 'Thursday';
          break;
        case 'Vendredi':
          $day = 'Friday';
          break;
        default:
        break;
      }
      return $day;
}

function convertDay($day){
    switch($day){
        case 'Saturday':
          $day = 'Samedi';
          break;
        case 'Sunday':
          $day = 'Dimanche';
          break;
        case 'Monday':
          $day = 'Lundi';
          break;
        case 'Tuesday':
          $day = 'Mardi';
          break;
        case 'Wednesday':
          $day = 'Mercredi';
          break;
        case 'Thursday':
          $day = 'Jeudi';
          break;
        case 'Friday':
          $day = 'Vendredi';
          break;
        default:
        break;
      }
      return $day;
}

function getRole($role){
    switch ($role) {
        case '0':
            return 'Admin <i class="fa fa-star" style="color:gold;"></i>';
            break;
        case '1':
            return 'Moniteur';
            break;
        
        case '2':
            return 'Candidat';
            break;

        default:
            return 'Client';
            break;
    }

}
?>