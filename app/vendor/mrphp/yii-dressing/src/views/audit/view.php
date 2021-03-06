<?php
/**
 * @var $this AuditController
 * @var $audit YdAudit
 */
$this->pageTitle = $this->pageHeading = $audit->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'View');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Audits')] = Yii::app()->user->getState('index.audit', array('/audit/index'));
$this->breadcrumbs[] = $audit->getName();

$this->renderPartial('dressing.views.audit._menu', array(
    'audit' => $audit,
));

?>

<div>

    <fieldset>
        <legend><?php echo $this->getName() . ' ' . Yii::t('dressing', 'Details') ?></legend>
        <?php

        $attributes = array();
        $attributes[] = array(
            'name' => 'id',
            'value' => ' audit-' . $audit->id,
        );
        $attributes[] = array(
            'name' => 'link',
            'value' => CHtml::link(urldecode($audit->link), urldecode($audit->link)),
            'type' => 'raw',
        );
        $attributes[] = array(
            'name' => 'referrer',
            'value' => CHtml::link(urldecode($audit->referrer), urldecode($audit->referrer)),
            'type' => 'raw',
        );
        $attributes[] = array(
            'name' => 'redirect',
            'value' => CHtml::link(urldecode($audit->redirect), urldecode($audit->redirect)),
            'type' => 'raw',
        );
        $attributes[] = array(
            'name' => 'created',
            'value' => $audit->created,
            'type' => 'raw',
        );
        $attributes[] = array(
            'name' => 'total_time',
        );
        $attributes[] = array(
            'name' => 'memory_usage',
            'value' => number_format($audit->memory_usage, 0),
        );
        $attributes[] = array(
            'name' => 'memory_peak',
            'value' => number_format($audit->memory_peak, 0),
        );
        $attributes[] = array(
            'name' => 'ip',
        );
        $attributes[] = array(
            'name' => 'user_id',
            'label' => 'user',
            'type' => 'raw',
            'value' => $audit->user ? ('user-' . $audit->user->id . '  ' . CHtml::link(h($audit->user->name), $audit->user->url)) : null,
        );
        $attributes[] = array(
            'name' => 'preserve',
            'value' => $audit->preserve ? Yii::t('dressing', 'This audit is Preserved.') . ' - ' . CHtml::link('Remove Preserve', array('/audit/preserve', 'id' => $audit->id, 'status' => 0))
                : CHtml::link('Preserve Values', array('/audit/preserve', 'id' => $audit->id, 'status' => 1)),
            'type' => 'raw',
        );


        $this->widget('dressing.widgets.YdDetailView', array(
            'data' => $audit,
            'attributes' => $attributes,
        ));
        ?>
    </fieldset>

    <fieldset>
        <legend><?php echo Yii::t('dressing', 'Audit Trail') ?></legend>
        <?php
        $auditTrail = new AuditTrail('search');
        if (isset($_GET['AuditTrail'])) {
            $auditTrail->attributes = $_GET['AuditTrail'];
        }
        $auditTrail->audit_id = $audit->id;
        $this->renderPartial('dressing.views.auditTrail._grid', array(
            'auditTrail' => $auditTrail,
        ));
        ?>
    </fieldset>

    <fieldset>
        <legend><?php echo Yii::t('dressing', 'Version Settings') ?></legend>
        <?php
        $this->widget('dressing.widgets.YdDetailView', array(
            'data' => $audit,
            'attributes' => array(
                array(
                    'name' => 'app_version',
                ),
                array(
                    'name' => 'yii_version',
                ),
            ),
        ));
        ?>
    </fieldset>

    <fieldset>
        <legend><?php echo Yii::t('dressing', 'Page Variables') ?></legend>
        <?php
        $this->widget('dressing.widgets.YdDetailView', array(
            'data' => $audit,
            'attributes' => array(
                array(
                    'label' => '$_GET',
                    'value' => '<pre>' . print_r($audit->unpack('get'), true) . '</pre>',
                    'type' => 'raw',
                ),
                array(
                    'label' => '$_POST',
                    'value' => '<pre>' . print_r($audit->unpack('post'), true) . '</pre>',
                    'type' => 'raw',
                ),
                array(
                    'label' => '$_FILES',
                    'value' => '<pre>' . print_r($audit->unpack('files'), true) . '</pre>',
                    'type' => 'raw',
                ),
            ),
        ));
        ?>
    </fieldset>

    <fieldset>
        <legend><?php echo Yii::t('dressing', 'Session and Cookies') ?></legend>
        <a href='javascript:void(0)' onclick="$('#show_session_detail').show('slow');$('#show_session').hide();"
           id='show_session'>Show</a>

        <div id='show_session_detail' style="display: none;">
            <a href='javascript:void(0)'
               onclick="$('#show_session_detail').hide('hide');$('#show_session').show();">Hide</a>
            <?php
            $this->widget('dressing.widgets.YdDetailView', array(
                'data' => $audit,
                'attributes' => array(
                    array(
                        'label' => '$_SESSION',
                        'value' => '<pre>' . print_r($audit->unpack('session'), true) . '</pre>',
                        'type' => 'raw',
                    ),
                    array(
                        'label' => '$_COOKIE',
                        'value' => '<pre>' . print_r($audit->unpack('cookie'), true) . '</pre>',
                        'type' => 'raw',
                    ),
                ),
            ));
            ?>
        </div>
    </fieldset>

    <fieldset>
        <legend><?php echo Yii::t('dressing', 'Server Data') ?></legend>
        <a href='javascript:void(0)' onclick="$('#show_server_detail').show('slow');$('#show_server').hide();"
           id='show_server'>Show</a>

        <div id='show_server_detail' style="display: none;">
            <a href='javascript:void(0)'
               onclick="$('#show_server_detail').hide('hide');$('#show_server').show();">Hide</a>
            <?php
            $this->widget('dressing.widgets.YdDetailView', array(
                'data' => $audit,
                'attributes' => array(
                    array(
                        'label' => '$_SERVER',
                        'value' => '<pre>' . print_r($audit->unpack('server'), true) . '</pre>',
                        'type' => 'raw',
                    ),
                ),
            )); ?>
        </div>
    </fieldset>

    <?php if ($audit->error) { ?>
        <fieldset>
            <legend><?php echo Yii::t('dressing', 'Error');
                if ($audit->error_code) echo '-' . $audit->error_code ?></legend>
            <a href='javascript:void(0)' onclick="$('#show_error_detail').show('slow');$('#show_error').hide();"
               id='show_error'>Show</a>

            <div id='show_error_detail' style="display: none;">
                <a href='javascript:void(0)'
                   onclick="$('#show_error_detail').hide('hide');$('#show_error').show();">Hide</a>
                <?php
                $contents = $audit->unpack('error');
                $contents = str_replace('class="container"', 'class="container-fluid"', $contents);
                if (strpos($contents, '<body>')) {
                    $contents = StringHelper::getBetweenString($contents, '<body>', '</body>');
                    Yii::app()->clientScript->registerCss('error', file_get_contents(dirname($this->getViewFile('/error/index')) . '/view.css'));
                }
                else {
                    $contents = '<pre>' . $contents . '</pre>';
                }
                echo $contents;
                ?>
            </div>
        </fieldset>
    <?php } ?>

</div>
