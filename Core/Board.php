<?php
namespace Core;

/**
 * Class Board
 * @author  Ariel Belloc
 * @license Propietary
 */
class Board {
    const BOMB_KEY = 'b';

    /**
     * @var int
     */
    private $amountRow;

    /**
     * @var int
     */
    private $amountColumn;

    /**
     * @var int
     */
    private $amountBomb;

    /**
     * @var array
     */
    protected $boardMap = array();


    public function __construct(int $amountRow, int $amountColumn, int $amountBomb)
    {
        $this->amountRow = $amountRow;
        $this->amountColumn = $amountColumn;
        $this->amountBomb = $amountBomb;

        $this->createBoard();
    }

    /**
     * @return int
     */
    public function getAmountRow(): int
    {
        return $this->amountRow;
    }

    /**
     * @return int
     */
    public function getAmountColumn(): int
    {
        return $this->amountColumn;
    }

    /**
     * @return int
     */
    public function getAmountBomb(): int
    {
        return $this->amountBomb;
    }

    /**
     * @return array
     */
    public function getBoardMap(): array
    {
        return $this->boardMap;
    }

    protected function createBoard()
    {
        $this->initializeBoardMap();
        $this->distributeBombsOnMap();
        $this->assignBoardMapNumbers();
    }

    /**
     * @param int $row
     * @param int $column
     */
    protected function initializeBoardMap()
    {
        $boardMap = array();
        for ($rowIndex = 0; $rowIndex < $this->amountRow; $rowIndex++) {
            for ($columnIndex = 0; $columnIndex < $this->amountColumn; $columnIndex++) {
                $boardMap[$rowIndex][$columnIndex] = 0;
            }
        }
        $this->boardMap = $boardMap;
    }

    /**
     * Create
     * Create a board, with bombs and numbers
     */
    protected function distributeBombsOnMap()
    {
        $rowAssigned = 0;
        while ($rowAssigned < $this->amountBomb) {
            $row = rand(0, $this->amountRow - 1);
            $column = rand(0, $this->amountColumn - 1);

            if ($this->boardMap[$row][$column] !== self::BOMB_KEY) {
                $this->boardMap[$row][$column] = self::BOMB_KEY;
                $rowAssigned++;
            }
        }
    }

    /**
     * Create
     * Create a board, with bombs and numbers
     */
    protected function assignBoardMapNumbers()
    {
        for ($rowIndex = 0; $rowIndex < $this->amountRow; $rowIndex++) {
            for ($columnIndex = 0; $columnIndex < $this->amountColumn; $columnIndex++) {
                if (isset($this->boardMap[$rowIndex][$columnIndex])) {
                    if ($this->boardMap[$rowIndex][$columnIndex] === self::BOMB_KEY) {
                        $this->assignNumbersAroundBomb($rowIndex, $columnIndex);
                    }
                } else {
                    $this->boardMap[$rowIndex][$columnIndex] = 0;
                }
            }
        }
    }

    protected function assignNumbersAroundBomb(int $rowIndex, int $columnIndex) {
        if ($rowIndex < 0 || $columnIndex < 0) {
            throw new InvalidArgumentException();
        }

        $rowFrom = $rowIndex === 0 ? 0 : -1;
        $rowTo = $rowIndex === $this->amountRow ? 0 : 1;

        $columnFrom = $columnIndex === 0 ? 0 : -1;
        $columnTo = $columnIndex === $this->amountColumn ? 0 : 1;

        for ($i=$rowFrom; $i<=$rowTo; $i++) {
            for ($x=$columnFrom; $x<=$columnTo; $x++) {
                try {
                    if ($this->boardMap[$rowIndex + $i][$columnIndex + $x] !== self::BOMB_KEY) {
                        $this->boardMap[$rowIndex + $i][$columnIndex + $x]++;
                    }
                } catch (\Exception $exception) {
                    echo $exception->getMessage();
                }

            }
        }
    }
}