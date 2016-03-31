<?php

/**
 * Created by PhpStorm.
 * User: leo
 * Date: 16-3-29
 * Time: 下午8:13
 */

require dirname(__DIR__) . '/vendor/autoload.php';
class TestCase extends PHPUnit_Framework_TestCase {

    public function __construct() {
        parent::__construct();
    }
}