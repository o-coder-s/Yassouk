<?php 

class Admin extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        if(isset($_SESSION['id'])&&$_SESSION['role']==0)
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $_SESSION['page'] = 'dashbord';
            $candidat = $this->userModel->getCount('Candidat');
            $client = $this->userModel->getCount('Client') - $candidat;
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
            'Moniteur' => $this->userModel->getCount('Moniteur'),
            'Candidat' => $candidat,
            'Client' => $client,
            'Vehicul' => $this->userModel->getCount('Vehicul')
          ];
            $profilePic = $this->userModel->getPic($userData['Image_id_img']);
            $_SESSION['dp'] = $profilePic->data;
            $this->view('admin/dashbord',$data);
        }else {
            redirect();
        }
        
    }
    //synchrounis function 
    public function listExamen(){
        //check if today is the exam date create the exam new 
        $save=$this->userModel->getsave();
        $today = new DateTime('Africa/Algiers');
        $save->jour_exm=convertDayBack($save->jour_exm);
        
        if($save->jour_exm==$today->format('l')){
            //create next exam if not existe
            $today->add(new DateInterval('P7D'));
            $this->userModel->createExamDay($today);
            
        }
        $data = $this->userModel->getInExam();
        $niveau ='';
        if($data){          
            foreach ($data as $dt) {
                switch($dt['candidat']['niveau']){
                    case '1':
                        $niveau = 'Code';
                        break;
                    case '2':
                        $niveau = 'Crénaux';
                        break;
                    case '3':
                        $niveau = 'Conduit';
                        break;
                    default:
                        break;
                }
                echo '<tr>
                <td>'.$dt['candidat']['id_cad'].'</td>
                <td>'.$dt['user']['nom'].' '.$dt['user']['prenom'].'</td>
                <td>'.$niveau.'</td>
                <td>Permis '.$dt['permis']['categorie'].'</td>
                <td>Pas encore</td></tr>';
            }
        }else{
            echo 'empty';
        }
    }
    //inscription list
    public function listInscription(){
        $data = $this->userModel->getUserInsc();
        if($data){        
            foreach ($data as $dt) {
                $type = 'client';
                if(!empty($dt['candidat'])) $type = 'candidat';
                echo '
                <tr>
                    <td>'.$dt['user']['id_user'].'</td>
                    <td>'.$dt['user']['nom'] .' '.$dt['user']['prenom'].'</td>
                    <td>'.$dt['user']['dn'].'</td>
                    <td>'.$type.'</td>
                    <td>'.$dt['client']['code'].'</td>
                </tr>';
            }
        }else{
            echo 'empty';
        }
    }
}
?>