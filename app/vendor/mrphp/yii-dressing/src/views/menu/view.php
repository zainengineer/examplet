<?php
/**
 * @var $this MenuController
 * @var $menu YdMenu
 */

$this->pageTitle = $this->pageHeading = $menu->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'View');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Menus')] = Yii::app()->user->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[] = $menu->getName();

$this->renderPartial('dressing.views.menu._menu', array(
    'menu' => $menu,
));
?>

<div class="row">
    <div class="span6">
        <?php
        $attributes = array();
        $attributes[] = 'id';
        $attributes[] = array(
            'name' => 'parent',
            'value' => $menu->parent ? $menu->parent->getLink() : null,
            'type' => 'raw',
        );
        $attributes[] = 'label';
        $attributes[] = 'icon';
        $attributes[] = 'url';
        $attributes[] = 'url_params';
        $attributes[] = 'target';
        $attributes[] = 'access_role';
        $attributes[] = 'created';
        $attributes[] = 'enabled';

        $this->widget('dressing.widgets.YdDetailView', array(
            'data' => $menu,
            'attributes' => $attributes,
        ));
        ?>
    </div>
    <div class="span6">
        <?php
        // actions
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('dressing', 'Create Menu Item'),
            'url' => array('/menu/create', 'Menu[parent_id]' => $menu->id),
            'type' => 'primary',
            'size' => 'mini',
        ));
        echo '<br/><br/>';

        // menuItems
        $sortables = array();
        foreach ($menu->child as $_menu) {
            $sortables[$_menu->id] = '<i class="icon-move handle" title="' . Yii::t('dressing', 'Move') . '"></i> ' . $_menu->getLink();
        }
        $this->widget('zii.widgets.jui.CJuiSortable', array(
            'items' => $sortables,
            'id' => 'sortable-menu-' . $menu->id,
            'htmlOptions' => array('class' => 'unstyled'),
            'options' => array(
                'handle' => '.handle',
                'beforeStop' => 'js: function() { jQuery.post("' . CHtml::normalizeUrl(array('/menu/order')) . '",{ Order:$("#sortable-menu-' . $menu->id . '.ui-sortable").sortable("toArray").toString() }); }',
            ),
        ));
        ?>
    </div>
</div>