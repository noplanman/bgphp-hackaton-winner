<?php
/**
 * Created by PhpStorm.
 * User: armyman
 * Date: 08/10/16
 * Time: 21:30
 */

namespace FourCheese;

use NoSQLite;

class SqliteStorageController implements StorageController
{
    private $storage;

    public function __construct()
    {
        $this->storage = new NoSQLite\NoSQLite('4cheese.sqlite');
    }

    public function addPlayer()
    {
        $store = $this->storage->getStore('players');
        $uid = uniqid();

        $store->set($uid, json_encode(['uid' => $uid, 'score' => 0, 'badluck' => 0]));

        return $uid;
    }

    public function getPlayers()
    {
        $store = $this->storage->getStore('players');

        return $store->getAll();
    }
}
