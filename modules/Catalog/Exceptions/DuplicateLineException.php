<?php

namespace Modules\Catalog\Exceptions;

use Modules\Catalog\Entities\Line as LineEntity;

class DuplicateLineException extends \Exception {

    /**
     * @var LineEntity
     */
    protected $matchedLine;

    /**
     * @var LineEntity
     */
    protected $newLine;

    public function __construct() {
        parent::__construct('Line already exists.');
    }

    /**
     * Get the existing line that was matched.
     *
     * @return LineEntity
     */
    public function getMatchedLine() : LineEntity {
        return $this->matchedLine;
    }

    /**
     * Set matched line.
     *
     * @param LineEntity $matchedLine
     *  The line.
     *
     * @return void
     */
    public function setMatchedLine(LineEntity $matchedLine) {
        $this->matchedLine = $matchedLine;
    }

    /**
     * Get the line object that would have been created.
     *
     * @return LineEntity
     */
    public function getNewLine() : LineEntity {
        return $this->newLine;
    }

    /**
     * Set the line that would have been created.
     *
     * @param LineEntity $newLine
     *   The new line.
     */
    public function setNewLine(LineEntity $newLine) {
        $this->newLine = $newLine;
    }

}