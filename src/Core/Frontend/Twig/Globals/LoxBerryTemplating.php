<?php

namespace LoxBerryPlugin\Core\Frontend\Twig\Globals;

/**
 * Class LoxBerryTemplating.
 */
class LoxBerryTemplating
{
    public function printHead()
    {
        return '{% sandbox %}<h1>Testhead</h1>{% endsandbox %}';
    }
}
