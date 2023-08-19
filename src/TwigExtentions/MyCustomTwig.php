<?php

namespace App\TwigExtentions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MyCustomTwig extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('defaultImage', [$this, 'defaultImage'])
        ];
    }

    public function defaultImage(string $path): string
    {
        if (strlen(trim($path))==0){
            return 'Capbture.PNG';

       }
       return $path;
    }
}