<?php
/**
 * BCmath 封装类
 * Calc::add(1, 2, 3)->sub(1, 2)->mul(4, 5)->value(4); //按步骤计算 1+2+3-1-2*4*5 最后调用 value 方法获取保留4位小数
 */
namespace App\Tools;

/**
 * @method Calc add(string ...$value) 加法
 * @method Calc sub(string ...$value) 减法
 * @method Calc mul(string ...$value) 乘法
 * @method Calc div(string ...$value) 除法
 * @method Calc comp(string ...$value) 比较
 * @method Calc mod(string ...$value) 取模
 * @method Calc pow(string ...$value) 乘方
 * @method Calc sqrt(string ...$value) 开方
 */

class Calc {

    protected $init = 0;
    protected $carry = [];

    public function __construct($value = 0)
    {
        $this->init = $value;
    }

    public static function init($value = 0)
    {
        return new static($value);
    }

    public static function __callStatic($method, $args)
    {
        return self::init(array_shift($args))->$method(...$args);
    }

    public function __call($method, $args)
    {
        $this->carry[] = ['bc' . $method => $args];
        return $this;
    }

    /**
     * 获取值
     * @param int $scale 保留小数位
     * @return string
     */
    public function value(int $scale = 2): string
    {
        foreach ($this->carry as $item) {
            foreach ($item as $func => $value) {
                $this->init = array_reduce($value, function ($carry, $val) use ($func, $scale) {
                    return $func($carry, $val, $scale);
                }, $this->init);
            }
        }
        return $this->init;
    }

    public static function percent(&$value)
    {
        $value = floatval($value) / 100;
    }

    public static function round(&$value, int $precision = 0, int $mode = PHP_ROUND_HALF_UP)
    {
        $value = round($value, $precision, $mode);
    }

}
