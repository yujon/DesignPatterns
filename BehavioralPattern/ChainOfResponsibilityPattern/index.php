<?php 

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
