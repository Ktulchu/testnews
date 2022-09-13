<?
namespace app\widgets;
use yii;
use yii\base\Widget;
use app\models\Category;

class Navigation extends Widget{
	
	public $data;
	public $tree;

	public function run()
	{
		$results = Category::find()
			->select([
				'c.id',
				'c.parent_id',
				'c.name',
				'u.url'
			])
			->from('category c')
			->leftJoin('article a', 'a.category_id = c.id')
			->rightJoin('alias u', 'c.seourl = u.seourl')
			->where('c.status = :status', [':status' => 10])
			->orderBy(['c.name' => SORT_ASC])
			->asArray()
			->all();
		if($results)
		{
			foreach($results as $result)
			{
				$this->data[$result['id']] = $result;
			}
		}
	
		
		$this->tree = $this->getTree();	
		
		return $this->render( 'navigation', ['models' => $this->tree]);		
	}
	
	
	protected function getTree()
	{
		$tree = array();
		foreach ($this->data as $id => &$node)
		{
			if(!$node['parent_id'])
			{
				$tree[$id] = &$node;
			}
			else 
			{
				$this->data[$node['parent_id']]['chailds'][$node['id']] = &$node;
			}
		}
		return $tree;
	}
}
?>