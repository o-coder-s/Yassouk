<?php
  class Pages extends Controller {
    public function __construct(){
      $this->userModel = $this->model('User');
    }
    
    public function index(){
      
      if(isset($_SESSION['id']) && isset($_SESSION['role']))
      {
        switch ($_SESSION['role']) {
          case 0:
            #admin
            $_SESSION['page'] = 'dashbord';                       
            redirect('admin/dashbord');
            break;

          case 1:
            #moniteur
            $_SESSION['page'] = 'dashbord';
            redirect('moniteur/dashbord');
            break;
          
            case 2:
            #candidat
            if($this->userModel->getStatus() == 1){
              $_SESSION['page'] = 'dashbord';
              redirect('candidat/dashbord/');
            }else{
              redirect('users/activation/');
            }
            break;

          case 3:
            #client
            if($this->userModel->getStatus() == 1){
              $_SESSION['page'] = 'dashbord';
              redirect('client/dashbord/');
            }else{
              redirect('user/activation/');
            }
            break;
          
          
          default:
            echo "<script> alert('Erreur inconneu') </script>";
            break;
        }
      }
      $this->view('pages/index');
    }
  }
?>