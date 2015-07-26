<?php
/**
 * @author Alexey Tishchenko <tischenkoalexey1@gmail.com>
 * @oDesk https://www.odesk.com/users/~01ad7ed1a6ade4e02e 
 * @website https://sjoorm.com
 * date: 2014-06-26
 */
/** @var \yii\web\View $this */
/** @var string $close */
?>
<div class="modal fade" id="jsModal" tabindex="-1" role="dialog" aria-labelledby="jsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="jsModalTitle"></h4>
            </div>
            <div class="modal-body" id="jsModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal"><?= $close ?></button>
            </div>
        </div>
    </div>
</div>
