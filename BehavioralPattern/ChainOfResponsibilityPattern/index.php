<?php 
// 职责链模式（又叫责任链模式）:
//  	包含了一些命令对象和一些处理对象，每个处理对象决定它能处理那些命令对象，它也知道应该把自己不能处理的命令对象交下一个处理对象，该模式还描述了往该链添加新的处理对象的方法。

//  角色：          
//    抽象处理者(Manager)：定义出一个处理请求的接口。如果需要，接口可以定义出一个方法，以设定和返回对下家的引用。这个角色通常由一个抽象类或接口实现。
//    具体处理者(CommonManager)：具体处理者接到请求后，可以选择将请求处理掉，或者将请求传给下家。由于具体处理者持有对下家的引用，因此，如果需要，具体处理者可以访问下家。

// 适用场景：          
 //    1、有多个对象可以处理同一个请求，具体哪个对象处理该请求由运行时刻自动确定。
 //    2、在不明确指定接收者的情况下，向多个对象中的一个提交一个请求。
	// 3、可动态指定一组对象处理请求。

// 简单的总结责任链模式,可以归纳为：
// 	用一系列类(classes)试图处理一个请求request,这些类之间是一个松散的耦合,唯一共同点是在他们之间传递request. 也就是说，来了一个请求，A类先处理，如果没有处理，就传递到B类处理，如果没有处理，就传递到C类处理，就这样象一个链条(chain)一样传递下去。

//代码实现
//申请类,
header("Content-type:text/html;Charset=utf-8");
class Request{
	public $name;
	public $requestContent;
	public $num;
	public $reason;
	function __construct($name,$requestContent,$reason,$num){
		$this->name = $name;
		$this->requestContent = $requestContent;
		$this->reason = $reason;
		$this->num = $num;
	}
}

//抽象处理类，定义处理者具有的公共属性和具体处理类需要实现的接口
abstract class AbstractManager{
	protected $name;   //姓名
	protected $position;  //职位
	protected $head;  //上司
	function __construct($name,$position){
		$this->name = $name;
		$this->position = $position;
	}
	 //设置上司
	function setHead(AbstractManager $head){
		$this->head = $head;
	}
	//处理申请
	abstract function handleRequest(Request $request);
}

//具体处理类，经理,可以处理不多于7天的假期和不多于1000元的加薪请求
class Director extends AbstractManager{
	function __construct($name,$position){
		parent::__construct($name,$position);
	}    
    //处理申请
    function handleRequest(Request $request){
         if(($request->requestContent == "请假" && $request->num <7)||($request->requestContent == "加薪" && $request->num <1000) ){
         	 return $request->name."的".$request->requestContent."请求已被".$this->name."批准.";
         }else{  //超过处理权限转给上级总监处理
            if(isset($this->head)){
            	return $this->head->handleRequest($request);
            }
         }
    }
}
//具体处理类，总监,可以处理不多于15天的假期和不多于2000元的加薪请求
class Majordomo extends AbstractManager{
	function __construct($name,$position){
		parent::__construct($name,$position);
	}    
    //处理申请
    function handleRequest(Request $request){
         if(($request->requestContent == "请假" && $request->num <15)||($request->requestContent == "加薪" && $request->num <2000) ){
         	 return $request->name."的".$request->requestContent."请求已被".$this->name."批准.";
         }else{  //超过处理权限转给上级总经理处理
            if(isset($this->head)){
            	return $this->head->handleRequest($request);
            }
         }
    }
}
//具体处理类，总经理,可以处理请假和加薪请求
class GeneralManager extends AbstractManager{
	function __construct($name,$position){
		parent::__construct($name,$position);
	}    
    //处理申请
    function handleRequest(Request $request){
         if(($request->requestContent == "请假" && $request->num < 30)||($request->requestContent == "加薪" && $request->num <5000) ){
         	 return $request->name."的".$request->requestContent."请求已被".$this->name."批准.";
         }else{  //没有上级
            return $request->name."的".$request->requestContent."请求已被".$this->name."否决！";
         }
    }
}

//测试
$generalManagerWang = new GeneralManager("王五","总经理");
$majordomoLi = new Majordomo("李四","总监");
$majordomoLi->setHead($generalManagerWang);
$directZhang = new Director("张三","经理");
$directZhang->setHead($majordomoLi);

$request = new Request("叶良辰","请假","如果你有问题，可以随时找我，良辰就喜欢对自以为是的人出手",100);
$result = $directZhang->handleRequest($request);  //叶良辰的请假请求已被王五否决！
echo $result;
?>