<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Factory
 *
 * @author amahalingam
 */
class ObjectFactory
{
    public static function build($class)
    {
        if (!class_exists($class)) {
            throw new Exception('Missing format class.');
        }
        return new $class;
    }
}

?>
