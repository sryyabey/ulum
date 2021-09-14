@extends('layouts.admin')
@section('styles')
    <style>
        .scroll1{
            max-height: 300px;
            margin-bottom: 10px;
            overflow:scroll;
            -webkit-overflow-scrolling: touch;
        }

        .scroll2{
            max-height: 600px;
            margin-bottom: 10px;
            overflow:scroll;
            -webkit-overflow-scrolling: touch;
        }
    </style>
@endsection
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">

        </div>
    </div>
<div class="card">
    <div class="card-header">

    </div>

    <div class="card-body">

        <form action="{{ route('quran.quran') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Surah">Surah</label>
                        <select name="surah" id="surah" class="form-control select2" data-route="{{ route('ajax.getCountAyah') }}" onchange="getAyah(this)">
                            <option value=""> ----- </option>
                        @foreach($surah as $sura)
                                <option {{ $sura->id == old('surah') ? 'selected':'' }} value="{{ $sura->id }}">{{ $sura->arabic }} - {{ $sura->latin }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ayah">Ayah</label>
                        <select name="ayah[]" id="ayah" multiple class="form-control select2 select2-selection--multiple" disabled>
                            <option value="o">All</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="Getir">__</label>
                        <button class="btn btn-primary btn-block" type="submit">Go</button>
                    </div>
                </div>
            </div>
        </form>

        <hr>
        <div class="row">
            <div class="col-md-8">
                <ul class="list-group scroll2">
                    @forelse($quran as $key => $item)
                    <li data-id="{{ $item->ayah_number }}"
                        data-surah="{{ $item->surah_id }}"
                        data-text="{{ $item->ayah }}"
                        data-route="{{ route('ajax.getInfo') }}"
                        onclick="getInfo(this)" class="list-group-item text-right h4">{{ $item->ayah_number }} - {!! $item->ayah !!}</li>
                    @empty
                    @endforelse
                </ul>
            </div>
            <div id="toastr"></div>


            <div class="col-md-4 border-left">
                <p class="text-right h4" id="ayahInNote"></p>

                <ul class="nav nav-tabs nav-pills nav-fill">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" aria-current="page" href="#note"><i class="fas fa-pen"></i> Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#meal"><i class="fas fa-book"></i> Meal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tefsir"><i class="fas fa-book-open"></i> Tefsir</a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="note">
                        <div class="col-md-12">
                            <input type="hidden" name="note_ayah_id" id="note_ayah" value="">
                            <input type="hidden" name="note_surah_id" id="note_surah" value="">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="note_text" placeholder="Note ...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" data-route="{{ route('ajax.note_save') }}" id="note_save" onclick="noteSave(this)" title="Kaydet" type="button">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="notes scroll1">
                            <ul class="list-group list-group-flush" id="notes">

                            </ul>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="meal">
                        <a href="{{ route('ajax.note_delete') }}">delete note</a>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tefsir">
                        tefsir
                    </div>
                </div>




            </div>
        </div>




    </div>
</div>



@endsection
@section('scripts')

    <script src="{{ asset('js/sryya.js') }}">
    </script>


@endsection
