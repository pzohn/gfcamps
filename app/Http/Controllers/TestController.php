<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function getTest(Request $req) {
        $id = $req->get('id');
        $test = Test::GetTest($id);
        return $test;
    }

    public function getTests(Request $req) {
        $test = Test::GetTests();
        return $test;
    }

    public function insertTests(Request $req) {
        $test = Test::writeTest($req);
        return $test;
    }
}
