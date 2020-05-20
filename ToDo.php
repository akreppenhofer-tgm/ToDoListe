<?php


class ToDo
{
    private $bezeichnung;
    private $fach;
    private $gemacht;
    private $deadline;

    public function __construct($bezeichnung,$fach,$deadline,$gemacht)
    {
        $this->bezeichnung = $bezeichnung;
        $this->fach = $fach;
        $this->deadline = $deadline;
        $this->gemacht = $gemacht;
    }

    /**
     * @return string
     */
    public function getBezeichnung()
    {
        return $this->bezeichnung;
    }

    /**
     * @return string
     */
    public function getFach()
    {
        return $this->fach;
    }

    /**
     * @return boolean
     */
    public function isDone()
    {
        return $this->gemacht;
    }

    /**
     * ob die deadline überschritten wurde
     */
    public function isOverdue() {
        if($this->deadline < time()) return true;
        else return false;
    }


}