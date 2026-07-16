$(".userOp").change(function () {
    var data = $(this).val();
    if (data == "cikis") {
        // ÇIKIŞ YAP
        window.location.href = "{{ route('front.signin.logout') }}";
    } else if (data == "hesabim") {
        // HESANNIM SAYFASI
        window.location.href = "{{ route('front.hesabim.index') }}";
    } else if (data == "bildirimler") {
        // BILDIRIMLER SAYFASI
        window.location.href = "{{ route('front.hesabim.notifications') }}";
    } else if (data == "kaydettiklerim") {
        // KAYIT ETTİĞM SORULAR KISMI
        window.location.href = "{{ route('front.hesabim.save_questions') }}";
    }
});
