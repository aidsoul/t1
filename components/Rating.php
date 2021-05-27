<?php
namespace app\components;
use yii;
use yii\base\Widget;

class Rating extends Widget 
{

    public $star;
    public function ratingImg($type){
        $svgStart = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">';
        $svgEnd = ' </svg>';
        $arr = [
            'star' => '<path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>',
            'star-h'=> ' <path d="M5.354 5.119L7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.519.519 0 0 1-.146.05c-.341.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.171-.403.59.59 0 0 1 .084-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027c.08 0 .16.018.232.056l3.686 1.894-.694-3.957a.564.564 0 0 1 .163-.505l2.906-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.002 2.223 8 2.226v9.8z"/>',
            'star-f' => '<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>'
        ];
        return  $svgStart.$arr[$type].$svgEnd;
    }


    public function ratingstarF($col,$type){
        for($i = 0; $i < $col; $i++){
            $str[] = $this->ratingImg($type);

        }

        return implode('',$str);
    }
    public function init()
    {        
    if($this->star === null){
        $this->star = 0;
        parent::init();
    }   
    }

    public function run()
    {    
        $arrTypes = [0,25,50,75,100];
        $star = $this->star;
        $starAsk = array_reduce($arrTypes, function ($carry, $item) use ( $star) {
            return $item <= $star? max($carry, $item): $carry;
        });
        if(empty($starAsk)){
            $starAsk = $arrTypes[0];
        }

        $send = [
            $arrTypes[0]=>$this->ratingstarF(5,'star'),
            $arrTypes[1]=>$this->ratingImg('star-h').$this->ratingstarF(4,'star'),
            $arrTypes[2]=>$this->ratingstarF(2,'star-f').$this->ratingImg('star-h').$this->ratingstarF(2,'star'),
            $arrTypes[3]=>$this->ratingstarF(3,'star-f').$this->ratingImg('star-h').$this->ratingstarF(1,'star'),
            $arrTypes[4]=>$this->ratingstarF(4,'star-f').$this->ratingImg('star-f')

        ];
        return $send[$starAsk].'<br>'.$star.'%';
    
    }
}