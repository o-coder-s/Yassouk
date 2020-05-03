<?php

class Users extends Controller{
  public function __construct(){
    $this->userModel = $this->model('User');
  }

public function wrong(){
  $this->view('users/wrong');
}
  
public function signin(){

    if($_SERVER['REQUEST_METHOD']=='POST')
    { 
      //sanatize the post array
      $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
      
      $data=[
        'email' => trim($_POST['email']),
        'password' =>trim($_POST['password']),
        'email_err' =>'',
        'password_err' =>''
      ];

      //validate email
      $_POST['email'] = strtolower($_POST['email']);
      if(strlen($_POST['email'])<15){
        $data['email_err'] = "Email invalid";
      }else if(!$this->userModel->checkEmail($data['email'])){
        $data['email_err'] = "Email n'existe pas";
      }

      //validate if the account is deactivated or not 
      if($this->userModel->checkActif($data['email'])){
        $data['email_err'] = "Votre compte a été disactivé";
      }
    
      //validate password

      if(strlen($_POST['password'])<6 && (empty($data['email_err']))){
        $data['password_err'] = 'Au moins 6 caractères';
      }else{ 
        if(empty($data['email_err'])){
        $userData = $this->userModel->getUserData($data['email']);
        if($data['password']==$userData->password){
          $_SESSION['id'] = $userData->id_user;
          $_SESSION['role'] = $userData->role;
          switch ($userData->role) {
            case 0:
              #admin
              $_SESSION['page'] = 'dashbord';
              redirect('admin/dashbord/');
              break;

            case 1:
              #moniteur
              $_SESSION['page'] = 'dashbord';
              redirect('moniteur/dashbord/');
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
                redirect('users/activation/');
              }
              break;
  
            default:
              echo "<script> alert('Erreur inconneu') </script>";
              break;
          }
        }else{
            $data['password_err'] = 'Mot de pass incorrect';
          }
        }
      }
    }else{

      //Init data
      $data=[
        'email' => '',
        'password' =>'',
        'email_err' =>'',
        'password_err' =>''
      ];

    }

