<?php 
// 命令模式：
// 	命令模式(Command Pattern)：将一个请求封装为一个对象，从而使我们可用不同的请求对客户进行参数化；对请求排队或者记录请求日志，以及支持可撤销的操作。命令模式是一种对象行为型模式，其别名为动作(Action)模式或事务(Transaction)模式。

// 命令模式包含如下角色：
// 	Command: 抽象命令类
// 	ConcreteCommand: 具体命令类
// 	Invoker: 调用者
// 	Receiver: 接收者
// 	Client:客户类

// 模式动机：
// 	在软件设计中，我们经常需要向某些对象发送请求，但是并不知道请求的接收者是谁，也不知道被请求的操作是哪个，我们只需在程序运行时指定具体的请求接收者即可，此时，可以使用命令模式来进行设计，使得请求发送者与请求接收者消除彼此之间的耦合，让对象之间的调用关系更加灵活。
// 	命令模式可以对发送者和接收者完全解耦，发送者与接收者之间没有直接引用关系，发送请求的对象只需要知道如何发送请求，而不必知道如何完成请求。这就是命令模式的模式动机。

// 模式分析：
// 命令模式的本质是对命令进行封装，将发出命令的责任和执行命令的责任分割开。
// 每一个命令都是一个操作：请求的一方发出请求，要求执行一个操作；接收的一方收到请求，并执行操作。
// 命令模式允许请求的一方和接收的一方独立开来，使得请求的一方不必知道接收请求的一方的接口，更不必知道请求是怎么被接收，以及操作是否被执行、何时被执行，以及是怎么被执行的。
// 命令模式使请求本身成为一个对象，这个对象和其他对象一样可以被存储和传递。
// 命令模式的关键在于引入了抽象命令接口，且发送者针对抽象命令接口编程，只有实现了抽象命令接口的具体命令才能与接收者相关联。

// 适用性：
// 抽象出待执行的动作以参数化某对象，你可用过程语言中的回调（call back）函数表达这种参数化机制。所谓回调函数是指函数先在某处注册，而它将在稍后某个需要的时候被调用。Command 模式是回调机制的一个面向对象的替代品。
// 在不同的时刻指定、排列和执行请求。一个Command对象可以有一个与初始请求无关的生存期。如果一个请求的接收者可用一种与地址空间无关的方式表达，那么就可将负责该请求的命令对象传送给另一个不同的进程并在那儿实现该请求。
// 支持取消操作。Command的Excute 操作可在实施操作前将状态存储起来，在取消操作时这个状态用来消除该操作的影响。Command 接口必须添加一个Unexecute操作，该操作取消上一次Execute调用的效果。执行的命令被存储在一个历史列表中。可通过向后和向前遍历这一列表并分别调用Unexecute和Execute来实现重数不限的“取消”和“重做”。
// 支持修改日志，这样当系统崩溃时，这些修改可以被重做一遍。在Command接口中添加装载操作和存储操作，可以用来保持变动的一个一致的修改日志。从崩溃中恢复的过程包括从磁盘中重新读入记录下来的命令并用Execute操作重新执行它们。
// 用构建在原语操作上的高层操作构造一个系统。这样一种结构在支持事务( transaction)的信息系统中很常见。一个事务封装了对数据的一组变动。Command模式提供了对事务进行建模的方法。Command有一个公共的接口，使得你可以用同一种方式调用所有的事务。同时使用该模式也易于添加新事务以扩展系统。

//代码实现：
header("Content-type:text/html;Charset=utf-8");
//命令接口，定义具体命令接口要实现的执行函数
interface Command{
	function execute();
}
//具体命令角色AttackCommand,指定接受者执行攻击命令
class AttackCommand implements Command{
	private $receiver;
	function __construct(Receiver $receiver){
		$this->receiver = $receiver;
	}
	function execute(){
		$this->receiver->attackAction();
	}
}
//具体命令角色DefenseCommand,指定接受者执行防御命令
class DefenseCommand implements Command{
	private $receiver;
	function __construct(Receiver $receiver){
		$this->receiver = $receiver;
	}
	function execute(){
		$this->receiver->defenseAction();
	}
}
//接受者，执行具体命令角色的命令
class Receiver{
	private $name;
	function __construct($name){
		$this->name = $name;
	}
	function attackAction(){
		echo $this->name."执行了攻击命令";
	}
	function defenseAction(){
		echo $this->name."执行了防御命令";
	}
}
//请求者，请求具体命令的执行
class Invoker{
	private $concreteCommand;
	function __construct($concreteCommand){
		$this->concreteCommand = $concreteCommand;
	}
	function executeCommand(){
		$this->concreteCommand->execute();
	}
}

//客户端角色
class Client{
	function __construct(){
		$receiverZhao = new Receiver("赵日天");
		$attackCommand = new AttackCommand($receiverZhao);
		$attackInvoker = new Invoker($attackCommand);
	    $attackInvoker->executeCommand();

	    $receiverYe = new Receiver("叶良辰");
		$defenseCommand = new DefenseCommand($receiverYe);
		$defenseInvoker = new Invoker($defenseCommand);
		$defenseInvoker->executeCommand();
	}
}

//测试：
new Client();

 ?>