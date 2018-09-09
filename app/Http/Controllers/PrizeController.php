<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Cash;
use App\Models\PrizeAbstractModel;
use App\Models\Shipment;
use App\Prizes\Prize;

class PrizeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \ReflectionException
     */
    public function random()
    {
        /** @var Bonus|Cash|Shipment $prize */
        $prize = resolve(Prize::class)->getRandomPrize();
        return response([
            'status' => 'success',
            'type' => $prize->getType(),
            'prize' => $prize
        ], 200);
    }

    /**
     * @param string $type
     * @param int $prizeId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \ReflectionException
     */
    public function get(string $type, int $prizeId)
    {
        /** @var PrizeAbstractModel $prize */
        $prize = resolve(Prize::class)->getPrizeInstance($type)->where('id', '=', $prizeId)->where('user_id', '=', auth()->id())->firstOrFail();

        return response([
            'status' => 'success',
            'type' => $type,
            'prize' => $prize
        ], 200);
    }


    /**
     * @param string $type
     * @param int $prizeId
     * @param string $status
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \ReflectionException
     */
    public function updateStatus(string $type, int $prizeId, string $status)
    {
        /** @var PrizeAbstractModel $prize */
        $prize = resolve(Prize::class)->getPrizeInstance($type)->where('id', '=', $prizeId)->where('user_id', '=', auth()->id())->firstOrFail();
        $prize->updateStatus($status);

        return response([
            'status' => 'success',
            'type' => $type,
            'prize' => $prize
        ], 200);
    }
}
