<?php

namespace Procountor\Tests;

use DateTime;
use PHPUnit\Framework\TestCase;
use Procountor\Procountor\Collection\AbstractCollection;
use ReflectionClass;
use RuntimeException;

class UnitTestCase extends TestCase
{

    protected function assertProcountorResponseObject($data, $object)
    {
        $reflection = new ReflectionClass($object);
        foreach ($reflection->getMethods() as $method) {
            if ($method->name == '__construct' || !preg_match('/get(.*)/', $method->name, $matches)) {
                continue;
            }

            $ret = $object->{$method->name}();
            $field = lcfirst($matches[1]);
            $excepted = $data->{$field};

            switch (gettype($ret)) {
                case 'object':
                    switch (true) {
                        case $ret instanceof AbstractCollection:
                            foreach ($ret as $k => $item) {
                                $this->assertProcountorResponseObject($excepted[$k], $item);
                            }
                            break;
                        case $ret instanceof DateTime:
                            $this->assertEquals(new DateTime($excepted), $ret);
                            break;
                        default:
                            $this->assertProcountorResponseObject($excepted, $ret);
                            break;
                    }
                    break;
                default:
                    $this->assertEquals(
                        $excepted,
                        $ret,
                        sprintf('Field "%s" of %s value not matching', $field, get_class($object))
                    );
                    break;
            }
        }
    }

    /**
     * Get predefined JSON test data for a given resource.
     * Simply a wrapper for file_get_contents.
     *
     * @param string $resourceName For example, "dimension", "attachment" etc.
     * @return string
     * @throws RuntimeException
     */
    protected function getResponseJson(string $resourceName): string
    {
        $filename = dirname(__FILE__) . "/json/$resourceName.json";
        if (!file_exists($filename)) {
            throw new RuntimeException('No JSON spesified for a given resource.');
        }
        return file_get_contents($filename);
    }

}
