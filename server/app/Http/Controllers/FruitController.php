<?php

namespace App\Http\Controllers;

use App\Models\Fruits;
use App\Repositories\Fruit\FruitDbRepository;
use App\Repositories\Fruit\FruitRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FruitController extends Controller
{
    /** @var Fruits */
    protected $fruits;

    /** @var FruitRepositoryInterface */
    protected $fruitRepository;

    /**
     * FruitController constructor.
     * @param Fruits|null $fruits
     * @param FruitRepositoryInterface|null $fruitRepository
     */
    public function __construct(
        Fruits $fruits = null
        //,FruitRepositoryInterface $fruitRepository = null
    )
    {
        $this->fruits = $fruits ?? new Fruits();
        //$this->fruitRepository = $fruitRepository ?? new FruitDbRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return JsonResponse::create(
            $this->fruits->all(),
            Response::HTTP_OK
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['status' => 200, 'id' => $id, 'name' => 'hoge']);
//        return JsonResponse::create(
//            $this->fruitRepository->getFirstRecordById($id),
//            Response::HTTP_OK
//        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
