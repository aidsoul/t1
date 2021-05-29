<?php
namespace app\models\tables;

use Users;
use Yii;
use yii\db\ActiveRecord;


class Basket extends ActiveRecord
{

    private $goodsId = null;
    private $userId = null;

    public function __construct($goods = null)
    {
        $this->goodsId = base64_decode($goods);
        $user = Yii::$app->user->userId();
        if( $user ){
            $this->userId =  $user;
        }
    }
    public static function tableName()
    {
        return 'basket';
    }
    public function getGoods()
    {
        return $this->hasMany(Goods::className(), ['id_goods' => 'goods_id']);
    }
    public function getUser()
    {
        return $this->hasMany(User::className(), ['id_user' => 'user_id']);
    }

    public function receiveBasket()
    {
        $send = $this->find()->where(['user_id'=>$this->userId])->InnerJoinWith(Goods::tableName())->asArray()->all();
        if( $send ){
            return $send;
        }
        else {
            return false;
        }
        
    }


    private function findByGoods(){
 
     return $this->findOne(['goods_id' => $this->goodsId,'user_id' => $this->userId]);
        
    }
    
    public function countBasket(){
 
        return $this->find()->where(['user_id' => $this->userId])->asArray()->all();
           
       }

    public function removeAllGoodsInBasket(){
        $this->deleteAll(['user_id'=>$this->userId]);
    }

    public function addInBasket()
    {
       $get = $this->findByGoods();
       if($get){
        $goods = Goods::findOne(['id_goods'=>$this->goodsId]);
        if(!empty($goods)){
          if($get->count < $goods->count){
            $get->count++;
            $get->save();
          }
          else{
              return false;
          }
        }      
       }
       else{
        $this->goods_id = $this->goodsId;
        $this->user_id =  $this->userId;  
        $this->count = 1;
        $this->save();
       }

    }

    public function removeGoods(){
        $get =  $this->findByGoods();
        if($get){
            $get->delete();
        }
    }

    public function removeOfBasket()
    {
        if($this->goodsId){
            $get = $this->findByGoods();
            if($get){
             if( $get->count <= 1){
                 $get->delete();
                 return ['danger','Товар удалён!'];
             }
             else{
                 $get->count--;
                 $get->save();
                 return ['danger','Одним товаром стало меньше!'];
             }
            }
        }

    }

}