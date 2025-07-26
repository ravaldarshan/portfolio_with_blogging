"use strict";


function showToast(type) {
  if (toastMessages[type]) {
    iziToast[type]({
      title: type,
      message: toastMessages[type],
      position: 'topRight'
    });
  }
}
document.addEventListener("DOMContentLoaded", function () {
if (toastMessages.info) {
  showToast('info');
}
if (toastMessages.warning) {
  showToast('warning');
}
if (toastMessages.success) {
  showToast('success');
}
if (toastMessages.error) {
  showToast('error');
}
});