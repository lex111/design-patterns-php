<?php

namespace RefactoringGuru\Visitor\Structural;

/**
 * EN: Visitor Design Pattern
 *
 * Intent: Represent an operation to be performed over elements of an object
 * structure. The Visitor pattern lets you define a new operation without
 * changing the classes of the elements on which it operates.
 *
 * RU: Паттерн Посетитель
 *
 * Назначение: Позволяет добавлять в программу новые операции, не изменяя классы
 * объектов, над которыми эти операции могут выполняться.
 */

/**
 * EN: The Component interface declares an `accept` method that should take the
 * base visitor interface as an argument.
 *
 * RU: Интерфейс Компонента объявляет метод принятия, который в качестве
 * аргумента может получать любой объект, реализующий интерфейс посетителя.
 */
interface Component
{
    function accept(Visitor $visitor);
}

/**
 * EN: Each Concrete Component must implement the `accept` method in such a way
 * that it calls the visitor's method corresponding to the component's class.
 *
 * RU: Каждый Конкретный Компонент должен реализовать метод принятия таким
 * образом, чтобы он вызывал метод посетителя, соотвествующий классу компонента.
 */
class ConcreteComponentA implements Component
{
    /**
     * EN: Note that we're calling `visitConcreteComponentA`, which matches the
     * current class name. This way we let the visitor know the class of the
     * component it works with.
     *
     * RU: Обратите внимание, мы вызываем visitConcreteComponentA, что
     * соответствует названию текущего класса. Таким образом мы позволяем
     * посетителю узнать, с каким классом компонента он работает.
     */
    function accept(Visitor $visitor)
    {
        $visitor->visitConcreteComponentA($this);
    }

    /**
     * EN: Concrete Components may have special methods that don't exist in
     * their base class or interface. The Visitor is still able to use these
     * methods since it's aware of the component's concrete class.
     *
     * RU: Конкретные Компоненты могут иметь особые методы, не объявленные в их
     * базовом классе или интерфейсе. Посетитель всё же может использовать эти
     * методы, поскольку он знает о конкретном классе компонента.
     */
    function exclusiveMethodOfConcreteComponentA()
    {
        return "A";
    }
}

class ConcreteComponentB implements Component
{
    /**
     * EN: Same here: visitConcreteComponentB => ConcreteComponentB
     *
     * RU: То же самое здесь: visitConcreteComponentB => ConcreteComponentB
     */
    function accept(Visitor $visitor)
    {
        $visitor->visitConcreteComponentB($this);
    }

    function specialMethodOfConcreteComponentB()
    {
        return "B";
    }
}

/**
 * EN: The Visitor Interface declares a set of visiting methods that correspond
 * to component classes. The signature of a visiting method allows the visitor
 * to identify the exact class of the component that it's dealing with.
 *
 * RU: Интерфейс Посетителя объявляет набор методов посещения, соответствующих
 * классам компонентов. Сигнатура метода посещения позволяет посетителю
 * определить конкретный класс компонента, с которым он имеет дело.
 */
interface Visitor
{
    public function visitConcreteComponentA(ConcreteComponentA $element);

    public function visitConcreteComponentB(ConcreteComponentB $element);
}

/**
 * EN: Concrete Visitors implement several versions of the same algorithm, which
 * can work with all concrete component classes.
 *
 * You can experience the biggest benefit of the Visitor pattern when using it
 * with a complex object structure, such as a Composite tree. In this case, it
 * might be helpful to store some intermediate state of the algorithm while
 * executing visitor's methods over various objects of the structure.
 *
 * RU: Конкретные Посетители реализуют несколько версий одного и того же
 * алгоритма, которые могут работать со всеми классами конкретных компонентов.
 *
 * Максимальную выгоду от паттерна Посетитель вы почувствуете, используя его со
 * сложной структурой объектов, такой как дерево Компоновщика. В этом случае
 * было бы полезно хранить некоторое промежуточное состояние алгоритма при
 * выполнении методов посетителя над различными объектами структуры.
 */
class ConcreteVisitor1 implements Visitor
{
    public function visitConcreteComponentA(ConcreteComponentA $element)
    {
        print($element->exclusiveMethodOfConcreteComponentA()." + ConcreteVisitor1\n");
    }

    public function visitConcreteComponentB(ConcreteComponentB $element)
    {
        print($element->specialMethodOfConcreteComponentB()." + ConcreteVisitor1\n");
    }
}

class ConcreteVisitor2 implements Visitor
{
    public function visitConcreteComponentA(ConcreteComponentA $element)
    {
        print($element->exclusiveMethodOfConcreteComponentA()." + ConcreteVisitor2\n");
    }

    public function visitConcreteComponentB(ConcreteComponentB $element)
    {
        print($element->specialMethodOfConcreteComponentB()." + ConcreteVisitor2\n");
    }
}

/**
 * EN: The client code can run visitor operations over any set of elements
 * without figuring out their concrete classes. The accept operation directs a
 * call to the appropriate operation in the visitor object.
 *
 * RU: Клиентский код может выполнять операции посетителя над любым набором
 * элементов, не выясняя их конкретных классов. Операция принятия направляет
 * вызов к соответствующей операции в объекте посетителя.
 */
function clientCode(array $components, Visitor $visitor)
{
    // ...
    foreach ($components as $component) {
        $component->accept($visitor);
    }
    // ...
}

$components = [
    new ConcreteComponentA(),
    new ConcreteComponentB(),
];

print("The client code works with all visitors via the base Visitor interface:\n");
$visitor1 = new ConcreteVisitor1();
clientCode($components, $visitor1);
print("\n");

print("It allows the same client code to work with different types of visitors:\n");
$visitor2 = new ConcreteVisitor2();
clientCode($components, $visitor2);
