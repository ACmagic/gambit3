<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false): ?>
    <?= Form::label($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>

    <?php if($type != 'hidden'): ?><div class="col-sm-10"><?php endif; ?>

        <?= Form::input($type, $name, $options['value'], $options['attr']) ?>
        <?php include 'help_block.php' ?>
        <?php include 'errors.php' ?>

    <?php if($type != 'hidden'): ?></div><?php endif; ?>

<?php endif; ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
