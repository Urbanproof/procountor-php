<?php

use Procountor\Tests\TestCollection;
use Procountor\Tests\TestResourcePrimary;

test('adding invalid item throws', function () {
    $collection = new TestCollection();
    $collection->addItem(new stdClass());
    $this->assertCount(0, $collection);
})
    ->throws(TypeError::class)
    ->group('collection');

test('adding valid item', function () {
    $collection = new TestCollection();
    $collection->addItem(new TestResourcePrimary());
    $this->assertCount(1, $collection);
})
    ->group('collection');

test('iterating over collection', function() {
    $collection = new TestCollection();
    for ($i = 1; $i <= 5; $i++) {
        $collection->addItem(new TestResourcePrimary());
    }
    $this->assertCount(5, $collection);
    $counted = 0;
    foreach ($collection as $resource) {
        $this->assertEquals('This is a test.', $resource->getTestString());
        ++$counted;
    }
    $this->assertEquals(5, $counted);
})
    ->group('collection');
