<?php
/*
桥接模式(Bridge Pattern)：
	将抽象部分与它的实现部分分离，使它们都可以独立地变化。它是一种对象结构型模式，又称为柄体(Handle and Body)模式或接口(Interface)模式。 

桥接模式包含如下角色：	
	Abstraction：抽象类
	RefinedAbstraction：扩充抽象类
	Implementor：实现类接口
	ConcreteImplementor：具体实现类

理解桥接模式，重点需要理解如何将抽象化(Abstraction)与实现化(Implementation)脱耦，使得二者可以独立地变化。
抽象化：抽象化就是忽略一些信息，把不同的实体当作同样的实体对待。在面向对象中，将对象的共同性质抽取出来形成类的过程即为抽象化的过程。
实现化：针对抽象化给出的具体实现，就是实现化，抽象化与实现化是一对互逆的概念，实现化产生的对象比抽象化更具体，是对抽象化事物的进一步具体化的产物。
脱耦：脱耦就是将抽象化和实现化之间的耦合解脱开，或者说是将它们之间的强关联改换成弱关联，将两个角色之间的继承关系改为关联关系。桥接模式中的所谓脱耦，就是指在一个软件系统的抽象化和实现化之间使用关联关系（组合或者聚合关系）而不是继承关系，从而使两者可以相对独立地变化，这就是桥接模式的用意。

优点：
	分离抽象接口及其实现部分。
	桥接模式有时类似于多继承方案，但是多继承方案违背了类的单一职责原则（即一个类只有一个变化的原因），复用性比较差，而且多继承结构中类的个数非常庞大，桥接模式是比多继承方案更好的解决方法。
	桥接模式提高了系统的可扩充性，在两个变化维度中任意扩展一个维度，都不需要修改原有系统。
	实现细节对客户透明，可以对用户隐藏实现细节。
缺点：
	桥接模式的引入会增加系统的理解与设计难度，由于聚合关联关系建立在抽象层，要求开发者针对抽象进
行设计与编程。 - 桥接模式要求正确识别出系统中两个独立变化的维度，因此其使用范围具有一定的局限性。

适用环境：
	如果一个系统需要在构件的抽象化角色和具体化角色之间增加更多的灵活性，避免在两个层次之间建立静态的继承联系，通过桥接模式可以使它们在抽象层建立一个关联关系。
	抽象化角色和实现化角色可以以继承的方式独立扩展而互不影响，在程序运行时可以动态将一个抽象化子类的对象和一个实现化子类的对象进行组合，即系统需要对抽象化角色和实现化角色进行动态耦合。
	一个类存在两个独立变化的维度，且这两个维度都需要进行扩展。
	虽然在系统中使用继承是没有问题的，但是由于抽象化角色和具体化角色需要独立变化，设计要求需要独立管理这两者。
	对于那些不希望使用继承或因为多层次继承导致系统类的个数急剧增加的系统，桥接模式尤为适用。
*/

//代码实现
header("Content-type:text/html;Charset=utf-8");

//抽象化角色，抽象化给出的定义，并保存一个对实现化对象的引用。
abstract class Abstraction {
    /* 对实现化对象的引用 */
    protected $imp;
    //其操作方法
    public function operation() {
        $this->imp->operationImp();
    }
}
//修正抽象化角色，扩展抽象化角色，改变和修正父类对抽象化的定义。
class RefinedAbstraction extends Abstraction {
     public function __construct(Implementor $imp) {
        $this->imp = $imp;
    } 
   //操作方法在修正抽象化角色中的实现
    public function operation() {
        echo 'RefinedAbstraction operation  ';
        $this->imp->operationImp();
    }
}
 //实现化角色，给出实现化角色的接口，但不给出具体的实现。
abstract class Implementor {
    //操作方法的实现化声明
    abstract public function operationImp();
}
 
//具体化角色A，给出实现化角色接口的具体实现
class ConcreteImplementorA extends Implementor {
    //操作方法的实现化实现
    public function operationImp() {
        echo 'Concrete implementor A operation <br />';
    }
}
 //具体化角色B  给出实现化角色接口的具体实现
class ConcreteImplementorB extends Implementor {
    //操作方法的实现化实现
    public function operationImp() {
        echo 'Concrete implementor B operation <br />';
    }
}

/*    具体实例  */
//抽象类,定义操作系统
abstract class OperationSystem{
     public $musicParren; 
     function playMpeg(){
     	   $this->musicParren->playMpeg();
     }
     function playWmv(){
     	   $this->musicParren->playWmv();
     }
     function playAvi(){
     	   $this->musicParren->playAvi();
     }
}

//扩展抽象类，定义Linux的播放模式
class linux extends OperationSystem{
	 function __construct(MusicParren $musicParren){
	 	 $this->musicParren = $musicParren;
	 }
}
//扩展抽象类，定义Linux的播放模式
class Windows extends OperationSystem{
	 function __construct(MusicParren $musicParren){
	 	 $this->musicParren = $musicParren;
	 }
}
//扩展抽象类，定义Unix的播放模式
class Unix extends OperationSystem{
	 function __construct(MusicParren $musicParren){
	 	 $this->musicParren = $musicParren;
	 }
}

//实现类接口
abstract class MusicParrenInterface{
    abstract function playMpeg();
    abstract function playWmv();
    abstract function playAvi();
}
//具体实现类
class MusicParren extends MusicParrenInterface{
	function playMpeg(){
		echo "播放Mpeg格式的视频";
	}
	function playWmv(){
		echo "播放Wmv格式的视频";
	}
	function playAvi(){
		echo "播放Avi格式的视频";
	}

}



$operationSystem = new Windows(new MusicParren());
$operationSystem->playMpeg();
$operationSystem->playAvi();
//播放Mpeg格式的视频 播放Avi格式的视频
 ?>