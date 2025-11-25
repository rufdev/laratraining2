<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $message = 'Hello from Location Page';
        return inertia('Location/Index',
            ['message' => $message]
        );
    }
}
