<?php

namespace App\Repositories\Fruit;

/**
 * Interface FruitRepositoryInterface
 * @package App\Repositories\Fruit
 */
interface FruitRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getAll();

    /**
     * IDで1レコードを取得
     *
     * @param  bigInteger      $id
     * @return object
     */
    public function getFirstRecordById($id);
}
