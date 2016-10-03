<?php
/* 
享元模式：
	享元模式(Flyweight Pattern)：运用共享技术有效地支持大量细粒度对象的复用。系统只使用少量的对象，而这些对象都很相似，状态变化很小，可以实现对象的多次复用。由于享元模式要求能够共享的对象必须是细粒度对象，因此它又称为轻量级模式，它是一种对象结构型模式。

模式动机：
	面向对象技术可以很好地解决一些灵活性或可扩展性问题，但在很多情况下需要在系统中增加类和对象的个数。当对象数量太多时，将导致运行代价过高，带来性能下降等问题。
	享元模式正是为解决这一类问题而诞生的。享元模式通过共享技术实现相同或相似对象的重用。
在享元模式中可以共享的相同内容称为内部状态(IntrinsicState)，而那些需要外部环境来设置的不能共享的内容称为外部状态(Extrinsic State)，由于区分了内部状态和外部状态，因此可以通过设置不同的外部状态使得相同的对象可以具有一些不同的特征，而相同的内部状态是可以共享的。
	在享元模式中通常会出现工厂模式，需要创建一个享元工厂来负责维护一个享元池(Flyweight Pool)用于存储具有相同内部状态的享元对象。
	在享元模式中共享的是享元对象的内部状态，外部状态需要通过环境来设置。在实际使用中，能够共享的内部状态是有限的，因此享元对象一般都设计为较小的对象，它所包含的内部状态较少，这种对象也称为细粒度对象。享元模式的目的就是使用共享技术来实现大量细粒度对象的复用。

主要角色：
	抽象享元(Flyweight)角色：此角色是所有的具体享元类的超类，为这些类规定出需要实现的公共接口。那些需要外蕴状态的操作可以通过调用商业以参数形式传入
	具体享元(ConcreteFlyweight)角色：实现Flyweight接口，并为内部状态（如果有的话）拉回存储空间。ConcreteFlyweight对象必须是可共享的。它所存储的状态必须是内部的
	不共享的具体享元（UnsharedConcreteFlyweight）角色：并非所有的Flyweight子类都需要被共享。Flyweigth使共享成为可能，但它并不强制共享。
	享元工厂(FlyweightFactory)角色：负责创建和管理享元角色。本角色必须保证享元对象可能被系统适当地共享
	客户端(Client)角色：本角色需要维护一个对所有享元对象的引用。本角色需要自行存储所有享元对象的外部状态

模式分析：
	享元模式是一个考虑系统性能的设计模式，通过使用享元模式可以节约内存空间，提高系统的性能。
	享元模式的核心在于享元工厂类，享元工厂类的作用在于提供一个用于存储享元对象的享元池，用户需要对象时，首先从享元池中获取，如果享元池中不存在，则创建一个新的享元对象返回给用户，并在享元池中保存该新增对象。
	享元模式以共享的方式高效地支持大量的细粒度对象，享元对象能做到共享的关键是区分内部状态(Internal State)和外部状态(External State)。
	内部状态是存储在享元对象内部并且不会随环境改变而改变的状态，因此内部状态可以共享。
	外部状态是随环境改变而改变的、不可以共享的状态。享元对象的外部状态必须由客户端保存，并在享元对象被创建之后，在需要使用的时候再传入到享元对象内部。一个外部状态与另一个外部状态之间是相互独立的。

优点
	享元模式的优点在于它可以极大减少内存中对象的数量，使得相同对象或相似对象在内存中只保存一份。
	享元模式的外部状态相对独立，而且不会影响其内部状态，从而使得享元对象可以在不同的环境中被共享。

缺点
	享元模式使得系统更加复杂，需要分离出内部状态和外部状态，这使得程序的逻辑复杂化。
	为了使对象可以共享，享元模式需要将享元对象的状态外部化，而读取外部状态使得运行时间变长。

在以下情况下可以使用享元模式：
	一个系统有大量相同或者相似的对象，由于这类对象的大量使用，造成内存的大量耗费。
	对象的大部分状态都可以外部化，可以将这些外部状态传入对象中。
	使用享元模式需要维护一个存储享元对象的享元池，而这需要耗费资源，因此，应当在多次重复使用享元对象时才值得使用享元模式。

单纯享元模式和复合享元模式
	单纯享元模式：在单纯享元模式中，所有的享元对象都是可以共享的，即所有抽象享元类的子类都可共享，不存在非共享具体享元类
	复合享元模式：将一些单纯享元使用组合模式加以组合，可以形成复合享元对象，这样的复合享元对象本身不能共享，但是它们可以分解成单纯享元对象，而后者则可以共享。

享元模式与其他模式的联用
	在享元模式的享元工厂类中通常提供一个静态的工厂方法用于返回享元对象，使用简单工厂模式来生成享元对象。
	在一个系统中，通常只有唯一一个享元工厂，因此享元工厂类可以使用单例模式进行设计。
	享元模式可以结合组合模式形成复合享元模式，统一对享元对象设置外部状态。
*/

//代码实现：
header("Content-type:text/html;Charset=utf-8");

//抽象享元角色
interface Flyweight{
     function show();
}
//共享的具体享元角色
class ConcreteFlyweight implements Flyweight{
	private $state;
	function __construct($state){
        $this->state = $state;
	}
	function show(){
		return $this->state;
	}
}
//不共享的具体享元角色，客户端直接调用
class UnsharedConcreteFlyweight implements Flyweight{
	private $state;
	function __construct($state){
        $this->state = $state;
	}
	function show(){
		return $this->state;
	}
}
//享元工厂模式
class FlyweightFactory{
	private $flyweights = array();
	function getFlyweight($state){
		if(!isset($this->flyweights[$state])){
            $this->flyweights[$state]=new ConcreteFlyweight($state);
		}
		return $this->flyweights[$state];
	}
}

//测试
$flyweightFactory = new FlyweightFactory();
$flyweightOne = $flyweightFactory->getFlyweight("state A");
echo $flyweightOne->show();
$flyweightTwo = new UnsharedConcreteFlyweight("state B");
echo $flyweightTwo->show();
/*
state A
state B
*/
 ?>