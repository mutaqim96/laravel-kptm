<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function audit()//nama cuntion yang akan dipass dari mw
    {
        //query all audits
        $audits = Audit::orderBy('created_at','desc')->get();// jadi audit 1,2,3,4,5 klaau tambah order by

        //reuturn to view
        return view('audit',compact('audits')); //kita hantar audits

    }
}
