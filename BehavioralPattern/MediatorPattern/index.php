<?php 
/*

中介者模式：
	中介者模式(Mediator Pattern)定义：用一个中介对象来封装一系列的对象交互，中介者使各对象不需要显式地相互引用，从而使其耦合松散，而且可以独立地改变它们之间的交互。中介者模式又称为调停者模式，它是一种对象行为型模式。

模式动机：
	1.在用户与用户直接聊天的设计方案中，用户对象之间存在很强的关联性，将导致系统出现如下问题：
	系统结构复杂：对象之间存在大量的相互关联和调用，若有一个对象发生变化，则需要跟踪和该对象关联的其他所有对象，并进行适当处理。
	2.对象可重用性差：由于一个对象和其他对象具有很强的关联，若没有其他对象的支持，一个对象很难被另一个系统或模块重用，这些对象表现出来更像一个不可分割的整体，职责较为混乱。
	3.系统扩展性低：增加一个新的对象需要在原有相关对象上增加引用，增加新的引用关系也需要调整原有对象，系统耦合度很高，对象操作很不灵活，扩展性差。
	4.在面向对象的软件设计与开发过程中，根据“单一职责原则”，我们应该尽量将对象细化，使其只负责或呈现单一的职责。
	5.对于一个模块，可能由很多对象构成，而且这些对象之间可能存在相互的引用，为了减少对象两两之间复杂的引用关系，使之成为一个松耦合的系统，我们需要使用中介者模式，这就是中介者模式的模式动机。

中介者模式包含如下角色：
	Mediator: 抽象中介者，在里面定义了各个同事之间相互交互所需要的方法。
	ConcreteMediator: 具体中介者，它需要了解并为维护每个同事对象，并负责具体的协调各个同事对象的交互关系。
	Colleague:抽象同事类，通常实现成为抽象类，主要负责约束同事对象的类型，并实现一些具体同事类之间的公共功能
	ConcreteColleague:具体同事类，实现自己的业务，需要与其他同事对象交互，就通知中介对象，中介对象会负责后续的交互
*/
//代码实现

header("Content-type:text/html;Charset=utf-8");
//抽象同事类，家教
abstract class Tutor{
	protected $message;   //个人信息
	protected $mediator;  //为家教服务的中介机构
	function __construct($message,Mediator $mediator){
		$this->message = $message;
		$this->mediator = $mediator;
	}
	//获取个人信息
	function getMessage(){
		return $this->message;
	}
	//找学生
	abstract function findStudent();
}
//具体同事类,大学生家教
class UndergraduateTutor extends Tutor{
   //家教类型
   public $type = "UndergraduateTutor";

   function __construct($message,Mediator $mediator){
   	   parent::__construct($message,$mediator);
   }
   //找学生,让中介机构代为寻找
   function findStudent(){
   	  $this->mediator->matchStudent($this);
   }
}
//具体同事类,高中生家教
class SeniorStudentTutor extends Tutor{
	//家教类型
   public $type = "SeniorStudentTutor";
   
   function __construct($message,Mediator $mediator){
   	   parent::__construct($message,$mediator);
   }
   //找学生,让中介机构代为寻找
   function findStudent(){
   	  $this->mediator->matchStudent($this);
   }
}
//具体同事类,初中生家教
class MiddleStudentTutor extends Tutor{
	//家教类型
   public $type = "MiddleStudentTutor";
   
   function __construct($message,Mediator $mediator){
   	   parent::__construct($message,$mediator);
   }
   //找学生,让中介机构代为寻找
   function findStudent(){
   	  $this->mediator->matchStudent($this);
   }
}

//抽象中介类
abstract class AbstractMediator{
	abstract function matchStudent(Tutor $tutor);
}
//具体中介类，为家教匹配合适的学生
class Mediator extends AbstractMediator{
	//定义其服务的所有家教，不在范围内的不服务
	private $serveObject = array("UndergraduateTutor","SeniorStudentTutor","MiddleStudentTutor");
	//匹配学生  
    function matchStudent(Tutor $tutor){
         for($i=0;$i<count($this->serveObject);$i++){
         	 if($tutor->type == $this->serveObject[$i]){
                  $message = $tutor->getMessage();
                  echo "该家教个人信息为".print_r($message)."<br/>,将为其匹配合适的学生";
                  break;
         	 }
         }
         if($i>=count($this->serveObject)){
         	echo "该家教不在我中介机构服务范围内";
         }
    }
}

//测试
$mediator = new Mediator();
$undergraduateTutor = new UndergraduateTutor(array("name"=>"张三","age"=>22),$mediator);
$undergraduateTutor->findStudent();
//该家教个人信息为 Array ( [name] => 张三 [age] => 22 ),将为其匹配合适的学生
 ?>
