<?php

namespace Gringo\Tests;

use Gringo\Store;

class StoreTest extends \PHPUnit_Framework_TestCase {
    private $store_root;

    public function setUp() {
        $this->store_root = __DIR__ . \DIRECTORY_SEPARATOR . 'data';
    }

    public function tearDown() {
        foreach(scandir($this->store_root) as $file) {
            $this->rmRecursive($this->store_root . \DIRECTORY_SEPARATOR . $file);
        }
    }

    public function testExceptionOnInvalidRoot() {
        $this->setExpectedException('RuntimeException');

        $store = new Store('test');
    }

    public function testStoreIsCreated() {
        $store = $this->getStore();

        $this->assertTrue(
            file_exists($this->store_root. \DIRECTORY_SEPARATOR . 'test')
        );
    }

    public function testGetDefault() {

    }

    public function testCreate() {

    }

    public function testHasNext() {
        $store = $this->getStore();

        $this->assertFalse($store->hasNext());

        $store->create($store->getDefault());

        // Reset our counter.
        $store = $this->getStore();

        $this->assertTrue($store->hasNext());
    }

    private function getStore() {
        return new Store('test', $this->store_root);
    }

    private function rmRecursive($file) {
        // Ignore dotfiles
        if(basename($file)[0] === '.') {
            return;
        }

        if(is_file($file)) {
            unlink($file);
        } else {
            foreach (scandir($file) as $files) {
                $files = $file . \DIRECTORY_SEPARATOR . $files;

                $this->rmRecursive($files);
            }

            rmdir($file);
        }
    }
}
