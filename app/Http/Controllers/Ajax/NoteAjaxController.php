<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class NoteAjaxController extends Controller
{
    public function note_save(Request $request){
        $save = Note::create([
            'ayah' => $request->ayah_id,
            'surah_id' => $request->surah_id,
            'note' => $request->note_text,
            'user_id' => Auth::id()
        ]);


        return response($save);
    }

    public function note_delete(Request $request){
        $delete= Note::find($request->id);
        $delete->delete();



        return response($delete,200);
    }
}
