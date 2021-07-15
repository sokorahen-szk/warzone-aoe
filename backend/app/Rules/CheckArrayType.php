<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/*
    型については、こちらを参照ください。gettypeの戻り値に依存します。
    https://www.php.net/manual/ja/function.gettype.php
 */

class CheckArrayType implements Rule
{
    private $type;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type = null)
    {
        if (!$type) {
            // TODO: Exceptionを独自に用意すべき、今後の課題
            throw new \Exception('type が未定義');
        }
        $this->type = $type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach($value as $d) {
            if (gettype($d) !== $this->type) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf("配列の値が %sではありません。", $this->type);
    }
}
