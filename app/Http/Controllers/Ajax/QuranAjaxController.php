<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Quran;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuranAjaxController extends Controller
{
    public function getCountAyah($id){
        $surah = Quran::where('surah_id',$id)->count();
        return response($surah,200);
    }

    public function getInfo(Request $request){
        if ($request->has('islem')){
            if ($request->islem== 1){
                $ayah = $request->ayah;
                $surah = $request->surah;

                $notes = Note::where([
                    'ayah' => $ayah,
                    'surah_id' => $surah,
                    'user_id' => Auth::id()
                ])->orderBy('created_at','desc')->get();
                return response($notes,200);
            }
        }

    }
}
