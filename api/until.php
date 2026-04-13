<?php
class until {
    public static function domain($links) {
        return '/' . ltrim($links, '/');
    }
    
    public static function avatar() {
       if (!isset($_SESSION['logger']['username'])){
        return until::domain("item/ngocrong.png");
       }
       return until::domain("item/ngocrong.png");
    //    return until::avatar_(sql::Select("account" , "username" , $_SESSION['logger']['username'])['id']);
    }
    
    public static function isPl(){
        if (!isset($_SESSION['logger']['username'])){
        return null;
       }
       $account = sql::Select("account" , "username" , $_SESSION['logger']['username']);
       $player = sql::Select("player" , "account_id" , $account['id']);
       if (!$player){
           return null;
       }
       return $player;
    }
   
    
    public static function avatar_($uid) {
        $player = sql::Select("player" , "account_id" , $uid);
        if (!$player){
           return until::domain("Assets/Images/0.png");
        }
        $items_body = json_decode($player['items_body'], true);
        $avatar = ($player['gender'] == 0) ? 19 : (($player['gender'] == 1) ? 121 : 261);
        foreach ($items_body as $item) {
            $decoded_item = json_decode($item, true);
            if (is_array($decoded_item)) {
                if ($decoded_item[0] != -1){
                    $items = sql::Select("item_template" , "id" , $decoded_item[0]);
                    if ($items['TYPE'] == 5){
                    $avatar = $items['icon_id'];
           }
         }
     }
   }
   return until::domain("item/caitrang.png");
 }
}
?>