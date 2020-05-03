<?php 

class Moniteur extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        if(isset($_SESSION['id'])&&$_SESSION['role']==1)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $profilePic = $this->userModel->getPic($userData['Image_id_img']);
            $_SESSION['id_mnt'] = $this->userModel->getIdMoniteur($_SESSION['id']);
            $data=[
                'familyname' => $userData['nom'],
                'name' => $userData['prenom']
              ];
            $_SESSION['dp'] = $profilePic->data;

            if($_SERVER['REQUEST_METHOD']=='POST'){


            }else{
                $this->view('moniteur/dashbord',$data);
            }
        }else {
            redirect();
        }
        
    }
    public function planning()
    {
        if(isset($_SESSION['id'])&&$_SESSION['role']==1)
        {
            $_SESSION['page']='mplanning';
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $profilePic = $this->userModel->getPic($userData['Image_id_img']);
            $_SESSION['id_mnt'] = $this->userModel->getIdMoniteur($_SESSION['id']);
            $data=[
                'familyname' => $userData['nom'],
                'name' => $userData['prenom']
              ];
            $_SESSION['dp'] = $profilePic->data;

            $this->view('moniteur/planning',$data);

        }else {
            redirect();
        }
    }

    public function getSuivants(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $now = new DateTime('Africa/Algiers');
                $b='<div class="row">
                <div href="#" class="text-white col Ls Ls-code mt-4">
                    <div class="row">
                        <div class="col">
                            <h2 class="mt-2 text-left">Code</h2>
                            <img class="" src="<?php echo URLROOT; ?>/svg/code.svg" alt="" style="width:40px;">
                        </div>
                        <div class="col">
                            <h5 class="text-right mt-3">B1</h5>
                            <h5 class="text-right ">14:30</h5>
                            <h3 class="text-right mb-2">27/03/2019</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div href="#" class="col text-white Ls Ls-crn mt-3">
                    <div class="row">
                        <div class="col">
                            <h2 class="mt-2 text-left">Crénaux</h2>
                            <img class="" src="<?php echo URLROOT; ?>/svg/crenaux.svg" alt="" style="width:40px;">
                        </div>
                        <div class="col">
                            <h5 class="text-right mt-3">Candidat</h5>
                            <h5 class="text-right ">14:30</h5>
                            <h3 class="text-right mb-2">27/03/2019</h3>
                        </div>
                    </div>
                </div>
            </div>';
                
                $event_1 = $this->userModel->getOneEvent($now);
                if($event_1){
                    if($event_1['type']==0){
                        $date_1 = new DateTime($event_1->date_seance);
                    }else{
                        $date_1 = new DateTime($event_1->date_seance);
                    }
                    $event_2 = $this->userModel->getOneEvent($date_1);
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
            redierct();
        }
    }


}
?>