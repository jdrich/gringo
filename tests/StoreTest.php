<?php

namespace Gringo\Tests;

use Gringo\Store;

class StoreTest extends \PHPUnit_Framework_TestCase {
    private $store_root;

    public function setUp() {
        $this->store_root = __DIR__ . \DIRECTORY_SEPARATOR . 'data';
    }

    public function tearDown() {
        $files = glob($this->store_root);

        foreach($files as $file) {
            if(is_file($file)) {
                unlink($file);
            }
        }
    }

    public function testExceptionOnInvalidRoot() {
        var_dump($this->store_root);

        $this->setExpectedException('RuntimeException');

        $store = new Store('test');
    }

    public function testStore() {
        $this->setExpectedException('RuntimeException');

        $store = new Store('test');
    }
}
