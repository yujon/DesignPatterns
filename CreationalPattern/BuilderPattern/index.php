<?php 
// 建造者模式：
// 将一个复杂对象的构造与它的表示分离，使同样的构建过程可以创建不同的表示的设计模式;
// 目的：
// 消除其他对象复杂的创建过程
// 建造者模式包含如下角色：
// 	  1.产品角色，产品角色定义自身的组成属性
//    2.抽象建造者，抽象建造者定义了产品的创建过程以及如何返回一个产品
//    3.具体建造者，具体建造者实现了抽象建造者创建产品过程的方法，给产品的具体属性进行赋值定义
//    4.指挥者，指挥者负责与调用客户端交互，决定创建什么样的产品
// 优点：
// 		建造者模式可以很好的将一个对象的实现与相关的“业务”逻辑分离开来，从而可以在不改变事件逻辑的前提下,使增加(或改变)实现变得非常容易。
// 缺点：
// 		建造者接口的修改会导致所有执行类的修改。
// 适用场景：
// 1、 需要生成的产品对象有复杂的内部结构。
// 2、 需要生成的产品对象的属性相互依赖，建造者模式可以强迫生成顺序。
// 3、 在对象创建过程中会使用到系统中的一些其它对象，这些对象在产品对象的创建过 程中不易得到。
// 使用建造者模式主要有以下效果：
// 1、 建造者模式的使用使得产品的内部表象可以独立的变化。使用建造者模式可以使客 户端不必知道产品内部组成的细节。
// 2、 每一个Builder都相对独立，而与其它的Builder无关。
// 3、 模式所建造的最终产品更易于控制。

class People{
	public $head;
    public $body;
    
    //不太此类中直接给属性赋值
    function __construct(){

    }
}

//定义具备建造者所需实现的方法
abstract class PeopleBuilder{
	abstract function buildHead();
	abstract function buildBody();
}

//具体建造类实现具体业务
class ChildBuilder extends PeopleBuilder{
	private $people;
	function __construct(){
		$this->people = new people;
	}

	function buildHead(){
       echo "this is a child's head!";
	}
	function buildBody(){
	   echo "this is a child's body!";
	}
	function returnResult(){
       return $this->people;
	}
}

class AdultBuilder extends PeopleBuilder{
	private $people;
	function __construct(){
		$this->people = new people;
	}

	function buildHead(){
       echo "this is a adult's head!";
	}
	function buildBody(){
	   echo "this is a adult's body!";
	}
	function returnResult(){
       return $this->people;
	}
}

//指挥者，指挥者负责与调用客户端交互，决定创建什么样的产品
class Director{
	function __construct(Peoplebuilder $builder){
		$builder->buildHead();
		$builder->buildBody(); 
	}
}


//测试
$builder = new AdultBuilder();  
$director = new Director($builder);  
$person = $builder->returnResult(); 
//this is a adult's head! this is a adult's body!
?>