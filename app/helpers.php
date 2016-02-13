<?php

if (!function_exists('intToMonth')) {
    function intToMonth($i)
    {
        $monthArr = [
            1 => "January",
            2 => "February",
            3 => "March",
            4 => "April",
            5 => "May",
            6 => "June",
            7 => "July",
            8 => "August",
            9 => "September",
            10 => "October",
            11 => "November",
            12 => "December"
        ];

        return $monthArr[$i];
    }
}

if (!function_exists('classActivePath')) {
    function classActivePath($path)
    {
        return Request::is($path) ? 'active' : '';
    }
}

if (!function_exists('classActiveSegment')) {
    function classActiveSegment($segment, $value)
    {
        if (!is_array($value)) {
            return Request::segment($segment) == $value ? 'active' : '';
        }
        foreach ($value as $v) {
            if (Request::segment($segment) == $v) return 'active';
        }
        return '';
    }
}

if (!function_exists('checkbox')) {
    function checkbox($checked, array $attributes = [])
    {
        $id = $attributes['name'] . $attributes['value'];
        return sprintf('<input type="checkbox" %s %s %s/><label for="' .$id  . '"></label>',
                        'id="' . $id . '"',
                        domAttrGenerator($attributes),
                        $checked ? 'checked' : ''
                      );
    }
}

if (!function_exists('domAttrGenerator')) {
    function domAttrGenerator(array $attributes = [])
    {
        $attr = ' ';

        foreach ($attributes as $key => $value) {
            $attr .= $key . '="' . $value . '" ';
        }
        return $attr;
    }
}