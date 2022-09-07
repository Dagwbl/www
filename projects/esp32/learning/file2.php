<?php

namespace Foo\Bar;
include 'file1.php';

const FOO=2;
function foo(){}
class foo{
    static function staticmethod(){

    }
}

foo();
foo::staticmethod();
echo FOO;

subnamespace\foo();
subnamespace\foo::staticmethod();

echo subnamespace\FOO;

\Foo\Bar\foo();
\Foo\Bar\foo::staticmethod();

echo \Foo\Bar\FOO;


?>