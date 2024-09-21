$(document).ready(function (){
    $(".remove-btn").click(function (e){

        var $data_url = $(this).data("url");

        Swal.fire({
            title: "Kaydı silmek istediğinizden emin misiniz?",
            text: "Bu işlemi geri alamayacaksınız!",
            icon: "uyarı",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Evet, Sil!",
            cancelButtonText: "Hayır"
        }).then((result) => {
            if (result.isConfirmed) {

                window.location.href = $data_url;

                /*Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });*/
            }
        });
    })
})