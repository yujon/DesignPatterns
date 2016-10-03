<?php
/*
工厂方法模式：
一个抽象产品类，可以派生出多个具体产品类。 
一个抽象工厂类，可以派生出多个具体工厂类。 
每个具体工厂类只能创建一个具体产品类的实例。
*/
abstract class Fruit{
    
}
class Apple extends Fruit{
	function __construct(){
		echo "Apple";
	}
}

class Banana extends Fruit{
	function __construct(){
		echo "Banana";
	}
}

interface Factory{
	function createFruit();
}

class AppleFactory implements Factory{
	 function createFruit(){
	 	return new Apple();
	 }
}
class BananaFactory implements Factory{
	 function createFruit(){
	 	return new Banana();
	 }
}