<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UserGostosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;

class ExportController extends Controller
{
    public function todos()
    {
        return Excel::download(new UserGostosExport(User::take(1000)->get()), 'users.csv');
    }
}
