<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Appliance;

class ProjectApplianceRecordController extends Controller
{
    public function create()
    {
        return view('admin.project.appliance.create')->withAppliances(Appliance::all());
    }
}
