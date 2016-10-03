<?php 
/*
策略模式：
	策略模式(Strategy Pattern)：定义一系列算法，将每一个算法封装起来，并让它们可以相互替换。策略模式让算法独立于使用它的客户而变化，也称为政策模式(Policy)。
	策略模式是一种对象行为型模式。

模式动机：
	完成一项任务，往往可以有多种不同的方式，每一种方式称为一个策略，我们可以根据环境或者条件的不同选择不同的策略来完成该项任务。
	在软件开发中也常常遇到类似的情况，实现某一个功能有多个途径，此时可以使用一种设计模式来使得系统可以灵活地选择解决途径，也能够方便地增加新的解决途径。
	在软件系统中，有许多算法可以实现某一功能，如查找、排序等，一种常用的方法是硬编码(Hard Coding)在一个类中，如需要提供多种查找算法，可以将这些算法写到一个类中，在该类中提供多个方法，每一个方法对应一个具体的查找算法；当然也可以将这些查找算法封装在一个统一的方法中，通过if…else…等条件判断语句来进行选择。这两种实现方法我们都可以称之为硬编码，如果需要增加一种新的查找算法，需要修改封装算法类的源代码；更换查找算法，也需要修改客户端调用代码。在这个算法类中封装了大量查找算法，该类代码将较复杂，维护较为困难。

角色分析：        
    抽象策略角色：策略类，通常由一个接口或者抽象类实现。
    具体策略角色：包装了相关的算法和行为。
	环境角色：持有一个策略类的引用，最终给客户端调用。

优点：      
    1、 策略模式提供了管理相关的算法族的办法。策略类的等级结构定义了一个算法或行为族。恰当使用继承可以把公共的代码转移到父类里面，从而避免重复的代码。
    2、 策略模式提供了可以替换继承关系的办法,继承可以处理多种算法或行为。如果不是用策略模式，那么使用算法或行为的环境类就可能会有一些子类，每一个子类提供一个不同的算法或行为。但是，这样一来算法或行为的使用者就和算法或行为本身混在一起。决定使用哪一种算法或采取哪一种行为的逻辑就和算法或行为的逻辑混合在一起，从而不可能再独立演化。继承使得动态改变算法或行为变得不可能。
	3、 使用策略模式可以避免使用多重条件转移语句。
	多重转移语句不易维护，它把采取哪一种算法或采取哪一种行为的逻辑与算法或行为的逻辑混合在一起，统统列在一个多重转移语句里面，比使用继承的办法还要原始和落后。

缺点：
    1、客户端必须知道所有的策略类，并自行决定使用哪一个策略类。
     这就意味着客户端必须理解这些算法的区别，以便适时选择恰当的算法类。换言之，策略模式只适用于客户端知道所有的算法或行为的情况。
    2、 策略模式造成很多的策略类，每个具体策略类都会产生一个新类。
	有时候可以通过把依赖于环境的状态保存到客户端里面，而将策略类设计成可共享的，这样策略类实例可以被不同客户端使用。换言之，可以使用享元模式来减少对象的数量。

*/

//代码实现：
header("Content-type:text/html;Charset=utf-8");
//抽象策略接口
abstract class Strategy{
	abstract function wayToSchool();
}
//具体策略角色
class BikeStrategy extends Strategy{
	function wayToSchool(){
         echo "骑自行车去上学";
	}
}
class BusStrategy extends Strategy{
	function wayToSchool(){
         echo "乘公共汽车去上学";
	}
}
class TaxiStrategy extends Strategy{
	function wayToSchool(){
         echo "骑出租车去上学";
	}
}

//环境角色
class Context{
	private $strategy;
    //获取具体策略
    function getStrategy($strategyName){
    	try{
    		$strategyReflection = new ReflectionClass($strategyName);
        	$this->strategy = $strategyReflection->newInstance();

    	}catch(ReflectionException $e){
             $this->strategy = ""; 
    	}       
    }

    function goToSchool(){
    	$this->strategy->wayToSchool();
    	// var_dump($this->strategy);
    }
}

//测试
$context = new Context();
$context->getStrategy("BusStrategy");
$context->goToSchool();
 ?>