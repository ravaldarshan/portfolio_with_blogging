<?php

namespace App\Http\Controllers\admin;

use PDF;
use DataTables;
use Carbon\Carbon;
use App\Models\admin\Log;
use App\Models\admin\User;
use App\Models\admin\Module;
use Illuminate\Http\Request;
use App\Models\admin\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class LogSystemController extends Controller
{
    private static $module = "log_system";

    public function index(){
        
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.logs.index');
    }

    public function getData(Request $request)
    {
        $data = Log::query()->with('user');

        if ($request->user || $request->module) {
            if ($request->user != "") {
                $user = $request->user;
                $data->where("user_id", $user);
            }
            
            if ($request->module != "") {
                $module = $request->module ;
                $data->where("module", $module);
            }
            $data->get();
        }
        


        return DataTables::of($data)
            ->make(true);
    }

    public function getDetail($id){

        $data = Log::with('user')->find($id);
        if (!$data) {
            return abort(404);
        }
        return response()->json([
            'data' => $data,
        ]);
    }
    
    public function getDataModule(Request $request)
    {
        $data_module = Module::query();

        return DataTables::of($data_module)
            ->make(true);
    }

    public function getDataUser(Request $request)
    {
        $data_user = User::query()->with('user_group')->where('code','!=', 'daysf');

        return DataTables::of($data_user)
            ->make(true);
    }

    public function clearLogs()
    {
        
        if (!isAllowed(static::$module, "clear")) {
            abort(403);
        }

        try {
            $DaysAgo = Carbon::now()->subDays(7);
            Log::where('created_at', '<', $DaysAgo)->delete();
            return redirect()->route('admin.logSystems')->with('success', 'Log data older than 7 days was successfully deleted.');
        } catch (\Exception $e) {
            return redirect()->route('admin.logSystems')->with('error', 'An error occurred while deleting log data: ' . $e->getMessage());
        }
    }

    public function generatePDF()
    {
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }

        ini_set('max_execution_time', 600); 

        $data = Log::with('user')->orderBy('created_at', 'desc')->get();

        $settings = Setting::get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        
        $html = View::make('administrator.logs.export', compact('data'))->render();

        
        $pdf = PDF::loadHTML($html);

        
        try {
            return $pdf->stream('log-export.pdf');
        } catch (\Exception $e) {
            return $e->getMessage(); 
        }
    }
}
