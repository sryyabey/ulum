// ayet sayısı getir select olarak append et
function getAyah(ths){
    console.log(ths)
    let id = $(ths).val();
    let yol = $(ths).data('route')+"/"+id;
    $.ajax({
        method:"GET",
        url:yol,
        success:function (res){
            $("#ayah").empty().prop('disabled',false).append("<option value='0'>ALL</option>");
            for (let i = 1; i <= res; i++){
                $("#ayah").append("<option value="+i+">"+i+"</option>")
            }
        }
    })
}

function getInfo(ths){
    let ayah_id = $(ths).data('id');
    let surah_id = $(ths).data('surah');
    let route = $(ths).data('route');
    let ayah = $(ths).data('text');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $("#ayahInNote").html(ayah)
    $('#note_ayah').val(ayah_id);
    $('#note_surah').val(surah_id);

    $.ajax({
        method: "POST",
        url: route,
        data:{
            "islem":1,
            "ayah":ayah_id,
            "surah":surah_id,
            _token: CSRF_TOKEN,
        },
        success:function (res){
            $("#notes").empty();
            $.each(res, function(index, value) {
                $("#notes").append("<li class='list-group-item' id='note_id-"+value.id+"' data-id='"+value.id+"'><div class='row'><div class='col-md-8'>"+value.note+"</div>" +
                    "<div class='col-md-4'><a href='' title='Edit' class='text-info'><i class='fas fa-edit'></i></a> / " +
                    "<span title='Delete' onclick='noteDelete(this)' data-id='"+value.id+"' class='text-danger'><i class='fas fa-trash'></i></span></div>" +
                    "</div></li>");
            });
        }
    })

}

function noteSave(ths){
    let ayah_id = $("#note_ayah").val();
    let surah_id = $("#note_surah").val();
    let note_text = $("#note_text").val();
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    let route = $(ths).data('route');
    $("#note_text").val(null);

    $.ajax({
        method:"POST",
        url:route,
        data:{
            'ayah_id':ayah_id,
            'surah_id':surah_id,
            'note_text':note_text,
            _token:CSRF_TOKEN
        },
        success:function (res){
            $('#notes').prepend("<li class='list-group-item' id='note_id-"+res['id']+"' data-id='"+res['id']+"'><div class='row'><div class='col-md-8'>"+res['note']+"</div>" +
                "<div class='col-md-4'><a href='' title='Edit' class='text-info'><i class='fas fa-edit'></i></a> / " +
                "<span title='Delete' onclick='noteDelete(this)' data-id='"+res['id']+"' class='text-danger'><i class='fas fa-trash'></i></span></div>" +
                "</div></li>")


        }
    })



}

function noteDelete(ths){
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    let id = $(ths).data('id')
    console.log(id)

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method:"POST",
                url:"../ajax/note_delete",
                data:{
                    "id":id,
                    _token:CSRF_TOKEN
                },success:function (res){
                    $("#note_id-"+id).hide();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            });

        }
    })


}
