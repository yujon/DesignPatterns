<?php
/*
访问者模式：
	表示作用于某个对象结构中的各个元素的操作。它使你可以在不改变各个元素类的前提下定义作用于这些元素的操作。

角色：
 	1)抽象访问者:为该对象结构中具体元素角色声明一个访问操作接口。该操作接口的名字和参数标识了发送访问请求给具体访问者的具体元素角色，这样访问者就可以通过该元素角色的特定接口直接访问它。
	2)具体访问者:实现访问者声明的接口。
	3)抽象元素:定义一个接受访问操作accept()，它以一个访问者作为参数。
    4) 具体元素:实现了抽象元素所定义的接受操作接口。
	5)结构对象:这是使用访问者模式必备的角色。它具备以下特性：能枚举它的元素；可以提供一个高层接口以允许访问者访问它的元素；如有需要，可以设计成一个复合对象或者一个聚集（如一个列表或无序集合）

 适用场景及优势：     
    1) 一个对象结构包含很多类对象，它们有不同的接口，而你想对这些对象实施一些依赖于其具体类的操作。
    2) 需要对一个对象结构中的对象进行很多不同的并且不相关的操作，而你想避免让这些操作“污染”这些对象的类。Visitor模式使得你可以将相关的操作集中起来定义在一个类中。
    3) 当该对象结构被很多应用共享时，用Visitor模式让每个应用仅包含需要用到的操作。
    4) 定义对象结构的类很少改变，但经常需要在此结构上定义新的操作。改变对象结构类需要重定义对所有访问者的接口，这可能需要很大的代价。如果对象结构类经常改变，那么可能还是在这些类中定义这些操作较好。
	
*/

//代码实现
header("Content-type:text/html;Charset=utf-8");

//抽象访问者接口,定义具体访问者要实现的方法，访问不同元素调用不同方法
abstract class Visitor{
	abstract function eat($place);
	abstract function work($place);
}
//具体访问者角色
class ConcreteVisitor extends Visitor{
	 //回家吃饭
	function eat($place){ 
		echo "回".$place->name."吃饭";
	}
	 //去公司上班
	function work($place){
		echo "去".$place->name."上班";
	}
}


//抽象元素，定义一个接受访问操作acceptVisitor()，它以一个访问者作为参数。
abstract class Place{
    abstract function acceptVisitor(Visitor $visitor);
}

//具体元素，实现抽象元素所定义的接受操作接口
//家，访问者回家吃饭
class Homn extends Place{
	public $name;

	function __construct($name){
		$this->name = $name;
	}

	function acceptVisitor(Visitor $visitor){
         $visitor->eat($this);
	}
}

//公司，访问者来公司上班
class Company extends Place{
	public $name;

	function __construct($name){
		$this->name = $name;
	}

	function acceptVisitor(Visitor $visitor){
         $visitor->work($this);
	}
}

//树形结构对象，即元素集合
class ObjectStruction{
	private $places = array();

	//增加元素
	function addPlace(Place $place){
		$this->places[] = $place;
	}
	//去除元素
	function removePlace(Place $place){
        $key = array_search($place, $this->places);
        if($key !== false){
        	unset($this->places[$key]);
        }
	}
	//元素集合所有元素接受访问
	function allAccept(Visitor $visitor)  {  
        foreach ($this->places as $place)  
        {  
            $place->acceptVisitor($visitor);  
        }  
    }  
}

//测试
$objectStruction = new ObjectStruction();
$home = new Homn("家");
$objectStruction->addPlace($home);
$company = new Company("公司");
$objectStruction->addPlace($company);

$visitor = new ConcreteVisitor();
$objectStruction->allAccept($visitor);

?>