<?php
/**
 * Created by PhpStorm.
 * User: fevr
 * Date: 09.09.2018
 * Time: 12:23
 */

namespace Tests\Unit;


use App\Models\Cash;
use App\Models\Setting;
use App\Models\User;
use App\Prizes\Prize;
use Tests\TestCase;

class CashModelTest extends TestCase
{

    public function testConvertToBonuses()
    {
        $cash = $this->getMockBuilder(Cash::class)->setMethods(['save'])->getMock();
        $cash->amount = 1;
        $cash->expects($this->once())->method('save');
        $userMock = $this->getMockBuilder(User::class)->setMethods(['save'])->getMock();
        $userMock->bonuses = 100;
        $userMock->expects($this->once())->method('save');
        $cash->user = $userMock;

        $setting = $this->createMock(Setting::class);
        $setting->expects($this->once())->method('modifyBalance')->with($cash->amount);
        $setting->expects($this->once())->method('getSettingValue')
            ->with(Setting::CASH_TO_BONUSES_MULTIPLIER_SETTING_NAME)->willReturn(2);

        $this->instance(Setting::class, $setting);

        $cash->convertToBonuses();

        $this->assertEquals($cash->user->bonuses, 102);
        $this->assertEquals($cash->status, Prize::PRIZE_STATUS_CONVERTED);
    }

}