<div class="row">
    <div class="col-xs-3">
        <span class="glyphicon glyphicon-remove-sign"></span>
    </div>
    <div class="col-xs-9">
        <h4>Не удалось отправить заявку</h4>

        <?php if ($error_type == 'server') : ?>
            <p>Произошла ошибка почтового сервера.</p>
        <?php elseif ($error_type == 'validation') : ?>
            <p>При отправке формы произошла ошибка валидации.</p>
        <?php endif; ?>
        <p>Попробуйте отправить заявку еще раз чуть позже.</p>
    </div>
</div>