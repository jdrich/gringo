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

    public function testExceptionOnInvalidStoreName() {
        $this->setExpectedException('UnexpectedValueException');

        $store = $this->getStore('!!!!invalid!!!');
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

    public function testHasNext() {
        $store = $this->getStore();

        $this->assertFalse($store->hasNext());

        $store->create($store->getDefault());

        // Reset our counter.
        $store = $this->getStore();

        $this->assertTrue($store->hasNext());
    }

    public function testCurrent() {
        $store = $this->getStore();

        $this->assertNull($store->current());

        $store->create($store->getDefault());

        $this->assertEquals([], $store->current());
    }

    public function testFirst() {
        $store = $this->getStore();

        $first = $store->getDefault();
        $first['bacon'] = 'delicious';

        $store->create($first);
        $store->create($store->getDefault());
        $store->create($store->getDefault());

        $this->assertEquals($first, $store->first());
    }

    public function testLast() {
        $store = $this->getStore();

        $last = $store->getDefault();
        $last['bacon'] = 'delicious';

        $store->create($store->getDefault());
        $store->create($store->getDefault());
        $store->create($last);

        $store->first();

        $this->assertEquals($last, $store->last());
    }

    public function testGetThrowsExceptionOnBadIndex() {
        $this->setExpectedException('RuntimeException');

        $store = $this->getStore();
        $store->get(5);
    }

    public function testGetThrowsExceptionOnInvalidIndex() {
        $this->setExpectedException('RuntimeException');

        $store = $this->getStore();
        $store->get('vanilla');
    }

    public function testGet() {
        $store = $this->getStore();

        $this->populate($store);

        $this->setExpectedException('RuntimeException');
        $store->get('vanilla');

        $store = $this->getStore();

        $this->assertNull($store->get());

        $store->get(20);
    }

    private function populate(Store $store) {
        $belome = function($index) {
            return [ 'item' => $index ];
        };

        $count = 10;

        while($count < 10) {
            $store->create($belome($count));

            $count++;
        }
    }

    private function getStore($store = 'test') {
        return new Store($store, $this->store_root);
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
