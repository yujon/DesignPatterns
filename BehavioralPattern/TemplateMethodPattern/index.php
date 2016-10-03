<?php 
// 模板方法模式：
// 定义一个操作中的算法的骨架，而将一些步骤延迟到子类中。TemplateMethod 使得子类可以不改变一个算法的结构即可重定义该算法的某些特定步骤。

// 角色：
// 抽象模板角色：抽象模板类，定义了一个具体的算法流程和一些留给子类必须实现的抽象方法。
// 具体子类角色：实现抽象模板类中的抽象方法，子类可以有自己独特的实现形式，但是执行流程受抽象模板类控制。

// 适用性：
// 1、完成某一细节层次一致的一个过程或一系列步骤，但其个别步骤在更详细的层次上的实现可能不同时。我们通常考虑用模板模式来处理。
// 2、当不变的和可变的行为在方法的子类实现中混合在一起的时候，不变的行为就会在子类中重复出现，我们通过模板模式把这些行为搬移到单一的地方，这样就帮助子类摆脱重复的不变行为的纠缠。
// 3、模板模式通过把不变的行为搬移到超级抽象类，去除子类中的重复代码来体现它的优势。模板模式提供了一个很好的代码复用平台。

//代码实现
header("Content-type:text/html;Charset=utf-8");

//抽象模板类：
abstract class makeComputer{
     private $type;
     function __construct($type){
     	$this->type = $type;
     }
     function procedure(){
     	$this->prepareScreen();  
     	$this->prepareMainboard();
     	$this->prepareCPU();
     	$this->prepareMemoryBank();
     }
     abstract function prepareScreen();
     abstract function prepareMainboard();
     abstract function prepareCPU();
     abstract function prepareMemoryBank();
}

class makeLenovoComputer extends makeComputer{
	 function __construct($type='联想')  {  
        parent::__construct($type);  
    }  
	function prepareScreen(){
		echo "联想屏幕准备完毕<br>";
	}
	function prepareMainboard(){
		echo "联想主板准备完毕<br>";
	}
	function prepareCPU(){
		echo "联想CPU准备完毕<br>";
	}
	function prepareMemoryBank(){
		echo "联想内存条准备完毕<br>";
	}
}

class makeAsusComputer extends makeComputer{
	function __construct($type='华硕')  {  
        parent::__construct($type);  
    }  
	function prepareScreen(){
		echo "华硕屏幕准备完毕<br>";
	}
	function prepareMainboard(){
		echo "华硕主板准备完毕<br>";
	}
	function prepareCPU(){
		echo "华硕CPU准备完毕<br>";
	}
	function prepareMemoryBank(){
		echo "华硕内存条准备完毕<br>";
	}
}

//测试
$lenovoComputer = new makeLenovoComputer();
$lenovoComputer->procedure();
 ?>