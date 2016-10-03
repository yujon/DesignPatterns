<?php 
// 解释器模式：
// 给定一个语言, 定义它的文法的一种表示，并定义一个解释器，该解释器使用该表示来解释语言中的句子。

//  角色：  
//        环境角色：定义解释规则的全局信息。
//        抽象解释器:：定义了部分解释具体实现，封装了一些由具体解释器实现的接口。
//        具体解释器(MusicNote)：实现抽象解释器的接口，进行具体的解释执行。
//  核心代码：（注意：需要开启extension=php_mbstring.dll扩展）

// 适用性：
// 当有一个语言需要解释执行, 并且你可将该语言中的句子表示为一个抽象语法树时，可使用解释器模式。而当存在以下情况时该模式效果最好：
// 该文法简单对于复杂的文法, 文法的类层次变得庞大而无法管理。此时语法分析程序生成器这样的工具是更好的选择。它们无需构建抽象语法树即可解释表达式, 这样可以节省空间而且还可能节省时间。
// 效率不是一个关键问题最高效的解释器通常不是通过直接解释语法分析树实现的, 而是首先将它们转换成另一种形式。例如，正则表达式通常被转换成状态机。但即使在这种情况下, 转换器仍可用解释器模式实现, 该模式仍是有用的。

//  代码实现：
header("Content-type:text/html;Charset=utf-8");

//环境角色，定义要解释的全局内容
class Expression{
	public $content;
	function getContent(){
		return $this->content;
	}
}

//抽象解释器
abstract class AbstractInterpreter{
	abstract function interpret($content);
}

//具体解释器,实现抽象解释器的抽象方法
class ChineseInterpreter extends AbstractInterpreter{
	function interpret($content){
		for($i=1;$i<count($content);$i++){
            switch($content[$i]){
			case '0': echo "没有人<br>";break;
			case "1": echo "一个人<br>";break;
			case "2": echo "二个人<br>";break;
			case "3": echo "三个人<br>";break;
			case "4": echo "四个人<br>";break;
			case "5": echo "五个人<br>";break;
			case "6": echo "六个人<br>";break;
            case "7": echo "七个人<br>";break;
			case "8": echo "八个人<br>";break;
			case "9": echo "九个人<br>";break;
			default:echo "其他";
		   }
		}
	}
}
class EnglishInterpreter extends AbstractInterpreter{
	function interpret($content){
		for($i=1;$i<count($content);$i++){
	         switch($content[$i]){
				case '0': echo "This is nobody<br>";break;
				case "1": echo "This is one people<br>";break;
				case "2": echo "This is two people<br>";break;
				case "3": echo "This is three people<br>";break;
				case "4": echo "This is four people<br>";break;
				case "5": echo "This is five people<br>";break;
				case "6": echo "This is six people<br>";break;
	            case "7": echo "This is seven people<br>";break;
				case "8": echo "This is eight people<br>";break;
				case "9": echo "This is nine people<br>";break;
				default:echo "others";
			}
		}
	}
}

//封装好的对具体解释器的调用类,非解释器模式必须的角色
class Interpreter{
	 private $interpreter;
	 private $content;
     function __construct($expression){
        $this->content = $expression->getContent();
        if($this->content[0] == "Chinese"){
	         $this->interpreter = new ChineseInterpreter();
	     }else{
	     	 $this->interpreter = new EnglishInterpreter();
	     }
     }
     function execute(){
     	$this->interpreter->interpret($this->content);
     }
}

//测试
$expression = new Expression();
$expression->content = array("Chinese",3,2,4,4,5);
$interpreter = new Interpreter($expression);
$interpreter->execute();

$expression = new Expression();
$expression->content = array("English",1,2,3,0,0);
$interpreter = new Interpreter($expression);
$interpreter->execute();
/*
三个人
二个人
四个人
四个人
五个人
This is one people
This is two people
This is three people
This is nobody
This is nobody
*/
?>