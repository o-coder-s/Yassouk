<?php 

class Forum extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        if(isset($_SESSION['id']))
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
                'niveau' => '',
                'phone' => $userData['telephone'],
                'password' => $userData['password']
            ];
            $profilePic = $this->userModel->getPic($userData['Image_id_img']);
            $_SESSION['dp'] = $profilePic->data;
            $_SESSION['page'] = 'forum';
            if($_SESSION['role']==2){
                $data['niveau']=$this->userModel->getLevelCandidat($_SESSION['id_cad']);
            }
            $this->view('forum/publications',$data);
        }else {
            redirect();
        }
        
    }

    public function ajouter(){
        
        if(isset($_SESSION['id']))
        {
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $profilePic = $this->userModel->getPic($userData['Image_id_img']);
            $_SESSION['dp'] = $profilePic->data;
            $_SESSION['page'] = 'forum';
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $data=[
                    'id' => $_SESSION['id'],
                    'familyname' => $userData['nom'],
                    'name' => $userData['prenom'],
                    'description' => $_POST['description'],
                    'title' => $_POST['title'],
                    'title_err' => '',
                    'description_err' => ''
                    
                ];
                //check for it
                if(strlen($data['description'])<50){
                    $data['description_err'] = 'au moins 50 caractères';
                }

                if(strlen($_POST['title'])>255){
                    $data['title_err'] = "pas plus de 255 caractère";
                }
                if(strlen($_POST['title'])<10){
                    $data['title_err'] = "au moins 10 caractères";
                }

                if(empty($data['description_err'])&&empty($data['title_err'])){

                    $this->userModel->addPost($data);
                    redirect('forum/publications');
                }
                //flush message

            }else{
                $data=[
                    'familyname' => $userData['nom'],
                    'name' => $userData['prenom'],
                    'description' =>'',
                    'title' =>'',
                    'title_err' =>'',
                    'description_err' =>''
                ];
            }
            $this->view('forum/ajouter',$data);
        }else {
            redirect();
        }
    }
    public function modifier($id){
        
        if(isset($_SESSION['id']))
        {
            //userdata
            $userData = $this->userModel->getUserDataById($_SESSION['id']);
            $userData = get_object_vars($userData);
            $profilePic = $this->userModel->getPic($userData['Image_id_img']);
            $_SESSION['dp'] = $profilePic->data;
            $_SESSION['page'] = 'forum';
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $data=[
                    'id' => $id,
                    'familyname' => $userData['nom'],
                    'name' => $userData['prenom'],
                    'description' =>$_POST['description'],
                    'title' =>$_POST['title'],
                    'title_err' =>'',
                    'description_err'=>''
                ];

                //checking data

                if(strlen($data['description'])<10){
                    $data['description_err']='au moins 10 caractères';
                }

                if(strlen($_POST['title'])>255){
                    $data['title_err'] = "pas plus de 255 caractère";
                }
                if(strlen($_POST['title'])<10){
                    $data['title_err'] = "au moins 10 caractères";
                }

                if(empty($data['description_err'])&&empty($data['title_err'])){
                    $this->userModel->updatePost($data);
                    redirect('forum/publications');
                }
            }else{

                $data=[
                    'id' => $id,
                    'familyname' => $userData['nom'],
                    'name' => $userData['prenom'],
                    'title' =>$this->userModel->getPostById($id)->titre_pub,
                    'title_err' =>'',
                    'description' =>$this->userModel->getPostById($id)->desc_pub,
                    'description_err'=>''
                ];
            }
            $this->view('forum/modifier',$data);
        }else {
            redirect();
        }
    }


    public function addComment(){
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data = [
                'description'=>$_POST['comment'],
                'id_pub' =>$_POST['id']
            ];

            $this->userModel->addComment($data);


        }else{
            redirect();
        }     
    }
    public function updateComment(){
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data = [
                'description'=>$_POST['edited'],
                'id' =>$_POST['id']
            ];

            $this->userModel->updateComment($data);
        }else{
            redirect();
        }     
    }
    public function updateReply(){
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data = [
                'description'=>$_POST['edited'],
                'id' =>$_POST['id']
            ];

            $this->userModel->updateReply($data);
        }else{
            redirect();
        }     
    }
    public function addReply(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $data = [
                'description'=>$_POST['reply'],
                'id_com' =>$_POST['id']
            ];

            $this->userModel->addReply($data);


        }else{
            redirect();
        }
    }

    public function deletePost($id){
        if($this->userModel->getPostById($id)->Utilisateur_id_user==$_SESSION['id']||$_SESSION['role']==0){
            $this->userModel->deletePost($id);
        }else{
            //alert not your post
        }
    }
    
    public function deleteComment($id){
        if($this->userModel->getCommentById($id)->Utilisateur_id_user==$_SESSION['id']||$_SESSION['role']==0){
            $this->userModel->deleteComment($id);
        }else{
            //alert not your post
        }
        
    }
    public function deleteReply($id){
        if($this->userModel->getReplyById($id)->Utilisateur_id_user==$_SESSION['id']||$_SESSION['role']==0){
            $this->userModel->deleteReply($id);
        }else{
            //alert not your post
        }
    }
    
    public function getPosts(){
        $posts = $this->userModel->getPosts();
        if(!$posts){
            echo ">empty<";
        }else{
            $data='';
            foreach($posts as $post)
            {
                $date_pub = new DateTime($post['pub']['date_pub']);
                if($_SESSION['id']==$post['user']['id_user']){
                    $buttons = '<button onClick="editPost('.$post['pub']['id_pub'].')" class="btn d-block d-sm-inline btn-sm btn-success mt-1">Modifier</button>
                    <button onClick="deletePost('.$post['pub']['id_pub'].')" class="btn d-block d-sm-inline btn-sm btn-danger mt-1">Supprimer</button>';
                }else if($_SESSION['role']==0){
                    $buttons ='<button onClick="deletePost('.$post['pub']['id_pub'].')" class="btn d-block d-sm-inline btn-sm btn-danger mt-1">Supprimer</button>';
                }else{
                    $buttons='';
                    
                }
                $userData = $this->userModel->getUserDataById($post['pub']['Utilisateur_id_user']);
                $dp = $this->userModel->getPic($userData->Image_id_img)->data;
                
                $data.='<div class="media border shadow p-3 mb-4">
                    <!-- profile picture of the poster -->
                    <a class="d-flex mr-3 align-self-bottom" href="#">
                        <img src="'.$dp.'" class=" rounded-circle" alt="" style="width:3em;">
                    </a>
                    <div class="media-body">
                        <!-- role -->
                        <small>'.getRole($post['user']['role']).'</small>
                        <!-- family name and name -->
                        <h6>'.$post['user']['nom'].' '.$post['user']['prenom'].'</h6>
                        <hr>
                        <h5 >'.$post['pub']['titre_pub'].'</h5>
                        <!-- description -->
                        <div class="text-wrap" style="max-height:25vh;overflow-y:auto;overflow-x:hidden;overflow-wrap: break-word;">
                            '.$post['pub']['desc_pub'].'
                        </div>
                        <hr>
                        <!-- buttons -->
                        <div class="row">
                            <div class="col-9">
                                <button onClick="getComments('.$post['pub']['id_pub'].')" class="btn d-block d-sm-inline btn-sm btn-secondary mt-1">Commenter<span
                                        class="ml-1 rounded px-1 bg-light text-secondary">'.$post['count'].'</span></button>
                                '.$buttons.'
                            </div>
                            <div class="col-3 text-right">
                                <small class="text-muted mt-1">'.$date_pub->format('Y/m/d').' à '.$date_pub->format('H:i:s').'</small>
                            </div>
                        </div>
                        
                        <!-- commentaire -->
                        <div id="comments'.$post['pub']['id_pub'].'">

                        </div>
                    </div>
                </div>';
            }
            echo $data;
        }
    }
    public function getComments($id){
        $comments = $this->userModel->getComments($id);
        $data='';
        foreach($comments as $comment){
            $date_com = new DateTime($comment['com']['date_com']);
            if($_SESSION['id']==$comment['user']['id_user']){
                $buttons = '<button onClick="editComment('.$comment['com']['id_com'].')" class="btn d-block d-sm-inline btn-sm btn-success mt-1">Modifier</button>
                <button onClick="deleteComment('.$comment['com']['id_com'].','.$id.')" class="btn d-block d-sm-inline btn-sm btn-danger mt-1">Supprimer</button>';
            }elseif($_SESSION['role']==0){
                
                $buttons='<button onClick="deleteComment('.$comment['com']['id_com'].','.$id.')" class="btn d-block d-sm-inline btn-sm btn-danger mt-1">Supprimer</button>';
                
            }else{
                $buttons='';
                
            }
            $userData = $this->userModel->getUserDataById($comment['com']['Utilisateur_id_user']);
            $dp = $this->userModel->getPic($userData->Image_id_img)->data;
            
            $data.='<div class="media border p-3 mt-4 mb-3>
                <!-- profile picture of the commenter -->
                <a class="d-flex align-self-bottom" href="#">
                    <img src="'.$dp.'" class=" rounded-circle" alt="" style="width:3em;">
                </a>
                <div class="media-body ml-3">
                    <!-- role -->
                    <small>'.getRole($comment['user']['role']).'</small>
                    <!-- family name and name -->
                    <h6>'.$comment['user']['nom'].' '.$comment['user']['prenom'].'</h6>
                    <hr>
                    <!-- description -->
                    <div id="descComment'.$comment['com']['id_com'].'" style="max-height:25vh;overflow-y:auto;overflow-wrap: break-word;">
                        '.$comment['com']['desc_com'].'
                    </div>
                    <hr>
                    <!-- buttons -->
                    <div class="row">
                        <div id="buttonsComment'.$comment['com']['id_com'].'" class="col-9">
                            <button onClick="getReplies('.$comment['com']['id_com'].')" class="btn d-block d-sm-inline btn-sm btn-secondary mt-1">Réponder
                            <span class="ml-1 rounded px-1 bg-light text-secondary">'.$comment['count'].'</span></button>
                            '.$buttons.'
                        </div>
                        <div class="col-3 text-right">
                            <small class="text-muted mt-1">'.$date_com->format('Y/m/d').' à '.$date_com->format('H:i:s').'</small>
                        </div>
                    </div>
                    <!-- replies -->
                    <div id="replies'.$comment['com']['id_com'].'">

                    </div>
                </div>
            </div>';
        }


        $user = $this->userModel->getUserDataById($_SESSION['id']);
        $addCommentModel = 
        '<div class="media border p-3 mt-4 mb-3">
            <a class="d-flex mr-3 align-self-bottom" href="#">
                <img src="'.$_SESSION['dp'].'" class="rounded-circle" alt="" style="width:3em;">
            </a>
            <div class="media-body">
                <small>'.getRole($_SESSION['role']).'</small>
                <h6>'.$user->nom .' '.$user->prenom.'</h6>
                <hr>
                <textarea id="newComment" rows="4" class="form-control"></textarea>
                <hr>
                <div class="row">
                    <div class="col-8 col-sm-9">
                        <button onClick="addComment('.$id.') " class="btn btn-sm btn-secondary">Commenter</button>
                    </div>
                </div>
            </div>
        </div>';

    echo $addCommentModel.$data;
    }
    public function getReplies($id){
        $replies = $this->userModel->getReplies($id);
        $data='';
        foreach($replies as $reply){
            $date_rep = new DateTime($reply['rep']['date_rep']);
            if($_SESSION['id']==$reply['user']['id_user']){
                $buttons = '<button onClick="editReply('.$reply['rep']['id_rep'].')" class="btn d-block d-sm-inline btn-sm btn-success mt-1">Modifier</button>
                <button onClick="deleteReply('.$reply['rep']['id_rep'].','.$id.')" class="btn d-block d-sm-inline btn-sm btn-danger mt-1">Supprimer</button>';
            }elseif($_SESSION['role']==0){
                $buttons='<button onClick="deleteReply('.$reply['rep']['id_rep'].','.$id.')" class="btn d-block d-sm-inline btn-sm btn-danger mt-1">Supprimer</button>';
            }else{
                
                $buttons='';
            }
            $userData = $this->userModel->getUserDataById($reply['rep']['Utilisateur_id_user']);
            $dp = $this->userModel->getPic($userData->Image_id_img)->data;
            
            $data.='<div class="media border p-3 mt-4 mb-3>
                <!-- profile picture of the replyer -->
                <a class="d-flex align-self-bottom" href="#">
                    <img src="'.$dp.'" class=" rounded-circle" alt="" style="width:3em;">
                </a>
                <div class="media-body ml-3">
                    <!-- role -->
                    <small>'.getRole($reply['user']['role']).'</small>
                    <!-- family name and name -->
                    <h6>'.$reply['user']['nom'].' '.$reply['user']['prenom'].'</h6>
                    <hr>
                    <!-- description -->
                    <div id="descReply'.$reply['rep']['id_rep'].'" style="max-height:25vh;overflow-y:auto;overflow-wrap: break-word;">
                        '.$reply['rep']['desc_rep'].'
                    </div>
                    <hr>
                    <!-- buttons -->
                    <div class="row">
                        <div id="buttonsReply'.$reply['rep']['id_rep'].'" class="col-9">
                            '.$buttons.'
                        </div>
                        <div class="col-3 text-right">
                            <small class="text-muted mt-1">'.$date_rep->format('Y/m/d').' à '.$date_rep->format('H:i:s').'</small>
                        </div>
                    </div>
                </div>
            </div>'; 
        }
        $user = $this->userModel->getUserDataById($_SESSION['id']);
        $addReplyModel = 
        '<div class="media border p-3 mt-4 mb-3">
            <a class="d-flex mr-3 align-self-bottom" href="#">
                <img src="'.$_SESSION['dp'].'" class="rounded-circle" alt="" style="width:3em;">
            </a>
            <div class="media-body">
            <small>'.getRole($_SESSION['role']).'</small>
            <h6>'.$user->nom .' '.$user->prenom.'</h6>
                <hr>
                <textarea id="newReply" rows="4" class="form-control"></textarea>
                <hr>
                <div class="row">
                    <div class="col-8 col-sm-9">
                        <button onClick="addReply('.$id.') " class="btn btn-sm btn-secondary">Réponder</button>
                    </div>
                </div>
            </div>
        </div>';
        echo $addReplyModel.$data;
    }

    public function liveSearch(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $posts = $this->userModel->postSearch($_POST['pattern']);
             // define empty string name is data in this line  that's all lol
            $data='';
            foreach($posts as $post){
                $date_pub = new DateTime($post['pub']['date_pub']);
                if($_SESSION['id']==$post['user']['id_user']){
                    $buttons = '<button onClick="editPost('.$post['pub']['id_pub'].')" class="btn d-block d-sm-inline btn-sm btn-success mt-1">Modifier</button>
                    <button onClick="deletePost('.$post['pub']['id_pub'].')" class="btn d-block d-sm-inline btn-sm btn-danger mt-1">Supprimer</button>';
                }else{
                    $buttons='';
                }
                $userData = $this->userModel->getUserDataById($post['pub']['Utilisateur_id_user']);
                $dp = $this->userModel->getPic($userData->Image_id_img)->data;
                
                $data.='
                        <div class="media border shadow p-3 mb-4">
                            <!-- profile picture of the poster -->
                            <a class="d-flex mr-3 align-self-bottom" href="#">
                                <img src="'.$dp.'" class=" rounded-circle" alt="" style="width:3em;">
                            </a>
                            <div class="media-body">
                                <!-- role -->
                                <small>'.getRole($post['user']['role']).'</small>
                                <!-- family name and name -->
                                <h6>'.$post['user']['nom'].' '.$post['user']['prenom'].'</h6>
                                <hr>
                                <h5 >'.$post['pub']['titre_pub'].'</h5>
                                <!-- description -->
                                <div class="text-wrap" style="max-height:25vh;overflow-y:auto;overflow-x:hidden;overflow-wrap: break-word;">
                                    '.$post['pub']['desc_pub'].'
                                </div>
                                <hr>
                                <!-- buttons -->
                                <div class="row">
                                    <div class="col-9">
                                        <button onClick="getComments('.$post['pub']['id_pub'].')" class="btn d-block d-sm-inline btn-sm btn-secondary mt-1">Commenter<span
                                                class="ml-1 rounded px-1 bg-light text-secondary">'.$post['count'].'</span></button>
                                        '.$buttons.'
                                    </div>
                                    <div class="col-3 text-right">
                                        <small class="text-muted mt-1">'.$date_pub->format('Y/m/d').' à '.$date_pub->format('H:i:s').'</small>
                                    </div>
                                </div>
                                
                                <!-- commentaire -->
                                <div id="comments'.$post['pub']['id_pub'].'">
            
                                </div>
                            </div>
                        </div>';
                
            }
            echo $data;

        }else{
            echo "you made it";
        }
    }
}
?>