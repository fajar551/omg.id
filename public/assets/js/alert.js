const Toast2 = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: true,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

const ToastDelete = Swal.mixin({
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    confirmButtonText: "Ya, hapus!",
    cancelButtonText: 'Batal',
    customClass: {
      confirmButton: 'btn btn-danger me-3',
      cancelButton: 'btn btn-secondary'
    },
    buttonsStyling: false
});

const ToastConfirm = Swal.mixin({
    icon: "warning",
    showCancelButton: true,
    showConfirmButton: true,
    confirmButtonText: "Ya, lanjutkan!",
    cancelButtonText: 'Batal',
    customClass: {
      confirmButton: 'btn btn-primary me-3',
      cancelButton: 'btn btn-secondary'
    },
    buttonsStyling: false
});