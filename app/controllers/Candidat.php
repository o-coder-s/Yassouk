<?php 

class Candidat extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        if(isset($_SESSION['id'])&&$_SESSION['role']==2)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $returned = $this->userModel->getPhCandidat($_SESSION['id']);
            $_SESSION['id_cl'] =$this->userModel->getIdClient($_SESSION['id']);
            $_SESSION['id_cad'] = $this->userModel->getIdCandidat($_SESSION['id_cl']);
            $data=[
                'familyname' => $userData['nom'],
                'name' => $userData['prenom'],
                'address' => $userData['adresse'] ,
                'email' => $userData['email'],
                'birth' => $userData['dn'],
                'blood' =>$userData['grp_sang'],
                'niveau' => $this->userModel->getLevelCandidat($_SESSION['id_cad']),
                'sexe' => $userData['sexe'],
                'phone' => $userData['telephone'],
                'password' => $userData['password'],
                'permis' => $this->userModel->getPermisId($_SESSION['id'])['categorie'],
                'info' => $returned
            ];
            //get the permis
            
            $profilePic = $this->userModel->getPic($userData['Image_id_img']);
            $_SESSION['dp'] = $profilePic->data;
            $this->view('candidat/dashbord',$data);
        }else {
            redirect();
        }
        
    }

    public function rendez_vous()
    {
        if(isset($_SESSION['id'])&&$_SESSION['role']==2)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $info = $this->userModel->getPhClient();
            $_SESSION['page'] = "rendez-vous";
            $_SESSION['id_cl'] = $this->userModel->getIdClient($_SESSION['id']);
            $_SESSION['id_cad'] = $this->userModel->getIdCandidat($_SESSION['id_cl']);
            $data=[
                'familyname' => $userData['nom'],
                'name' => $userData['prenom'],
                'address' => $userData['adresse'] ,
                'email' => $userData['email'],
                'birth' => $userData['dn'],
                'blood' =>$userData['grp_sang'],
                'niveau' => $this->userModel->getLevelCandidat($_SESSION['id_cad']),
                'sexe' => $userData['sexe'],
                'phone' => $userData['telephone'],
                'password' => $userData['password'],
                'permis' => $this->userModel->getPermisId($_SESSION['id'])['categorie'],
                'info' => $info
            ];
            $profilePic = $this->userModel->getPic($userData['Image_id_img']);
            $_SESSION['dp'] = $profilePic->data;
            $this->view('candidat/rendez_vous',$data);
        }else {
            redirect();
        }
        
    }
    public function getProgress(){

    }
    
    public function getSuivants(){
        $niveau = $this->userModel->getLevelCandidat($_SESSION['id_cad']);
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $now = new DateTime('Africa/Algiers');
            if($niveau==1){ 
                $seance_1 = $this->userModel->getOneSeance($now);
                if($seance_1){
                    $date_1 = new DateTime($seance_1->date_seance);
                    $seance_2 = $this->userModel->getOneSeance($date_1);
                    echo 
                    '<div class="row">
                        <div href="#" class="text-white col Ls Ls-code mt-4">
                            <div class="row">
                                <div class="col">
                                    <h2 class="mt-2 text-left">Code</h2>
                                    <img class="" src="'.URLROOT.'/svg/code.svg" alt="" style="width:40px;">
                                </div>
                                <div class="col">
                                    <h5 class="text-right mt-5">'.$date_1->format('H:i').'</h5>
                                    <h3 class="text-right mb-2">'.$date_1->format('Y/m/d').'</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';


                    if($seance_2){
                        //create the data
                        $date_2= new DateTime($seance_2->date_seance);

                        echo '<div class="row">
                                <div href="#" class="col text-white Ls Ls-crn mt-3">
                                    <div class="row">
                                        <div class="col">
                                            <h2 class="mt-2 text-left">Code</h2>
                                            <img class="" src="'.URLROOT.'/svg/code.svg" alt="" style="width:40px;">
                                        </div>
                                        <div class="col">
                                        <h5 class="text-right mt-5">'.$date_2->format('H:i').'</h5>
                                        <h3 class="text-right mb-2">'.$date_2->format('Y/m/d').'</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }else{
                        
                    }
                }else{
                    echo 
                    '<div class="row">
                        <div href="#" class="text-white col Ls Ls-code mt-4">
                            <div class="row">
                                <div class="col">
                                    <h2 class="mt-2 text-left">Non disponible</h2>
                                    
                                </div>
                                <div class="col">
                                    <h5 class="text-right mt-5">--:--</h5>
                                    <h3 class="text-right mb-2">--/--/----</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div href="#" class="col text-white Ls Ls-crn mt-3">
                            <div class="row">
                                <div class="col">
                                    <h2 class="mt-2 text-left">Non disponible</h2>
                                    
                                </div>
                                <div class="col">
                                    <h5 class="text-right mt-5">--:--</h5>
                                    <h3 class="text-right mb-2">--/--/----</h3>
                                </div>
                            </div>
                        </div>
                    </div>';

                }
            }else{

                $rdv_1 = $this->userModel->getOneRdv($now);
                $img="";
                if($rdv_1){
                    if($rdv_1->type_rdv=0){
                        $img=' <img class="" src="'.URLROOT.'/svg/crenaux.svg" alt="" style="width:40px;">';
                    }else{
                        $img=' <img class="" src="'.URLROOT.'/svg/car.svg" alt="" style="width:120px;">';
                    }
                    $date_1 = new DateTime($rdv_1->date_rdv);
                    $rdv_2 = $this->userModel->getOneRdv($date_2);
                    echo 
                    '<div class="row">
                        <div href="#" class="text-white col Ls Ls-code mt-4">
                            <div class="row">
                                <div class="col">
                                    <h2 class="mt-2 text-left">Code</h2>'.$img.'</div>
                                <div class="col">
                                    <h5 class="text-right mt-5">'.$date_1->format('H:i').'</h5>
                                    <h3 class="text-right mb-2">'.$date_1->format('Y/m/d').'</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                    if($rdv_2){
                        $date_2 = new DateTime($rdv_2->date_rdv);
                        echo '
                        <div class="row">
                            <div href="#" class="col text-white Ls Ls-crn mt-3">
                                <div class="row">
                                    <div class="col">
                                        <h2 class="mt-2 text-left">Code</h2>'.$img.'</div>
                                    <div class="col">
                                    <h5 class="text-right mt-5">'.$date_2->format('H:i').'</h5>
                                    <h3 class="text-right mb-2">'.$date_2->format('Y/m/d').'</h3>
                                    </div>
                                </div>
                            </div>
                        </div>';
    
                    }else{
                        echo 
                        '<div class="row">
                            <div href="#" class="text-white col Ls Ls-crn mt-4">
                                <div class="row">
                                    <div class="col">
                                        <h2 class="mt-2 text-left">Non disponible</h2>
                                    </div>
                                    <div class="col">
                                        <h5 class="text-right mt-5">--:--</h5>
                                        <h3 class="text-right mb-2">--/--/----</h3>
                                    </div>
                                </div>
                            </div>
                        </div>';
    
                    }
                }else{
                    echo 
                    '<div class="row">
                        <div href="#" class="text-white col Ls Ls-code mt-4">
                            <div class="row">
                                <div class="col">
                                    <h2 class="mt-2 text-left">Non disponible</h2>
                                    
                                </div>
                                <div class="col">
                                    <h5 class="text-right mt-5">--:--</h5>
                                    <h3 class="text-right mb-2">--/--/----</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div href="#" class="col text-white Ls Ls-crn mt-3">
                            <div class="row">
                                <div class="col">
                                    <h2 class="mt-2 text-left">Non disponible</h2>
                                    
                                </div>
                                <div class="col">
                                    <h5 class="text-right mt-5">--:--</h5>
                                    <h3 class="text-right mb-2">--/--/----</h3>
                                </div>
                            </div>
                        </div>
                    </div>';

                }
            }


        }else{
            redierct();
        }
    }
}
?>