<?php


class Fach
{
    private $kuerzel;
    private $bezeichnung;

    public function __construct($kuerzel,$bezeichnung)
    {
        $this->bezeichnung=$bezeichnung;
        $this->kuerzel = $kuerzel;
    }

    /**
     * @return mixed
     */
    public function getBezeichnung()
    {
        return $this->bezeichnung;
    }

    /**
     * @return mixed
     */
    public function getKuerzel()
    {
        return $this->kuerzel;
    }
}