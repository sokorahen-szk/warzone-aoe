<?php

namespace Tests\Unit\App\Models;

use Tests\TestCase;
use App\Models\GamePackageModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GamePackageModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_insert()
    {
        $gamePackage = GamePackageModel::factory()->create();
        $result = GamePackageModel::find($gamePackage->id);

        $this->assertSame($gamePackage->id, $result->id);
    }

    public function test_delete()
    {
        $gamePackage = GamePackageModel::factory()->create();
        $result = GamePackageModel::find($gamePackage->id);

        $this->assertSame($gamePackage->id, $result->id);

        $result = GamePackageModel::find($gamePackage->id)->delete();
        $this->assertTrue($result);
    }
}
