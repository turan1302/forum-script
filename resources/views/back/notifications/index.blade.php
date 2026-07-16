@extends('back.layout.master')

@section('css')
    <!-- SORTABLE -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

    <!-- TOGGLE -->
    <link href="{{ asset('back') }}/css/toggle.css" rel="stylesheet">

    <link href="{{ asset('back') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tüm Bildirimler</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bildirim Listesi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered yajra-datatable" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th><i class="fa fa-bars"></i></th>
                        <th>#</th>
                        <th>İşlem</th>
                        <th>Gönderici Üye</th>
                        <th>Alıcı Üye</th>
                        <th>Okunma Durumu</th>
                        <th>Açıklama</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody class="sortable">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <!-- Page level plugins -->
    <script src="{{ asset('back') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('back') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- SSWEET ALERT -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SORTABLE JS -->
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

    <script>
        // YAJRA DATATABLE ISLEMINI AYARLAYALIM
        $(document).ready(function () {
            var table = $('.yajra-datatable').DataTable({

                processing: true,
                serverSide: true,

                ajax: {
                    type: "POST",
                    url: "{{ route('back.notifications.data') }}",
                    error : function (e){
                        console.log(e);
                    }
                },
                columns: [
                    {data: 'sira', name: 'sira',orderable : true},
                    {data: 'id', name: 'id'},
                    {data: 'type', name: 'type'},
                    {data: 'gonderici', name: 'gonderici'},
                    {data: 'alici', name: 'alici'},
                    {data: 'status', name: 'status'},
                    {data: 'text', name: 'text'},
                    {data: 'actions', name: 'actions'},
                ],
                "fnCreatedRow" : function (nRow,aData,iDataIndex) {
                    $(nRow).attr("id","item-"+aData.id);
                }


            });

            // IS ACTIVE KISMINI AYARLAYALIM
            $(".yajra-datatable").on("change", ".isActive", function () {
                var data = $(this).prop("checked");
                var data_url = $(this).data("url");
                $.ajax({
                    type: "PATCH",
                    url: data_url,
                    data: {
                        data: data
                    }
                });
            });

            // DELETE KISMI AYARLAMSI
            $(".yajra-datatable").on("click", ".isDelete", function () {
                var data_url = $(this).data("url");
                Swal.fire({
                    title: 'Dikkat!',
                    text: "Kayıt Silinecektir. Onaylıyor Musunuz ? (Bu işlem geri alınamaz)",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, Kaydı Sil!',
                    cancelButtonText: 'Vazgeç',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: data_url,
                            data: {},
                            success: function () {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'İşlem Başarılı. Lütfen Bekleyin',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(()=>{
                                    location.reload();
                                });
                            },
                            error : function (e) {
                                console.log(e);
                            }
                        })
                    }
                })
            });
        });
    </script>
@endsection
