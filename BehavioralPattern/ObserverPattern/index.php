<?php 
/*
观察者模式：
	观察者模式(Observer Pattern)：定义对象间的一种一对多依赖关系，使得每当一个对象状态发生改变时，其相关依赖对象皆得到通知并被自动更新。观察者模式又叫做发布-订阅（Publish/Subscribe）模式、模型-视图（Model/View）模式、源-监听器（Source/Listener）模式或从属者（Dependents）模式。
	观察者模式是一种对象行为型模式。

模式动机
	建立一种对象与对象之间的依赖关系，一个对象发生改变时将自动通知其他对象，其他对象将相应做出反应。在此，发生改变的对象称为观察目标，而被通知的对象称为观察者，一个观察目标可以对应多个观察者，而且这些观察者之间没有相互联系，可以根据需要增加和删除观察者，使得系统更易于扩展，这就是观察者模式的模式动机。

观察者模式包含如下角色：
	Subject: 目标
	ConcreteSubject: 具体目标
	Observer: 观察者
	ConcreteObserver: 具体观察者

适用性：
	当一个抽象模型有两个方面, 其中一个方面依赖于另一方面。将这二者封装在独立的对象中以使它们可以各自独立地改变和复用。
	当对一个对象的改变需要同时改变其它对象, 而不知道具体有多少对象有待改变。
	当一个对象必须通知其它对象，而它又不能假定其它对象是谁。换言之, 你不希望这些对象是紧密耦合的
*/

//代码实现
header("Content-type:text/html;Charset=utf-8");
//目标接口，定义观察目标要实现的方法
abstract class Subject{
   abstract function attach(Observer $observer);  //添加观察者
   abstract function detach(Observer $observer);  //去除观察者
   abstract function notify();  //满足条件时通知所有观察者修改
   abstract function condition($num); //发起通知的条件
}
//具体观察目标
class ConcreteSubject extends Subject{
	private $observers = array();
	//添加观察者
	function attach(Observer $observer){
         $this->observers[] = $observer;
	}
	//移除观察者
	function detach(Observer $observer){
		 $key=array_search($observer, $this->observers);
		 if($key !== false){  //注意不要写成!=,表达式0!=flase为flase
		 	 unset($this->observers[$key]);
		 }
	}
	//通知所有所有观察者修改
	function notify(){
		foreach($this->observers as $observer){
			$observer->update();
		}
	}
	//发起通知的条件
	function condition($num){
		if($num>100){
			$this->notify();
		}
	}
}

//抽象观察者接口，定义所有观察者共同具有的属性——执行修改
abstract class Observer{
	abstract function update();
}
//具体观察者类，实现抽象观察者接口
class ConcreteObserverA extends Observer{

	function update(){
       echo "A报告:敌军超过一百人了，快撤！<br>";
	}
	//其他函数
	function eat(){
		echo "A在吃饭";
	}
}
class ConcreteObserverB extends Observer{

	function update(){
       echo "B报告:敌军超过一百人了，快撤！<br>";
	}
    //其他函数
	function sleep(){
		echo "B在睡觉";
	}
}


//测试
$observerA = new ConcreteObserverA();
$observerB = new ConcreteObserverB();
$concreteSubject = new ConcreteSubject();
$concreteSubject->attach($observerA);  //添加观察者A
$concreteSubject->detach($observerA);  //去除观察者A
$concreteSubject->attach($observerA);
$concreteSubject->attach($observerB);
$concreteSubject->condition(1000);

 ?>