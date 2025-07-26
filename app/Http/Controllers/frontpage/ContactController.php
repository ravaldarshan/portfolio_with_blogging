<?php

namespace App\Http\Controllers\frontpage;

use Illuminate\Http\Request;
use App\Models\admin\Contact;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index(){
        $data = Contact::get()->toArray();
        
        $data = array_column($data, 'value', 'name');

        return view('frontpage.contact.index', compact('data'));
    }
}
