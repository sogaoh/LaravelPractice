<?php


namespace App\Repositories\Fruit;

use App\Models\Fruits;

/**
 * Class FruitDbRepository
 * @package App\Repositories\Fruit
 */
class FruitDbRepository extends Fruits
{
    protected $fruits;

    /**
     * FruitDbRepository constructor.
     * @param Fruits $fruits
     */
    public function __construct(
        FruitDbRepository $fruits = null
    )
    {
        $this->fruits = $fruits ?? new FruitDbRepository();
    }

    /**
     * @return Fruits[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAll()
    {
        return $this->fruits->all();
    }

    /**
     * IDで1レコードを取得
     *
     * @param $id
     * @return mixed
     */
    public function getFirstRecordById($id)
    {
        return $this->fruits->where('id', '=', $id)->first();
    }
}