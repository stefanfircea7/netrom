<?php

// src/Twig/GroupByExtension.php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GroupByExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('group_by', [$this, 'groupBy']),
        ];
    }

    public function groupBy(array $array, $property)
    {
        $groupedArray = [];
        foreach ($array as $item) {
            $value = $this->getPropertyValue($item, $property);
            $groupedArray[$value][] = $item;
        }

        return $groupedArray;
    }

    private function getPropertyValue($object, $property)
    {
        if (is_array($object)) {
            return $object[$property] ?? null;
        }

        if (is_object($object)) {
            return $object->{$property} ?? null;
        }

        return null;
    }
}
