<?php

// Інтерфейс спостерігача
interface Observer {
    public function update($data);
}

// Конкретний спостерігач
class ConcreteObserver implements Observer {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function update($data) {
        echo "Observer $this->name received update: $data<br>";
    }
}

// Інтерфейс суб'єкта (об'єкта, який спостерігається)
interface Subject {
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify($data);
}

// Конкретний суб'єкт
class ConcreteSubject implements Subject {
    private $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $index = array_search($observer, $this->observers);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    public function notify($data) {
        foreach ($this->observers as $observer) {
            $observer->update($data);
        }
    }
}

// Використання паттерна Спостерігач
$subject = new ConcreteSubject();

$observerA = new ConcreteObserver("A");
$observerB = new ConcreteObserver("B");

$subject->attach($observerA);
$subject->attach($observerB);

$subject->notify("Data 1");
// Output:
// Observer A received update: Data 1
// Observer B received update: Data 1

$subject->detach($observerA);

$subject->notify("Data 2");
// Output:
// Observer B received update: Data 2
