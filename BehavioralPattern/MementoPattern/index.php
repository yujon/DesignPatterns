<?php 
/*
备忘录模式：
	又叫做快照模式或Token模式，在不破坏封闭的前提下，捕获一个对象的内部状态，并在该对象之外保存这个状态。这样以后就可将该对象恢复到原先保存的状态。

角色：        
    1.创建者：负责创建一个备忘录，用以记录当前时刻自身的内部状态，并可使用备忘录恢复内部状态。发起人可以根据需要决定备忘录存储自己的哪些内部状态。
	2.备忘录：负责存储发起人对象的内部状态，并可以防止发起人以外的其他对象访问备忘录。备忘录有两个接口：管理者只能看到备忘录的窄接口，他只能将备忘录传递给其他对象。发起人却可看到备忘录的宽接口，允许它访问返回到先前状态所需要的所有数据。
	3.管理者:负责存取备忘录，不能对的内容进行访问或者操作。

适用性：
	必须保存一个对象在某一个时刻的(部分)状态, 这样以后需要时它才能恢复到先前的状态。
	如果一个用接口来让其它对象直接得到这些状态，将会暴露对象的实现细节并破坏对象的封装性。


*/
//代码实现
header("Content-type:text/html;Charset=utf-8");

//备忘录
class Memento{
	public $id;
	public $name;
	public $liveLevel;

	function __construct($id,$name,$liveLevel){
		$this->id = $id;
		$this->name = $name;
		$this->liveLevel = $liveLevel;
	}
}

//备忘录管理器
class Originator{
     public static $mementos = array();
     private static $instance = null;

     //单例模式确保只有一个管理器
     private function __construct(){

     }
     //返回单例对象
     static function getInstance(){
         if(!(self::$instance instanceOf slef)){
              self::$instance = new self();
         }
         return self::$instance;
     }
     //存备忘录
     function setMemento($id,Memento $memento){
         self::$mementos[$id] = $memento;
     }
     //取备忘录
     function getMemento($id){
     	return self::$mementos[$id];
     }
}

//创建者，玩家，可存取自身状态
class Player{
	private static $i = 0;  //静态变量累加用于给$id赋值
	public $id; //每个对象独一无二，用于保存状态备忘录到管理器
	private $name; //姓名
	private $liveLevel;  //生命值

	function __construct($name){
		$this->name = $name;
		$this->id = self::$i;
		self::$i++;
	}
    //初始化
	function init(){
       $this->liveLevel = 100;
	}

	//生命值减少10
	function damage(){
		$this->liveLevel -=10;
	}
   
    //显示现有状态
    function displayState(){
    	echo "姓  名：".$this->name."<br/>";
    	echo "生命值：".$this->liveLevel."<br/>";
    }

	//保存状态到一个备忘录中，该备忘录将被放置到管理器中
	function saveState(){
		$originator = Originator::getInstance();
		$originator->setMemento($this->id,new Memento($this->id,$this->name,$this->liveLevel));
	}
	//恢复备忘录
	function getState(){
        $originator = Originator::getInstance();
        $memento = $originator->getMemento($this->id);
        $this->id = $memento->id;
        $this->name = $memento->name;
        $this->liveLevel = $memento->liveLevel;
	}
}

//测试
//创建、初始化角色并显示状态
$player = new Player("张三");
$player->init();
$player->displayState(); //生命值100

//开始游戏前存档
$player->saveState();

//开始游戏,收到伤害生命值减少，显示状态
$player->damage();
$player->damage();
$player->displayState(); //生命值80

//回档恢复原来状态，显示状态
$player->getState();
$player->displayState();  //生命值100

 ?>