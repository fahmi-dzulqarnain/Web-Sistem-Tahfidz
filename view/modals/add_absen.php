<div class="modal__container" id="modal-container">
    <div class="modal__content" title="Close">
        <i class="fas fa-times modal__close close-modal-btn"></i>

        <div class="title">Tambah Absen</div>

        <form id="absenForm" action="user_absen.php" class="flex-column" method="post" enctype="multipart/form" style="margin-top: 24px;">
            <div >
                <input class="text-form col-half" type="date" name="txtDate" placeholder="Pilih Tanggal...">
            </div>

            <button class="button close-modal-btn" name="btnAddAbsen" style="margin: auto;">
                Tambah
            </button>
        </form>
    </div>
</div>