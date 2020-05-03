<?php 

class User{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getSeance($id){
        $this->db->query('SELECT mnt.*, se.*,grp.*, us.* 
            FROM utilisateur as us, moniteur as mnt, seance as se, groupe as grp 
            WHERE se.id_seance="'.$id.'" AND se.moniteur_id_mnt=mnt.id_mnt AND se.groupe_id_grp=grp.id_grp 
            AND mnt.utilisateur_id_user=us.id_user;');
        return $this->db->single();
    }
    public function getRdv($id){
        $this->db->query('SELECT rdv.*,mnt.*,us.*,ve.* FROM rdv,moniteur as mnt, utilisateur as us, vehicul as ve 
        WHERE rdv.id_rdv="'.$id.'" AND rdv.moniteur_id_mnt=mnt.id_mnt AND us.id_user=mnt.utilisateur_id_user 
        AND rdv.vehicul_matricule=ve.matricule;');
        return $this->db->single();
    }

    public function editSaveExam($data){
        $this->db->query('UPDATE saveexam SET temps_debut="'.$data['tmp_d'].'",
        temps_fin="'.$data['tmp_f'].'",nbr_p="'.$data['nbr_p'].'",jour_exm="'.$data['day'].'"');
        $this->db->execute();
    }
    public function getSave(){
        $this->db->query('SELECT * FROM saveexam;');
        return $this->db->single();
    }

    public function createExamDay($date){
        $this->db->query('SELECT * FROM examen WHERE DATE_FORMAT(date_exm,"%Y-%m-%d")="'.$date->format('Y-m-d').'";');
        if($this->db->rowCount()==0){
            //add
            $this->db->query('INSERT INTO examen VALUES("","'.$date->format('Y-m-d').'","1");');
            $this->db->execute();
        }       
    }
    public function editPlanningSave($data){
        $this->db->query('UPDATE saveexam SET start_time="'.$data['start'].'",end_time="'.$data['end'].'"');
        $this->db->execute();
    }

    public function addGroup($data){
        $this->db->query('INSERT INTO groupe VALUES ("","'.$data['nom_grp'].'","'.$data['nbr_places'].'");');
        $this->db->execute();
    }
    



    public function getPlanning($firstDay, $lastDay){

        $this->db->query('SELECT * FROM seance WHERE DATE_FORMAT(date_seance, "%Y-%m-%d")>="'.$firstDay->format('Y-m-d').'" AND 
        DATE_FORMAT(date_seance, "%Y-%m-%d")<="'.$lastDay->format('Y-m-d').'" ORDER BY date_seance;');
        $seance = $this->db->resultSet();
        $this->db->query('SELECT * FROM rdv WHERE DATE_FORMAT(date_rdv, "%Y-%m-%d")>="'.$firstDay->format('Y-m-d').'" AND 
        DATE_FORMAT(date_rdv, "%Y-%m-%d")<="'.$lastDay->format('Y-m-d').'" ORDER BY date_rdv;');
        $rdv = $this->db->resultSet();
        return ['seance' => $seance, 'rdv' => $rdv];
    }

    public function checkEmail($value){
        $this->db->query('SELECT * FROM utilisateur WHERE email = :email');
        $this->db->bind(':email',$value);

        if($this->db->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function deleteSeance($id){
        $this->db->query('DELETE FROM seance WHERE id_seance="'.$id.'"');
        $this->db->execute();
    }
    public function deleteRdv($id){
        $this->db->query('DELETE FROM rdv WHERE id_rdv="'.$id.'"');
        $this->db->execute();
    }

    public function test(){
        
    }

    public function getChoice($date){
        $week_before = new DateTime($date->format('Y-m-d H:i:s'));
        $week_before->sub(new DateInterval('P7D')); 
        
        $this->db->query('SELECT mnt.id_mnt FROM moniteur as mnt WHERE mnt.id_mnt NOT IN
        (SELECT mnt.id_mnt FROM rdv, moniteur as mnt
        WHERE rdv.date_rdv="'.$date->format('Y-m-d H').':00:00" and mnt.id_mnt=rdv.moniteur_id_mnt);');
        //moniteurs who doesn't work in in that time 
        $moniteurs = $this->db->resultSet();
        $mntArray = array();
        $mnta=[
            'mnt' =>'',
            'count'=>''
        ];
        $i=0;
        foreach ($moniteurs as $mnt) {
            $this->db->query('SELECT count(rdv.id_rdv) as nbr FROM rdv WHERE 
            rdv.moniteur_id_mnt="'.$mnt->id_mnt.'" AND DATE_FORMAT(rdv.date_rdv, "%Y-%m-%d")<"'.$date->format('Y-m-d').'"
            AND DATE_FORMAT(rdv.date_rdv, "%Y-%m-%d")>="'.$week_before->format('Y-m-d').'";');
            if($i==0) {$mnta['count']=$this->db->single()->nbr ;$mnta['mnt']=$mnt->id_mnt;$i++;}
            if($mnta['count']>$this->db->single()->nbr){
                echo "we are here";
                unset($mntArray);
                $mntArray = array();
                $mnta['count']=$this->db->single()->nbr ;$mnta['mnt']=$mnt->id_mnt;
            }elseif ($mnta['count']==$this->db->single()->nbr){
                array_push($mntArray,$mnta);
            }
        }
        
        $permis=$this->getPermisId($_SESSION['id']);


        $this->db->query('SELECT v.* FROM vehicul as v WHERE permis_id_pem="'.$permis['id_pem'].'" and v.matricule NOT IN
        (SELECT v.matricule FROM rdv, vehicul as v
        WHERE rdv.date_rdv="'.$date->format('Y-m-d H').':00:00" and v.matricule=rdv.vehicul_matricule and statut_v="1"
        and permis_id_pem="'.$permis['id_pem'].'");');

        $vehiculs = $this->db->resultSet();
        $vaArray = array();
        $va=[
            'v' =>'',
            'count'=>''
        ];
        $i=0;

        foreach ($vehiculs as $v) {
            $this->db->query('SELECT count(rdv.id_rdv) as nbr FROM rdv WHERE 
            rdv.vehicul_matricule="'.$v->matricule.'" AND DATE_FORMAT(rdv.date_rdv, "%Y-%m-%d")<"'.$date->format('Y-m-d').'"
            AND DATE_FORMAT(rdv.date_rdv, "%Y-%m-%d")>="'.$week_before->format('Y-m-d').'";');
            if($i==0) {$va['count']=$this->db->single()->nbr ;$va['v']=$v->matricule;$i++;}

            if($va['count']>$this->db->single()->nbr){
                unset($vaArray);
                $vaArray = array();
                $va['count']=$this->db->single()->nbr ;$va['v']=$v->matricule;
            }elseif ($va['count']==$this->db->single()->nbr) {
                array_push($vaArray,$va);
            }
        } 

        if(empty($vaArray)){
            return [
                'm' => $mnta,
                'v' => $va
            ];
            
        }else{
            $selMnt=rand(0,sizeof($mntArray));
            $selVe=rand(0,sizeof($vaArray));
            return[
                'm' => $mntArray[$selMnt]['mnt'],
                'v' => $mntArray[$selVe]['v']
            ];
        }
    } 

    public function getWorkingday(){
        $this->db->query('SELECT * FROM saveexam');
        return $this->db->single();
    }

    public function getRessources(){
        $this->db->query('SELECT * FROM ressource;');
        $res = $this->db->resultSet();
        $returned = array();
        foreach($res as $re)
        {
            array_push($returned,get_object_vars($re));
        }
        return $returned;
    }

    public function getRessourceById($id){
        $this->db->query('SELECT * FROM ressource WHERE id_ress="'.$id.'";');
        return $this->db->single();
    }

    public function getPublisher($id){
        $this->db->query('SELECT utilisateur.*,image.data FROM ressource, moniteur, Image, utilisateur WHERE ressource.id_ress="'.$id.'" AND 
        ressource.Moniteur_id_mnt = moniteur.id_mnt AND moniteur.Utilisateur_id_user = utilisateur.id_user 
        AND utilisateur.Image_id_img = image.id_img ;');
        return $this->db->single();
    }

    public function getContributers($id){
        $this->db->query('SELECT utilisateur.*, image.data FROM utilisateur, moniteur, Image, contribution 
        WHERE contribution.Ressource_id_ress="'.$id.'" AND contribution.Moniteur_id_mnt=moniteur.id_mnt 
        AND moniteur.Utilisateur_id_user=Utilisateur.id_user AND utilisateur.Image_id_img=image.id_img;');
        return $this->db->resultSet();
    }

    public function contRessource($data){
        $now = New DateTime('Africa/Algiers');

        $this->db->query('SELECT * FROM contribution WHERE Moniteur_id_mnt="'.$data['id_mnt'].'" AND Ressource_id_ress="'.$data['id_ress'].'";');
        if($this->db->rowCount()>0){
            $this->db->query('UPDATE contribution SET d_cont="'.$now->format('Y-m-d H:i:s').'" WHERE Moniteur_id_mnt="'.$data['id_mnt'].'" AND Ressource_id_ress="'.$data['id_ress'].'";');
        }else{
            $this->db->query('INSERT INTO contribution VALUES("","'.date_format($now, 'Y-m-d H:i:s').'","'.$data['id_mnt'].'","'.$data['id_ress'].'");');
        }
        $this->db->execute();
        $this->db->query('UPDATE ressource SET cont_ress="'.$data['content'].'" WHERE id_ress="'.$data['id_ress'].'";');
        $this->db->execute();
    }
    
    public function updateRessource($data){
        $this->db->query('UPDATE ressource SET titre_ress="'.$data['title'].'",desc_ress="'.$data['description'].'",cont_ress="'.$data['content'].'";');
        $this->db->execute();
    }
    public function addRessource($data){
        $now = New DateTime('Africa/Algiers');
        $this->db->query('SELECT id_mnt FROM moniteur WHERE Utilisateur_id_user="'.$data['id_user'].'";');
        $this->db->query('INSERT INTO ressource Values("","'.$data['title'].'",
        "'.$data['description'].'","'.$data['content'].'","'.date_format($now, 'Y-m-d H:i:s').'","'.$this->db->single()->id_mnt.'");');
        $this->db->execute();
    }

    public function deletGroupe($id){
        $this->db->query('DELETE FROM groupe WHERE id_grp="'.$id.'";');
        $this->db->execute();
    }

    public function getGroup($id){
        $this->db->query('SELECT * FROM groupe WHERE id_grp = "'.$id.'"');
        return get_object_vars($this->db->single());
    }

    public function getCandidatGroup($id){

        $this->db->query('SELECT id_cl FROM client WHERE Utilisateur_id_user="'.$id.'";');
        $this->db->query('SELECT id_cad FROM candidat WHERE Client_id_cl="'.$this->db->single()->id_cl.'";');
        $this->db->query('SELECT Groupe_id_grp FROM candidat WHERE id_cad="'.$this->db->single()->id_cad.'";');
        $this->db->query('SELECT nom_grp FROM groupe WHERE id_grp="'.$this->db->single()->Groupe_id_grp.'";');
        return $this->db->single()->nom_grp;
    }

    public function getCountCand($id){
        $this->db->query('SELECT * FROM candidat WHERE Groupe_id_grp="'.$id.'";');
        return $this->db->rowCount();
    }

    public function permisUsed($id){
        $this->db->query('SELECT * FROM client, candidat WHERE client.Permis_id_pem="'.$id.'" AND client.id_cl=candidat.Client_id_cl;');
        if($this->db->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function getIdOfPermis($id){
        $this->db->query('SELECT client.Permis_id_pem FROM utilisateur, client WHERE utilisateur.id_user=client.Utilisateur_id_user AND utilisateur.id_user="'.$id.'";');
        return $this->db->single()->Permis_id_pem;
    }

    public function getDossier($id){
        $this->db->query('SELECT dossier FROM permis WHERE id_pem="'.$id.'";');
        return $this->db->single()->dossier;
    }

    public function checkActif($email){
        $this->db->query('SELECT * FROM utilisateur WHERE email="'.$email.'";');
        if($this->db->rowCount()>0){
            if($this->db->single()->statut_acc==0){
                return true;
            }
        }
        return false;
    } 

    public function addPermis($data){
        $this->db->query('INSERT INTO permis VALUES ("","'.$data['categorie'].'","'.$data['prix'].'","'.$data['prix_rdv'].'","'.$data['code'].'","'.$data['creneau'].'","'.$data['conduite'].'","'.$data['add_h'].'","'.$data['add_p'].'","'.$data['dossier'].'");');
        $this->db->execute();
    }

    public function deletePermis($id){
        $this->db->query('DELETE FROM permis WHERE id_pem="'.$id.'";');
        $this->db->execute();
    }

    public function editPermis($data){
        $this->db->query('UPDATE permis SET categorie="'.$data['categorie'].'",prix="'.$data['prix'].'",prix_rdv_h="'.$data['prix_rdv'].'",code_h="'.$data['code'].'",
        creneau_h="'.$data['creneau'].'",conduite_h="'.$data['conduite'].'",add_h="'.$data['add_h'].'",add_p="'.$data['add_p'].'",dossier="'.$data['dossier'].'" WHERE id_pem="'.$data['id'].'";');
        $this->db->execute();
    }


    public function getGroups(){
        $this->db->query('SELECT * FROM groupe WHERE nom_grp!="-";');
        return $this->db->resultSet();
    }

    public function editGroup($data){
        $this->db->query('UPDATE groupe SET nom_grp="'.$data['nom'].'",nbr_p="'.$data['nbr'].'" WHERE id_grp="'.$data['id'].'" ;');
        $this->db->execute();
    }

    public function getInExam(){
        $this->db->query('SELECT Candidat_id_cad FROM insexam;');
        $data=$this->db->resultSet();//Array([0]=>stdObject(candidat_id_cad));
        $returned = array();
        $combined =[
            'candidat'=>'',
            'client'=>'',
            'user'=>'',
            'permis'=>''
        ];
        foreach($data as $dt){
            $this->db->query('SELECT * FROM candidat where id_cad = "'.$dt->Candidat_id_cad.'" ;');
            $combined['candidat'] = get_object_vars($this->db->single());
            $this->db->query('SELECT * FROM client where id_cl="'.$combined['candidat']['Client_id_cl'].'";');
            $combined['client'] = get_object_vars($this->db->single());
            $this->db->query('SELECT * FROM utilisateur where id_user="'.$combined['client']['Utilisateur_id_user'].'";');
            $combined['user'] = get_object_vars($this->db->single());
            $this->db->query('SELECT * FROM permis where id_pem="'.$combined['client']['Permis_id_pem'].'";');
            $combined['permis'] = get_object_vars($this->db->single());
            array_push($returned,$combined);
        }
        return $returned;
    }

    public function checkEmailEdit($value){
        $this->db->query('SELECT * FROM utilisateur WHERE email = :email AND id_user!=:id');
        $this->db->bind(':email',$value);
        $this->db->bind(':id',$_SESSION['id']);

        if($this->db->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    public function getUserInsc(){
        $this->db->query('SELECT * FROM client WHERE statut="0";');
        $clients = $this->db->resultSet();
        $returned = array();
        $combined =[
            'client' => '',
            'user' => '',
            'candidat' =>''
        ];
        foreach($clients as $client){
            $combined['client'] = get_object_vars($client);
            $this->db->query('SELECT * FROM utilisateur WHERE id_user="'.$client->Utilisateur_id_user.'";');
            $combined['user'] = get_object_vars($this->db->single());
            if($combined['user']['role']==2){
                $this->db->query('SELECT * FROM candidat WHERE Client_id_cl="'.$combined['client']['id_cl'].'";');
                if($this->db->single()) $combined['candidat'] = get_object_vars($this->db->single());
            }else{
                $combiuned['candidat'] = '';   
            }
            array_push($returned,$combined);
        }
        return $returned;
    }

    public function updateImageVehicul($data,$mat){
        if($_SESSION['dp_id']==9)
        {
            $name = generateRandomString();
            $this->db->query("INSERT INTO image values('','".$name."','".$data."');");
            $this->db->execute();
          
            $this->db ->query('SELECT id_img FROM image WHERE nom_img="'.$name.'";');
            $dp_id=$this->db->single();                       

            $this->db->query('UPDATE vehicul set Image_id_img='. $dp_id->id_img .' WHERE matricule='.$mat.';');
            $this->db->execute();

        }else{
            $this->db->query('SELECT Image_id_img FROM vehicul WHERE matricule="'.$mat.'";');
            $this->db->query('UPDATE image SET data=:data where id_img="'.$this->db->single()->Image_id_img.'";');
            $this->db->bind(':data',$data);
            $this->db->execute();
        }
    }

    public function updateVehicul($data,$mat){
        $this->db->query('UPDATE vehicul set matricule="'.$data['matricule'].'",marque="'.$data['marque'].'",
        modele="'.$data['modele'].'",df_assu="'.$data['df_assu'].'",dfc_tec="'.$data['dfc_tec'].'", Permis_id_pem="'.$this->getpermisByCategorie($data['permis'])->id_pem.'", statut_v="'.$data['statut'].'" WHERE matricule="'.$mat.'";');
        $this->db->execute();
    }

    public function addVehicul($data){
        $this->db->query('INSERT INTO vehicul values("'.$data['matricule'].'","'.$data['modele'].'","'.$data['marque'].'","1","'.$data['df_assu'].'","'.$data['dfc_tec'].'","'.$this->getpermisByCategorie($data['permis'])->id_pem.'","9");');
        $this->db->execute();
    }

    public function checkMat($currentMat,$previousMat){
        $this->db->query('SELECT * FROM vehicul WHERE matricule="'.$currentMat.'" AND matricule !="'.$previousMat.'";');
        if($this->db->rowCount() == 0){
            return false;
        }else{
            return true;
        }
    }

    public function disableAccount($id){
        $this->db->query('UPDATE utilisateur SET statut_acc="0" WHERE id_user="'.$id.'";');
        $this->db->execute();
    }
    public function enableAccount($id){
        $this->db->query('UPDATE utilisateur SET statut_acc="1" WHERE id_user="'.$id.'";');
        $this->db->execute();
    }

    public function updateEditedUser($data){
        $this->db->query('UPDATE utilisateur SET nom="'.$data['u_familyname'].'", prenom="'.$data['name'].'"
        ,adresse="'.$data['address'].'",dn="'.$data['birth'].'",sexe="'.$data['sexe'].'",grp_sang="'.$data['blood'].'",
        telephone="'.$data['phone'].'"WHERE id_user="'.$data['id'].'";');
        $this->db->execute();

        if($data['role']>1){
            $this->db->query('SELECT id_cl FROM client WHERE utilisateur_id_user="'.$data['id'].'";');
            $id_cl=$this->db->single()->id_cl;
            $this->db->query('SELECT id_pem FROM permis WHERE categorie = "'.$data['permis'].'";');
            $this->db->query('UPDATE client SET Permis_id_pem="'.$this->db->single()->id_pem.'"  WHERE id_cl="'.$id_cl.'";');
            $this->db->execute();
        }
        if($data['role']==2){
            $this->db->query('SELECT id_cad FROM candidat WHERE client_id_cl="'.$id_cl.'";');
            $this->db->query('UPDATE candidat SET Groupe_id_grp="'.$data['group'].'" WHERE id_cad="'.$this->db->single()->id_cad.'";');
            $this->db->execute();
        }
    }
    
    public function updateEdit($data){
        if($data['mpassword']){
            $this->db->query('UPDATE utilisateur SET nom="'.$data['familyname'].'", prenom="'.$data['name'].'"
            ,adresse="'.$data['address'].'",dn="'.$data['birth'].'",sexe="'.$data['sexe'].'",grp_sang="'.$data['blood'].'",
            telephone="'.$data['phone'].'", email="'.$data['email'].'", password="'.$data['npassword'].'"WHERE id_user="'.$_SESSION['id'].'";');
        }else{
            $this->db->query('UPDATE utilisateur SET nom="'.$data['familyname'].'", prenom="'.$data['name'].'"
            ,adresse="'.$data['address'].'",dn="'.$data['birth'].'",sexe="'.$data['sexe'].'",grp_sang="'.$data['blood'].'",
            telephone="'.$data['phone'].'", email="'.$data['email'].'"WHERE id_user="'.$_SESSION['id'].'";');

        }
        $this->db->execute();
    }

    public function getCountVehicul($id_pem){
        $this->db->query('SELECT * FROM vehicul WHERE Permis_id_pem="'.$id_pem.'" AND statut_v="1";');
        return [
            'N' => $this->db->rowCount(),
            'V' => $this->db->resultSet()
        ];
    }
    
    public function getVehiculMat($mat){
        $this->db->query('SELECT * FROM vehicul WHERE matricule="'.$mat.'";');
        $vehicul = get_object_vars($this->db->single());
        $this->db->query('SELECT * FROM image WHERE id_img="'.$vehicul['Image_id_img'].'";');
        $image = get_object_vars($this->db->single());
        return [
            'vehicul' =>$vehicul,
            'image' => $image
        ];
    }


    public function getVehicules(){
        $this->db->query('SELECT * FROM vehicul;');
        return $this->db->resultSet();
    }

    public function deleteRessource($id){
        $this->db->query('DELETE FROM ressource WHERE id_ress="'.$id.'";');
        $this->db->execute();
    }

    

    public function getIdMoniteur($id){
        $this->db->query('SELECT * FROM moniteur WHERE Utilisateur_id_user="'.$id.'";');
        return $this->db->single()->id_mnt;
    }
    public function getIdCandidat($id){
        $this->db->query('SELECT * FROM candidat WHERE Client_id_cl="'.$id.'";');
        return $this->db->single()->id_cad;
    }
    public function getIdClient($id){
        $this->db->query('SELECT * FROM client WHERE Utilisateur_id_user="'.$id.'";');
        return $this->db->single()->id_cl;
    }

    public function getClientById($id){

        $this->db->query('SELECT * FROM client WHERE id_cl="'.$id.'";');
        $client = $this->db->single();

        $this->db->query('SELECT * FROM utilisateur where id_user="'.$client->Utilisateur_id_user.'";');
        return $this->db->single();
    }

    public function getClients(){
        $this->db->query('SELECT * FROM utilisateur WHERE role="3";');
        $users = $this->db->resultSet();
        $combined=[
            'user' =>'',
            'client'=>''
        ];
        $returned = array();

        foreach($users as $user){
            $combined['user'] = get_object_vars($user);
            $this->db->query('SELECT * FROM client WHERE  Utilisateur_id_user = "'.$combined['user']['id_user'].'";');
            $combined['client'] = get_object_vars($this->db->single());
            array_push($returned,$combined);
        }
        return $returned;
    }

    public function getMoniteurId($id){
        $this->db->query('SELECT id_mnt FROM moniteur WHERE Utilisateur_id_user="'.$id.'";');
        return get_object_vars($this->db->single());
    }

    public function getMoniteurById($id){

        $this->db->query('SELECT * FROM  moniteur WHERE id_mnt="'.$id.'";');
        $mnt = $this->db->single();
        $this->db->query('SELECT * FROM utilisateur WHERE id_user="'.$mnt->Utilisateur_id_user.'";');
        return $this->db->single();
    }

    public function getMoniteurs(){
        $this->db->query('SELECT * FROM moniteur;');
        $moniteurs = $this->db->resultSet();
        $combined=[
            'user' =>'',
            'moniteur'=>''
        ];
        $returned = array();

        foreach ($moniteurs as $moniteur){
            $combined['moniteur'] = get_object_vars($moniteur);
            $this->db->query('SELECT * FROM utilisateur WHERE id_user = "'.$combined['moniteur']['Utilisateur_id_user'].'";');
            $combined['user'] = get_object_vars($this->db->single());
            array_push($returned,$combined);
        }
        return $returned;
    }


    public function getVersements($id){
        $this->db->query('SELECT * FROM versement WHERE Payement_id_pay="'.$id.'";');
        return $this->db->resultSet();
    }
    public function idPayement($id){
        $this->db->query('SELECT * FROM payement WHERE Client_id_cl="'.$id.'";');
        return $this->db->single();
    }
    public function getPayementId($id){
        $this->db->query('SELECT * FROM payement WHERE Client_id_cl="'.$id.'";');
        $pay = $this->db->single();
            $this->db->query('SELECT SUM(mont_ver) as sum FROM versement WHERE Payement_id_pay="'.$pay->id_pay.'";');
            if(!$this->db->single()->sum){
                return 0;
            }else{
                return $this->db->single()->sum;
            }
        }
    public function addVersement($data){
        $now = new DateTime();
        $this->db->query('INSERT INTO versement VALUES ("","'.$data['mont'].'","'.$now->format('Y-m-d H:m:s').'","'.$data['id'].'");');   
        $this->db->execute();
    }
    public function deleteVersement($id){
    $this->db->query('DELETE FROM versement WHERE id_ver="'.$id.'";');
    $this->db->execute();
    }
    public function updateVersement($data){
    $this->db->query('UPDATE versement SET mont_ver="'.$data['mont'].'" WHERE id_ver="'.$data['id'].'";');
    $this->db->execute();
    }

    public function getCandidats(){
        $this->db->query('SELECT * FROM candidat;');
        $candidats = $this->db->resultSet();
        $combined=[
            'user' =>'',
            'candidat' =>'',
            'client'=>''
        ];
        $returned = array();

        foreach($candidats as $candidat){
            $combined['candidat'] = get_object_vars($candidat);
            $this->db->query('SELECT * FROM client WHERE id_cl="'.$combined['candidat']['Client_id_cl'].'";');
            $combined['client'] = get_object_vars($this->db->single());
            $this->db->query('SELECT * FROM utilisateur WHERE id_user = "'.$combined['client']['Utilisateur_id_user'].'";');
            $combined['user'] = get_object_vars($this->db->single());
            array_push($returned,$combined);
        }
        return $returned;
    } 

    public function updateImage($data){
        if($_SESSION['dp_id']<8)
        {
            $name = generateRandomString();
            $this->db->query("INSERT INTO Image values('','".$name."','".$data."');");
            $this->db->execute();
          
            $this->db ->query('SELECT id_img FROM Image WHERE nom_img="'.$name.'";');
            $dp_id=$this->db->single();                       
            $_SESSION['dp_id'] = $dp_id->id_img ;

            $this->db->query('UPDATE utilisateur set Image_id_img='. $dp_id->id_img .' WHERE id_user='.$_SESSION['id'].';');
            $this->db->execute();

        }else{
            $this->db->query("UPDATE image SET data=:data where id_img=:dp_id");
            $this->db->bind(':data',$data);
            $this->db->bind(':dp_id',$_SESSION['dp_id']);
            $this->db->execute();
        }

    }


    public function getCount($table){
        $table = strtolower($table);
        $this->db->query('SELECT * FROM '. $table .';');
        return $this->db->rowCount();
    }

    public function updateStatus(){
        $this->db->query('UPDATE client SET statut = :actif WHERE Utilisateur_id_user = :id_user');
        $this->db->bind(':actif',1);
        $this->db->bind(':id_user',$_SESSION['id']);
        $this->db->execute();
    }

    public function updatePassword($data){
        $this->db->query('UPDATE utilisateur SET password = :password WHERE id_user = :id_user;');
        $this->db->bind(':password',$data['password']);
        $this->db->bind(':id_user',$data['id']);
        $this->db->execute();
    }

    public function getUserData($email){
        $this->db->query('SELECT * FROM utilisateur WHERE email = :email');
        $this->db->bind(':email',$email);

        return $this->db->single();
    }

    public function getPic($id){
        $this->db->query('SELECT data FROM image WHERE id_img = :id');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }

    public function getUserDataById($id){
        $this->db->query('SELECT * FROM utilisateur WHERE id_user = :id');
        $this->db->bind(':id',$id);
        return $this->db->single();
    }

    public function getCode(){
        $this->db->query('SELECT code FROM client WHERE Utilisateur_id_user = :id');
        $this->db->bind(':id',$_SESSION['id']);
        return $this->db->single();
    }

    public function getStatus(){
        $this->db->query('SELECT statut FROM client WHERE Utilisateur_id_user = :id');
        $this->db->bind(':id',$_SESSION['id']);
        return $this->db->single()->statut;
    }

    public function getLevelCandidat($id_cad){
        $this->db->query('SELECT niveau FROM candidat WHERE id_cad="'.$id_cad.'";');
        return $this->db->single()->niveau;
    }

    public function getPermis(){
        $this->db->query('SELECT * FROM permis;');
        return $this->db->resultSet();
    }
    public function getPermisById($id){
        $this->db->query('SELECT * FROM permis WHERE id_pem="'.$id.'";');
        return get_object_vars($this->db->single());
    }

    public function getPermisId($id){
        $this->db->query('SELECT id_cl FROM client WHERE Utilisateur_id_user='.$id.';');
        $this->db->query('SELECT Permis_id_pem FROM client WHERE id_cl='.$this->db->single()->id_cl.'');
        $this->db->query('SELECT * FROM permis WHERE id_pem='.$this->db->single()->Permis_id_pem.';');
       
        return get_object_vars($this->db->single());
    }

    public function liveSearchRessource($pattern){
        $this->db->query('SELECT * FROM ressource WHERE titre_ress LIKE "%'.$pattern.'%";');
        $res = $this->db->resultSet();
        $returned = array();
        foreach($res as $re)
        {
            array_push($returned,get_object_vars($re));
        }
        return $returned;
    }

    public function getCountComments($id){
        $this->db->query('SELECT * FROM commentaire WHERE Publication_id_pub="'.$id.'";');
        return $this->db->rowCount();
    }
    public function getCountreplies($id){
        $this->db->query('SELECT * FROM reponse WHERE Commentaire_id_com="'.$id.'";');
        return $this->db->rowCount();
    }

    public function addPost($data){
        $now = new DateTime('Africa/Algiers');
        $this->db->query('INSERT INTO publication VALUES("","'.$data['title'].'","'.$data['description'].'","'.$now->format('Y-m-d H:i:s').'","'.$data['id'].'");');
        $this->db->execute();
    }

    public function postSearch($pattern){
        $mixed = [
            'pub' => '',
            'count' =>'',
            'user' => ''
        ];
        $this->db->query('SELECT * FROM publication WHERE titre_pub LIKE "%'.$pattern.'%";');
        $pubs = $this->db->resultSet();

        $returned = array();
        
        foreach ($pubs as $pub) {
            $mixed['pub'] = get_object_vars($pub);
            $this->db->query('SELECT * FROM utilisateur WHERE id_user="'.$mixed['pub']['Utilisateur_id_user'].'";');
            $mixed['user'] = get_object_vars($this->db->single());
            $this->db->query('SELECT * FROM commentaire WHERE Publication_id_pub="'.$mixed['pub']['id_pub'].'";');
            $mixed['count'] = $this->db->rowCount();
            array_push($returned,$mixed);
        }
        return $returned;   
    }
    
    public function addComment($data){
        $now = new DateTime('Africa/Algiers');
        $this->db->query('INSERT INTO commentaire VALUES("","'.$data['description'].'","'.date_format($now, 'Y-m-d H:i:s').'","'.$data['id_pub'].'","'.$_SESSION['id'].'");');
        $this->db->execute();
    }
    public function addReply($data){
        $now = new DateTime('Africa/Algiers');
        $this->db->query('INSERT INTO reponse VALUES("","'.$data['description'].'","'.date_format($now, 'Y-m-d H:i:s').'","'.$data['id_com'].'","'.$_SESSION['id'].'");');
        $this->db->execute();
    }
    public function updatePost($data){
        $this->db->query('UPDATE publication SET desc_pub = "'.$data['description'].'",titre_pub = "'.$data['title'].'" WHERE id_pub ="'.$data['id'].'";');
        $this->db->execute();
    }
    public function updateComment($data){
        $this->db->query('UPDATE commentaire SET desc_com = "'.$data['description'].'" WHERE id_com ="'.$data['id'].'";');
        $this->db->execute();
    }
    public function updateReply($data){
        $this->db->query('UPDATE reponse SET desc_rep = "'.$data['description'].'" WHERE id_rep ="'.$data['id'].'";');
        $this->db->execute();
    }
    public function deletePost($id){
        $this->db->query('SELECT * FROM commentaire WHERE Publication_id_pub="'.$id.'";');
        $comments = $this->db->resultSet();
        if($comments){
            foreach ($comments as $comment) {
                $this->deleteComment($comment->id_com);
            }
        }
        $this->db->query('DELETE FROM publication WHERE id_pub="'.$id.'";');
        $this->db->execute();
    }
    public function deleteComment($id){  
        $replies = $this->db->query('SELECT * FROM reponse WHERE commentaire_id_com="'.$id.'";');
        if($replies){
            foreach($replies as $reply){
                $this->deleteReply($reply->id_rep);
            }
        }
        $this->db->query('DELETE FROM commentaire WHERE id_com="'.$id.'";');
        $this->db->execute();
    }
    public function deleteReply($id){
        $this->db->query('DELETE FROM reponse WHERE id_rep='.$id.';');
        $this->db->execute();
    }


    public function getPosts(){
        $mixed = [
            'pub' => '',
            'count' =>'',
            'user' => ''
        ];
        $this->db->query('SELECT * FROM publication ORDER BY id_pub DESC;');
        $pubs = $this->db->resultSet();

        $returned = array();
        
        foreach ($pubs as $pub) {
            $mixed['pub'] = get_object_vars($pub);
            $this->db->query('SELECT * FROM utilisateur WHERE id_user="'.$mixed['pub']['Utilisateur_id_user'].'";');
            $mixed['user'] = get_object_vars($this->db->single());
            $this->db->query('SELECT * FROM commentaire WHERE Publication_id_pub="'.$mixed['pub']['id_pub'].'";');
            $mixed['count'] = $this->db->rowCount();
            array_push($returned,$mixed);
        }
        return $returned;
    } 
    public function getComments($id){
        $mixed = [
            'com' => '',
            'count' => '',
            'user' => ''
        ];
        $this->db->query('SELECT * FROM commentaire WHERE Publication_id_pub="'.$id.'" ORDER BY id_com DESC;');
        $coms = $this->db->resultSet();
        $returned = array();

        foreach ($coms as $com) {
            $mixed['com'] = get_object_vars($com);
            $this->db->query('SELECT * FROM utilisateur WHERE id_user="'.$mixed['com']['Utilisateur_id_user'].'";');
            $mixed['user'] = get_object_vars($this->db->single());
            $this->db->query('SELECT * FROM reponse WHERE Commentaire_id_com="'.$mixed['com']['id_com'].'";');
            $mixed['count'] = $this->db->rowCount();
            array_push($returned,$mixed);
        }
        return $returned;

    } 

    public function getPhCandidat($id){

        $this->db->query('SELECT * FROM client WHERE Utilisateur_id_user="'.$id.'";');
        $client=$this->db->single();

        $this->db->query('SELECT * FROM candidat WHERE client_id_cl="'.$client->id_cl.'";');
        $candidat = $this->db->single();
        
        $this->db->query('SELECT id_pay FROM payement WHERE Client_id_cl="'.$client->id_cl.'";');
        $id_pay=$this->db->single()->id_pay;

        $pb = $client->prix_base;
        $pba = $candidat->add_p_base;
        $nbe = $candidat->nbr_echoue;
        $pay=$pb+($pb*(($pba*$nbe)/100));

        $this->db->query('UPDATE payement SET mont_pay="'.$pay.'" WHERE id_pay="'.$id_pay.'";');
        $this->db->execute();

        $sum=$this->getPayementId($client->id_cl);
        $rest= $pay-$sum;
        if($rest<0) $rest = 0;
        $payement = [
            'montant' => $pay,
            'payee' => $sum,
            'restant' => $rest
        ];
        
        


        $hours = [
            'code' => '',
            'crenaux' => '',
            'conduit' => ''
        ];

        $this->db->query('SELECT * FROM seance WHERE Groupe_id_grp="'.$candidat->Groupe_id_grp.'" AND statut_seance="1";');
        $nbr_code = $this->db->rowCount();
        $code=$candidat->code_h_cad;
        $creneau=$candidat->creneau_h_cad;
        $conduite=$candidat->conduite_h_cad;
        $add=$candidat->add_h_base;

        $hours['code'] = ($code-$nbr_code)+($add*$nbe);

        $this->db->query('SELECT * FROM rdv WHERE Client_id_cl="'.$client->id_cl.'" AND statut_rdv="1" AND type_rdv="0";');
        $nbr_creneau = $this->db->rowCount();
        $hours['crenaux'] = ($creneau-$nbr_creneau)+($add*$nbe);

        $this->db->query('SELECT * FROM rdv WHERE Client_id_cl="'.$client->id_cl.'" AND statut_rdv="1" AND type_rdv="1";');
        $nbr_conduite = $this->db->rowCount();

        $hours['conduit'] = ($conduite-$nbr_conduite)+($add*$nbe);
        
        return[
            'payements' => $payement,
            'hours' => $hours
        ];
    }

    public function getOneEvent($date){

            $this->db->query('SELECT * FROM seance WHERE seance.moniteur_id_mnt="'.$_SESSION['id_mnt'].'"
            AND seance.statut_seance="0" AND DATE_FORMAT(seance.date_seance,"%Y-%m-%d %H")>"'.$date->format('Y-m-d H').'"  
            ORDER BY seance.date_seance LIMIT 1;');
            $seance = $this->db->single();
            
            $this->db->query('SELECT * FROM rdv WHERE rdv.moniteur_id_mnt="'.$_SESSION['id_mnt'].'"
            AND rdv.statut_rdv="0" AND DATE_FORMAT(rdv.date_rdv,"%Y-%m-%d %H")>"'.$date->format('Y-m-d H').'"  
            ORDER BY rdv.date_rdv LIMIT 1;');
            $rdv = $this->db->single();
            if($seance && $rdv){
                if($seance->date_seance>$rdv->date_seance){
                    print_r($seance);
                }else{
                    print_r($rdv);
                }
            }elseif($seance){
                print_r($seance);
            }elseif($rdv){
                print_r($rdv);
            }else{
                return NULL;
            }
                
           

    }

    public function getOneSeance($date){
        switch ($_SESSION['role']) {
            //still some code here get seance in case of moniteur and candidat
            case '2':
            {  
                $this->db->query('SELECT seance.* FROM seance,candidat 
                WHERE seance.groupe_id_grp=candidat.groupe_id_grp
                AND candidat.id_cad="'.$_SESSION['id_cad'].'"
                AND seance.statut_seance="0" AND 
                DATE_FORMAT(seance.date_seance,"%Y-%m-%d %H")>"'.$date->format('Y-m-d H').'"
                ORDER BY seance.date_seance LIMIT 1;');
                return $this->db->single();
                break;
            }

        }
    }   

    public function getOneRdv($date){
        switch ($_SESSION['role']) {
            case '2':
            {    
                $this->db->query('SELECT rdv.* FROM rdv
                WHERE rdv.Client_id_cl="'.$_SESSION['id_cl'].'"
                AND rdv.statut_rdv="0" AND 
                DATE_FORMAT(rdv.date_rdv,"%Y-%m-%d %H")>"'.$date->format('Y-m-d H').'"
                ORDER BY rdv.date_rdv LIMIT 1;');
                return $this->db->single();
                break;
            }
            case '3':
            {   $this->db->query('SELECT rdv.* FROM rdv
                WHERE rdv.statut_rdv="0" AND rdv.client_id_cl="'.$_SESSION['id_cl'].'"
                AND DATE_FORMAT(rdv.date_rdv,"%Y-%m-%d %H")>"'.$date->format('Y-m-d H').'"
                ORDER BY rdv.date_rdv LIMIT 1;');
                return $this->db->single();
                break;
            }
        }
    } 

    public function getMessages($id){
        $this->db->query('SELECT * FROM message WHERE (emt="'.$id.'" AND rec="'.$_SESSION['id'].'") 
        OR (rec="'.$id.'" AND emt="'.$_SESSION['id'].'") ORDER BY date_msg ;');
        $messages = $this->db->resultSet();
        return $messages;     
    }

    public function updateViewedMessage($id){
        $this->db->query('UPDATE message SET statut_msg="1" WHERE emt="'.$id.'" AND rec="'.$_SESSION['id'].'";');
        $this->db->execute();
    }

    public function addMessage($data){
        $now = new Datetime('Africa/Algiers');
        $this->db->query('INSERT INTO message VALUES("","'.$data['desc_msg'].'","'.$now->format('Y-m-d H-i-s').'","0","'.$_SESSION['id'].'",
        "'.$data['id'].'");');
        $this->db->execute();
    }

    public function getConversation(){
        $this->db->query('SELECT DISTINCT us.* 
        FROM utilisateur as us, message as msg 
        WHERE us.id_user != "'.$_SESSION['id'].'" AND (us.id_user = msg.emt AND msg.rec = "'.$_SESSION['id'].'") OR (us.id_user = msg.rec AND msg.emt = "'.$_SESSION['id'].'")
        ;');
        $returned = [
            'notViewed' => array(),
            'conversations' => $this->db->resultSet()
        ];

        $this->db->query('SELECT DISTINCT emt FROM message WHERE rec="'.$_SESSION['id'].'" AND statut_msg="0";');
        $arr=$this->db->resultSet();

        foreach ($arr as $ar) {
            array_push($returned['notViewed'],$ar->emt);
        }
        
        return $returned;
    }

    public function isThereNewMessage(){
        $this->db->query('SELECT * FROM message WHERE rec="'.$_SESSION['id'].'" AND statut_msg="0";');
        if($this->db->rowCount()){
            return 1;
        }else{
            return 0;
        }
    }

    public function getContact(){
        $contacts=array();
        if($_SESSION['role']!=0){
            $this->db->query('SELECT * FROM utilisateur WHERE role="0";');
            array_push($contacts,$this->db->single());

            if($_SESSION['role']==1){

                $this->db->query('SELECT * FROM moniteur WHERE utilisateur_id_user!="'.$_SESSION['id'].'";');
                $moniteurs = $this->db->resultSet();
                foreach ($moniteurs as $moniteur) {
                    # code...
                    array_push($contacts,$moniteur);
                }
    
                $this->db->query('SELECT DISTINCT us.*
                 FROM moniteur as mnt, utilisateur as us,client as cl,groupe as gp, seance as se, candidat as cd 
                 WHERE mnt.utilisateur_id_user="'.$_SESSION['id'].'" AND se.moniteur_id_mnt=mnt.id_mnt AND cd.client_id_cl=cl.id_cl 
                 AND cl.utilisateur_id_user=us.id_user AND cd.niveau=1 AND cd.groupe_id_grp = se.groupe_id_grp ;');
                 $candidats = $this->db->resultSet();
                foreach ($candidats as $candidat) {
                    # code...
                    array_push($contacts,$candidat);
                }
    
                $this->db->query(
                'SELECT DISTINCT us.* 
                 FROM moniteur as mnt, utilisateur as us,client as cl,rdv 
                 WHERE mnt.Utilisateur_id_user="'.$_SESSION['id'].'" AND rdv.moniteur_id_mnt=mnt.id_mnt 
                 AND rdv.Client_id_cl=cl.id_cl AND cl.Utilisateur_id_user=us.id_user');
                 $clients = $this->db->resultSet();
                 foreach ($clients as $client) {
                     # code...
                     array_push($contacts,$client);
                 }
    
            }
    
            if($_SESSION['role']==2){
    
                $this->db->query('SELECT DISTINCT us.* 
                FROM utilisateur as us, candidat as cd ,moniteur as mnt, seance as se, client as cl 
                WHERE cl.Utilisateur_id_user="'.$_SESSION['id'].'" and cd.niveau=1 and us.id_user=cl.utilisateur_id_user AND cl.id_cl=cd.client_id_cl 
                AND se.groupe_id_grp=cd.groupe_id_grp AND mnt.id_mnt = se.moniteur_id_mnt;');
    
                $moniteurs = $this->db->resultSet();
                foreach ($moniteurs as $moniteur) {
                    # code...
                    array_push($contacts,$moniteur);
                }

    
                // $this->db->query('SELECT DISTINCT us.* 
                // FROM utilisateur as us, candidat as cd ,moniteur as mnt, seance as se, client as cl 
                // WHERE cl.Utilisateur_id_user=7 and cd.niveau=1 and us.id_user=cl.utilisateur_id_user AND cl.id_cl=cd.client_id_cl 
                // AND se.groupe_id_grp=cd.groupe_id_grp AND mnt.id_mnt = se.moniteur_id_mnt;');
    
    
                
            }
    
            if($_SESSION['role']==3){
    
            }
        }else{
            $this->db->query('SELECT * FROM utilisateur WHERE role!="0";');
            $contacts = $this->db->resultSet(); 
        }


        

        return $contacts;
    }

    public function deleteUser($id){
        $this->db->query('DELETE FROM utilisateur WHERE id_user = "'.$id.'";');
        $this->db->execute();
    } 

    

    public function getPhClient(){

        $rdvs=[
            'total'=>0,
            'termine'=>0,
            'restant'=>0
        ];

        $payement = [
            'montant' => 0,
            'payee' => 0,
            'restant' => 0
        ];

        //getting the client
        $this->db->query('SELECT * FROM client WHERE Utilisateur_id_user="'.$_SESSION['id'].'";');
        $client=$this->db->single();
        
        
        //getting his rdv
        $this->db->query('SELECT * FROM rdv WHERE  Client_id_cl="'.$client->id_cl.'";');
        $rdvs = $this->db->resultSet();
        $total = $this->db->rowCount();
        
        $done = 0;
        $notYet = 0;

        $now = new DateTime('Africa/Algiers');

        foreach ($rdvs as $rdv) {
            if($rdv->date_rdv<$now){
                $notYet++;
            }else{
                $done++;
            }
        }

        
        
        $rdvs['total'] = $total;
        $rdvs['termine'] = $done;
        $rdvs['restant'] = $notYet;
        
        $payement['total'] = $client->prix_base*$done;
        //update payement
        $this->db->query('UPDATE payement set mont_pay = "'.$payement['total'].'" WHERE 
        Client_id_cl="'.$client->id_cl.'"');
        $this->db->execute();

        $payement['payee'] = $this->getPayementId($client->id_cl);


        $payement['restant'] = $payement['total'] - $payement['payee'];
        if( $payement['restant']<0) $payement['restant']=0;


        return [
            'payement' =>$payement,
            'rdvs' =>$rdvs
        ];
    }

    public function getPostById($id){
        $this->db->query('SELECT * FROM publication WHERE id_pub = "'.$id.'";');
        return $this->db->single();
    }
    public function getCommentById($id){
        $this->db->query('SELECT * FROM commentaire WHERE id_com = "'.$id.'";');
        return $this->db->single();
    }
    public function getReplyById($id){
        $this->db->query('SELECT * FROM reponse WHERE id_rep = "'.$id.'";');
        return $this->db->single();
    }

    public function getReplies($id){
        $this->db->query('SELECT * FROM reponse WHERE Commentaire_id_com="'.$id.'" ORDER BY id_rep DESC;');
        $reps = $this->db->resultSet();
        $mixed = [
            'rep' => '',
            'user' => ''
        ];
        $returned = array();

        foreach ($reps as $rep) {
            $mixed['rep'] = get_object_vars($rep);
            $this->db->query('SELECT * FROM utilisateur WHERE id_user="'.$mixed['rep']['Utilisateur_id_user'].'";');
            $mixed['user'] = get_object_vars($this->db->single());
            array_push($returned,$mixed);
        }
        return $returned;
    } 

    public function getExams(){
        $now = new DateTime('Africa/Algiers');
        'SELECT COUNT(id_insc) as total, Examen_id_exm FROM insexam WHERE val_insc="1" AND res_exm!=0';
        'SELECT COUNT(id_insc) as success, Examen_id_exm FROM insexam WHERE val_insc="1" AND res_exm=1';
        $this->db->query('SELECT * FROM 
        (SELECT COUNT(id_insc) as total, Examen_id_exm FROM insexam WHERE val_insc="1" AND res_exm!=0) as total,
        (SELECT COUNT(id_insc) as success, Examen_id_exm FROM insexam WHERE val_insc="1" AND res_exm=1) as success,
        examen as ex 
        WHERE ex.id_exm = total.Examen_id_exm AND ex.id_exm = success.Examen_id_exm;
        ');
        return $this->db->resultSet();
    }

    public function getPhone(){
        $this->db->query('SELECT telephone FROM utilisateur;');
        return $this->db->resultSet();
    }
    public function getPhoneEdit($id){
        $this->db->query('SELECT telephone FROM utilisateur WHERE id_user!=:id;');
        $this->db->bind(':id',$id);
        return $this->db->resultSet();
    }

    public function getpermisByCategorie($categorie){
        $this->db->query('SELECT * from permis where categorie=:categorie');
        $this->db->bind(':categorie',$categorie);
        return $this->db->single();
    }

    public function addSeance($data){
        $this->db->query('INSERT INTO seance VALUES("","'.$data['datetime']->format('Y-m-d H').'","0","'.$data['g'].'","'.$data['m'].'");');
        $this->db->execute();
    }

    public function createUser($data){
        $this->db->query('INSERT INTO utilisateur (nom,prenom,dn,grp_sang,adresse,telephone,sexe,email,password,role,statut_acc,date_creation,Image_id_img) VALUES
        (:nom,:prenom,:dn,:grp_sang,:adresse,:telephone,:sexe,:email,:password,:role,:statut_acc,:date_creation,:Image_id_img);');
        $this->db->bind(':nom',$data['ufamilyname']);
        $this->db->bind(':prenom',$data['name']);
        $this->db->bind(':dn',$data['birth']);
        $this->db->bind(':grp_sang',$data['blood']);
        $this->db->bind(':adresse',$data['address']);
        $this->db->bind(':telephone',$data['phone']);
        $this->db->bind(':sexe',$data['sexe']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':password',$data['password']);
        $this->db->bind(':role',$data['role']);
        $this->db->bind(':statut_acc',1);
        $now = new DateTime('Africa/Algiers');
        $this->db->bind(':date_creation',date_format($now, 'Y-m-d H:i:s'));
        switch ($data['role']) {
            case 0:{
                switch ($data['sexe']) {
                    case 'male':
                        $this->db->bind(':Image_id_img',1);
                        break;
                    
                    case 'female' :
                        $this->db->bind(':Image_id_img',2);
                        break;
                    default:
                        #code..
                        break;
                }
                break;
            }
            case 1:{
                switch ($data['sexe']) {
                    case 'male':
                        $this->db->bind(':Image_id_img',3);
                        break;
                    
                    case 'female' :
                        $this->db->bind(':Image_id_img',4);
                        break;
                    default:
                        #code..
                        break;
                }
                break;
            }
            case 2:
            {
                switch ($data['sexe']) {
                    case 'male':
                        $this->db->bind(':Image_id_img',5);
                        break;
                    
                    case 'female' :
                        $this->db->bind(':Image_id_img',6);
                        break;
                    default:
                        #code..
                        break;
                }
                break;
            }
            case 3:
            { 
                switch ($data['sexe']) {
                    case 'male':
                        $this->db->bind(':Image_id_img',7);
                        break;
                    
                    case 'female' :
                        $this->db->bind(':Image_id_img',8);
                        break;
                    default:
                        #code..
                        break;
                }
                break;
            }
            default:
                break;
        }
        $this->db->execute();

        //in case of candidat client moniteur
        $this->db->query('SELECT id_user FROM utilisateur WHERE email=:email');
        $this->db->bind(':email',$data['email']);
        $user = $this->db->single();
        switch ($data['role']){
            case 1 :{
                $this->db->query('INSERT INTO moniteur values ("",:Utilisateur_id_user);');
                $this->db->bind(':Utilisateur_id_user',$user->id_user);
                $this->db->execute();
                break;
            }
            case 2 :{

                //get the id of the permis
                $this->db->query('SELECT * from permis where categorie=:categorie');
                $this->db->bind(':categorie',$data['permis']);
                $permis = $this->db->single();
                

                $this->db->query('INSERT INTO client (statut,prix_base,code,Utilisateur_id_user,Permis_id_pem) values (:statut,:prix_base,:code,:Utilisateur_id_user,:Permis_id_pem);');
                if($data['addedFrom']==0){
                    $this->db->bind(':statut',1);
                }else{
                    $this->db->bind(':statut',0);
                }
                //generate code
                $this->db->bind(':code',generateRandomString());
                $this->db->bind(':prix_base',$permis->prix);
                $this->db->bind(':Utilisateur_id_user',$user->id_user);
                $this->db->bind(':Permis_id_pem',$permis->id_pem);
                $this->db->execute();

                //get the client id
                $this->db->query('SELECT id_cl from client where Utilisateur_id_user=:id_user');
                $this->db->bind(':id_user',$user->id_user);
                $client = $this->db->single();

                //create payement

                $this->db->query('INSERT INTO payement VALUES("","0","'.$client->id_cl.'")');
                $this->db->execute();

                $now = new Datetime('Africa/Algiers');
                //add the candidat // ifx things here
                $this->db->query('INSERT INTO candidat (niveau,nbr_echoue,add_p_base,code_h_cad,creneau_h_cad,conduite_h_cad,add_h_base,Client_id_cl,Groupe_id_grp) 
                values (:niveau,:nbr_echoue,:add_p_base,:code_h_cad,:creneau_h_cad,:conduite_h_cad,:add_h_base,:Client_id_cl,:Groupe_id_grp);');
                $this->db->bind(':niveau',1);
                $this->db->bind(':nbr_echoue',0);
                $this->db->bind(':add_p_base',$permis->add_p);
                $this->db->bind(':code_h_cad',$permis->code_h);
                $this->db->bind(':creneau_h_cad',$permis->creneau_h);
                $this->db->bind(':conduite_h_cad',$permis->conduite_h);
                $this->db->bind(':add_h_base',$permis->add_h);
                $this->db->bind(':Client_id_cl',$client->id_cl);
                $this->db->bind(':Groupe_id_grp',1);
                $this->db->execute();
                break;
            }
            case 3 :{
                //get the id of the permis

                $this->db->query('SELECT * from permis where categorie=:categorie');
                $this->db->bind(':categorie',$data['permis']);
                $permis = $this->db->single();
                

                $this->db->query('INSERT INTO client (statut,prix_base,code,Utilisateur_id_user,Permis_id_pem) values (:statut,:prix_base,:code,:Utilisateur_id_user,:Permis_id_pem);');
                if($data['addedFrom']==0){
                    $this->db->bind(':statut',1);
                }else{
                    $this->db->bind(':statut',0);
                }
                //generate code
                $this->db->bind(':code',generateRandomString());
                $this->db->bind(':prix_base',$permis->prix_rdv_h);
                $this->db->bind(':Utilisateur_id_user',$user->id_user);
                $this->db->bind(':Permis_id_pem',$permis->id_pem);
                $this->db->execute();

                //get the client id
                $this->db->query('SELECT id_cl from client where Utilisateur_id_user=:id_user');
                $this->db->bind(':id_user',$user->id_user);
                $client = $this->db->single();

                //create payement

                $this->db->query('INSERT INTO payement VALUES("","0","'.$client->id_cl.'")');
                $this->db->execute();

                break;
            }
        }
    }
}

?>