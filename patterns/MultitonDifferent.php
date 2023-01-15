<?php

namespace Patterns\MultitonDifferent;

/**
 * Интерфейс сложного пула одиночек
 */
abstract class RegistryFactory extends FactoryAbstract
{

    /**
     * Возвращает экземпляр класса, из которого вызван
     *
     * @param integer|string $id - уникальный идентификатор одиночки
     * @return static
     */
    final public static function getInstance($id)
    {
        $className = static::getClassName();
        if (isset(self::$instances[$className])) {
            if (empty(self::$instances[$className][$id])) self::$instances[$className][$id] = null;
            if (!(self::$instances[$className][$id] instanceof $className)) {
                self::$instances[$className][$id] = new $className($id);
            }
        } else {
            self::$instances[$className] = [
                $id => new $className($id),
            ];
        }
        return self::$instances[$className][$id];
    }

    /**
     * Удаляет экземпляр класса, из которого вызван
     *
     * @param integer|string $id - уникальный идентификатор одиночки. Если не указан, все экземпляры класса будут удалены
     * @return void
     */
    final public static function removeInstance($id = null)
    {
        $className = static::getClassName();
        if (isset(self::$instances[$className])) {
            if (is_null($id)) {
                unset(self::$instances[$className]);
            } else {
                if (isset(self::$instances[$className][$id])) {
                    unset(self::$instances[$className][$id]);
                }
                if (empty(self::$instances[$className])) {
                    unset(self::$instances[$className]);
                }
            }
        }
    }

    protected function __construct($id)
    {
    }
}

/*
 * =====================================
 *           USING OF MULTITON
 * =====================================
 */

/**
 * Первый пул одиночек
 */
class FirstFactory extends RegistryFactory
{
    public $a = [];
}

/**
 * Второй пул одиночек
 */
class SecondFactory extends FirstFactory
{
}

// Заполняем свойства одиночек
FirstFactory::getInstance('FirstProduct')->a[] = 1;
FirstFactory::getInstance('SecondProduct')->a[] = 2;
SecondFactory::getInstance('FirstProduct')->a[] = 3;
SecondFactory::getInstance('SecondProduct')->a[] = 4;
FirstFactory::getInstance('FirstProduct')->a[] = 5;
FirstFactory::getInstance('SecondProduct')->a[] = 6;
SecondFactory::getInstance('FirstProduct')->a[] = 7;
SecondFactory::getInstance('SecondProduct')->a[] = 8;

print_r(FirstFactory::getInstance('FirstProduct')->a);
// array(1, 5)
print_r(FirstFactory::getInstance('SecondProduct')->a);
// array(2, 6)
print_r(SecondFactory::getInstance('FirstProduct')->a);
// array(3, 7)
print_r(SecondFactory::getInstance('SecondProduct')->a);
// array(4, 8)

abstract class FactoryAbstract
{

    /**
     * @var array
     */
    protected static $instances = array();


    /**
     * Возвращает экземпляр класса, из которого вызван
     *
     * @return static
     */
    abstract public static function getInstance($id);

    /**
     * Удаляет экземпляр класса, из которого вызван
     *
     * @return void
     */
    abstract public static function removeInstance($id);

    /**
     * Возвращает имя экземпляра класса
     *
     * @return string
     */
    final protected static function getClassName()
    {
        return get_called_class();
    }

    /**
     * Конструктор закрыт
     */
    protected function __construct()
    {
    }

    /**
     * Клонирование запрещено
     */
    final protected function __clone()
    {
    }

    /**
     * Сериализация запрещена
     */
    final public function __sleep()
    {
    }

    /**
     * Десериализация запрещена
     */
    final public function __wakeup()
    {
    }
}