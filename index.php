<?php

function funcA()
{
    $variableRef = "3";
    echo $variableRef.PHP_EOL; /// valeur ici 3
    funcB($variableRef);
    echo $variableRef;   /// valeur ici 6, satria novaina 6 izy tao anaty b
}

function funcB(&$var)
{
    $var = '6';
}

funcA();