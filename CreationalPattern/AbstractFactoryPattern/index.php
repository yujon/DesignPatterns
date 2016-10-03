<?php
/*
抽象工厂模式：
多个抽象产品类，每个抽象产品类可以派生出多个具体产品类。 
一个抽象工厂类，可以派生出多个具体工厂类。 
每个具体工厂类可以创建多个具体产品类的实例。 
区别：
工厂方法模式只有一个抽象产品类，而抽象工厂模式有多个。 
工厂方法模式的具体工厂类只能创建一个具体产品类的实例，而抽象工厂模式可以创建多个
*/
header("Content-type:text/html;Charset=utf-8");
abstract class Fruit{
    abstract function eat();
}
class Apple extends Fruit{
	function eat(){
		echo "Apple";
	}
}
class Banana extends Fruit{
	function eat(){
		echo "Banana";
	}
}

abstract class vegetables{
    abstract function eat();
}
class tomato extends vegetables{
     function eat(){
     	echo "toamto";
     }
}
class potato extends vegetables{
	function eat(){
		echo "potato";
	}
}

//不同子类工厂分别创建不同的类
interface Factory{
	function createFruit();
	function createVegetables();
}

class ManFactory implements Factory{
	 function createFruit(){
	 	return new Apple();
	 }
	 function createveges(){
	 	return new tomato();
	 }
}
class WomanFactory implements Factory{
	 function createFruit(){
	 	return new Banana();
	 }
	 function createveges(){
	 	return new tomato();
	 }
}