    $this->view('users/signin',$data);
  }

  public function dossier($id){
    $dossier = base64_decode($this->userModel->getDossier($id));
    $this->view('users/dossier',$dossier);
  }

  public function signup(){
    //Check for post
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
    //Process form
    //sanatize the input because the trim function works only with strings
    $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

    $lp =$this->userModel->getPermis();
    $p = array();

    foreach($lp as $l){
      array_push($p,$l->categorie);
    }

    $data=[
      'ufamilyname'=>trim($_POST['familyname']),
      'name' => trim($_POST['name']),
      'address' => trim($_POST['address']),
      'email' =>trim($_POST['email']),
      'birth' =>trim($_POST['birth']),
      'role' =>trim($_POST['role']),
      'blood' =>trim($_POST['blood']),
      'sexe' => trim($_POST['sexe']),
      'phone' => trim($_POST['phone']),
      'password' =>trim($_POST['password']),
      'repassword' => trim($_POST['repassword']),
      'permis' =>trim($_POST['permis']),
      'listpermis' => $this->userModel->getPermis(),
      'familyname_err'=>'',
      'address_err' => '',
      'name_err' => '',
      'email_err' =>'',
      'birth_err' =>'',
      'password_err' =>'',
      'repassword_err' => '',
      'role_err' => '',
      'addedFrom' => '1'
    ];

    //validate familyname
    $_POST['familyname'] = strtolower($_POST['familyname']);
    if(strlen($_POST['familyname'])<4){
      $data['familyname_err'] = "Le nom doit etre superieure a 3 caractères";
    }
    if(!preg_match("/[a-z]+/ ",$_POST['familyname']) && empty($data['familyname_err']))
    {
      $data['familyname_err'] = "Utilise que des alphabets";
    }

    //validate name
    $_POST['name'] = strtolower($_POST['name']);
    if(strlen($_POST['name'])<4){
      $data['name_err'] = "Au moins 4 caractères";
    }
    if(!preg_match("/[a-z]+/ ",$_POST['name']) && empty($data['name_err']))
    {
      $data['name_err'] = "Utilise que des alphabets";
    }

    //validate address

    if(strlen($_POST['address'])>100)
    {
      $data['address_err'] = "Pas plus de 100 caractères";
    }


    //validate email
    $_POST['email'] = strtolower($_POST['email']);
    if(strlen($_POST['email'])<15){
      $data['email_err'] = "email trop court";
    }else if($this->userModel->checkEmail($data['email'])){
      $data['email_err'] = "Email existe déja";
    }
    

    //validate phone
    if(strlen($_POST['phone'])!=10 || !preg_match("/^[0]/ ",$_POST['phone']))
    {
      $data['phone_err'] = "Numéro de téléphone incorrect";
    }

    $phones = $this->userModel->getPhone();

    foreach($phones as $phone){
        if($phone->telephone==$_POST['phone']){
          $data['phone_err'] = "Numéro existe déja";
          break;
        }
    }

    //validate role in case of F12 (inspect)
      if(isset($_POST['role'])){
      if($data['role'] != 2 && $data['role'] != 3 ){
        $data['role_err'] = "Ne jeu pas avec les elements";
      }
    }
    //Validate birthdate
    
    if(isset($_POST['birth'])){
      $date = date('Y-m-d');
      $date1=date_create($_POST['birth']);
      $date2=date_create($date);
      $diff=date_diff($date1,$date2);
      $age = $diff->y;
      if($age<18){
        $data['birth_err'] = "Age 18 au minimum";
      }
    }
    
    //permis error
    if($data['role']==2&&!in_array($_POST['permis'],$p)){
      $data['permis_err'] = 'Ne jou pas avec les elements';
    }
    //Validate Password

    if(strlen($_POST['password'])<6){
      $data['password_err'] = 'Au moins 6 caractères';
    }

    if($_POST['password']!=$_POST['repassword'] && empty($data['password_err']))
    {
      $data['repassword_err'] = 'Ne pas le mème mot de pass';
    }
  
    //sign up the user $data['address_err']
    if(empty($data['familyname_err'])&&empty($data['name_err'])&&empty($data['email_err'])&&empty($data['permis_err'])
    &&empty($data['birth_err'])&&empty($data['password_err'])&&empty($data['repassword_err'])&&empty($data['address_err'])){
      $this->userModel->createUser($data);
      $_SESSION['id']=$this->userModel->getUserData($data['email'])->id_user;
      redirect('users/activation');
    }

    }else{
    //Init data
    $data=[
      'ufamilyname'=>'',
      'name' => '',
      'address' => '',
      'email' =>'',
      'birth' =>'',
      'role' =>'',
      'blood' =>'',
      'permis' =>'',
      'sexe' => '',
      'phone' => '',
      'password' =>'',
      'repassword' => '',
      'listpermis' => $this->userModel->getPermis(),

      'familyname_err'=>'',
      'address_err' => '',
      'name_err' => '',
      'email_err' =>'',
      'birth_err' =>'',
      'password_err' =>'',
      'repassword_err' => '',
      'role_err' => ''
    ];
    
    }

    $this->view('users/signup',$data);
  }

  public function npassword(){
    if(!isset($_SESSION['id'])){
      redirect();
    }


    if($_SERVER['REQUEST_METHOD']=='POST'){
      $data=[
        'id' =>$_SESSION['id'],
        'password' => trim($_POST['password']),
        'npassword' => trim($_POST['npassword']),

        'password_err' => '',
        'npassword_err' => ''
      ];

      //checking

      if(strlen($data['password'])<6){
        $data['password_err'] = 'Au moins 6 caractères';
      }

      if($data['password']!=$data['npassword']&&empty($data['password_err']))
      {
        $data['npassword_err'] = 'Ne pas le meme mot de pass';
      }

      if(empty($data['password_err'])&&empty($data['npassword_err'])){
        $this->userModel->updatePassword($data);
        session_destroy();
        //flush message of success
        redirect();
      }

    }else{
      $data=[
        'password' => '' ,
        'npassword' => '',

        'password_err' => '',
        'npassword_err' => ''
      ];
    }

    $this->view('users/npassword',$data);

  }

  public function question(){
    if(!isset($_SESSION['email'])){
      redirect();
    }
    $user = $this->userModel->getUserData($_SESSION['email']);
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $data=[
        'family_name' => strtolower(trim($_POST['family_name'])),
        'name' => strtolower(trim($_POST['name'])),
        'phone' => $_POST['phone']
      ];

      //cheking the data
      if(strtolower($user->nom) == $data['family_name'] && strtolower($user->prenom)==$data['name']&&$user->phone='0'.$data['phone']){
        $_SESSION['id']=$user->id_user;
        redirect('users/npassword/');
      }else{
        redirect('users/wrong');
      }
    }else{
      $data=[
        'family_name' => '',
        'name' => '',
        'phone' => ''
      ];
    }
    $this->view('users/question',$data);
  }

  public function fpassword()
  {
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $data = [
        'email'=>trim($_POST['email']),
        'email_err' =>''
      ];

      if($this->userModel->checkEmail(trim($_POST['email']))){
        session_start();
        $_SESSION['email'] = $data['email'];
        redirect('users/question/');

      }else{
        $data['email_err'] = `Email n'existe pas`; 
      }

      }else{
        $data = [
          'email'=>'',
          'email_err' =>''
        ];
      }
    
    $this->view('users/fpassword',$data);
  }

  public function activation()
  {
    if(isset($_SESSION['id']) && ($_SESSION['role']==2 || $_SESSION['role']==3) && $this->userModel->getStatus()==0){
      $id = $this->userModel->getIdOfPermis($_SESSION['id']);
    if($_SERVER['REQUEST_METHOD']=='POST')
    { 
    
    $data = [
      'id' => $id,
      'code' => trim($_POST['code']),
      'code_err' => ''
    ];

    //getcode
    $code = $this->userModel->getCode()->code;
    if($code != $data['code']){
      $data['code_err'] = "Code incorrect";
    }else{
      $code = $this->userModel->updateStatus();
      redirect();
    }
    }else{
      $data = [
        'id' => $id,
        'code' => '',
        'code_err' => ''
      ];
    }
    $this->view('users/activation',$data);
    }else{
      redirect();
    }
  }

  //logout
  public function logout()
  {
    $this->view('users/logout');
  }

  //edit
  public function modifier()
  {
    if(!isset($_SESSION['id'])){
      redirect();
    }else{
      $_SESSION['page']='edit';
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
    //Process form
      $userData = $this->userModel->getUserDataById($_SESSION['id']);
      $userData = get_object_vars($userData);
      $profilePic = $this->userModel->getPic($userData['Image_id_img']);
      $_SESSION['dp'] = $profilePic->data;
      $_SESSION['dp_id'] = $userData['Image_id_img']; 
    //sanatize the input because the trim function works only with strings
    $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

    $data=[
      'familyname'=>trim($_POST['familyname']),
      'name' => trim($_POST['name']),
      'address' => trim($_POST['address']),
      'email' =>trim($_POST['email']),
      'birth' =>$_POST['birth'],
      'blood' =>trim($_POST['blood']),
      'sexe' => trim($_POST['sexe']),
      'niveau' =>'',
      'phone' => trim($_POST['phone']),
      'cpassword' =>trim($_POST['cpassword']),
      'npassword' =>trim($_POST['npassword']),
      'rn_password' => trim($_POST['rn_password']),
      'mpassword' =>true,

      'familyname_err'=>'',
      'address_err' => '',
      'name_err' => '',
      'email_err' =>'',
      'birth_err' =>'',
      'cpassword_err' =>'',
      'npassword_err' =>'',
      'rn_password_err' => '',
    ];
    if($_SESSION['role']==2){
      $data['niveau']=$this->userModel->getLevelCandidat($_SESSION['id_cad']);
    }

    //validate familyname
    $_POST['familyname'] = strtolower($_POST['familyname']);
    if(strlen($_POST['familyname'])<4){
      $data['familyname_err'] = "Le nom doit etre superieure a 3 caractères";
    }
    if(!preg_match("/[a-z]+/ ",$_POST['familyname']) && empty($data['familyname_err']))
    {
      $data['familyname_err'] = "Utilise que des alphabets";
    }

    //validate name
    $_POST['name'] = strtolower($_POST['name']);
    if(strlen($_POST['name'])<4){
      $data['name_err'] = "Au moins 4 caractères";
    }
    if(!preg_match("/[a-z]+/ ",$_POST['name']) && empty($data['name_err']))
    {
      $data['name_err'] = "Utilise que des alphabets";
    }

    //validate address
    if(strlen($_POST['address'])>100)
    {
      $data['address_err'] = "Pas plus de 100 caractères";
    }

    //validate email
    $_POST['email'] = strtolower($_POST['email']);
    if(strlen($_POST['email'])<15){
      $data['email_err'] = "email trop court";
    }else if($this->userModel->checkEmailEdit($data['email'])){
      $data['email_err'] = "Email existe déja";
    }
    

    //validate phone
    if(strlen($_POST['phone'])!=10 || !preg_match("/^[0]/ ",$_POST['phone']))
    {
      $data['phone_err'] = "Numéro de téléphone incorrect";
    }

    //check if phone number exists 
    $phones = $this->userModel->getPhoneEdit($_SESSION['id']);
    if(isset($phones)){
    foreach($phones as $phone){
        if($phone->telephone==$_POST['phone']){
          $data['phone_err'] = "Numéro existe déja";
          break;
        }
     }
   }

    //Validate birthdate 
    if(isset($_POST['birth'])){
      $date = date('Y-m-d');
      $date1=date_create($_POST['birth']);
      $date2=date_create($date);
      $diff=date_diff($date1,$date2);
      $age = $diff->y;
      if($age<18){
        $data['birth_err'] = "Age 18 au minimum";
      }
    }


    
    if(empty($data['cpassword'])&&empty($data['npassword'])&&empty($data['rn_password'])){
      $data['mpassword'] = false;
    }
    
    //validate curent password
    if($_POST['cpassword']!=$userData['password']&&$data['mpassword']){
      $data['cpassword_err'] = 'Mot de pass incorrect';
    }

    //Validate Password
    if(strlen($_POST['npassword'])<6&&!empty($_POST['npassword'])&&$data['mpassword']){
      $data['npassword_err'] = 'Au moins 6 caractères';
    }

    //checking if the password not empty

    if(empty($_POST['npassword'])&&empty($data['cpassword_err'])&&$data['mpassword']){
      $data['npassword_err'] = 'required';
    }

    if(empty($_POST['rn_password'])&&empty($data['cpassword_err'])&&$data['mpassword']){
      $data['rn_password_err'] = 'required';
    }

    if($_POST['npassword']!=$_POST['rn_password']&&$data['mpassword'])
    {
      $data['rn_password_err'] = 'Ne pas le mème mot de pass';
    }
  
    //sign up the user $data['address_err']
    if(empty($data['familyname_err'])&&empty($data['name_err'])&&empty($data['email_err'])&&empty($data['cpassword_err'])
    &&empty($data['birth_err'])&&empty($data['npassword_err'])&&empty($data['rn_password_err'])&&empty($data['address_err'])){
      //correcting date
      
      //modifier update
      $this->userModel->updateEdit($data);
      //redirect();
      $this->view('users/modifier',$data);
    }

    }else{
    //Init data
      $userData = $this->userModel->getUserDataById($_SESSION['id']);
      $userData = get_object_vars($userData);
      $profilePic = $this->userModel->getPic($userData['Image_id_img']);
      $_SESSION['dp'] = $profilePic->data;
      $_SESSION['dp_id'] = $userData['Image_id_img'];   

    $data=[

      'familyname'=>$userData['nom'],
      'name' => $userData['prenom'],
      'address' => $userData['adresse'],
      'email' =>$userData['email'],
      'blood' =>$userData['grp_sang'],
      'birth' =>$userData['dn'],
      'sexe' => $userData['sexe'],
      'phone' => '0'.$userData['telephone'],
      'cpassword' =>'',
      'npassword' =>'',
      'rn_password' =>'',
      'niveau' => '',
      'familyname_err'=>'',
      'address_err' => '',
      'name_err' => '',
      'email_err' =>'',
      'birth_err' =>'',
      'cpassword_err' =>'',
      'npassword_err' =>'',
      'rn_password_err' => '',
    ];
    }
    if($_SESSION['role']==2){
      $data['niveau']=$this->userModel->getLevelCandidat($_SESSION['id_cad']);
    }
    $this->view('users/modifier',$data);

    }

  }

    public function upload(){
      if($_SERVER['REQUEST_METHOD']=='POST')
      { 
        //sanatize the post array
      $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

      if(isset($_POST['image']))
        {
          $this->userModel->updateImage($_POST['image']);
          echo '<img src="'. $_POST['image'] .'" class="hide" style="width:150px;" alt="Profile picture" />';
        }
    }
  }

  public function getNotification(){
    $data = $this->userModel->getNotification();
  }

  public function getMessages($id){
    
    $data = $this->userModel->getMessages($id);
  }

  public function sendMessage($data){

    $this->userModel->sendMessage($data);
  }

  

}
?>