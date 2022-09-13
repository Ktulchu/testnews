<?php
namespace app\components;
 
use app\models\Alias;
use yii\web\UrlRuleInterface;
 
class SefRule extends \yii\base\BaseObject implements UrlRuleInterface{
 
    public $connectionID = 'db';
    public $name;
 
    public function init(){
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }
	
	public function createUrl($manager, $route, $params)
	{
		if(count($params)){
            $link = "?";
            $page = false;
            foreach ($params as $key => $value){
                if($key == 'page'){
                    $page = $value;
                    continue;
                }
				if($key == 'per-page'){
                    continue;
                }
				if($key == 'id'){
					$id = $value;
                    continue;
                }
				if(is_array($value))
				{
					foreach($value as $subkey => $subvalue)
					{
						$link .= $key .'[]='.  $subvalue .'&';
					}
					
				}
				else
				{
					 $link .= "$key=$value&";
				}
               
            }
            $link = substr($link, 0, -1); 
        }
		

		if(isset($params['id']))
		{
			$sef = Alias::find()->where(['safe' => $route .'?id='. $params['id']])->one();	
		}
		
		if(isset($sef))
		{
			if($page) return str_replace('??', '?', $sef->url . '?' .$link . '&page=' . $page); else  return str_replace('??', '?', $sef->url . '?' . $link);
		}

		return false;
    }
	
    //Разбирает входящий URL запрос, преобразует ссылки произвольного вида (из БД поле url) в нужный для Yii2
    public function parseRequest($manager, $request){        	
		$pathInfo = '/'.  $request->getPathInfo();    
        $sef  = Alias::find()->where(['url' => $pathInfo])->one();
		if($sef){
			
			$link_data = explode('?', $sef->safe);

			if(isset($link_data[1]))
			{
				$temp = explode('&',$link_data[1]);

				foreach($temp as $t){
                    $t = explode('=', $t);
                    $params[$t[0]] = $t[1];
                }
            }

			return [$link_data[0], $params];
		}

		return false;
    }
}