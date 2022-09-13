<?php

namespace app\modules\models;

use Yii;
use yii\base\Model;
use Symfony\Component\DomCrawler\Crawler;
use app\models\Category;
use app\models\Article;
use app\models\Alias;
/**
 * ParsePregmatch is the model.
 */
class ParsePregmatch extends Model
{
    public $url;
	public $grabmain;
	
	public $parentteg;
    public $parenttipe;
	public $parent;
	public $itemteg;
    public $itemtipe;
	public $item;
	
	public $titleteg;
	public $titletipe;
	public $title;
	public $categoryteg;
	public $categorytipe;
	public $category;
	public $imageteg;
	public $imagetipe;
	public $image;
	public $article;
	public $articleteg;
	public $articletipe;
	
	public $home;
	public $hometeg;
	public $hometipe;
	
	public $homeid;
	public $homeidteg;
	public $homeidtipe;
	
	/**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'grabmain', 'parentteg', 'parenttipe', 'parent', 'itemteg', 'titleteg', 'titletipe', 'categoryteg', 'categorytipe', 'imageteg', 'imagetipe', 'articleteg', 'articletipe'], 'required'],
			[['parent', 'item', 'title', 'image', 'article', 'category', 'home', 'hometeg', 'hometipe'], 'string', 'max' => 50],
        ];
    }
	
	/**
     * {@inheritdoc}
     */
	public function init()
	{
		if(Yii::$app->request->get('type') == 'rbk')
		{
			$this->url = 'https://www.rbc.ru/';
			$this->grabmain = 1;
			$this->parentteg = 'div';
			$this->parenttipe = '@class';
			$this->parent = 'js-news-feed-list';
			$this->itemteg = 'a';
			$this->itemtipe = '@class';
			$this->item = 'news-feed__item';
			$this->titleteg = 'h1';
			$this->titletipe = '@class';
			$this->title = 'article__header__title-in';
			$this->categoryteg = 'a';
			$this->categorytipe = '@class';
			$this->category = "article__header__category";
			$this->imageteg = 'meta';
			$this->imagetipe = 'other';
			$this->image = "property='og:image'";
			$this->article = "itemprop='articleBody'";
			$this->articleteg = 'div';
			$this->articletipe = 'other';
			$this->home = 'main__big__link';
			$this->hometeg = 'a';
			$this->hometipe = '@class';
			
			$this->homeid = 'main__big';
			$this->homeidteg = 'div';
			$this->homeidtipe = '@class';
		}
		parent::init();	
	}
	
	
	/**
     * @inheritdoc
     */
    public static function getTypelist()
    {
        return [
			'@class'  => 'Класс',
			'@id'     => 'Идентификатор',
			'other'   => 'Другой'
		];
    }
	
	/**
     * @inheritdoc
     */
    public static function getGrabmainlist()
    {
        return [
			'0'  => 'Нет',
			'1'  => 'да'
		];
    }
	
