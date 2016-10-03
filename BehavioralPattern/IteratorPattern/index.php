<?php  
/*
迭代器模式：
	迭代器模式是遍历集合的成熟模式，迭代器模式的关键是将遍历集合的任务交给一个叫做迭代器的对象，它的工作时遍历并选择序列中的对象，而客户端程序员不必知道或关心该集合序列底层的结构。

角色：      
    Iterator（迭代器）：迭代器定义访问和遍历元素的接口
    ConcreteIterator（具体迭代器）：具体迭代器实现迭代器接口，对该聚合遍历时跟踪当前位置
    Aggregate （聚合）：聚合定义创建相应迭代器对象的接口(可选)
    ConcreteAggregate（具体聚合）：具体聚合实现创建相应迭代器的接口，该操作返回ConcreteIterator的一个适当的实例(可选)

适用性：
	访问一个聚合对象的内容而无需暴露它的内部表示。
	支持对聚合对象的多种遍历。
	为遍历不同的聚合结构提供一个统一的接口(即, 支持多态迭代)。
*/

//代码实现：
header("Content-type:text/html;Charset=utf-8");
//迭代器接口,注意不要使用Iterator命名，其为内置接口
abstract class IIterator{
	 abstract function firstValue();  //获取聚合中第一个元素
	 abstract function nextValue();   //获取聚合中下一个元素
	 abstract function currentValue();  //获取聚合中当前元素
	 abstract function isFinished();   //判断该聚合是否已被遍历完
}
//具体迭代器
class ConcreteIterator extends IIterator{
    private $aggr;  //具体聚合元素
    private $currentKey = 0; 
    function __construct($aggr){
    	$this->aggr = $aggr;
    }
    //获取第一个元素
    function firstValue(){
    	return $this->aggr[0];
    }
    //获取下一个元素
    function nextValue(){
    	$this->currentKey++;
    	if($this->currentKey<count($this->aggr)){
    		return $this->aggr[$this->currentKey];
    	}
    	return false;
    }
    //获取当前元素
    function currentValue(){
    	return $this->aggr[$this->currentKey];
    }
    //当前聚合是否已经遍历完成
    function isFinished(){
    	return $this->currentKey>=count($this->aggr)?true:false;
    }
}

//测试
$iterator = new ConcreteIterator(array("张三","李四","王五"));
echo $iterator->firstValue();
echo $iterator->nextValue();
echo $iterator->currentValue();
?>