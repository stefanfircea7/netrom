<?php

namespace App\Entity;

class FormGameResults
{

    public ?int $homescored = null;
    public ?int $awayscored = null;
    public ?Team $hometeam;
    public ?Team $awayteam;
    public ?Game $gameid;
}