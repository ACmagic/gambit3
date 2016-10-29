<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showField && !$options['is_child']): ?>

    <?= Form::radio($name, $options['value'], $options['checked'], $options['attr']) ?>

    <?php include 'help_block.php' ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false): ?>
    <?php if ($options['is_child']): ?>
        <label>
            <?= Form::radio($name, $options['value'], $options['checked'], $options['attr']) ?>
            <?= $options['label'] ?>
            <?php include 'help_block.php' ?>
        </label>
    <?php else: ?>
        <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
    <?php endif; ?>
<?php endif; ?>

        <?php include 'errors.php' ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
