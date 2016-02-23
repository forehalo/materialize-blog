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
        return sprintf(
            '<input type="checkbox" %s %s %s/><label for="' . $id . '"></label>',
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

if (!function_exists('formText')) {
    function formText($col, $name, $id, $errors, $label = '', $icon = '', $memory = true, $value = '', $type = 'text')
    {
        return sprintf('
            <div class="input-field col %s">
                <input type="%s" name="%s" id="%s" class="validate %s" value="%s"/>
                <label for="%s">%s</label>
            </div>',
            $col,
            $type,
            $name,
            $id,
            $errors->first($name) ? 'invalid' : '',
            $memory ? (old($name) ? old($name) : $value) : $value,
            $id,
            $label ? '<i class="material-icons">' . $icon . '</i>' . $label : ''
        );
    }
}

if (!function_exists('destroy')) {
    function destroy($message)
    {
        return sprintf(
            '<button type="submit" class="btn btn-danger" onclick="return confirm(\'%s\')">Destroy</button>',
            $message
        );
    }
}

if (!function_exists('setting')) {
    function setting($key = null, $value = null)
    {
        if (is_null($key)) {
            return app('setting');
        }

        if (is_array($key)) {
            return app('setting')->set($key);
        }

        return app('setting')->get($key, $value);
    }
}

if (!function_exists('parseArticle')) {
    function parseArticle($filepath)
    {
        $inputs = [];

        $content = File::get($filepath);

        $parsed = explode("---\r\n", $content);

        $attrStr = $parsed[0];
        $inputs['origin'] = $parsed[1];

        foreach (preg_split("/\r\n/", $attrStr, -1, true) as $item) {
            $attr = explode(': ', $item);
            $inputs[$attr[0]] = isset($attr[1]) ? $attr[1] : '';
        }

        return $inputs;
    }
}