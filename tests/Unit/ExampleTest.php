<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testLinksWithoutLogin()
    {
        //auth()->loginUsingId(1);

        $links = ["items", "customer","vendor","bill", "payment"];
        $sub_links = ["index", "create"];
        foreach($links as $link){
            foreach($sub_links as $sub_link) {
                if ($link == "items" && $sub_link == "index") continue;

                $response = $this->get(route($link .".". $sub_link));
                $response->assertStatus(302);
            }
        }
    }

    public function testLinksWithLogin()
    {
        auth()->loginUsingId(1);

        $links = ["items", "customer","vendor","bill", "payment"];
        $sub_links = ["index", "create"];
        foreach($links as $link){
            foreach($sub_links as $sub_link) {
                if ($link == "items" && $sub_link == "index") continue;

                $response = $this->get(route($link .".". $sub_link));
                $response->assertStatus(200);
            }
        }
    }


}
