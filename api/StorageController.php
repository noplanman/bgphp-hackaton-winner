<?php
/**
 * Created by PhpStorm.
 * User: armyman
 * Date: 08/10/16
 * Time: 21:29
 */

namespace FourCheese;


interface StorageController
{
    public function addPlayer();
    public function getPlayers();
    public function postBet($uid, $bet);
}
