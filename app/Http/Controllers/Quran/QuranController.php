<?php

namespace App\Http\Controllers\Quran;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Quran;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class QuranController extends Controller
{
    public function index(Request $request){

        if ($request->has('ayah') or $request->has('surah')){
            if ($request->ayah[0] == "0"){
                $quran = Quran::where([
                    'surah_id' => $request->surah,
                ])->get();
            }else{

                $quran = Quran::where([
                    'surah_id' => $request->surah
                ])->whereIn('ayah_number', $request->ayah)->get();
            }
        }else{
            $quran = Quran::where('surah_id',1)->get();
        }


        $surah=Surah::all();

        return view('quran.index',compact('surah','quran'));
    }

    public function ayah_ajax($id = null){

        $ayah = Surah::find($id);

        return response($ayah);
    }

    public function note_al_ajax(Request $request){
        $ayah_id = $request->ayah_id;
        $note = $request->note;
        $surah_id = $request->surah_id;
        $id = $request->id;



        if ($id == 0){
            $save= Note::create([
                'ayah' => $ayah_id,
                'surah_id' => $surah_id,
                'user_id' => Auth::id(),
                'note' => $request->note
            ]);
        }else{
            $save = Note::find($id);
            $save->update([
                'note' => $request->note
            ]);

        }

        return response($save,200);
    }

    public function note_getir_ajax(Request $request){


        $notes= Note::where([
            'surah_id' => $request->surah_id,
            'ayah' => $request->ayah_id,
            'user_id' => Auth::id()
        ])->get();

        return response($notes);
    }

    public function note_getir_ajax_tekli($id){
        $note = Note::find($id);

        return response($note,200);
    }
}
