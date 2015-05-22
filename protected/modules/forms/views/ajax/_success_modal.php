<div class="row">
    <div class="col-xs-3">
        <span class="glyphicon glyphicon-ok-sign"></span>
    </div>
    <div class="col-xs-9">
        <h4>Ваша заявка успешно отправлена!</h4>

        <?php if (isset($time_info['work_time'])) : ?>
            <?php if ($time_info['work_time']) : ?>
                <p>В течение <?=$time_info['time_to_call']?> с вами свяжется наш специалист.</p>
            <?php else: ?>
                <p>К сожалению, в данный момент мы не можем вам перезвонить, так как наш офис не работает.</p>
                <p>Офис работает с <?=$time_info['openTime']?> до <?=$time_info['endTime']?> по московскому времени.</p>
                <p><strong>Через <?=$time_info['time_to_call']?> с вами свяжется наш специалист.</strong></p>
            <?php endif; ?>
        <?php endif; ?>
        <p>Большое спасибо за оставленную заявку.</p>

    </div>
</div>