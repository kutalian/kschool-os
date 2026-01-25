<?php

namespace App\Http\Controllers\Parent;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $parent = $user->parent;

        if (!$parent) {
            abort(403, 'Parent profile not found.');
        }

        $children = $parent->students()->with('class_room')->get();

        return view('parent.children.index', compact('children'));
    }
}
