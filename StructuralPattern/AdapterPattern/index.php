<?php
/*
1. 概述
　　将一个类的接口转换成客户希望的另外一个接口。Adapter模式使得原本由于接口不兼容而不能一起工作的那些类可以在一起工作。

2. 解决的问题
　　即Adapter模式使得原本由于接口不兼容而不能一起工作的那些类可以在一起工作。

3. 角色
　　3.1 目标接口（Target）：客户所期待的接口。目标可以是具体的或抽象的类，也可以是接口。
　　3.2 源接口/类（Adaptee）：需要适配的类或适配者类。
　　3.3 适配器（Adapter）：通过包装一个需要适配的对象，把源接口转换成目标接口。　　

4. 模式解读
　　注：在GoF的设计模式中，对适配器模式讲了两种类型，类适配器模式和对象适配器模式。由于类适配器模式通过多重继承对一个接口与另一个接口进行匹配，而C#、java等语言都不支持多重继承，因而这里只是介绍对象适配器。

5 优点
    5.1.1 通过适配器，客户端可以调用同一接口，因而对客户端来说是透明的。这样做更简单、更直接、更紧凑。
　　5.1.2 复用了现存的类，解决了现存类和复用环境要求不一致的问题。
　　5.1.3 将目标类和适配者类解耦，通过引入一个适配器类重用现有的适配者类，而无需修改原有代码。
　　5.1.4 一个对象适配器可以把多个不同的适配者类适配到同一个目标，也就是说，同一个适配器可以把适配者类和它的子类都适配到目标接口。

6 缺点
　对于对象适配器来说，更换适配器的实现过程比较复杂。

7 适用场景
　  7.1系统需要使用现有的类，而这些类的接口不符合系统的接口。
	7.2想要建立一个可以重用的类，用于与一些彼此之间没有太大关联的一些类，包括一些可能在将来引进的类一起工作
　  7.3 两个类所做的事情相同或相似，但是具有不同接口的时候。
	7.4 旧的系统开发的类已经实现了一些功能，但是客户端却只能以另外接口的形式访问，但我们不希望手动更改原有类的时候。
	7.5使用第三方组件，组件接口定义和自己定义的不同，不希望修改自己的接口，但是要使用第三方组件接口的功能。
*/
header("Content-type:text/html;Charset=utf-8");
//目标对象
interface Target{
	function mothed();
}

//源接口
interface Adaptee{
	function mothed();
}
class ConcreteAdaptee implements Adaptee{
	function mothed(){
		echo "源方法";
	}
}


//适配器
class Adapter Implements Target{
	private $adaptee;
	function  __construct(Adaptee $adaptee){
         $this->adaptee = $adaptee;
	}
	//override目标接口的方法执行的却是源接口的方法从实现适配
	function mothed(){
		$this->adaptee->mothed();
	}
}

//测试
$adaptee = new ConcreteAdaptee();
$adapter = new Adapter($adaptee);
$adapter->mothed();




// 实例：实现电源适配器
/* 代码中有两个接口，分别为德标接口和国标接口，分别命名为DBSocketInterface和GBSocketInterface，此外还有两个实现类，分别为德国插座和中国插座，分别为DBSocket和GBSocket。为了提供两套接口之间的适配，我们提供了一个适配器，叫做SocketAdapter。除此之外，还有一个客户端，比如是我们去德国旅游时住的一家宾馆，叫Hotel，在这个德国旅馆中使用德国接口。 
*/
// 德标接口： 
interface DBSocketInterface{	
	//这个方法的名字叫做：使用两项圆头的插口供电
	function powerWithTwoRound();
}

// 德国插座实现德标接口 
class DBSocket implements DBSocketInterface{	
	public function powerWithTwoRound(){
		echo "使用两项圆头的插孔供电";
	}
}

// 德国旅馆是一个客户端，它里面有德标的接口，可以使用这个德标接口给手机充电： 
class Hotel{

	//旅馆中有一个德标的插口
	private $dbSocket;	

	public function __construct(DBSocketInterface $dbSocket) {
		$this->dbSocket = $dbSocket;
	}

