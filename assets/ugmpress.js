function toastr_view(param){
  toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "500",
      "hideDuration": "500",
      "timeOut": "2000",
      "extendedTimeOut": "1000",
      "showEasing": "linear",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
  };
  if(param == '1'){
    toastr.success('Penulis berhasil dipilih');
  }else if(param == '2'){
    toastr.success('Penulis dihapus');
  }else if(param == '3'){
    toastr.success('Reviewer berhasil dipilih');
  }else if(param == '4'){
    toastr.success('Reviewer dihapus');
  }else if(param == '5'){
    toastr.success('Editor berhasil dipilih');
  }else if(param == '6'){
    toastr.success('Editor dihapus');
  }else if(param == '7'){
    toastr.success('Layouter berhasil dipilih');
  }else if(param == '8'){
    toastr.success('Layouter dihapus');
  }else if(param == '11'){
    toastr.error('Penulis sudah terpilih');
  }else if(param == '22'){
    toastr.error('Reviewer sudah terpilih');
  }else if(param == '33'){
    toastr.error('Editor sudah terpilih');
  }else if(param == '44'){
    toastr.error('Layouter sudah terpilih');
  }else if(param == '99'){
    toastr.error('Reviewer max 2');
  }else if(param == '111'){
    toastr.success('Data Saved');
  }else if(param == '000'){
    toastr.error('Failed to Save');
  }else if(param == 'penilaian'){
    toastr.error('Lengkapi nilai review');
  }else if(param == 'flag'){
    toastr.error('Rekomendasi dibutuhkan');
  }
}

// // Datepicker

// $(".date").datepicker({
//     changeMonth: true,
//     changeYear: true,
//     yearRange: '1970:+5',
//     dateFormat: "yy-mm-dd",
//     firstDay: 1
// });


// siswaAutocomplete (Ajax)
function reviewerAutoComplete() {
    var min_length = 0; // min characters to display the autocomplete
    var key = $('#search_reviewer').val();
    if (key.length >= min_length) {
        $.ajax({
            url: 'http://localhost/ugmpress/draftreviewer/reviewer_auto_complete',
            type: 'POST',
            data: {key:key},
            success:function(data){
                $('#reviewer_list').show();
                $('#reviewer_list').html(data);
            }
        });
    } else {
        $('#reviewer_list').hide();
    }
}

//// siswaAutocomplete (Ajax)
//function siswaAutoComplete() {
//    var min_length = 0; // min characters to display the autocomplete
//    var keywords = $('#search_siswa').val();
//    if (keywords.length >= min_length) {
//        $.ajax({
//            url: 'http://ciperpus306.dev/peminjaman/siswa_auto_complete',
//            type: 'POST',
//            data: {keywords:keywords},
//            success:function(data){
//                $('#siswa_list').show();
//                $('#siswa_list').html(data);
//            }
//        });
//    } else {
//        $('#siswa_list').hide();
//    }
//}

//// bukuAutocomplete (Ajax)
//function bukuAutoComplete() {
//    var min_length = 0; // min characters to display the autocomplete
//    var keywords = $('#search_buku').val();
//    if (keywords.length >= min_length) {
//        $.ajax({
//            url: 'http://localhost/ugmpress/peminjaman/buku_auto_complete',
//            type: 'POST',
//            data: {keywords:keywords},
//            success:function(data){
//                $('#buku_list').show();
//                $('#buku_list').html(data);
//            }
//        });
//    } else {
//        $('#buku_list').hide();
//    }
//}

// setItem : Change the value of input when "clicked"
function setItemReviewer(item) {
    // change input value
    $('#search_reviewer').val(item);
    $('#reviewer_list').hide();
}


//// setItem : Change the value of input when "clicked"
//function setItemSiswa(item) {
//    // change input value
//    $('#search_siswa').val(item);
//    $('#siswa_list').hide();
//function setItemBuku(item) {
//    // change input value
//    $('#search_buku').val(item);
//    $('#buku_list').hide();
//}

// Create input "reviewer_id" if not exist, otherwise set it's value
function makeHiddenIdReviewer(nilai) {
    if ($("#reviewer-id").length > 0) {
        $("#reviewer-id").attr('value', nilai);
    } else {
        str = '<input type="hidden" id="reviewer-id" name="reviewer_id" value="'+nilai+'" />';
        $("#form_draftreviewer").append(str);
    }
}


// Create input "id_siswa" if not exist, otherwise set it's value
function makeHiddenIdSiswa(nilai) {
    if ($("#id-siswa").length > 0) {
        $("#id-siswa").attr('value', nilai);
    } else {
        str = '<input type="hidden" id="id-siswa" name="id_siswa" value="'+nilai+'" />';
        $("#form-peminjaman").append(str);
    }
}

// Create input "id_buku" if not exist, otherwise set it's value
//function makeHiddenIdBuku(nilai) {
//    if ($("#id-buku").length > 0) {
//        $("#id-buku").attr('value', nilai);
//    } else {
//        str = '<input type="hidden" id="id-buku" name="id_buku" value="'+nilai+'" />';
//        $("#form-peminjaman").append(str);
//    }
//}
