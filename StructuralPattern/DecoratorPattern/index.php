<?php 
/*
装饰模式(Decorator Pattern) ：
    动态地给一个对象增加一些额外的职责(Responsibility)，就增加对象功能来说，装饰模式比生成子类实现更为灵活。其别名也可以称为包装器(Wrapper)，与适配器模式的别名相同，但它们适用于不同的场合。根据翻译的不同，装饰模式也有人称之为“油漆工模式”，它是一种对象结构型模式。


模式动机:
    一般有两种方式可以实现给一个类或对象增加行为：
    继承机制，使用继承机制是给现有类添加功能的一种有效途径，通过继承一个现有类可以使得子类在拥有自身方法的同时还拥有父类的方法。但是这种方法是静态的，用户不能控制增加行为的方式和时机。
    关联机制，即将一个类的对象嵌入另一个对象中，由另一个对象来决定是否调用嵌入对象的行为以便扩展自己的行为，我们称这个嵌入的对象为装饰器(Decorator)
    装饰模式以对客户透明的方式动态地给一个对象附加上更多的责任，换言之，客户端并不会觉得对象在装饰前和装饰后有什么不同。装饰模式可以在不需要创造更多子类的情况下，将对象的功能加以扩展。这就是装饰模式的模式动机。

装饰模式包含如下角色：
    Component: 抽象构件
    ConcreteComponent: 具体构件
    Decorator: 抽象装饰类
    ConcreteDecorator: 具体装饰类

装饰模式的优点:
    装饰模式与继承关系的目的都是要扩展对象的功能，但是装饰模式可以提供比继承更多的灵活性。
    可以通过一种动态的方式来扩展一个对象的功能，通过配置文件可以在运行时选择不同的装饰器，从而实现不同的行为。
    通过使用不同的具体装饰类以及这些装饰类的排列组合，可以创造出很多不同行为的组合。可以使用多个具体装饰类来装饰同一对象，得到功能更为强大的对象。
    具体构件类与具体装饰类可以独立变化，用户可以根据需要增加新的具体构件类和具体装饰类，在使用时再对其进行组合，原有代码无须改变，符合“开闭原则”

装饰模式的缺点:
    使用装饰模式进行系统设计时将产生很多小对象，这些对象的区别在于它们之间相互连接的方式有所不同，而不是它们的类或者属性值有所不同，同时还将产生很多具体装饰类。这些装饰类和小对象的产生将增加系统的复杂度，加大学习与理解的难度。
    这种比继承更加灵活机动的特性，也同时意味着装饰模式比继承更加易于出错，排错也很困难，对于多次装饰的对象，调试时寻找错误可能需要逐级排查，较为烦琐。
*/

//代码实现：
header("Content-type:text/html;Charset=utf-8");

//被装饰者基类
interface Component{
    function operation();
}
//具体被装饰者类
class ConcreteComponent implements Component{
	function operation(){
		echo "加了被装饰者";
	}
}
//装饰者基类
abstract class Decorator implements Component{
    private $component;
    function __construct($component){
    	$this->component = $component;
    }
    //override
    function operation(){
    	$this->component->operation();
    }
}
//具体装饰类A
class ConcreteDecoratorA extends Decorator {
    public function __construct(Component $component) {
        parent::__construct($component);
 
    }
 
    public function operation() {
        parent::operation();
        $this->addedOperationA();   //  新增加的操作
    }
 
    public function addedOperationA() {
        echo "，又加了A个性化装饰<br>";
    }
}
//具体装饰类B
class ConcreteDecoratorB extends Decorator {
    public function __construct(Component $component) {
        parent::__construct($component);
 
    }
 
    public function operation() {
        parent::operation();
        $this->addedOperationB();   //  新增加的操作
    }
 
    public function addedOperationB() {
        echo "，又加了B个性化装饰<br><br>";
    }
}

//测试
$decoratorA = new ConcreteDecoratorA(new ConcreteComponent());
$decoratorA->operation();
$decoratorB = new ConcreteDecoratorB($decoratorA);
$decoratorB->operation();
/*
加了被装饰者，又加了A个性化装饰
加了被装饰者，又加了A个性化装饰
，又加了B个性化装饰
*/

?>