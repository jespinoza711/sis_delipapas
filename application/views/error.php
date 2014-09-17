<div class="modal-dialog demo-modal">
    <div class="modal-content panel panel-<?= $panel ?>">
        <div class="modal-header panel-heading">
            <h4 class="modal-title"><?= $encabezado ?></h4>
        </div>
        <div class="modal-body">
            <ul>
                <?php foreach ($cuerpo as $mensaje) {  ?>
                    <li><?= $mensaje ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>