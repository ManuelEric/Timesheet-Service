import Swal from 'sweetalert2';

export const showLoading = (message='Please wait...') => {
  Swal.fire({
    title: message,
    text: 'Processing...',
    width: '400px',
    allowOutsideClick: false,
    showConfirmButton: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });
}

export const showNotif = (status, message, position='top-end') => {
  const Toast = Swal.mixin({
    toast: true,
    position: position,
    showConfirmButton: false,
    width: '400px',
    timer: 3000,
    timerProgressBar: true,
    didOpen: toast => {
      toast.onmouseenter = Swal.stopTimer
      toast.onmouseleave = Swal.resumeTimer
    },
  })

  Toast.fire({
    icon: status,
    title: message,
  })
}

// Fungsi untuk konfirmasi sebelum mengirimkan data
export const confirmBeforeSubmit = async message => {
  const result = await Swal.fire({
    icon: 'info',
    title: 'Confirmation',
    width: 450,
    text: message,
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'No, Cancel',
    confirmButtonColor: "#aac2ff",
    cancelButtonColor: "#ffaaaa",
  })

  return result.isConfirmed
}

export default { showNotif, confirmBeforeSubmit, showLoading }
