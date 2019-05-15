<?php

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\MakeRepositoryCommand as MakeCmd;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MakeRepositoryCommandTest extends TestCase
{
    /** @var MakeCmd */
    private $obj;

    /**
     * MakeRepositoryCommandTest setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->obj = new MakeCmd();
    }

    /**
     * Test of decideRepositoryPathString
     */
    public function test_decideRepositoryPathString(): void
    {
        $sources = [
            'Hoge',
            'Hoge/Fuga',
            'Hoge/Fuga/Heno',
        ];
        $expected = [
            [MakeCmd::BASE_PATH.'Hoge/',           'Hoge'],
            [MakeCmd::BASE_PATH.'Hoge/Fuga/',      'Fuga'],
            [MakeCmd::BASE_PATH.'Hoge/Fuga/Heno/', 'Heno'],
        ];

        $actual = [];
        foreach ($sources as $testSource) {
            $actual[] = $this->obj->decideRepositoryPathString($testSource);

        }

        $this->assertSame($expected, $actual);
    }

    /**
     * Test of decideRepositoryNamespaceString
     */
    public function test_decideRepositoryNamespaceString(): void
    {
        $sources = [
            'Hoge',
            'Hoge/Fuga',
            'Hoge/Fuga/Heno',
        ];
        $expected = [
            [MakeCmd::NAMESPACE_PATH_HEAD.'Hoge',             'Hoge'],
            [MakeCmd::NAMESPACE_PATH_HEAD.'Hoge\\Fuga',       'Fuga'],
            [MakeCmd::NAMESPACE_PATH_HEAD.'Hoge\\Fuga\\Heno', 'Heno'],
        ];

        $actual = [];
        foreach ($sources as $testSource) {
            $actual[] = $this->obj->decideRepositoryNamespaceString($testSource);

        }

        $this->assertSame($expected, $actual);
    }

}
