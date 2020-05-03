<?php 

class Gestion extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function index(){
      redirect();
    }

    /*Disable account*/


    public function disableAccount(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $this->userModel->disableAccount($_POST['id']);
      }else{
        redirect();
      }
    }
    /*enable account*/
    public function enableAccount(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $this->userModel->enableAccount($_POST['id']);
      }else{
        redirect();
      }
    }

    /* Messages et Notifications ici */


    public function isThereNewMessage(){
        echo $this->userModel->isThereNewMessage();
    }

    public function updateViewedMessage(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $this->userModel->updateViewedMessage($_POST['id']);
      }else{
        redirect();
      }
    }

    public function getName(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $user=$this->userModel->getUserDataById($_POST['id']);
        echo $user->nom.' '.$user->prenom;
      }else{
        redirect();
      }
    }


    public function getConversation(){
      
        $conversations =$this->userModel->getConversation();
        $size = sizeof($conversations['conversations']);
        $i=1;
        echo '<div class="bg-white my-2" style="height:1px;width:100%;"></div>';
        foreach ($conversations['conversations'] as $conversation) {
          $cl = '';
          if(in_array($conversation->id_user,$conversations['notViewed'])){
            $cl='border-left: 0.8vh solid #FB4B09;';
          }
          $dp = $this->userModel->getPic($conversation->Image_id_img);
        if($i<$size){
          $i++;
          echo '    
            <div id="'.$conversation->id_user.'" onclick="run('.$conversation->id_user.')" class="row " style="'.$cl.';cursor:pointer;">
            <div class="col-1 my-auto mr-3">
                <img src="'.$dp->data.'" class="rounded-circle" style="width:2.7em;" alt="">
            </div>
            <div class="col-10 ml-2 mr-auto my-auto text-light">
                <small>'.getRole($conversation->role).'</small>
                <h6>'.$conversation->nom.' '.$conversation->prenom.'</h6>
            </div>
          </div>
          <div class="bg-white my-2" style="height:1px;width:100%;"></div>
        ';
        }else{
          echo '
            <div id="'.$conversation->id_user.'" onclick="run('.$conversation->id_user.')" class="row " style="'.$cl.';cursor:pointer;">
            <div class="col-1 my-auto mr-3">
                <img src="'.$dp->data.'" class="rounded-circle" style="width:2.7em;" alt="">
            </div>
            <div class="col-10 mr-auto my-auto ml-2 text-light">
                <small>'.getRole($conversation->role).'</small>
                <h6>'.$conversation->nom.' '.$conversation->prenom.'</h6>
            </div>
          </div>
        ';

        }
        
    }
 
  }

    public function addMessage()
    {
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $this->userModel->addMessage($_POST);
        }else{
        redirect();
      }
    }

    public function getMessages(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $user = $this->userModel->getUserDataById($_POST['id']);
        $dp= $this->userModel->getpic($user->Image_id_img);
        $messages=$this->userModel->getMessages($_POST['id']);
        $show ='';
        foreach($messages as $message){
          $now = new DateTime($message->date_msg);
          if($message->emt==$_POST['id']){
            //left
            $show.= 
            '<div class="row my-3 mr-auto">
                <div class="col-1 ml-3">
                    <img src="'.$dp->data.'" class="rounded-circle" style="width:2.5em;" alt="">
                </div>
                <div class="col-8 ml-2 shadow-sm bg-secondary text-white rounded">
                    <span class="my-auto w-100">'.$message->desc_msg.'</span>
                    <div class="text-right" style="font-size:12px;">'.$now->format('Y-m-d à H:i:s').'</div>
                </div>
            </div>';
          }else{
            //right
            $show.= 
            '
            <div class="row my-2 ml-4 ">
                <div class="col-9 ml-auto  shadow-sm bg-info text-white rounded">
                    <span>'.$message->desc_msg.'</span>
                    <div class="text-right" style="font-size:12px;">'.$now->format('Y-m-d à H:i:s').'</div>
                </div>
                <div class="col-1 mr-4">
                    <img src="'.$_SESSION['dp'].'" class="rounded-circle" style="width:2.5em;" alt="">
                </div>
            </div>';
          }
        }
        echo $show;
        }else{
          redirect();
        }

    }


    public function getContacts(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
          $contacts=$this->userModel->getContact();
          $size = sizeof($contacts);
          $i=1;
          foreach ($contacts as $contact) {
            $dp = $this->userModel->getPic($contact->Image_id_img);
          if($i<$size){
            $i++;
            echo '
          <div id="'.$contact->id_user.'" onclick="run('.$contact->id_user.')" class="row " style="cursor:pointer;">
              <div class="col-1 my-auto mr-3">
                  <img src="'.$dp->data.'" class="rounded-circle" style="width:3em;" alt="">
              </div>
              <div class="col-10 mr-auto text-light">
                  <small>'.getRole($contact->role).'</small>
                  <h6>'.$contact->nom.' '.$contact->prenom.'</h6>
              </div>
          </div>
          <div class="dropdown-divider"></div>
          ';
          }else{
            echo '
          <div onclick="run('.$contact->id_user.')" class="row " style="cursor:pointer;">
              <div class="col-1 my-auto mr-3">
                  <img src="'.$dp->data.'" class="rounded-circle" style="width:3em;" alt="">
              </div>
              <div class="col-10 mr-auto text-light">
                  <small>'.getRole($contact->role).'</small>
                  <h6>'.$contact->nom.' '.$contact->prenom.'</h6>
              </div>
          </div>
          ';

          }
          
      }
      }else{
        
          redirect();
      }
      
  }


    public function mVehicul($mat=0){
      if($mat==0)
      {
        redirect();
      }

      

      if(isset($_SESSION['id'])&&$_SESSION['role']==0)
      {
        if($_SERVER['REQUEST_METHOD']=='POST'){
          $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
          $userData = $this->userModel->getUserDataById($_SESSION['id']);
          $userData = get_object_vars($userData);
          $vehicul = $this->userModel->getVehiculMat($mat);
          $_SESSION['page'] = 'vehiculs';
          $data=[
              'mat' => $vehicul['vehicul']['matricule'],
              'matricule' => $_POST['matricule'],
              'marque' => $_POST['marque'],
              'modele' => $_POST['modele'],
              'df_assu' => $_POST['df_assu'],
              'dfc_tec' =>$_POST['dfc_tec'],
              'dp' => $vehicul['image']['data'],
              'listpermis' => $this->userModel->getPermis(),
              'statut' =>$_POST['statut'],
              'permis' =>$_POST['permis'],
              //errors
              'matricule_err' =>'',
              'dfc_tec_err' => '',
              'df_assu_err' => '',
              'familyname' => $userData['nom'],
              'name' => $userData['prenom'],
              'address' => $userData['adresse'] ,
              'email' => $userData['email'],
              'birth' => $userData['dn'],
              'blood' =>$userData['grp_sang'],
              'sexe' => $userData['sexe'],
              'phone' => $userData['telephone'],
              'password' => $userData['password']
            ];

            
            //check for errors 

            if($this->userModel->checkMat($data['matricule'],$vehicul['vehicul']['matricule']))
            {
              $data['matricule_err'] = 'Matricule existe déja';
            }

            $today = new DateTime();
            $dfc = new DateTime($data['dfc_tec']);
            $dfa = new DateTime($data['df_assu']);
            if($dfc<$today){
              $data['dfc_tec_err'] = "date non valide";
            }

            if($dfa<$today){
              $data['df_assu_err'] = "date non valide";
            }
            if(empty($data['df_assu_err'])&&empty($data['dfc_tec_err'])&&empty($data['matricule_err']))
            {
              //update vehicul
              $this->userModel->updateVehicul($data,$mat);
              redirect('gestion/vehiculs');
            }
  
        }else{
          $userData = $this->userModel->getUserDataById($_SESSION['id']);
          $userData = get_object_vars($userData);
          $vehicul = $this->userModel->getVehiculMat($mat);
          $_SESSION['page'] = 'Vehiculs';
          $data=[
              'mat' => $vehicul['vehicul']['matricule'],
              'matricule' => $vehicul['vehicul']['matricule'],
              'marque' => $vehicul['vehicul']['marque'],
              'listpermis' => $this->userModel->getPermis(),
              'permis' =>$this->userModel->getPermisById($vehicul['vehicul']['Permis_id_pem']),
              'modele' => $vehicul['vehicul']['modele'],
              'statut' => $vehicul['vehicul']['statut_v'],
              'df_assu' => $vehicul['vehicul']['df_assu'],
              'dfc_tec' =>$vehicul['vehicul']['dfc_tec'],
              'dp' => $vehicul['image']['data'],
              'familyname' => $userData['nom'],
              'name' => $userData['prenom'],
              'address' => $userData['adresse'] ,
              'email' => $userData['email'],
              'birth' => $userData['dn'],
              'blood' =>$userData['grp_sang'],
              'sexe' => $userData['sexe'],
              'phone' => $userData['telephone'],
              'password' => $userData['password']
            ];
            
          }
          $_SESSION['page'] = 'vehiculs';
          $this->view('gestion/mVehicul',$data);
        }else {
          redirect();
      }
    }



    public function paiements($id){

      if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);

            $data=[
                'id'=>$this->userModel->idPayement($id)->id_pay,
                'familyname' => $userData['nom'],
                'name' => $userData['prenom'],
                'address' => $userData['adresse'] ,
                'email' => $userData['email'],
                'birth' => $userData['dn'],
                'blood' =>$userData['grp_sang'],
                'sexe' => $userData['sexe'],
                'phone' => $userData['telephone'],
                'password' => $userData['password']
              ];
              $_SESSION['page'] = 'parametres';
            $this->view('gestion/paiements',$data);
        }else {
            redirect();
        }
  
    }

    public function addVersement(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
          $this->userModel->addVersement($_POST);
      }else{
        redirect();
      }
    }

    public function  deleteVersement(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $this->userModel->deleteVersement($_POST['id']);
      }else{
        redirect();
      }
    }
    public function  updateVersement(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        print_r($_POST);
        $this->userModel->updateVersement($_POST);
      }else{
        redirect();
      }
    }
    
    public function getVersements(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $versements=$this->userModel->getVersements($_POST['id']);
        foreach ($versements as $versement) {
          $date = new DateTime($versement->date_ver);
          echo 
          '<tr>
            <td>'.$versement->id_ver.'</td>
            <td id="v'.$versement->id_ver.'" >'.$versement->mont_ver.'</td>
            <td>'.$date->format('Y-m-d').'</td>
            <td><button href="" onClick="edit('.$versement->id_ver.')") class="col col-lg-5 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-green"><i class="fa fa-pencil px-3"
                  style="color: azure;"></i></button>
                  <button href="#delete" data-toggle="modal" onclick="run('.$versement->id_ver.')" class="col col-lg-5 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-danger"><i class="fa fa-user-times px-3"
                  style="color: azure;"></i>
                  </button>
            </td>
          </tr>
          ';
        }

      }else{

      }
    }

    public function addGroup(){
      if($_SERVER['REQUEST_METHOD']=="POST"){
        $this->userModel->addGroup($_POST);
      }else{
        redirect();
      }
    }

    public function editGroup(){
      if($_SERVER['REQUEST_METHOD']=="POST"){
        $this->userModel->editGroup($_POST);
      }else{
        redirect();
      }
    }
    
    public function getSaveExam(){
      if($_SERVER['REQUEST_METHOD']=="POST"){
        $save = $this->userModel->getSave();
        $start='';

        $days = [
          'Samdi',
          'Dimanche',
          'Lundi',
          'Mardi',
          'Mercredi',
          'Jeudi',
          'Vendredi'
        ];
        
        $day='';
        foreach($days as $dy){
          if($dy==$save->jour_exm){
            $day.='<option value="'.$dy.'" selected>'.$dy.'</option>';
          }else{
            $day.='<option value="'.$dy.'">'.$dy.'</option>';
          }
        }


        for($i = 0 ; $i<24 ; $i++){
          if($i<10){
            if('0'.$i.':00:00'>=$save->start_time && '0'.$i.':00:00'<$save->end_time){
            if('0'.$i.':00:00'==$save->temps_debut){
              $start.='<option value ="'.'0'.$i.':00:00'.'" selected>'.'0'.$i.':00'.'</option>'; 
            }else{
              $start.='<option value ="'.'0'.$i.':00:00'.'">'.'0'.$i.':00'.'</option>';
            }
          }
          }else{
            if($i.':00:00'>=$save->start_time && $i.':00:00'<$save->end_time){
            if($i.':00:00'==$save->temps_debut){
              $start.='<option value ="'.$save->temps_debut.'" selected>'.$i.':00</option>';
            }else{
              $start.='<option value ="'.$i.':00:00'.'">'.$i.':00'.'</option>';
            }
          }
        }
        }


        $end='';
        for($i = 1 ; $i<25 ; $i++){
          if($i<10){
            if('0'.$i.':00:00'>$save->start_time && '0'.$i.':00:00'<=$save->end_time){
              
              if('0'.$i.':00:00'==$save->temps_debut){
                $end.='<option value ="'.'0'.$i.':00:00'.'" selected>'.'0'.$i.':00'.'</option>';
              }else{
                $end.='<option value ="'.'0'.$i.':00:00'.'">'.'0'.$i.':00'.'</option>';
              }
            }
          }else{
            if($i.':00:00'>$save->start_time && $i.':00:00'<=$save->end_time){
              if($i.':00:00'==$save->temps_fin){
                $end.='<option value ="'.$i.':00:00'.'" selected>'.$i.':00'.'</option>';
              }else{
                $end.='<option value ="'.$i.':00:00'.'">'.$i.':00'.'</option>';
              }

            }
          }
        }

        echo $start.'~'.$end.'~'.$save->nbr_p.'~'.$day;

      } else{
        redirect();
      }
    }
    public function editSaveExam(){
      if($_SERVER['REQUEST_METHOD']=="POST"){
        $this->userModel->editSaveExam($_POST);
      } else{
        redirect();
      }
    }
    public function getPlanningSave(){
      if($_SERVER['REQUEST_METHOD']=="POST"){
        $save = $this->userModel->getSave();

        $start='';
        for($i = 0 ; $i<24 ; $i++){
          if($i<10){
            if('0'.$i.':00:00'==$save->start_time){
              $start.='<option value ="'.'0'.$i.':00:00'.'" selected>'.'0'.$i.':00'.'</option>';
            }else{
              $start.='<option value ="'.'0'.$i.':00:00'.'">'.'0'.$i.':00'.'</option>';
            }
          }else{
            if($i.':00:00'==$save->start_time){
              $start.='<option value ="'.$i.':00:00" selected>'.$i.':00</option>';
            }else{
              $start.='<option value ="'.$i.':00:00'.'">'.$i.':00'.'</option>';
            }
          }
        }


        $end='';
        for($i = 1 ; $i<25 ; $i++){
          if($i<10){
            if('0'.$i.':00:00'==$save->end_time){
              $end.='<option value ="'.'0'.$i.':00:00'.'" selected>'.'0'.$i.':00'.'</option>';
            }else{
              $end.='<option value ="'.'0'.$i.':00:00'.'">'.'0'.$i.':00'.'</option>';
            }
          }else{
            if($i.':00:00'==$save->end_time){
              $end.='<option value ="'.$i.':00:00'.'" selected>'.$i.':00'.'</option>';
            }else{
              $end.='<option value ="'.$i.':00:00'.'">'.$i.':00'.'</option>';
            }
          }
        }

        echo $start.'~'.$end;
        
      } else{
        redirect();
      }
    }
    public function editPlanningSave(){
      if($_SERVER['REQUEST_METHOD']=="POST"){

      } else{
        redirect();
      }
    }

    public function deleteGroupe(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $this->userModel->deletGroupe($_POST['id']);
      }else{
        redirect();
      }
    }



    public function getGroupe(){
      $data = $this->userModel->getGroups();
      foreach($data as $dt){
        $count = $this->userModel->getCountCand($dt->id_grp);
        if($count>0){
          echo 
          '
            <tr>
              <td>'.$dt->id_grp.'</td>
              <td id="nom_grp_'.$dt->id_grp.'">'.$dt->nom_grp.'</td>
              <td>'.$count.'</td>
              <td id="nbr_places_'.$dt->id_grp.'">'.$dt->nbr_p.'</td>
              <td>
              <button class="btn btn-sm btn-success px-2" onClick="editGroupe('.$dt->id_grp.')"><i class="fa fa-pencil" aria-hidden="true"></i></button>
              <button class="btn btn-sm btn-secondary px-2"  ><i class="fa fa-trash-o" aria-hidden="true"></i></button>
              </td>
            </tr>
          ';
        }else{
          echo 
          '
            <tr>
              <td>'.$dt->id_grp.'</td>
              <td id="nom_grp_'.$dt->id_grp.'">'.$dt->nom_grp.'</td>
              <td>'.$count.'</td>
              <td id="nbr_places_'.$dt->id_grp.'">'.$dt->nbr_p.'</td>
              <td>
              <button class="btn btn-sm btn-success px-2" onClick="editGroupe('.$dt->id_grp.')" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
              <button class="btn btn-sm btn-danger px-2" onClick="deleteGroupe('.$dt->id_grp.')" ><i class="fa fa-trash-o" aria-hidden="true"></i></button>
              </td>
            </tr>
          ';
        }
      }
    }

    public function editPlanning(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $this->userModel->editPlanningSave($_POST);
      }else{
        redirecrt();
      }
    }

    public function editExam(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $this->userModel->editSaveExam($_POST);
      }else{
        redirecrt();
      }
    }

    public function deletePermis(){
      if($_SERVER['REQUEST_METHOD']=="POST"){
        $this->userModel->deletePermis($_POST['id']);
      }else{
        redirect();
      }
    }

    public function getPermisParam(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $data= $this->userModel->getPermis();
        foreach($data as $dt){
          if($this->userModel->permisUsed($dt->id_pem)){
            echo 
            '<tr>
                <td>'.$dt->id_pem.'</td>
                <td>'.$dt->categorie.'</td>
                <td>'.$dt->prix.'</td>
                <td>'.$dt->prix_rdv_h.'</td>
                <td>'.$dt->code_h.'</td>
                <td>'.$dt->creneau_h.'</td>
                <td>'.$dt->conduite_h.'</td>
                <td>'.$dt->add_h.'</td>
                <td>'.$dt->add_p.'</td>
                <td>
                <a  class="btn btn-sm btn-success" href="'.URLROOT.'/gestion/editPermis/'.$dt->id_pem.'" role="button"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <button " class="btn btn-sm  btn-secondary"  role="button"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </td>
             </tr>
            ';

          }else{
            
            echo 
            '<tr>
                <td>'.$dt->id_pem.'</td>
                <td>'.$dt->categorie.'</td>
                <td>'.$dt->prix.'</td>
                <td>'.$dt->prix_rdv_h.'</td>
                <td>'.$dt->code_h.'</td>
                <td>'.$dt->creneau_h.'</td>
                <td>'.$dt->conduite_h.'</td>
                <td>'.$dt->add_h.'</td>
                <td>'.$dt->add_p.'</td>
                <td>
                <a  class="btn btn-sm btn-success" href="'.URLROOT.'/gestion/editPermis/'.$dt->id_pem.'" role="button"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <button " class="btn btn-sm  btn-danger" onclick="deletePermis('.$dt->id_pem.')" role="button"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </td>
             </tr>
            ';
          }
        }
      }else{
        redirect();
      }
    }

    public function addPermis(){

      if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            if($_SERVER['REQUEST_METHOD']=="POST"){
              $data=[
                  'familyname' => $userData['nom'],
                  'categorie' =>$_POST['categorie'],
                  'code' =>$_POST['code'],
                  'creneau' =>$_POST['creneau'],
                  'conduite' =>$_POST['conduite'],
                  'add_h' =>$_POST['add_h'],
                  'add_p' =>$_POST['add_p'],
                  'prix' =>$_POST['prix'],
                  'prix_rdv' =>$_POST['prix_rdv'],
                  'dossier' =>$_POST['dossier'],
  
                  'code_err' =>'',
                  'creneau_err' =>'',
                  'conduite_err' =>'',
                  'add_h_err' =>'',
                  'add_p_err' =>'',
                  'prix_err' =>'',
                  'prix_rdv_err' =>'',
  
                ];
                $_SESSION['page'] = 'addPermis';
  
                //checking data
                if($data['code']<0){
                   $data['code_err']="dois etre supperiur a 0";
                }
                if($data['creneau']<0){
                   $data['creneau_err']="dois etre supperiur a 0";
                }
                if($data['conduite']<0){
                   $data['conduite_err']="dois etre supperiur a 0";
                }
                if($data['add_h']<0){
                   $data['add_h_err']="dois etre supperiur a 0";
                }
                if($data['add_p']<0 || $data['add_p']>100){
                  $data['add_p_err']="dois etre entre 0 et 100";
                }
                if($data['prix']<=0){
                   $data['add_h_err']="dois etre supperiur a 0";
                }
                if($data['prix_rdv']<=0){
                   $data['add_h_err']="dois etre supperiur a 0";
                }
  
                if(empty($data['code_err'])&&empty($data['creneau_err'])&&empty($data['conduite_err'])&&empty($data['add_h_err'])&&
                empty($data['add_p_err'])&&empty($data['prix_err'])&&empty($data['prix_rdv_err'])){
                  $data['dossier'] = base64_encode($data['dossier']);
                  $this->userModel->addPermis($data);
                  redirect('gestion/parametres');
                }

            }else{
              $data=[
                'familyname' => $userData['nom'],
                'categorie' =>'',
                'code' =>'',
                'creneau' =>'',
                'conduite' =>'',
                'add_h' =>'',
                'add_p' =>'',
                'prix' =>'',
                'prix_rdv' =>'',
                'dossier' =>'',

                'code_err' =>'',
                'creneau_err' =>'',
                'conduite_err' =>'',
                'add_h_err' =>'',
                'add_p_err' =>'',
                'prix_err' =>'',
                'prix_rdv_err' =>'',

              ];
            }
            $this->view('gestion/addPermis',$data);

        }else {

            redirect();
        }
  
    }
    public function editPermis($id){

      if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $permis = $this->userModel->getPermisById($id);
            $userData = get_object_vars($userData);
            if($_SERVER['REQUEST_METHOD']=="POST"){
              $data=[
                  'id' => $id,
                  'familyname' => $userData['nom'],
                  'categorie' =>$_POST['categorie'],
                  'code' =>$_POST['code'],
                  'creneau' =>$_POST['creneau'],
                  'conduite' =>$_POST['conduite'],
                  'add_h' =>$_POST['add_h'],
                  'add_p' =>$_POST['add_p'],
                  'prix' =>$_POST['prix'],
                  'prix_rdv' =>$_POST['prix_rdv'],
                  'dossier' =>$_POST['dossier'],
  
                  'code_err' =>'',
                  'creneau_err' =>'',
                  'conduite_err' =>'',
                  'add_h_err' =>'',
                  'add_p_err' =>'',
                  'prix_err' =>'',
                  'prix_rdv_err' =>'',
  
                ];
                $_SESSION['page'] = 'addPermis';
  
                //checking data
                if($data['code']<0){
                   $data['code_err']="dois etre supperiur a 0";
                }
                if($data['creneau']<0){
                   $data['creneau_err']="dois etre supperiur a 0";
                }
                if($data['conduite']<0){
                   $data['conduite_err']="dois etre supperiur a 0";
                }
                if($data['add_h']<0){
                   $data['add_h_err']="dois etre supperiur a 0";
                }
                if($data['add_p']<0 || $data['add_p']>100){
                  $data['add_p_err']="dois etre entre 0 et 100";
                }
                if($data['prix']<=0){
                   $data['add_h_err']="dois etre supperiur a 0";
                }
                if($data['prix_rdv']<=0){
                   $data['add_h_err']="dois etre supperiur a 0";
                }
  
                if(empty($data['code_err'])&&empty($data['creneau_err'])&&empty($data['conduite_err'])&&empty($data['add_h_err'])&&
                empty($data['add_p_err'])&&empty($data['prix_err'])&&empty($data['prix_rdv_err'])){
                  $data['dossier'] = base64_encode($data['dossier']);
                  $this->userModel->editPermis($data);
                  redirect('gestion/parametres');
                }

            }else{
              $data=[
                'id' => $id,
                'familyname' => $userData['nom'],
                'categorie' =>$permis['categorie'],
                'code' =>$permis['code_h'],
                'creneau' =>$permis['creneau_h'],
                'conduite' =>$permis['conduite_h'],
                'add_h' =>$permis['add_h'],
                'add_p' =>$permis['add_p'],
                'prix' =>$permis['prix'],
                'prix_rdv' =>$permis['prix_rdv_h'],
                'dossier' =>base64_decode($permis['dossier']),

                'code_err' =>'',
                'creneau_err' =>'',
                'conduite_err' =>'',
                'add_h_err' =>'',
                'add_p_err' =>'',
                'prix_err' =>'',
                'prix_rdv_err' =>'',

              ];
            }
            $this->view('gestion/editPermis',$data);

        }else {

            redirect();
        }
  
    }
    public function parametres(){

      if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $data=[
                'familyname' => $userData['nom'],
                'name' => $userData['prenom'],
                'address' => $userData['adresse'] ,
                'email' => $userData['email'],
                'birth' => $userData['dn'],
                'blood' =>$userData['grp_sang'],
                'sexe' => $userData['sexe'],
                'phone' => $userData['telephone'],
                'password' => $userData['password']
              ];
              $_SESSION['page'] = 'parametres';
            $this->view('gestion/parametres',$data);
        }else {
            redirect();
        }
  
    }
    public function aUtilisateur($role=-1){
      if($role==-1){
        redirect();
      }


      if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            switch ($role){
              case '1': $_SESSION['page'] = 'moniteur';
                break;
              case '2': $_SESSION['page'] = 'candidat';
                break;
              case '3': $_SESSION['page'] = 'client';
                break;
              default: $_SESSION['page'] = '';
                break;
            } 
            if($_SERVER['REQUEST_METHOD']=='POST'){
              
              if($role=='1'){
                $data=[
                  'familyname' => trim($userData['nom']),
                  'ufamilyname' => trim($_POST['ufamilyname']),
                  'name' => trim($_POST['name']),
                  'address' => trim($_POST['address']),
                  'email' => trim($_POST['email']),
                  'birth' => trim($_POST['birth']),
                  'blood' =>trim($_POST['blood']),
                  'sexe' => trim($_POST['sexe']),
                  'phone' => trim($_POST['phone']),
                  'password' => trim($_POST['password']),
                  'repassword' => trim($_POST['repassword']),
                  'permis' => '',
                  //handling errors 
                  'ufamilyname_err' =>'',
                  'name_err' => '',
                  'address_err' => '',
                  'email_err' => '',
                  'birth_err' => '',
                  'blood_err' =>'',
                  'sexe_err' => '',
                  'phone_err' => '',
                  'password_err' => '',
                  'repassword_err' => '',
                  'role' => $role,
                  'addedFrom' => '0'
                ];
              }else{
              $data=[
                'familyname' => trim($userData['nom']),
                'ufamilyname' => trim($_POST['ufamilyname']),
                'name' => trim($_POST['name']),
                'address' => trim($_POST['address']),
                'email' => trim($_POST['email']),
                'birth' => trim($_POST['birth']),
                'blood' =>trim($_POST['blood']),
                'sexe' => trim($_POST['sexe']),
                'phone' => trim($_POST['phone']),
                'password' => trim($_POST['password']),
                'repassword' => trim($_POST['repassword']),
                'permis' => trim($_POST['permis']),
                'listpermis' => $this->userModel->getPermis(),
                //handling errors 
                'ufamilyname_err' =>'',
                'name_err' => '',
                'address_err' => '',
                'email_err' => '',
                'birth_err' => '',
                'blood_err' =>'',
                'sexe_err' => '',
                'phone_err' => '',
                'password_err' => '',
                'repassword_err' => '',
                'role' => $role,
                'addedFrom' => '0'
              ];
            }
              
          //validate familyname
          $_POST['ufamilyname'] = strtolower($_POST['ufamilyname']);
          if(strlen($_POST['ufamilyname'])<4){
            $data['ufamilyname_err'] = "Le nom doit etre superieure a 3 caractères";
          }
          if(!preg_match("/[a-z]+/ ",$_POST['ufamilyname']) && empty($data['ufamilyname_err']))
          {
            $data['ufamilyname_err'] = "Utilise que des alphabets";
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
          if($_SESSION['role']==1){
            $permis = array();
            foreach($data['listpermis'] as $dt){
              array_push($permis,$dt->categorie);
            }
            //permis error
            if($data['role']!=1&&!in_array($_POST['permis'],$permis)){
              $data['permis_err'] = 'Ne jou pas avec les elements';
          }
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
            switch ($role){
              case '1': redirect('gestion/moniteurs');
                break;
              case '2': redirect('gestion/candidats');
                break;
              case '3': redirect('gestion/clients');
                break;
              default:
                break;
            } 
          }

            }else{
              $data = [
              'familyname' => $userData['nom'],
                'ufamilyname' =>'',
                'name' => '',
                'address' => '',
                'email' => '',
                'birth' => '',
                'blood' =>'',
                'sexe' => '',
                'phone' => '',
                'password' => '',
                'repassword' => '',
                'listpermis' => $this->userModel->getPermis(),
                //initialising errors
                'ufamilyname_err' =>'',
                'name_err' => '',
                'address_err' => '',
                'email_err' => '',
                'birth_err' => '',
                'blood_err' =>'',
                'sexe_err' => '',
                'phone_err' => '',
                'password_err' => '',
                'repassword_err' => '',

                'role' => $role
              ];
            }
            
              
             
            $this->view('gestion/aUtilisateur',$data);
        }else {
            redirect();
        }
  
    }
    public function aVehicul(){

      if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $_SESSION['page'] = 'vehiculs';
            if($_SERVER['REQUEST_METHOD']=='POST'){
              $data=[
                  'matricule' => $_POST['matricule'],
                  'marque' => $_POST['marque'],
                  'modele' => $_POST['modele'],
                  'df_assu' => $_POST['df_assu'],
                  'dfc_tec' =>$_POST['dfc_tec'],
                  'listpermis' => $this->userModel->getPermis(),
                  'permis' =>$_POST['permis'],
                  'matricule_err' =>'',
                  'dfc_tec_err' => '',
                  'df_assu_err' => '',
                  'familyname' => $userData['nom'],
                ];
                $_SESSION['page'] = 'vehiculs';

                //checking the data entered 

                
            if($this->userModel->checkMat($data['matricule'],"0"))
            {
              $data['matricule_err'] = 'Matricule existe déja';
            }
            
            $today = date("d-m-Y");

            if($data['dfc_tec']>$today){
              $data['dfc_tec_err'] = "date non valide";
            }

            if($data['df_assu']>$today){
              $data['df_assu_err'] = "date non valide";
            }

            // if(strlen($data['modele'])<2){
            //   $data['modele_err'] = "au moins deux caractères";
            // }

            // if(strlen($data['marque'])<3){
            //   $data['marque_err'] = "au moins trois caractères";
            // }


            if(empty($data['df_ass_err'])&&empty($data['dfc_tec_err'])&&empty($data['matricule_err'])&&empty($data['marque_err'])&&empty($data['modele_err']))
            {
              //update

              $this->userModel->addVehicul($data);
              redirect('gestion/vehiculs');
            }


              $this->view('gestion/aVehicul',$data);
            }else{
              $data=[
                'matricule' => '',
                'marque' => '',
                'modele' => '',
                'df_assu' => '',
                'dfc_tec' =>'',
                'listpermis' => $this->userModel->getPermis(),
                'permis' => '',
                'matricule_err' =>'',
                'dfc_tec_err' => '',
                'df_assu_err' => '',
                'familyname' => $userData['nom'],
              ];
              $_SESSION['page'] = 'vehiculs';
            $this->view('gestion/aVehicul',$data);
            }
        }else {
            redirect();
        }
  
    }

    public function candidats()
    {
      if($_SERVER['REQUEST_METHOD']=='POST')
      {
        $data = $this->userModel->getCandidats();
        if(!$data){
          echo ">empty<";
        }else{
          foreach($data as $dt){
            if($dt['user']['statut_acc']=="1"){
              $btn='<a href="#deact" title="desactiver" data-toggle="modal" onclick="disableAccount('.$dt['user']['id_user'].')" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-secondary"><i class="fa fa-user text-white" aria-hidden="true"></i>
              </a>';
            }else{
              $btn='<a href="#deact" title="activer" data-toggle="modal" onclick="enableAccount('.$dt['user']['id_user'].')" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-info"><i class="fa fa-user text-white" aria-hidden="true"></i>
              </a>';
            }
            echo ' 
              <tr>
                <td>'.$dt['candidat']['id_cad'].'</td>
                <td>'.$dt['user']['nom'] .' '.$dt['user']['prenom'].'</td>
                <td>'.$dt['user']['dn'].'</td>
                <td>'.$this->userModel->getGroup($dt['candidat']['Groupe_id_grp'])['nom_grp'].'</td>
                <td>'.$this->userModel->getPermisId($dt['user']['id_user'])['categorie'].'</td>
                <td><a href="'.URLROOT.'/gestion/paiements/'.$dt['client']['id_cl'].'" >'.$this->userModel->getPayementId($dt['client']['id_cl']).'</a></td>
                <td><a href="'.URLROOT.'/gestion/mUtilisateur/'.$dt['user']['id_user'].'" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-green"><i class="fa fa-pencil px-3"
                style="color: azure;"></i></a>
                <a href="#delete" data-toggle="modal" onclick="run()" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-danger"><i class="fa fa-user-times px-3"
                style="color: azure;"></i>
                </a>
                </a>
                 '.$btn.'
                </td>
              </tr>
            ';
          }
        }
      }else{
        if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $_SESSION['page'] = 'candidats';
            $data=[
                'familyname' => $userData['nom'],
                'name' => $userData['prenom'],
                'address' => $userData['adresse'] ,
                'email' => $userData['email'],
                'birth' => $userData['dn'],
                'blood' =>$userData['grp_sang'],
                'sexe' => $userData['sexe'],
                'phone' => $userData['telephone'],
                'password' => $userData['password']
              ];
            $this->view('gestion/candidats',$data);
        }else {
            redirect();
        }
      }
        
        
    }

    public function dExam(){
      if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            if($_SERVER['RESQUESt_POST']=='¨POST'){
                $this->db->getDExam($_POST['id']);
                //TODO:print here
            }else{

              $userData = $this->userModel->getUserDataById($_SESSION['id']);
              $userData = get_object_vars($userData);
              $_SESSION['page'] = 'candidats';
              $data=[
                  'familyname' => $userData['nom'],
                  'name' => $userData['prenom'],
                  'address' => $userData['adresse'] ,
                  'email' => $userData['email'],
                  'birth' => $userData['dn'],
                  'blood' =>$userData['grp_sang'],
                  'sexe' => $userData['sexe'],
                  'phone' => $userData['telephone'],
                  'password' => $userData['password']
                ];
            }
            $this->view('gestion/dExam',$data);

        }else {
            redirect();
        }
    }
    
    public function getExams(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $exams=$this->userModel->getExams();
        foreach ($exams as $exam) {
          echo 
          '
          <tr>
            <td>id</td>
            <td>date</td>
            <td>total</td>
            <td>success</td>
            <td>faile</td>
            <td>details</td>
          </tr>
          
          ';
        }
      }else{  
        redirect();
      }
    }


    public function clients()
    {
      if($_SERVER['REQUEST_METHOD']=='POST')
      {
        $data = $this->userModel->getClients();
        if(!$data){
          echo ">empty<";
        }
        else{
          foreach($data as $dt){
            if($dt['user']['statut_acc']=="1"){
              $btn='<a href="#deact" title="desactiver" data-toggle="modal" onclick="disableAccount('.$dt['user']['id_user'].')" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-secondary"><i class="fa fa-user text-white" aria-hidden="true"></i>
              </a>';
            }else{
              $btn='<a href="#deact" title="activer" data-toggle="modal" onclick="enableAccount('.$dt['user']['id_user'].')" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-info"><i class="fa fa-user text-white" aria-hidden="true"></i>
              </a>';
            }
            echo ' 
              <tr>
                <td>'.$dt['client']['id_cl'].'</td>
                <td>'.$dt['user']['nom'] .' '.$dt['user']['prenom'].'</td>
                <td>'.$dt['user']['dn'].'</td>
                <td>'.$this->userModel->getPermisId($dt['user']['id_user'])['categorie'].'</td>
                <td><a href="'.URLROOT.'/gestion/paiements/'.$dt['client']['id_cl'].'" >'.$this->userModel->getPayementId($dt['client']['id_cl']).'</a></td>
                <td><a href="'.URLROOT.'/gestion/mUtilisateur/'.$dt['user']['id_user'].'" title="modifier" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-green"><i class="fa fa-pencil px-3"
                style="color: azure;"></i></a>
                <a href="#delete" title="supprimer" data-toggle="modal" onclick="run()" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-danger"><i class="fa fa-user-times px-3"
                style="color: azure;"></i>
                </a>
                </a>
                '.$btn.'
                </td>
              </tr>
            ';
            }
          }
        }else{

          if(isset($_SESSION['id'])&&$_SESSION['role']==0)
          {
              $userData = $this->userModel->getUserDataById($_SESSION['id']);
              $userData = get_object_vars($userData);
              $_SESSION['page'] = 'clients';
              $data=[
                  'familyname' => $userData['nom'],
                  'name' => $userData['prenom'],
                  'address' => $userData['adresse'] ,
                  'email' => $userData['email'],
                  'birth' => $userData['dn'],
                  'blood' =>$userData['grp_sang'],
                  'sexe' => $userData['sexe'],
                  'phone' => $userData['telephone'],
                  'password' => $userData['password']
                ];
              $this->view('gestion/clients',$data);
          }else {
              redirect();
          }
        }
    }

    public function sMoniteur(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $this->userModel->deleteUser( $_POST['id']);
        echo "deleted";
      }else{
        redirect();
      }
    }
    public function moniteurs()
    {
      if($_SERVER['REQUEST_METHOD']=='POST')
      {
      $data = $this->userModel->getMoniteurs();
      if(!$data){
        echo ">empty<";
      }else{
          foreach($data as $dt){
            if($dt['user']['statut_acc']=="1"){
              $btn='<a href="#deact" title="desactiver" data-toggle="modal" onclick="disableAccount('.$dt['user']['id_user'].')" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-secondary"><i class="fa fa-user text-white" aria-hidden="true"></i>
              </a>';
            }else{
              $btn='<a href="#deact" title="activer" data-toggle="modal" onclick="enableAccount('.$dt['user']['id_user'].')" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-info"><i class="fa fa-user text-white" aria-hidden="true"></i>
              </a>';
            }
            $date = new DateTime($dt['user']['date_creation']);
            echo ' 
            <tr>
              <td>'.$dt['moniteur']['id_mnt'].'</td>
              <td>'.$dt['user']['nom'] .' '.$dt['user']['prenom'].'</td>
              <td>'.$dt['user']['dn'].'</td>
              <td>'.date_format($date,'Y-m-d').'</td>
              <td><a href="'.URLROOT.'/gestion/mUtilisateur/'.$dt['user']['id_user'].'" title="modifier" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-green"><i class="fa fa-pencil px-3"
              style="color: azure;"></i></a>
              <a href="#delete" title="supprimer" data-toggle="modal" onclick="run('.$dt['user']['id_user'].')" class="col col-lg-3 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-danger"><i class="fa fa-user-times px-3"
              style="color: azure;"></i>
              </a>
              '.$btn.'
              </td>
            </tr>
          ';
          }
      }
      }else{
        if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
        $userData = $this->userModel->getUserDataById($_SESSION['id']);
        $userData = get_object_vars($userData);
        $_SESSION['page'] = 'moniteurs';
        $data=[
            'familyname' => $userData['nom'],
            'name' => $userData['prenom'],
            'address' => $userData['adresse'] ,
            'email' => $userData['email'],
            'birth' => $userData['dn'],
            'blood' =>$userData['grp_sang'],
            'sexe' => $userData['sexe'],
            'phone' => $userData['telephone'],
            'password' => $userData['password']
          ];
            $this->view('gestion/moniteurs',$data);
        }else {
            redirect();
        }
      }
    }
    public function vehiculs()
    {
      if($_SERVER['REQUEST_METHOD']=='POST')
      {
        $data = $this->userModel->getVehicules();
        if(!$data){
          echo ">empty<";
        }else{
          foreach($data as $dt){
            $satut="en panne";
            $dt = get_object_vars($dt);
            if($dt['statut_v']==1){
              $satut="actif";
            }
              echo '
                <tr>
                  <td>'.$dt['matricule'].'</td>
                  <td>'.$dt['marque'].'</td>
                  <td>'.$dt['modele'].'</td>
                  <td>'.$this->userModel->getPermisById($dt['Permis_id_pem'])['categorie'].'</td>
                  <td>'.$satut.'</td>
                  <td>'.$dt['df_assu'].'</td>
                  <td>'.$dt['dfc_tec'].'</td>
                  <td><a href="'.URLROOT.'/gestion/mVehicul/'.$dt['matricule'].'" class="col col-lg-5 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-green"><i class="fa fa-pencil px-3"
                  style="color: azure;"></i></a>
                  <a href="#delete" data-toggle="modal" onclick="run()" class="col col-lg-5 mr-2 my-1 my-md-auto btn btn-white btn-sm bg-danger"><i class="fa fa-user-times px-3"
                  style="color: azure;"></i>
                  </a></td>
                </tr>
              ';
            }
        }
        

      }else{
         
        if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $_SESSION['page'] = 'vehiculs';
            $data=[
            'familyname' => $userData['nom'],
            'name' => $userData['prenom'],
            'address' => $userData['adresse'] ,
            'email' => $userData['email'],
            'birth' => $userData['dn'],
            'blood' =>$userData['grp_sang'],
            'sexe' => $userData['sexe'],
            'phone' => $userData['telephone'],
            'password' => $userData['password']
          ];
            $this->view('gestion/vehiculs',$data);
        }else {
            redirect();
        }
      }
    }
    public function planning()
    {
        if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $_SESSION['page'] = 'planning';
            $data=[
            'familyname' => $userData['nom'],
            'name' => $userData['prenom'],
            'address' => $userData['adresse'] ,
            'email' => $userData['email'],
            'birth' => $userData['dn'],
            'blood' =>$userData['grp_sang'],
            'sexe' => $userData['sexe'],
            'phone' => $userData['telephone'],
            'password' => $userData['password'],
            'groups' => $this->userModel->getGroups(),
            'moniteurs' => $this->userModel->getMoniteurs()
          ];
            $this->view('gestion/planning',$data);
        }else {
            redirect();
        }
        
    }
    public function examens()
    {
        if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $_SESSION['page'] = 'examens';
            $data=[
            'familyname' => $userData['nom'],
            'name' => $userData['prenom'],
            'address' => $userData['adresse'] ,
            'email' => $userData['email'],
            'birth' => $userData['dn'],
            'blood' =>$userData['grp_sang'],
            'sexe' => $userData['sexe'],
            'phone' => $userData['telephone'],
            'password' => $userData['password']
          ];
            $this->view('gestion/examens',$data);
        }else {
            redirect();
        }
        
    }

   
    public function mUtilisateur($id)
  {
    if(!isset($_SESSION['id'])&&$_SESSION['role']!=0){
      redirect();
    }else{
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
    //Process form
    $userData = $this->userModel->getUserDataById($id);
    $userData = get_object_vars($userData);
    $uData = $this->userModel->getUserDataById($_SESSION['id']);
    $uData = get_object_vars($uData);
    $profilePic = $this->userModel->getPic($uData['Image_id_img']);
    $_SESSION['dp'] = $profilePic->data;
    $_SESSION['dp_id'] = $uData['Image_id_img'];   

    //sanatize the input because the trim function works only with strings
    $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

    $data=[
      'listpermis' => $this->userModel->getPermis(),
      'permis' =>'',
      'role' => $userData['role'],
      'id'=>$id,
      'familyname'=>$uData['nom'],
      'u_familyname'=>trim($_POST['u_familyname']),
      'name' => $userData['prenom'],
      'address' => trim($_POST['address']),
      'birth' =>trim($_POST['birth']),
      'blood' =>trim($_POST['blood']),
      'sexe' => trim($_POST['sexe']),
      'phone' => trim($_POST['phone']),
      'group' => '', 
      'familyname_err'=>'',
      'groups' =>  $this->userModel->getGroups(),
      'address_err' => '',
      'name_err' => '',
      'email_err' =>'',
      'birth_err' =>'',
    ];
    if($data['role']>1){
      $data['permis']=$_POST['permis'];
    }
    if($data['role']==2){
      $data['group'] = $_POST['group'];
    }


    //validate familyname
    $_POST['u_familyname'] = strtolower($_POST['u_familyname']);
    if(strlen($_POST['u_familyname'])<4){
      $data['familyname_err'] = "Le nom doit etre superieure a 3 caractères";
    }
    if(!preg_match("/[a-z]+/ ",$_POST['u_familyname']) && empty($data['familyname_err']))
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

    
    //validate phone
    if(strlen($_POST['phone'])!=10 || !preg_match("/^[0]/ ",$_POST['phone']))
    {
      $data['phone_err'] = "Numéro de téléphone incorrect";
    }
    //check if phone number exists 

    $phones = $this->userModel->getPhoneEdit($id);
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
  
    //sign up the user $data['address_err']
    if(empty($data['familyname_err'])&&empty($data['name_err'])&&empty($data['email_err'])
    &&empty($data['birth_err'])&&empty($data['address_err'])){
      
      //update
      $this->userModel->updateEditedUser($data);
      //redirect
      switch ($userData['role']) {
          case '1':
              redirect("gestion/moniteurs");
              break;
          
          case '2':
              redirect("gestion/candidats");
              break;
          
          case '3':
              redirect("gestion/clients");
              break;
          
          default:
              redirect();
              break;
      }
    }
    $data['group']=$this->userModel->getGroup($data['group'])['nom_grp'];


    }else{
    //Init data
      $userData = $this->userModel->getUserDataById($id);
      if(empty($userData)){
          //flush message
          redirect('gestion/moniteurs');
      };
      $userData = get_object_vars($userData);
      $uData = $this->userModel->getUserDataById($_SESSION['id']);
      $uData = get_object_vars($uData);
      $profilePic = $this->userModel->getPic($uData['Image_id_img']);
      $_SESSION['dp'] = $profilePic->data;
      $_SESSION['dp_id'] = $uData['Image_id_img'];   

    $data=[
      'listpermis' => $this->userModel->getPermis(),
      'permis' =>'',
      'role' => $userData['role'],
      'id'=>$id,
      'group' =>'',
      'familyname'=>$uData['nom'],
      'u_familyname'=>$userData['nom'],
      'name' => $userData['prenom'],
      'm_name' => $userData['prenom'],
      'address' => $userData['adresse'],
      'email' =>$userData['email'],
      'blood' =>$userData['grp_sang'],
      'birth' =>$userData['dn'],
      'sexe' => $userData['sexe'],
      'phone' => '0'.$userData['telephone'],
      'groups' =>  $this->userModel->getGroups(),
      'familyname_err'=>'',
      'address_err' => '',
      'name_err' => '',
      'email_err' =>'',
      'birth_err' =>'',
    ];
    if($data['role']>1){
      $data['permis']=$this->userModel->getPermisId($data['id']);
    }
    if($data['role']==2){
      $data['group']=$this->userModel->getCandidatGroup($data['id']);
    }

    }
    $this->view('gestion/mUtilisateur',$data);
    }

  }

  public function upload($mat){
    if($_SERVER['REQUEST_METHOD']=='POST')
    { 
      //sanatize the post array
    $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

    if(isset($_POST['image']))
      {
        $this->userModel->updateImageVehicul($_POST['image'],$mat);
        echo '<img src="'. $_POST['image'] .'" class="hide" style="width:150px;" alt="Profile picture" />';
      }
    }
  }

  public function getAddRdv(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      

    }else{
      redirect();
    }
  }

  private function canAddP($day,$time){
     
  }

  public function addRdv(){
    if($_SERVER['REQUEST_METHOD']=='POST'){

      $data=[
        'id_cl'=>'',
        'id_mnt'=>'',
        'matricule' =>'',
        'date' => ''
      ];

      $this->userModel->addRdv();

    }else{
      redirect();
    }
  }

  public function getPermis(){
      $data = $this->userModel->getPermis();
      foreach($data as $dt){
        echo '<option>'.$dt->categorie.'</option>';
      }
  }



  //planning

  public function test(){
    $this->userModel->getOneSeance(new DateTime('Africa/Algiers'));
    $this->userModel->getOneEvent(new DateTime('Africa/Algiers'));
  }

  public function getCountVehicul(){
    print_r($this->userModel->getCountVehicul(1));
  }

  private function getEvents($date,$time,$data){
    $returned = [
      'addT' =>'',
      'addP' =>'',
      'total' => '',
      'seances' =>array(),
      'rdvs' =>array()
    ];


    $nbrM = $this->userModel->getCount('Moniteur');
    if($_SESSION['role']>1){
    $permis=$this->userModel->getPermisId($_SESSION['id']);
    $nbrV = $this->userModel->getCountVehicul($permis['id_pem']);
    
    }

    $count = 0;
    $seances = [
      'S' =>'',
      'nbr' =>'',
      'G' => '',
      'M' => ''
    ];
    $rdvs = [
      'R' => '',
      'nbr' =>'',
      'C' => '',
      'M' => '',
      'V' => ''
    ];

    foreach($data['seance'] as $seance){
      $date_seance = new DateTime($seance->date_seance);
      if($date_seance->format('Y-m-d H')==$date->format('Y-m-d').' '.$time->format('H')){
        //get moniteur groupe
        $count++;
        $group = $this->userModel->getGroup($seance->Groupe_id_grp);
        $moniteur = $this->userModel->getMoniteurById($seance->Moniteur_id_mnt);
        $seances['S'] = $seance;
        $seances['G'] = $group;
        $seances ['M'] = $moniteur;
        $seances['nbr'] = $count;
        $returned['addT'] = '0';
        $nbrM--;

        array_push($returned['seances'],$seances);
      }
    }

    foreach($data['rdv'] as $rdv){
      $date_rdv = new DateTime($rdv->date_rdv);
      if($date_rdv->format('Y-m-d H')==$date->format('Y-m-d').' '.$time->format('H')){
        //get candidat or client and moniteur and vehicule
        $count++;
        $client = $this->userModel->getClientById($rdv->Client_id_cl);
        $moniteur = $this->userModel->getMoniteurById($rdv->Moniteur_id_mnt);
        $vehicul = $this->userModel->getVehiculMat($rdv->Vehicul_matricule);
        $rdvs['R'] = $rdv;
        $rdvs['C'] = $client;
        $rdvs['M'] = $moniteur;
        $rdvs['V'] = $vehicul;
        $rdvs['nbr'] = $count;
        $nbrM--;
        
        if($_SESSION['role']>1){
          if($permis['id_pem']==$vehicul['vehicul']['Permis_id_pem'])
          {
            $nbrV['N']--;
          }
        }
        array_push($returned['rdvs'],$rdvs);
      }
    }
    $returned['total'] = $count;
    if($_SESSION['role']>1){
    if($nbrM>0){
      if($nbrV['N']>0){
        $returned['addP'] = '1';
      }else{
        $returned['addP'] = '0';
      }
    }else{
      $returned['addP'] = '0';
    }
    }
    return $returned;
  }


  public function getSeance(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $seance = $this->userModel->getSeance($_POST['id']);
        $date = new DateTime($seance->date_seance);
        $date_1 = new DateTime($seance->date_seance);
        $date_1->add(new DateInterval('PT1H'));
        echo 
        '
          <div class="row">
              <div class="mt-2 ml-4">
                  <label class="ml-2"><b>Groupe:</b> '.$seance->nom_grp.'</label><br>
                  <label class="ml-2"><b>Moniteur:</b> '.$seance->nom.' '.$seance->prenom.'</label><br>
                  <label class="ml-2"><b>Date:</b> '.$date->format('Y/m/d').'</label><br>
                  <label class="ml-2"><b>Temps:</b> '. $date->format('H:i').' à '.$date_1->format('H:i').'</label><br>
              </div>
          </div>
        ';
    }else{
      redirect();
    }
  }

  public function getRdv_test($id){
    $rdv = $this->userModel->getRdv($id);
    print_r($rdv);
  }
  public function getRdv(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $rdv = $this->userModel->getRdv($_POST['id']);
        $date = new DateTime($rdv->date_rdv);
        $date_1 = new DateTime($rdv->date_rdv);
        $date_1->add(new DateInterval('PT1H'));
        echo 
        '
          <div class="row">
              <div class="mt-2 ml-4">
                  <label class="ml-2"><b>Moniteur:</b> '.$rdv->nom.' '.$rdv->prenom.'</label><br>
                  <label class="ml-2"><b>Date:</b> '.$date->format('Y/m/d').'</label><br>
                  <label class="ml-2"><b>Véhicule:</b> '.$rdv->modele.'</label><br>
                  <label class="ml-2"><b>Temps:</b> '. $date->format('H:i').' à '.$date_1->format('H:i').'</label><br>
              </div>
          </div>
        ';
    }else{
      redirect();
    }
  }

  public function getChoice(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $date = new DateTime($_POST['d']);
      $selected=$this->userModel->getChoice($date);
      $vehicul=$this->userModel->getVehiculMat($selected['v']);
      $moniteur=$this->userModel->getMoniteurById($selected['m']);
    }else{     
      redirect();
    }
  }

  public function getPl($firstDay){
    //$firstDay = new Datetime('Africa/Algiers');
    $day2 = new Datetime( $firstDay->format('Y-m-d H:i:s'));
    $day3 = new Datetime( $firstDay->format('Y-m-d H:i:s'));
    $day4 = new Datetime( $firstDay->format('Y-m-d H:i:s'));
    $day5 = new Datetime( $firstDay->format('Y-m-d H:i:s'));
    $day6 = new Datetime( $firstDay->format('Y-m-d H:i:s'));
    $lastDay = new Datetime( $firstDay->format('Y-m-d H:i:s'));
    $day2->add(new DateInterval('P1D'));
    $day3->add(new DateInterval('P2D'));
    $day4->add(new DateInterval('P3D'));
    $day5->add(new DateInterval('P4D'));
    $day6->add(new DateInterval('P5D'));
    $lastDay->add(new DateInterval('P6D'));


    $days = [
      '1' => $firstDay->format('l'),
      '2' => $day2->format('l'),
      '3' => $day3->format('l'),
      '4' => $day4->format('l'),
      '5' => $day5->format('l'),
      '6' => $day6->format('l'),
      '7' => $lastDay->format('l')
    ];
 
    for ($i=1; $i < 8; $i++) { 
      $days[$i] = convertDay($days[$i]);
    }

    //add dates to days

    $days['1'] .=' ' . $firstDay->format('d/m');
    $days['2'] .=' ' . $day2->format('d/m');
    $days['3'] .=' ' . $day3->format('d/m');
    $days['4'] .=' ' . $day4->format('d/m');
    $days['5'] .=' ' . $day5->format('d/m');
    $days['6'] .=' ' . $day6->format('d/m');
    $days['7'] .=' ' . $lastDay->format('d/m');

    $workingDay=$this->userModel->getWorkingday();
    $start = new DateTime($workingDay->start_time);
    $end = new DateTime($workingDay->end_time);

    $times = array();
    while($start->format('H:i:s')<$end->format('H:i:s')){
      array_push($times,new DateTime($start->format('H:i:s')));
      $start->add(new DateInterval('PT1H'));
    }
    
    $dateDays = [
      '1' => $firstDay,
      '2' =>$day2,
      '3' =>$day3,
      '4' =>$day4,
      '5' =>$day5,
      '6' =>$day6,
      '7' =>$lastDay
    ];

    //getting the data
    $data = $this->userModel->getPlanning($firstDay,$lastDay);
    
    //costomize the calender

   $head = '<tr><th id="'.$firstDay->format('Y-m-d').'" scope="col">H</th>';
   foreach($days as $day)
   {
     $head = $head.'<th style="width:13.30%" scope="col">'.$day.'</th>';
   }
   $head.=' </tr>';
   $body = '';

  $save = $this->userModel->getSave();
  $save->jour_exm=convertDayBack($save->jour_exm);
  $start_exm = new DateTime($save->temps_debut);
  $end_exm = new DateTime($save->temps_fin);


  switch ($_SESSION['role']) {
    case '0':
      {
        foreach($times as $time){
          //time[$i]
          $body.='<tr>';
          $body.='<th scope="row">'.$time->format('H:i').'</th>';
          for($j=1;$j<8;$j++){
            $eve='';
            $found = false;
            $exam=false;
            if($dateDays[$j]->format('l')==$save->jour_exm){
              if($time->format('H')>=$start_exm->format('H') && $time->format('H')<$end_exm->format('H')){
                $exam= true;
              }
            };
            
            $events = $this->getEvents($dateDays[$j],$time,$data);
            $foundSeance = false;
            foreach($events['seances'] as $seance){
              $eve.=
              '   <div onclick="vSeance('.$seance['S']->id_seance.')" class="caze text-left bg-info pl-2 pt-2 border" style="height:110px;">
                  <span class="bagde d-inline-block mb-2 rounded text-secondary px-1 pb-1 badge-light">'.$seance['nbr'].'/'.$events['total'].'</span><br>
                  G: '.$seance['G']['nom_grp'].'<br>
                  M: '.$seance['M']->nom.'
                  </div>
              ';
              $foundSeance = true;
              $found = true;
            }
            
            foreach($events['rdvs'] as $rdv){
             
              $eve.=
              '   <div onclick="vRdv('.$rdv['R']->id_rdv.')" class="caze text-left bg-danger pl-2 pt-2 border" style="height:110px;">
                  <span class="w-100 text-right bagde rounded text-secondary px-1 pb-1 badge-light">'.$rdv['nbr'].'/'.$events['total'].'</span><br>
                  C: '.$rdv['C']->nom.'<br>
                  M: '.$rdv['M']->nom.'<br>
                  V: '.$rdv['V']['vehicul']['modele'].'
                  </div>
              ';
              $found = true;
            }
            //the ability to add seance if not existe
            if(!$foundSeance){
              //check if it is an exam
              
                $eve.='<div class="border empty" style="height:110px;" onclick="add(\''.$dateDays[$j]->format('Y-m-d').'\','.$time->format('H').')"><span><br><br>+</span></div>';
            }
            
            if(!$found){
              if($exam){
                $body.='<td ><div  class="border exam text-light bg-success" style="height:110px;" ><span><br><br>Exam</span></div></td>';
              }else{
               $body.='<td ><div onClick="add(\''.$dateDays[$j]->format('Y-m-d').'\','.$time->format('H').')" class="border empty " style="height:110px;" ><span><br><br>+</span></div></td>';
              }
              }else{
              
              $body.='<td class=" text-light"><div id="scroll-hide" style="max-height:110px;overflow-y:auto;">'.$eve.'</div></td>';
            
            }
          }
          $body.='</tr>';
       }

        break;
      }
    case '1':
      {
        foreach($times as $time){
          //time[$i]
          $body.='<tr>';
          $body.='<th scope="row">'.$time->format('H:i').'</th>';
          for($j=1;$j<8;$j++){
            $eve='';
            $found = false;
            $exam=false;
            if($dateDays[$j]->format('l')==$save->jour_exm){
              if($time->format('H')>=$start_exm->format('H') && $time->format('H')<$end_exm->format('H')){
                $exam= true;
              }
            };
            $events = $this->getEvents($dateDays[$j],$time,$data);
            //count 
            $count = 0;
            foreach($events['seances'] as $seance){
              if($seance['S']->Moniteur_id_mnt==$_SESSION['id_mnt']){
                $count++;
              }
            }
            foreach($events['rdvs'] as $rdv){
              if($rdv['R']->Moniteur_id_mnt==$_SESSION['id_mnt']){
                $count++;
              }
            }

            $index=0;

            foreach($events['seances'] as $seance){
              if($seance['S']->Moniteur_id_mnt==$_SESSION['id_mnt']){
                $index++;
              $eve.=
              '   <div onclick="vSeance('.$seance['S']->id_seance.')" class="caze text-left bg-info pl-2 pt-2 border" style="height:110px;">
                  <span class="bagde d-inline-block mb-2 rounded text-secondary px-1 pb-1 badge-light">'.$index.'/'.$count.'</span><br>
                  G: '.$seance['G']['nom_grp'].'<br>
                  M: '.$seance['M']->nom.'
                  </div>
              ';
              $found = true;
              }
            }
            
            foreach($events['rdvs'] as $rdv){
              if($rdv['R']->Moniteur_id_mnt==$_SESSION['id_mnt']){
                $index++;
              $eve.=
              '   <div onclick="vRdv('.$rdv['R']->id_rdv.')" class="caze text-left bg-danger pl-2 pt-2 border" style="height:110px;">
                  <span class="w-100 text-right bagde rounded text-secondary px-1 pb-1 badge-light">'.$index.'/'.$count.'</span><br>
                  C: '.$rdv['C']->nom.'<br>
                  M: '.($rdv['M'])->nom.'<br>
                  V: '.($rdv['V'])['vehicul']['modele'].'
                  </div>
              ';
              $found = true;
            }
            }

            if(!$found){
              if($exam){
                $body.='<td ><div  class="border exam text-light bg-success" style="height:110px;" ><span><br><br>Exam</span></div></td>';
              }else{
                $body.='<td ><div class="border case " style="height:110px;" ><span><br><br>---</span></div></td>';
              }
            }else{
              
              $body.='<td class=" text-light"><div id="scroll-hide" style="max-height:110px;overflow-y:auto;">'.$eve.'</div></td>';
            
            }
          }
          $body.='</tr>';
       }

        break;
      }
    case '2':
      {
        foreach($times as $time){
          //time[$i]
          $body.='<tr>';
          $body.='<th scope="row">'.$time->format('H:i').'</th>';
          for($j=1;$j<8;$j++){
            $eve='';
            $found = false;
            $events = $this->getEvents($dateDays[$j],$time,$data);
            $foundSeance = false;
            $exam=false;
            if($dateDays[$j]->format('l')==$save->jour_exm){
              if($time->format('H')>=$start_exm->format('H') && $time->format('H')<$end_exm->format('H')){
                $exam= true;
              }
            };
            foreach($events['seances'] as $seance){
              $eve.=
              '   <div onclick="vSeance('.$seance['S']->id_seance.')" class="caze text-left bg-info pl-2 pt-2 border" style="height:110px;">
                  <span class="bagde d-inline-block mb-2 rounded text-secondary px-1 pb-1 badge-light">'.$seance['nbr'].'/'.$events['total'].'</span><br>
                  G: '.$seance['G']['nom_grp'].'<br>
                  M: '.$seance['M']->nom.'
                  </div>
              ';
            }
            
            foreach($events['rdvs'] as $rdv){
              if( $rdv['R']->Client_id_cl==$_SESSION['id_cl'])
              {
              $eve.=
              '   <div onclick="vRdv('.$rdv['R']->id_rdv.')" class="caze text-left bg-danger pl-2 pt-2 border" style="height:110px;">
                  <span class="w-100 text-right bagde rounded text-secondary px-1 pb-1 badge-light">'.$rdv['nbr'].'/'.$events['total'].'</span><br>
                  C: '.$rdv['C']->nom.'<br>
                  M: '.($rdv['M'])->nom.'<br>
                  V: '.($rdv['V'])['vehicul']['modele'].'
                  </div>
              ';
              $found = true;
              }
            }
            //the ability to add rdv if not existe
            
            if(!$found){
              if($exam){
                $body.='<td ><div class="border bg-success text-light exam " style="height:110px;" ><span><br><br>Examen</span></div></td>';
              }else{
                if($events['addP']==1){  
                  $body.='<td ><div onClick="addP(\''.$dateDays[$j]->format('Y-m-d').'\','.$time->format('H').')" class="border empty " style="height:110px;" ><span><br><br>+</span></div></td>';
                }else{
                  $body.='<td ><div class="border complet bg-warning text-light" style="height:110px;" ><span><br><br>Complet</span></div></td>';
                }
              }

            }else{
              
              $body.='<td class=" text-light"><div id="scroll-hide" style="max-height:110px;overflow-y:auto;">'.$eve.'</div></td>';
            
            }
          }
          $body.='</tr>';
       }

        break;
      }
    case '3':{
      foreach($times as $time){
        $body.='<tr>';
        $body.='<th scope="row">'.$time->format('H:i').'</th>';
        for($j=1;$j<8;$j++){
          $eve='';
          $found = false;
          $exam=false;
            if($dateDays[$j]->format('l')==$save->jour_exm){
              if($time->format('H')>=$start_exm->format('H') && $time->format('H')<$end_exm->format('H')){
                $exam= true;
              }
            };
          $events = $this->getEvents($dateDays[$j],$time,$data);
          foreach($events['rdvs'] as $rdv){
            if( $rdv['R']->Client_id_cl==$_SESSION['id_cl'])
            {
            $eve.=
            '   <div onclick="vRdv('.$rdv['R']->id_rdv.')" class="caze text-left bg-danger pl-2 pt-2 border" style="height:110px;">
                <span class="w-100 text-right bagde rounded text-secondary px-1 pb-1 badge-light">'.$rdv['nbr'].'/'.$events['total'].'</span><br>
                C: '.$rdv['C']->nom.'<br>
                M: '.($rdv['M'])->nom.'<br>
                V: '.($rdv['V'])['vehicul']['modele'].'
                </div>
            ';
            $found = true;
            }
          }
          
          if(!$found){
            if($exam){
              $body.='<td ><div class="border bg-success text-light exam " style="height:110px;" ><span><br><br>Examen</span></div></td>';
            }else{
              if($events['addP']==1){  
                $body.='<td ><div onClick="addP(\''.$dateDays[$j]->format('Y-m-d').'\','.$time->format('H').')" class="border empty " style="height:110px;" ><span><br><br>+</span></div></td>';
              }else{
                $body.='<td ><div class="border complet bg-warning text-light" style="height:110px;" ><span><br><br>Complet</span></div></td>';
              }
            }
          }else{
            $body.='<td class=" text-light"><div id="scroll-hide" style="max-height:110px;overflow-y:auto;">'.$eve.'</div></td>';
          }
        }
        $body.='</tr>';
     }
      break;
    }
  } 
   

   //end of costomized section


   echo '<thead>'. $head.'</thead><tbody class="bg-white py-2 text-secondary">'.$body.'</tbody>';
  }





  //delete seance
  function deleteSeance(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
    $this->userModel->deleteSeance($_POST['id']);
    echo 'success';
    //notify the groupe and the monitor 
    }else{
      redirect();
    }
  }

  public function deleteRdv(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
    $this->userModel->deleteRdv($_POST['id']);
    echo 'success';
    //notify the groupe and the monitor 
    }else{
      redirect();
    }
  }
  


  //ajouter une seance 
  public function addSeance(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $datetime = new DateTime(''.$_POST['d']);
      $data=[
        'datetime' => $datetime,
        'm' => $_POST['m'],
        'g' => $_POST['g']
      ];
      $this->userModel->addSeance($data);
    }
  }

  public function getPlanning(){
    $year = new DateTime();
    $data = [ 
      'data' =>$this->getPl(new DateTime('Africa/Algiers')),
      'Year' => $year->format('Y')
    ];
    echo implode('~',$data);
  }

  public function currentWeek($currentDay){
    $currentDay = new DateTime(''.$currentDay);
    $data = [ 
      'data' =>$this->getPl($currentDay),
      'Year' => $currentDay->format('Y')
    ];
    echo implode('~',$data);
  }
  
  public function nextWeek($currentDay){
    $currentDay = new DateTime(''.$currentDay);
    $currentDay->add(new DateInterval('P7D'));
    $data = [
      'data' =>$this->getPl($currentDay),
      'Year' => $currentDay->format('Y')
    ];
    echo implode('~',$data);
  }

  public function previousWeek($currentDay){
    $currentDay = new DateTime(''.$currentDay);
    $currentDay->sub(new DateInterval('P7D'));
    $data = [ 
      'data' =>$this->getPl($currentDay),
      'Year' => $currentDay->format('Y')
    ];
    echo implode('~',$data);
  }


}

?>