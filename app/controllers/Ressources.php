<?php 

class Ressources extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function index()
    {
      if($_SERVER['REQUEST_METHOD']=='POST'){
          //get ressources
          $data = $this->userModel->getRessources();
         if($_SESSION['role']==1){
             $obj = $this->userModel->getMoniteurId($_SESSION['id']);
         }

        if(!$data){
            echo '>empty<';
        }else{
          foreach ($data as $dt){
            $date_ress = new DateTime($dt['date_ress']);
              if($_SESSION['role']==1){
                  if($obj['id_mnt']==$dt['Moniteur_id_mnt']){
                      $btns = '<a href="'.URLROOT.'/ressources/mRessource/'.$dt['id_ress'].'" class="btn  btn-sm btn-success ">MODIFIER</a>
                      <a href="#delete" data-toggle="modal" onclick="sup('.$dt['id_ress'].')" class="btn  btn-sm btn-danger ">SUPPRIMER</a>';
                  }else{
                      $btns = '<a href="'.URLROOT.'/ressources/cRessource/'.$dt['id_ress'].'" class="btn  btn-sm btn-secondary ">CONTRIBUER</a>';
                  }
              }else{
                $btns='';
              }
            echo 
            '<div class="col-12 col-lg-11 pt-3 mx-auto mb-3 border shadow">
                <div class="media-body my-3">
                    <h4>'.$dt['titre_ress'].'</h4>
                    <hr>
                    <p style="font-size:1em">'.$dt['desc_ress'].'</p>
                    <div class="row">
                        <div class="col-9">
                            <a href="'.URLROOT.'/ressources/vRessource/'.$dt['id_ress'].'" class="btn  btn-sm btn-primary ">VOIR</a>
                            '.$btns.'
                        </div>
                        <div class="col-3 text-right">
                            <small class="text-muted mt-1">'. $date_ress->format('Y-m-d').' à '.$date_ress->format('H:i:s').'</small>
                        </div>
                    </div>
                </div>
            </div>';
          }
        }
      }else{
          if(isset($_SESSION['id']))
          {
              $userData = $this->userModel->getUserDataById($_SESSION['id']);
              $userData = get_object_vars($userData);
              $_SESSION['page']= 'ressources';
              $data=[
                  'familyname' => $userData['nom'],
                  'name' => $userData['prenom'],
                  'address' => $userData['adresse'] ,
                  'email' => $userData['email'],
                  'birth' => $userData['dn'],
                  'niveau' => '',
                  'blood' =>$userData['grp_sang'],
                  'sexe' => $userData['sexe'],
                  'phone' => $userData['telephone'],
                  'password' => $userData['password']
                ];
                if($_SESSION['role']==2){
                    $data['niveau']=$this->userModel->getLevelCandidat($_SESSION['id_cad']);
                }
              $this->view('ressources/index',$data);
          }else {
              redirect();
          }
      }
        
    }

    public function aRessource()
    {
        
        if(isset($_SESSION['id'])&&$_SESSION['role']==1)
        {
            if($_SERVER['REQUEST_METHOD']=='POST'){

                $userData = $this->userModel->getUserDataById($_SESSION['id']);
                $userData = get_object_vars($userData);
                $_SESSION['page']= 'ressources';
                
                $data=[
                    'familyname' => $userData['nom'],
                    'name' => $userData['prenom'],
                    'title' =>trim($_POST['title']),
                    'description' => trim($_POST['description']),
                    'content' => $_POST['content'],
                    'id_user' => $_SESSION['id'],
                    'title_err' =>'',
                    'description_err' => '',
                    'content_err' => ''
                ];

                //checking the data

                if(strlen($data['title'])<10){
                    $data['title_err'] = "au moins 10 caractères";
                }
                if(strlen($data['description'])<100){
                    $data['description_err'] = "au moins 100 caractères";
                }
                if(strlen($data['content'])<20){
                    $data['content_err'] = "SVP ajouter un contonaire";
                }

                if(empty($data['title_err'])&&empty($data['description_err'])&&empty($data['content_err'])){
                    $dom = new DOMDocument;
                    $dom->loadHTML('<?xml encoding="utf-8" ?>'.$data['content']);
                    $iframes = $dom->getElementsByTagName('iframe');
                    foreach ($iframes as $iframe) {
                            $iframe->setAttribute('src', 'https://' . $iframe->getAttribute('src'));
                    }
                    $data['content'] = $dom->saveHTML();
                    $data['content'] = base64_encode($data['content']);
                    $this->userModel->addRessource($data);
                    redirect('/ressources/index');
                }
                    $this->view('ressources/aRessource',$data);

            }else{
                
                $userData = $this->userModel->getUserDataById($_SESSION['id']);
                $userData = get_object_vars($userData);
                $_SESSION['page']= 'ressources';
                $data=[
                    'familyname' => $userData['nom'],
                    'name' => $userData['prenom'],
                    'title' =>'',
                    'description' =>'',
                    'content' =>'',

                    'title_err' =>'',
                    'description_err' =>'',
                    'content_err' =>''
                  ];
                $this->view('ressources/aRessource',$data);
            }
        }else {
            redirect();
        }
        
    }

    public function vRessource($id)
    {
        if(isset($_SESSION['id']))
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $ressource = get_object_vars($this->userModel->getRessourceById($id));

            //get controbuters

            $publisher =$this->userModel->getPublisher($id);
            $contributers = $this->userModel->getContributers($id);


            $_SESSION['page']= 'ressources';
            $data=[
                'familyname' => $userData['nom'],
                'name' => $userData['prenom'],
                'address' => $userData['adresse'] ,
                'email' => $userData['email'],
                'birth' => $userData['dn'],
                'blood' =>$userData['grp_sang'],
                'sexe' => $userData['sexe'],
                'phone' => $userData['telephone'],
                'niveau' => '',
                'password' => $userData['password'],
                'content' => base64_decode($ressource['cont_ress']),
                'publisher' => $publisher,
                'contributors' => $contributers
              ];
              if($_SESSION['role']==2){
                $data['niveau']=$this->userModel->getLevelCandidat($_SESSION['id_cad']);
            }
            $this->view('ressources/vRessource',$data);
        }else {
            redirect();
        }
    }

    public function cRessource($id)
    {
        if(isset($_SESSION['id'])&&$_SESSION['role']==1)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $ressource = get_object_vars($this->userModel->getRessourceById($id));
            $_SESSION['page']= 'ressources';
            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                $data=[
                    'id_ress'=>$ressource['id_ress'],
                    'id_mnt' =>$this->userModel->getMoniteurId($_SESSION['id'])['id_mnt'],
                    'familyname' => $userData['nom'],
                    'name' => $userData['prenom'],
                    'title' => $ressource['titre_ress'],
                    'content' => $_POST['content'],

                    'content_err' =>''
                  ];

                //checking the data

                if(strlen($data['content'])<20){
                    $data['content_err'] = "SVP ajouter un contonaire";
                }

                if(empty($data['content_err'])){
                    $dom = new DOMDocument;
                    $dom->loadHTML('<?xml encoding="utf-8" ?>'.$data['content']);
                    $iframes = $dom->getElementsByTagName('iframe');
                    foreach ($iframes as $iframe) {
                            if(strpos($iframe->getAttribute('src'),'http')!=0){
                                $iframe->setAttribute('src', 'https://' . $iframe->getAttribute('src'));
                            }
                    }
                    $data['content'] = $dom->saveHTML();
                    $data['content'] = base64_encode($data['content']);
                    $this->userModel->contRessource($data);
                    redirect('/ressources/index');
                }
                $this->view('ressources/cRessource',$data);

            }else{
                
                $data=[
                    'id_ress'=>$ressource['id_ress'],
                    'familyname' => $userData['nom'],
                    'name' => $userData['prenom'],
                    'title' => $ressource['titre_ress'],
                    'description' => $ressource['desc_ress'],
                    'content' => base64_decode($ressource['cont_ress']),

                    'title_err' =>'',
                    'description_err' =>'',
                    'content_err' =>''
                  ];
            }
            $this->view('ressources/cRessource',$data);
        }else {
            redirect();
        }
        
    }

    public function rRessource($id){
        if(isset($_SESSION['id'])&&$_SESSION['role']==1)
        {
            $ressource = $this->userModel->getRessourceById($id);
            $moniteur = $this->userModel->getMoniteurId($_SESSION['id']);

        if($moniteur['id_mnt']==$ressource->Moniteur_id_mnt){
            $this->userModel->deleteRessource($id);
            echo 'success';
        }else{
            echo 'fail';
        }
        }else{
            redirect();
        }
        

    }

    public function mRessource($id)
    {
        if(isset($_SESSION['id'])&&$_SESSION['role']==1)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $ressource = get_object_vars($this->userModel->getRessourceById($id));
            $_SESSION['page']= 'ressources';
            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                $data=[
                    'id_ress'=>$ressource['id_ress'],
                    'familyname' => $userData['nom'],
                    'name' => $userData['prenom'],
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'content' => $_POST['content'],

                    'title_err' =>'',
                    'description_err' =>'',
                    'content_err' =>''
                  ];

                //checking the data

                if(strlen($data['title'])<10){
                    $data['title_err'] = "au moins 10 caractères";
                }
                if(strlen($data['description'])<100){
                    $data['description_err'] = "au moins 100 caractères";
                }
                if(strlen($data['content'])<20){
                    $data['content_err'] = "SVP ajouter un contonaire";
                }

                if(empty($data['title_err'])&&empty($data['description_err'])&&empty($data['content_err'])){
                    $dom = new DOMDocument;
                    $dom->loadHTML('<?xml encoding="utf-8" ?>'.$data['content']);
                    $iframes = $dom->getElementsByTagName('iframe');
                    foreach ($iframes as $iframe) {
                            if(strpos($iframe->getAttribute('src'),'http')!=0){
                                $iframe->setAttribute('src', 'https://' . $iframe->getAttribute('src'));
                            }
                    }
                    $data['content'] = $dom->saveHTML();
                    $data['content'] = base64_encode($data['content']);
                    $this->userModel->updateRessource($data);
                    redirect('/ressources/index');
                }
                $this->view('ressources/mRessource',$data);

            }else{
                
                $data=[
                    'id_ress'=>$ressource['id_ress'],
                    'familyname' => $userData['nom'],
                    'name' => $userData['prenom'],
                    'title' => $ressource['titre_ress'],
                    'description' => $ressource['desc_ress'],
                    'content' => base64_decode($ressource['cont_ress']),

                    'title_err' =>'',
                    'description_err' =>'',
                    'content_err' =>''
                  ];
            }
            $this->view('ressources/mRessource',$data);
        }else {
            redirect();
        }
        
    }
    public function livesearch(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //get ressources
            $data = $this->userModel->liveSearchRessource($_POST['pattern']);
           if($_SESSION['role']==1){
               $obj = $this->userModel->getMoniteurId($_SESSION['id']);
           }
          if($data){
            foreach ($data as $dt){
                if($_SESSION['role']==1){
                    if($obj['id_mnt']==$dt['Moniteur_id_mnt']){
                        $btns = '<a href="'.URLROOT.'/ressources/mRessource/'.$dt['id_ress'].'" class="btn  btn-sm btn-success ">MODIFIER</a>
                        <a href="#delete" data-toggle="modal" onclick="sup('.$dt['id_ress'].')" class="btn  btn-sm btn-danger ">SUPPRIMER</a>';
                    }else{
                        $btns = '<a href="'.URLROOT.'/ressources/cRessource/'.$dt['id_ress'].'" class="btn  btn-sm btn-secondary ">CONTRIBUER</a>';
                    }
                }else{
                  $btns='';
                }
              echo 
              '<div class="col-12 col-lg-11 pt-3 mx-auto mb-3 border shadow">
                  <div class="media-body my-3">
                      <h4>'.$dt['titre_ress'].'</h4>
                      <hr>
                      <p style="font-size:1em">'.$dt['desc_ress'].'</p>
                      <div class="row">
                          <div class="col-9">
                              <a href="'.URLROOT.'/ressources/vRessource/'.$dt['id_ress'].'" class="btn  btn-sm btn-primary ">VOIR</a>
                              '.$btns.'
                          </div>
                          <div class="col-3 text-right">
                              <small class="text-muted mt-1">'. $dt['date_ress'].'</small>
                          </div>
                      </div>
                  </div>
              </div>';
            }
          }
        }else{
            redirect();
        }

    }
}
?>