	public function setSocket (DBSocketInterface $dbSocket){
		$this->dbSocket = $dbSocket;
	}

	//旅馆中有一个充电的功能
	public function charge(){		
		//使用德标插口充电
		$this->dbSocket->powerWithTwoRound();
	}
}


// 现在写一段代码进行测试： 
class Test {
	public static function main() {		
		//初始化一个德国插座对象， 用一个德标接口引用它
		 $dbSoket = new DBSocket();		
		//创建一个旅馆对象
		$hotel = new Hotel($dbSoket);		
		//在旅馆中给手机充电
		$hotel->charge();
	}
}

// 运行程序，打印出以下结果： 使用两项圆头的插孔供电 


/*现在我去德国旅游，带去的三项扁头的手机充电器。如果没有带电源适配器，我是不能充电的，因为不可能为了我一个旅客而为我更改墙上的插座，更不可能为我专门盖一座使用中国国标插座的宾馆。因为人家德国人一直这么使用，并且用的挺好，俗话说入乡随俗，我就要自己想办法来解决问题。对应到我们的代码中，也就是说，上面的Hotel类，DBSocket类，DBSocketInterface接口都是不可变的（由德国的客户提供），如果我想使用这一套API，那么只能自己写代码解决。 
*/
// 下面是国标接口和中国插座的代码。 
// 国标接口： 
interface GBSocketInterface {
	//这个方法的名字叫做：使用三项扁头的插口供电
	function powerWithThreeFlat();
}

// 中国插座实现国标接口： 
class GBSocket implements GBSocketInterface{	
	public function powerWithThreeFlat() {
		echo "使用三项扁头插孔供电";
	}
}

// 可以认为这两个东西是我带到德国去的，目前他们还不能使用，因为接口不一样。那么我必须创建一个适配器，这个适配器必须满足以下条件： 
// 1 必须符合德国标准的接口，否则的话还是没办法插到德国插座中； 2 在调用上面实现的德标接口进行充电时，提供一种机制，将这个调用转到对国标接口的调用 。 
// 这就要求： 1 适配器必须实现原有的旧的接口 2 适配器对象中持有对新接口的引用，当调用旧接口时，将这个调用委托给实现新接口的对象来处理，也就是在适配器对象中组合一个新接口。 

// 下面给出适配器类的实现： 
class SocketAdapter implements DBSocketInterface{   //实现旧接口
	//组合新接口
	private $gbSocket;
    //在创建适配器对象时，必须传入一个新街口的实现类
	public function SocketAdapter(GBSocketInterface $gbSocket) {
		$this->gbSocket = $gbSocket;
	}
    //将对就接口的调用适配到新接口
	public function powerWithTwoRound() {		
		$this->gbSocket->powerWithThreeFlat();
	}
}

// 这个适配器类满足了上面的两个要求。下面写一段测试代码来验证一下适配器能不能工作，我们按步骤一步步的写出代码，以清楚的说明适配器是如何使用的。 
// 1 我去德国旅游，带去的充电器是国标的（可以将这里的GBSocket看成是充电器） 
$gbSocket = new GBSocket();
// 2 来到德国后， 找到一家德国宾馆住下 (这个宾馆还是上面代码中的宾馆，使用的依然是德国标准的插口) 
$hotel = new Hotel();
// 3 由于没法充电，我拿出随身带去的适配器，并且将我带来的充电器插在适配器的上端插孔中。这个上端插孔是符合国标的，我的充电器完全可以插进去。 
$socketAdapter = new SocketAdapter($gbSocket);
// 4 再将适配器的下端插入宾馆里的插座上 
$hotel->setSocket($socketAdapter);
// 5 可以在宾馆中使用适配器进行充电了 
$hotel->charge();


// 上面的五个步骤就是适配器的使用过程，下面是完整的测试代码。 
class TestAdapter {

	public static function main() {
		$gbSocket = new GBSocket();		
		$hotel = new Hotel();		
		$socketAdapter = new SocketAdapter($gbSocket);		
		$hotel->setSocket($socketAdapter);		
		$hotel->charge();
	}
}

?>