<?php


namespace App\Repositories\Fruit;

use App\Models\Fruits;
use App\Repositories\Fruit\FruitRepositoryInterface;

/**
 * Class FruitDbRepository
 * @package App\Repositories\Fruit
 */
class FruitDbRepository extends Fruits implements FruitRepositoryInterface
{

    /**
     * @return Fruits[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAll()
    {
        return FruitDbRepository::all();
    }

    /**
     * IDで1レコードを取得
     *
     * @param $id
     * @return mixed
     */
    public function getFirstRecordById($id)
    {
        return FruitDbRepository::where('id', '=', $id)->first();
    }
}