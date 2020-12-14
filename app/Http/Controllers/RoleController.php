<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;

class RoleController extends Controller
{
 //
 public function index()
    {
        foreach (Role::all() as $role) {
        echo $role->name;
        }
    }
}
