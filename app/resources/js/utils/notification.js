import Swal from 'sweetalert2';

export const Notification = {
    showSuccessMessage: (message, html) => Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        html,
    }),
    showErrorMessage: (message, html) => Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: message,
        html
    }),
    showBadResponseMessages: responseData => {
        if ('errors' in responseData) {
            Notification.showErrorMessage(null, Object.values(responseData.errors).flat().join('<br>'));
        } else {
            Notification.showErrorMessage('Error!');
        }
    },
};