	/**
     * @inheritdoc
     */
    public static function getElementlist()
    {
        return [
			'div'  => 'div',
			'a'    => 'a',
			'span' => 'span',
			'h1'   => 'h1',
			'h2'   => 'h2',
			'h3'   => 'h3',
			'h4'   => 'h4',
			'h5'   => 'h5',
			'h6'   => 'h6',
			'p'    => 'p',
			'meta' => 'meta',
			'td'   => 'td',
			'img'  => 'img'
		];
    }
	
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'url'         => 'Страница донора',
            'grabmain'    => 'Паринг главной новости',
			'parentteg'   => 'Тэг блока',
			'parenttipe'  => 'Атрибут блока',
			'parent'      => 'Значение атрибута',
			'itemteg'     => 'Тэг элемента',
			'itemtipe'    => 'Атрибут элемента',
			'item'        => 'Значение атрибута',
			'titleteg'    => 'Тэг заголовка',
			'titletipe'   => 'Атрибут заголовка',
            'title'       => 'Значение атрибута',
            'categoryteg' => 'Тег категории',
            'categorytipe'=> 'Атрибут категории',
            'category'    => 'Значение атрибута',
			'image'       => 'Значение атрибута',
			'imageteg'    => 'Тег изображения',
			'imagetipe'   => 'Атрибут изображения',
			'article'     => 'Значение атрибута',
			'articleteg'  => 'Тэг блока контента',
			'articletipe' => 'Атрибут блока контента',
			'home'        => 'Значение атрибута',
			'hometeg'     => 'Тег сылки',
			'hometipe'    => 'Атрибут сылки',
			'homeid'      => 'Значение атрибута',
			'homeidteg'   => 'Тег ID',
			'homeidtipe'  => 'Атрибут ID'
        ];
    }
	
	public function Parse()
	{
		$content = $this->getSringHtml($this->url);
		if(!$content) return false;
		$crawler = new Crawler($content);

		//Graub Main News
		if($this->grabmain == 1)
		{
			// we get the id
			$prop = ($this->homeid == 'other') ? "@". trim($this->homeid) : "contains(". $this->homeidtipe .", '". trim($this->homeid) ."')";
			$Node_id = $crawler->filterXPath("//". $this->homeidteg ."[". $prop ."]");
			if(! $Node_id) { Yii::$app->session->setFlash('danger', 'Не нвйден идентификатор главной новости'); return;}
				else $id = $Node_id->attr("data-id");
			
			// we get the url		
			$prop = ($this->home == 'other') ? "@". trim($this->home) : "contains(". $this->hometipe .", '". trim($this->home) ."')";	
			$urlNode = $crawler->filterXPath("//". $this->hometeg ."[". $prop ."]")->first();
			if (!$urlNode) { Yii::$app->session->setFlash('danger', 'Не нвйден URL главной новости'); return;}
				else $url = $urlNode->attr("href");

			// we get the content page
			$content = $this->getContent($url, 1);
			if($content) $this->Save($content, $id);
		}
		
		//Graub List News	
		///$crawler->filterXPath("//div[contains(@class, 'js-news-feed-list')]/a[contains(@class, 'news-feed__item')]") 
		$crawler->filterXPath("//". $this->parentteg ."[contains(". $this->parenttipe .", '". $this->parent ."')]/". $this->itemteg ."[contains(". $this->itemtipe .", '". $this->parent ."')]") 		
            ->each(function (Crawler $node) {
				
                // we get the url
				$url = $node->attr("href");
                if (!$url) return;
				
				// we get the id
                $id = str_replace("id_newsfeed_", "", $node->attr("id")); 
                if (!$id)  return;
				
				// we get the content page
				$content = $this->getContent($url, 0);
				if($content) $this->Save($content, $id);
            });
	}
	
	private function Save($content, $id)
	{
		$transaction = Yii::$app->db->beginTransaction();
		try {
			$category = Category::findOne(['name' => $content['category']]);
			if($category === null)
			{
				$category = new Category([
					'name'   => $content['category'],
					'seourl' => $this->Translate($content['category']),
					'status' => 10,
					'parent_id' => 0
				]);
				if(!$category->validate())
				{
					foreach ($category->getErrors() as $key => $value) {
						\Yii::$app->session->setFlash('danger', 'Ошибка категории! '. $value[0]);
						break;
					}
					return false; 
				}
				$category->save();
				$alias = new Alias([
					'seourl' => $this->Translate($content['title']),
					'url'    => '/'. $this->Translate($content['title']),
					'safe'   => 'news/category?id='. $category->id
				]);
				$alias->save();
			}
			$article = Article::findOne(['ext_id' => $id]);

			if($article === null)
			{
				$article = new Article([
					'category_id' => $category->id,
					'title'       => $content['title'],
					'image'       => $content['image'],
					'announcement'=> $this->setAnons($content['article']),	
					'ext_id'      => $id,
					'content'     => $content['article'],
					'seourl'      => $this->Translate($content['title']),
				]);
				if(!$article->validate())
				{
					foreach ($article->getErrors() as $key => $value) {
						\Yii::$app->session->setFlash('danger', 'Ошибка статьи! '. $value[0]);
						break;
					}
					return false; 
				}
				$article->save();
				$alias = new Alias([
					'seourl' => $this->Translate($content['title']),
					'url'    => '/news/'. $this->Translate($content['title']),
					'safe'   => 'news/view?id='. $article->id
				]);
				$alias->save();
			}

			$transaction->commit();
			
			return true;
			
		} catch (\Exception $e) {
			\Yii::$app->session->setFlash('danger','Oшибка записи!');
			$transaction->rollBack();
			throw $e;
		} catch (\Throwable $e) {
			\Yii::$app->session->setFlash('danger','Oшибка записи!');
			$transaction->rollBack();
			throw $e;
		}
	}
	
	private function getSringHtml($url)
	{
		$arr = explode('=', $url);
		if(count($arr) > 2) return false;
		
		$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_URL, $url);
		return curl_exec($ch);
		
	}
	
	private function setAnons($string, $limit = 200)
	{
		mb_internal_encoding('UTF-8');
		$string = trim(str_replace('  ', '', strip_tags($string)));
		$anons = mb_substr($string, 0, $limit); 
		return $anons;
	}

	private function getContent(string $url, $type)
    {
        $content = $this->getSringHtml($url);
		if(!$content) return false;
        $crawler = new Crawler($content);
				
		
		// we get the title
		$prop = ($this->titletipe == 'other') ? "@". trim($this->title) : "contains(". $this->titletipe .", '". trim($this->title) ."')";
		$title = $crawler->filterXPath("//". $this->titleteg ."[". $prop ."]")->first(); 
		if (!empty($title))
		{
			$conten['title'] = trim($title->html());
		}

		
		// we get the image
		$prop = ($this->imagetipe == 'other') ? "@". trim($this->image) : "contains(". $this->imagetipe .", '". trim($this->image) ."')";	
        $imageBlock = $crawler->filterXPath("//". $this->imageteg ."[". $prop ."]")->first();
		$conten['image'] = '';
        if ($imageBlock->count()) {
			 
			 $conten['image'] = trim($imageBlock->attr("content"));
        }
		
		// we get the category
		$prop = ($this->categorytipe == 'other') ? "@". trim($this->category) : "contains(". $this->categorytipe .", '". trim($this->category) ."')";
		$category = $crawler->filterXPath("//". $this->categoryteg ."[". $prop ."]")->first(); 		
		if ($category)
		{
			$conten['category'] = trim($category->html());
        }

		// we get the article
		if($this->url == 'https://www.rbc.ru/')
		{
			$crawler->filter('html .pro-anons')->each(function (Crawler $crawler) {
				foreach ($crawler as $node) {
					$node->parentNode->removeChild($node);
				}
			});
			$crawler->filter('html .article__inline-item')->each(function (Crawler $crawler) {
				foreach ($crawler as $node) {
					$node->parentNode->removeChild($node);
				}
			});
			$crawler->filter('html .article__main-image')->each(function (Crawler $crawler) {
				foreach ($crawler as $node) {
					$node->parentNode->removeChild($node);
				}
			});
			$crawler->filter('html .article__ticker__link')->each(function (Crawler $crawler) {
				foreach ($crawler as $node) {
					$node->parentNode->removeChild($node);
				}
			});
			$crawler->filter('html .article__ticker__link')->each(function (Crawler $crawler) {
				foreach ($crawler as $node) {
					$node->parentNode->removeChild($node);
				}
			});
			$remove = $crawler->filter('html .fox-tail')->nextAll();
		}
		$prop = ($this->articletipe == 'other') ? "@". trim($this->article) : "contains(". $this->articletipe .", '". trim($this->article) ."')";
        $articleBlock = $crawler->filterXPath("//". $this->articleteg ."[". $prop ."]")->first(); 
        if ($articleBlock->count()) {
			$conten['article'] = mb_convert_encoding(trim($articleBlock->html()), 'UTF-8', mb_detect_encoding($articleBlock->html()));	
        }
		return $conten;
    }
	
	/**
	 * translete name 
     * @param string $data
     * @return string json
     */
	public function Translate($data, $language = 'ru') {
		
		$translit = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e', 
			'ё' => 'yo',   'ж' => 'zh',  'з' => 'z', 
			'и' => 'i',   'й' => 'j',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u', 
			'ф' => 'f',   'х' => 'x',   'ц' => 'c', 
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh', 
			'ь' => '',  'ы' => 'y',   'ъ' => '',
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
		 
 
			'А' => 'a',   'Б' => 'b',   'В' => 'v',
			'Г' => 'g',   'Д' => 'D',   'Е' => 'E',
			'Ё' => 'YO',   'Ж' => 'Zh',  'З' => 'Z',
			'И' => 'I',   'Й' => 'J',   'К' => 'K',
			'Л' => 'L',   'М' => 'M',   'Н' => 'N',
			'О' => 'O',   'П' => 'P',   'Р' => 'R',
			'С' => 'S',   'Т' => 'T',   'У' => 'U',
			'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
			'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
			'Ь' => '',    'Ы' => 'Y',   'Ъ' => '', 
			'Э' => 'E',   'Ю' => 'YU',  'Я' => 'YA',
			
			' ' => '-', ',' => '', '(' => '', ')' => '',
			'#' => '', '@' => '', '!' => '', '%' => '', '?' => '',
			'*' => '-', '=' => '', '+' => '', '&' => '-', '^' => '',
			'`' => '', '~' => '', '"' => '', '№' => '', '$' => '',
			';' => '', ':' => ''
 
		);
		
		if($language == 'ru') {
			return mb_strtolower(strtr(trim($data), $translit), 'utf-8');
		} else {
			return mb_strtolower(strtr(trim($data), array_flip($translit)), 'utf-8');
		}
	}
}
