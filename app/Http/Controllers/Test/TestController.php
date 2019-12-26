<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Importer;

class TestController extends Controller
{
    public function accessors()
    {
        $user = User::find(1);
        dd($user->name);
    }

    public function mutators()
    {
        $user = User::find(2);
        $user->name = "tUi lA aDmIn 2";
        $user->save();
    }

    public function qscope()
    {
        $user = User::LastActivatedUser();
        dd($user->name);
    }

    public function session(Request $request)
    {
        // create session
        session()->put(['new_session' => 'Tran Dinh Dat']);

        // update session
        session(['new_session' => 'Update session']); 

        // read session 
        echo 'Read session: '.session()->get('new_session') . '<br>';

        // delete session 
        session()->forget('new_session');

        $request->session()->flash('msg', 'test flash session');
        echo $request->session()->get('msg');
        $request->session()->keep('msg');

        // delete complete session 
        // $request->session()->flush();
        dd(session()->all());
    }
    
    public function import()
    {
        return view('test.excel');
    }

    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|max:5000|mimes:xlsx,xls,csv'
        ]);

        if ($validator->passes()) {
            $dataTime = date('Ymd_His');
            $file = $request->file('file');
            $fileName = $dataTime . '-' . $file->getClientOriginalName();
            $savePath = public_path('/excel/upload/');
            $file->move($savePath, $fileName);

            $excel = Importer::make('Excel');
            $excel->load($savePath.$fileName);
            $collection = $excel->getCollection();

            // dd($collection);
            // kiem tra so luong field excel id, name, first name, last name, previous shool,  == 5
            if (sizeof($collection[1]) == 5) {
                for ($row=1; $row < sizeof($collection); $row++) { 
                    try {
                        echo '<pre>';
                        var_dump($collection[$row]);
                    } catch (\Exception $e) {
                        return back()->with(['errors' => $e->getMessage()]);
                    }
                }
            } else {
                return back()->with(['errors' => [0 => 'Please provide data acording to sample...']]);
            }

        } else {
            return back()->with(['errors' => $validator->errors()->all()]);
        }
    }
}
