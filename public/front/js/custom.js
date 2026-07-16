// GZIP KISMI AYARLANMA ISLEMMI YAPILDI. (YAZI DETAY SAYFASI HARIC)

// AJAX SETUP
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// USER OP
$(".userOp").change(function () {
    var data = $(this).val();
    window.location.href = data;
});

// YAZI DETAY KISMI AYARLAMALARINI YAPALIM

// YORUM BEĞENME ISLEMI
$(".commentLike").click(function () {
    var comment = $(this).data("comment");
    var url = $(this).data("url");
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            comment: comment,
            status: 1
        },
        success: function (e) {
            // $(".likeButton-" + comment).toggleClass("isLike");
            // $(".disslikeButton-" + comment).removeClass("isDissLike");
            location.reload();
        },
        error: function (e) {
            console.log(e);
        }
    });
});

// YORUM BEĞENMEME ISLEMI
$(".commentDisslike").click(function () {
    var url = $(this).data("url");
    var comment = $(this).data("comment");
    $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            comment: comment,
            status: -1
        },
        success: function (e) {
            // $(".likeButton-" + comment).removeClass("isLike");
            // $(".disslikeButton-" + comment).toggleClass("isDissLike");

            location.reload();
        },
        error: function (e) {
            console.log(e);
        }
    });
});

// YORUM SILME KISMI AYARLAMASI
$(".commentDelete").click(function () {
    var comment = $(this).data("comment");
    var url = $(this).data("url");
    Swal.fire({
        title: 'Dikkat!',
        text: "Yorumunuz Silinecektir. Onaylıyor Musunuz ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Evet',
        cancelButtonText: 'Hayır'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    comment: comment
                },
                success: function (e) {
                    location.reload();
                },
                error: function (e) {
                    // console.log(e);
                    swal({
                        title: "Hata!",
                        text: "Bir Hata Oluştu. Lütfen Daha Sonra Tekrar Deneyiniz",
                        type: "error",
                        timer: 3000
                    });
                }
            });
        }
    })
});

// DOĞRU CEVAP KISMI AYARLAMA ISLEMI
$(".isCorrect").click(function () {
    var comment = $(this).data("comment");
    var question = $(this).data("question");
    var url = $(this).data("url");
    $.ajax({
        type: "POST",
        url: url,
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            comment: comment,
            question: question
        },
        success: function (e) {
            location.reload();
        },
        error: function (e) {
            console.log(e);
        }
    });
});


// YAZI KISMI BEĞENME VE BEĞENMEME ISLEMINI AYARLAYALIM
$(".questionLike").click(function () {
    var url = $(this).data("url");
    $.ajax({
        type: "GET",
        url: url,
        data: {
            status: 1
        },
        success: function (e) {
            location.reload();
        },
        error: function (e) {
            console.log(e);
        }
    });
});

// YAZI KISMI BEĞENMEME ISLEMINI AYARLAYALIM
$(".questionDisslike").click(function () {
    var url = $(this).data("url");
    $.ajax({
        type: "GET",
        url: url,
        data: {
            status: -1
        },
        success: function (e) {
            location.reload();
        },
        error: function (e) {
            console.log(e);
        }
    });
});

// YAZI SILME KISMI AYARLAMA
$(".deleteQuestion").click(function () {
    var url = $(this).data("url");
    Swal.fire({
        title: 'Dikkat!',
        text: "Sorunuz Silinecektir. Onaylıyor Musunuz ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Evet, Bunu Sil!',
        cancelButtonText: 'Vazgeç'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: url,
                data: {},
                success: function (e) {
                    if (e == 1) {
                        Swal.fire(
                            'Başarılı!',
                            'Sorunuz Başarıyla Silindi',
                            'success'
                        ).then((result) => {
                            window.location.href = "{{ route('front.index') }}";
                        })
                    } else {
                        Swal.fire(
                            'Hata!',
                            'Sorunuz Silinirken Hata Oluştu',
                            'error'
                        ).then((result) => {
                            location.reload();
                        })
                    }
                }
            });
        }
    })
});


// SORU KAYDETME KISMI AYARLAMASINI YAPALIM
$(".saveQuestion").click(function () {
    var url = $(this).data("url");
    $.ajax({
        type: "POST",
        url: url,
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (e) {
            location.reload();
        },
        error: function (e) {
            console.log(e);
        }
    });
});
