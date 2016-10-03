<?php 
/*
状态模式：
	允许一个对象在其内部状态改变时改变它的行为，对象看起来似乎修改了它的类。其别名为状态对象(Objects for States)，状态模式是一种对象行为型模式。

模式分析：
	在很多情况下，一个对象的行为取决于一个或多个动态变化的属性，这样的属性叫做状态，这样的对象叫做有状态的(stateful)对象，这样的对象状态是从事先定义好的一系列值中取出的。当一个这样的对象与外部事件产生互动时，其内部状态就会改变，从而使得系统的行为也随之发生变化。

角色：
	Context: 环境类
	State: 抽象状态类
	ConcreteState: 具体状态类

模式分析：
	状态模式描述了对象状态的变化以及对象如何在每一种状态下表现出不同的行为。
	状态模式的关键是引入了一个抽象类来专门表示对象的状态，这个类我们叫做抽象状态类，而对象的每一种具体状态类都继承了该类，并在不同具体状态类中实现了不同状态的行为，包括各种状态之间的转换。

在状态模式结构中需要理解环境类与抽象状态类的作用：
	环境类实际上就是拥有状态的对象，环境类有时候可以充当状态管理器(State Manager)的角色，可以在环境类中对状态进行切换操作。
	抽象状态类可以是抽象类，也可以是接口，不同状态类就是继承这个父类的不同子类，状态类的产生是由于环境类存在多个状态，同时还满足两个条件： 这些状态经常需要切换，在不同的状态下对象的行为不同。因此可以将不同对象下的行为单独提取出来封装在具体的状态类中，使得环境类对象在其内部状态改变时可以改变它的行为，对象看起来似乎修改了它的类，而实际上是由于切换到不同的具体状态类实现的。由于环境类可以设置为任一具体状态类，因此它针对抽象状态类进行编程，在程序运行时可以将任一具体状态类的对象设置到环境类中，从而使得环境类可以改变内部状态，并且改变行为。

*/
/*
需求：当用户花费余额少于10元时提醒其充值，当大于10元少于1000元时给其拨打电话推荐包月套餐，当前大于1000时给其推荐金融产品
*/
//代码实现
header("Content-type:text/html;Charset=utf-8");

//抽象状态类:
abstract class State{
	protected $balance; //余额
	abstract function recommend(); //推荐

}
//具体状态类，屌丝类（少于10元）
class DiaosiState extends State{
	//提醒或者推荐
	function recommend(){
		echo "别撸啦，停机了女神电话就打不进来拉，赶快充值";
	}
}
//具体状态类，中产类（多于10元，少于1000）
class ZhongchanState extends State{
	//提醒或者推荐
    function recommend(){
    	echo "4G套餐不错哦,妈妈再也不用担心我的话费用不完啦";
    }
}
//具体状态类，土豪类（多于1000）
class TuhaoState extends State{
	//提醒或者推荐
    function recommend(){
    	echo "e租宝不错哦，人傻钱多速来";
    }
}

//应用环境类，简单的理解为调用环境就可以了 
class Context{    
    private $state;    
    function setState($balance){    	 
     	if($balance<10){
     	 	$this->state = new DiaosiState();
     	}else if($balance>1000){
     	 	$this->state = new TuhaoState();
     	}else{
     	 	$this->state = new ZhongchanState();
     	}
    }
    function recommend(){
    	$this->state->recommend();
    }
}

//测试
$context = new Context();
$context->setState(100);
$context->recommend();
 ?>