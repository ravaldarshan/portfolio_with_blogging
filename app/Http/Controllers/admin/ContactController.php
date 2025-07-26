<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\admin\Contact;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    private static $module = "contact";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $data = Contact::get()->toArray();
        
        $data = array_column($data, 'value', 'name');

        // Ambil pengaturan dari database dan tampilkan di halaman
        return view('administrator.contact.index', compact('data'));
    }

    public function update(Request $request)
    {
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $settings = Contact::get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        
        $data_contact = [];
        $data_contact["address"] = $request->address;
        $data_contact["telepon"] = $request->telepon;
        $data_contact["email"] = $request->email;
        $data_contact["location"] = $request->location;

        $logs = []; // Buat array kosong untuk menyimpan log

        foreach ($data_contact as $key => $value) {
            $data = [];

            if (array_key_exists($key, $settings)) {
                $data["value"] = $value;
                $set = Contact::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Data Sebelumnya' => ['value' => $settings[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = Contact::create($data);

                $logs[] = $set;
            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.contact'))->with(['success' => 'Data berhasil di update.']);

    }
}
