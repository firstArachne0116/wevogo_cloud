<?php

function active_class($controller, $currentController) {
    $currentController = explode(',', $currentController);
    $class = '';
    foreach ($currentController as $cc) {
        if ($controller == $cc)
            $class = 'active';
    }
    return $class;

}

function getControllerName($fullPath)
{
    if (!isset($controller) && strpos($fullPath, '@') != false) {
        list($controller, $action) = explode('@', $fullPath);
        $controller = preg_replace('/^.+[\\\\\\/]/', '', $controller);
        return $controller;
    }
}

function getActionName($fullPath)
{
    if (!isset($controller) && strpos($fullPath, '@') != false) {
        list($controller, $action) = explode('@', $fullPath);
        return $action;
    }
}

function radioArray()
{
    return ['Yes' => 1, 'No' => 0];
}
function full_name($object)
{
    return ucfirst($object->first_name) . ' ' . ucfirst($object->last_name);
}

function getEnumValues($table, $column)
{
    $type = DB::select( DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'") )[0]->Type;
    preg_match('/^enum\((.*)\)$/', $type, $matches);
    $enum = array();
    foreach( explode(',', $matches[1]) as $value )
    {
        $v = trim( $value, "'" );
        $enum = array_add($enum, $v, $v);
    }
    return $enum;
}

function generateRandomNumber($length)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return 1234;
}