<?php
namespace Tests;
use Core\Board;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateBoardTest
 * @author  Ariel Belloc
 * @license Propietary
 */
final class CreateBoardTest extends TestCase
{
    protected static function getMethod($name)
    {
        $class = new \ReflectionClass('Core\Board');

        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    protected static function getPropery($name)
    {
        $class = new \ReflectionClass('Core\Board');
        $property = $class->getProperty($name);
        $property->setAccessible(true);
        return $property;
    }

    public function testCreateMapAroundBombSuccess() {
        /** Armo el mapa a testear */
        $bombMap[0][0] = 'b';
        $bombMap[1][1] = 'b';
        $bombMap[2][2] = 'b';

        $bombMap[0][1] = 0;
        $bombMap[0][2] = 0;

        $bombMap[1][0] = 0;
        $bombMap[1][2] = 0;

        $bombMap[2][0] = 0;
        $bombMap[2][1] = 0;

        $board = new Board(3, 3, 3);

        $boardMapProperty = self::getPropery('boardMap');
        $boardMapProperty->setValue($board, $bombMap);

        $createMapAroundBombMethod = self::getMethod('assignBoardMapNumbers');

        $createMapAroundBombMethod->invokeArgs($board, array($bombMap));
        $originalBoardMap = $board->getBoardMap();

        $compareBombMap[0][0] = 'b';
        $compareBombMap[1][1] = 'b';
        $compareBombMap[2][2] = 'b';

        $compareBombMap[0][1] = 2;
        $compareBombMap[0][2] = 1;

        $compareBombMap[1][0] = 2;
        $compareBombMap[1][2] = 2;

        $compareBombMap[2][0] = 1;
        $compareBombMap[2][1] = 2;

        $this->assertEquals($compareBombMap, $originalBoardMap);
    }
}