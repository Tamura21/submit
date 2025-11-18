// 削除確認モーダル機能
document.addEventListener('DOMContentLoaded', function () {
    const delete_buttons = document.querySelectorAll('.delete-button');
    const delete_modal = document.getElementById('deleteModal');
    const confirm_delete = document.getElementById('confirmDelete');
    const cancel_delete = document.getElementById('cancelDelete');
    let current_form = null;

    // 削除ボタンをクリックしたときの処理
    delete_buttons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            current_form = this.closest('form');
            delete_modal.classList.remove('hidden');
        });
    });

    // モーダルの「削除」ボタンをクリックしたときの処理
    confirm_delete.addEventListener('click', function () {
        if (current_form) {
            current_form.submit();
        }
    });

    // モーダルの「キャンセル」ボタンをクリックしたときの処理
    cancel_delete.addEventListener('click', function () {
        delete_modal.classList.add('hidden');
        current_form = null;
    });

    // モーダルの背景をクリックしたときの処理
    delete_modal.addEventListener('click', function (e) {
        if (e.target === delete_modal) {
            delete_modal.classList.add('hidden');
            current_form = null;
        }
    });
});