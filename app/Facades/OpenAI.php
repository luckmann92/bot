<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static ask(string $string)
 */
class OpenAI extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'openai';
    }
}
