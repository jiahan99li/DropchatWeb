<?php
class Friends
{
    static public function renderFriendShip($user_one, $user_two, $type)
    {
        if(!empty($user_one) && !empty($user_two)) 
        {
            $db = new PDO('mysql:host=localhost:3306;dbname=chiahanc_dropchat', 'chiahanc_drop', 'Vili0809');
            
            switch($type) 
            {
                case 'isThereRequestPending':
                    $query = $db->prepare("SELECT * FROM friends WHERE user_one='".$user_one."' AND user_two='".$user_two."' AND friendship_official='0'");
                    $query->execute();
                    
                    return $query->rowCount();
                    break;
                    
                case 'isThereFriendship':
                    $query = $db->prepare("SELECT * FROM friends WHERE user_one='".$user_one."' AND user_two='".$user_two."' AND friendship_official='1' OR user_one='".$user_two."' AND user_two='".$user_one."' AND friendship_official='1'");
                    $query->execute();
                    
                    return $query->rowCount();
                    break;
                    
                case 'isItAccepted':
                    $query = $db->prepare("SELECT * FROM friends WHERE user_one='".$user_two."' AND user_two='".$user_one."' AND friendship_official='0'");
                    $query->execute();
                    
                    return $query->rowCount();
                    break;
            }
        }
    }

    
    
    
    
    
    static public function add($uid, $user_two) {
        if(!empty($uid) && !empty($user_two)) 
        {
            include '../includes/dbh.inc.php';
            $db = new PDO('mysql:host=localhost;dbname=LIJIA', 'root', '');
            
            $response = array();
            
            $uid = $uid;
            $user_two = $user_two;
            $fr_official = 0;
            $now = date("Y-m-d h:i:s");
                
            if($uid != $user_two) {
                $f = new Friends;
                $check = $f->renderFriendShip($uid, $user_two, 'isThereFriendship');
            
            if($check == 0)
            {   
                $insert = $db->prepare("INSERT INTO friends VALUES ('','".$uid."', '".$user_two."', '".$fr_official."', '".$now."')");
                $insert->execute();
                
                $response['code'] = 1;
                $response['msg'] = "Request Sent!";
                echo json_encode($response);
                return false;
            } else {
                $response['code'] = 0;
                $response['msg'] = "Already Friends";
                echo json_encode($response);
                return false;
            } 
            } else {
                $response['code'] = 0;
                $response['msg'] = "You can't friend yourself";
                echo json_encode($response);
                return false;
            }
        } 
    }
}
