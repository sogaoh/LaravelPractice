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
    /** @var FruitRepositoryInterface */
    protected $fruitRepository;

    /**
     * FruitController constructor.
     * @param FruitRepositoryInterface $fruitRepository
     */
    public function __construct(
        FruitRepositoryInterface $fruitRepository
    )
    {
        $this->fruitRepository = $fruitRepository ?? new FruitDbRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Not Repository Pattern
        return JsonResponse::create(
            Fruits::all(),
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
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        //Not Repository Pattern
        if ($id == 0) {
            return JsonResponse::create(
                $this->fruitRepository->getAll(),
                Response::HTTP_OK
            );
        }
        return JsonResponse::create(
            $this->fruitRepository->getFirstRecordById($id),
            Response::HTTP_OK
        );
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
