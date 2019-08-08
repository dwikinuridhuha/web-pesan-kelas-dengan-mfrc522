function myFunction() {
    var x = document.getElementById('myTopNav');
    if(x.className === 'topnav') {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

function validasiBrow() {
    var hariIni = new Date();

    var dd = String(hariIni.getDate()).padStart(2, '0');
    var mm = String(hariIni.getMonth() + 1).padStart(2, '0');
    var yyyy = hariIni.getFullYear();
    var tanggalSekarang = yyyy + '-' + mm + '-' + dd;

    var jam = String(hariIni.getHours()).padStart(2, '0');
    var menit = String(hariIni.getMinutes()).padStart(2, '0');
    var detik = String(hariIni.getSeconds());
    var jamSekarang = jam + ":" + menit + ":" + detik;

    var jamMulai = document.getElementById('jamMulai').value;
    var jamSelesai = document.getElementById('jamSelesai').value;
    var tanggal = document.getElementById('tanggal').value;

    if((jamMulai < jamSelesai) && (tanggalSekarang < tanggal)) {
        alert('berhasil');
        return true;
    } else if((tanggal === tanggalSekarang) && (jamSekarang < jamMulai) && (jamMulai < jamSelesai)) {
        alert('berhasil');
        return true;
    } else {
        alert('jam atau tanggal ada yang salah');
        return false;
    }
}

(function ($) {
    "use strict";

    /*==================================================================
    [ Focus input ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    });
  
  
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    /*==================================================================
    [ Show pass ]*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $(this).next('input').attr('type','text');
            $(this).addClass('active');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).removeClass('active');
            showPass = 0;
        }
    });

})(jQuery);