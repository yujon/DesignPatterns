<?php 
疑是一种好办法；
/*原型模式：
	原型模式通过复制已经存在的实例来返回新的实例，而不是新建实例，并且原型（被复制的实例）是可定制的；原型模式多用于创建复杂的或耗时的实例，这种情况下，复制一个已经存在的实例是程序运行更高效无

主要角色：
	抽象原型角色(Prototype)：声明一个克隆自身的接口
	具体原型角色(ConcretePrototype)：实现一个克隆自身的操作

Prototype模式优点：
	1、可以在运行时刻增加和删除产品
	2、可以改变值或结构以指定新对象
	3、减少子类的构造
	4、用类动态配置应用

Prototype模式的缺点：
	Prototype是的最主要的缺点就是每一个类必须包含一个克隆方法；
	而且这个克隆方法需要对类的功能进行检测，这对于全新的类来说较容易，但对已有的类进行改造时将不是件容易的事情；

适用场景：
	1、当一个系统应该独立于它的产品创建、构成和表示时，要使用Prototype模式
	2、当要实例化的类是在运行时刻指定时，例如动态加载
	3、为了避免创建一个与产品类层次平等的工厂类层次时；
	4、当一个类的实例只能有几个不同状态组合中的一种时。建立相应数目的原型并克隆它们可能比每次用合适的状态手工实例化该类更方便一些
*/
//方案一：
interface Prototype{
	function copy();
}
class ConcretePrototype implements Prototype{
	 public $time;
	 public $people;  //对象
     function __construct($time,$people){
         $this->time = $time;
         $this->people = $people;
     }

     //序列化和反序列化对象实现复制，深度复制
     function copy(){
         return unserialize(serialize($this));
     }
}

/*
//方法二：
class ConcretePrototype implements Prototype{
	 public $time;
	 public $people;  //对象
     function __construct($time,$people){
         $this->time = $time;
         $this->people = $people;
     }

     //在克隆前调用，将所有子对象进行深度复制，不过当子对象较多或者层次较深时比较麻烦
     function __clone(){
         $this->people = new people("zhangsang");
     }
}
*/

class People{
	public $name;
	function __construct($name){
		$this->name = $name;
	}
}

//测试：
$prototype = new ConcretePrototype("2016/5/26",new People("zhangsang"));
// $clonePrototype = clone $prototype;
$clonePrototype = $prototype->copy();
echo $clonePrototype->people->name;
$prototype->people->name = "lisi";
echo $clonePrototype->people->name;
?>	