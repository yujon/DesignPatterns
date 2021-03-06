<?php
/*
外观模式(Facade Pattern)：外部与一个子系统的通信必须通过一个统一的外观对象进行，为子系统中的一组接口提供一个一致的界面，外观模式定义了一个高层接口，这个接口使得这一子系统更加容易使用。外观模式又称为门面模式，它是一种对象结构型模式。

目的：
	1、为一个复杂子系统提供简单的接口
	2、减少客户端和子系统的耦合

外观模式包含如下角色：
	Facade: 外观角色
	SubSystem:子系统角色

模式分析:
	 根据“单一职责原则”，在软件中将一个系统划分为若干个子系统有利于降低整个系统的复杂性，一个常见的设计目标是使子系统间的通信和相互依赖关系达到最小，而达到该目标的途径之一就是引入一个外观对象，它为子系统的访问提供了一个简单而单一的入口
	外观模式也是“迪米特法则”的体现，通过引入一个新的外观类可以降低原有系统的复杂度，同时降低客户类与子系统类的耦合度。 
	外观模式要求一个子系统的外部与其内部的通信通过一个统一的外观对象进行，外观类将客户端与子系统的内部复杂性分隔开，使得客户端只需要与外观对象打交道，而不需要与子系统内部的很多对象打交道。 
	外观模式的目的在于降低系统的复杂程度。
	外观模式从很大程度上提高了客户端使用的便捷性，使得客户端无须关心子系统的工作细节，通过外观角色即可调用相关功能。

优点：
	对客户屏蔽子系统组件，减少了客户处理的对象数目并使得子系统使用起来更加容易。通过引入外观模式，客户代码将变得很简单，与之关联的对象也很少。
	实现了子系统与客户之间的松耦合关系，这使得子系统的组件变化不会影响到调用它的客户类，只需要调整外观类即可。
	降低了大型软件系统中的编译依赖性，并简化了系统在不同平台之间的移植过程，因为编译一个子系统一般不需要编译所有其他的子系统。一个子系统的修改对其他子系统没有任何影响，而且子系统内部变化也不会影响到外观对象。
	只是提供了一个访问子系统的统一入口，并不影响用户直接使用子系统类

缺点
	不能很好地限制客户使用子系统类，如果对客户访问子系统类做太多的限制则减少了可变性和灵活性。
	在不引入抽象外观类的情况下，增加新的子系统可能需要修改外观类或客户端的源代码，违背了“开闭原则”。

适用环境：
	当要为一个复杂子系统提供一个简单接口时可以使用外观模式。该接口可以满足大多数用户的需求，而且用户也可以越过外观类直接访问子系统。
	客户程序与多个子系统之间存在很大的依赖性。引入外观类将子系统与客户以及其他子系统解耦，可以提高子系统的独立性和可移植性。
	在层次化结构中，可以使用外观模式定义系统中每一层的入口，层与层之间不直接产生联系，而通过外观类建立联系，降低层之间的耦合度。
*/

//代码实现:
header("Content-type:text/html;Charset=utf-8");

//子系统角色
class SubSystemOne{
   function mothedOne(){
       echo "方法一<br>";
   }
}
class SubSystemTwo{
   function mothedTwo(){
       echo "方法二<br>";
   }
}
class SubSystemThree{
   function mothedThree(){
       echo "方法三<br>";
   }
}

//外观角色
class Facade{
    private $subSystemOne = null;
    private $subSystemTwo = null;
    private $subSystemThree =null;

    function __construct(){
    	$this->subSystemOne =new SubSystemOne();
        $this->subSystemTwo =new SubSystemTwo();
        $this->subSystemThree =new SubSystemThree();
    }

    function mothedA(){
    	$this->subSystemOne->mothedOne();
    }
    function mothedB(){
    	$this->subSystemTwo->mothedTwo();
    }
    function mothedC(){
    	$this->subSystemThree->mothedThree();
    }
    function mothedD(){
    	$this->subSystemOne->mothedOne();
    	$this->subSystemTwo->mothedTwo();
    	$this->subSystemThree->mothedThree();
    }
}

//测试
$facade = new Facade();
$facade->mothedA();
$facade->mothedB();
$facade->mothedC();
$facade->mothedD();
/*
方法一
方法二
方法三
方法一
方法二
方法三
*/

?>