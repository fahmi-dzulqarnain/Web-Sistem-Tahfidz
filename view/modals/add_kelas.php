<?php $pengampu = $mysqli->query("SELECT * FROM tbl_pengampu"); ?>

<div class="modal__container" id="modal-container">
    <div class="modal__content" title="Close">
        <i class="fas fa-times modal__close close-modal-btn"></i>

        <div class="title">Tambah Kelas</div>

        <form id="kelasForm" action="atur_santri.php" class="flex-column" method="post" enctype="multipart/form" style="margin-top: 24px;">
            <div >
                <input class="text-form col-half" type="text" name="txtNamaKelas" placeholder="Nama Kelas...">
                <select class="text-form col-half" name="txtWaliKelas" form="kelasForm">
                    <option selected disabled hidden>Pilih Wali Kelas...</option>
                    <?php while ($row = $pengampu->fetch_assoc()): ?>
                    <option><?php echo $row['nama_lengkap']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button class="button close-modal-btn" name="btnAddKelas" style="margin: auto;">
                Tambah
            </button>
        </form>


    </div>
</div>