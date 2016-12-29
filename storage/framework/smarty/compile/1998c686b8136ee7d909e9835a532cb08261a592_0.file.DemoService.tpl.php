<?php
/* Smarty version 3.1.30, created on 2016-09-30 16:49:14
  from "D:\wamp\www\laravel\database\makecfg\views\DemoService.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57ee978ab6e283_40024490',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1998c686b8136ee7d909e9835a532cb08261a592' => 
    array (
      0 => 'D:\\wamp\\www\\laravel\\database\\makecfg\\views\\DemoService.tpl',
      1 => 1475141612,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57ee978ab6e283_40024490 (Smarty_Internal_Template $_smarty_tpl) {
echo '<?php

';?>namespace app\Services\<?php echo $_smarty_tpl->tpl_vars['moduleName']->value;?>
;

/*
 * <?php echo $_smarty_tpl->tpl_vars['className']->value;?>
Service
<?php echo $_smarty_tpl->tpl_vars['classNote']->value;?>

 */

use Illuminate\Support\Facades\Storage;
use Log;
use App\Eloquent\<?php echo $_smarty_tpl->tpl_vars['moduleName']->value;?>
\<?php echo $_smarty_tpl->tpl_vars['className']->value;?>
;
use App\Exceptions\<?php echo $_smarty_tpl->tpl_vars['moduleName']->value;?>
\<?php echo $_smarty_tpl->tpl_vars['className']->value;?>
Exception;
use App\Services\<?php echo $_smarty_tpl->tpl_vars['moduleName']->value;?>
\<?php echo $_smarty_tpl->tpl_vars['moduleName']->value;?>
Service;

class <?php echo $_smarty_tpl->tpl_vars['className']->value;?>
Service extends <?php echo $_smarty_tpl->tpl_vars['moduleName']->value;?>
Service
{
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['method']->value, 'val');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
ob_start();
echo $_smarty_tpl->tpl_vars['val']->value['isService'];
$_prefixVariable1=ob_get_clean();
if ($_prefixVariable1 == 0) {?>
   /**
   <?php echo $_smarty_tpl->tpl_vars['val']->value['methodNoteDetail'];?>

     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value['inParam'], 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
* @param  $<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
  <?php echo $_smarty_tpl->tpl_vars['v']->value['note'];?>

     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
* @return array
     <?php if (count($_smarty_tpl->tpl_vars['val']->value['inParam']) != 0) {?>* @throws <?php echo $_smarty_tpl->tpl_vars['className']->value;?>
Exception
     <?php }?>
*/
    public function <?php echo $_smarty_tpl->tpl_vars['val']->value['methodName'];?>
(<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value['inParam'], 'v', false, NULL, 'tmp', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['total'];
?>$<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];
if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['last'] : null)) {
} else { ?>,<?php }?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
) {
        $data = array();
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value['inParam'], 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
if (empty($<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
))  throw new <?php echo $_smarty_tpl->tpl_vars['className']->value;?>
Exception('<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
'.self::EMPTY_NOTE);
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
echo $_smarty_tpl->tpl_vars['val']->value['content'];?>

        return $data;
   }

<?php } else { ?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['val']->value['service'], 'service');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['service']->value) {
?>

    /**
     * <?php echo $_smarty_tpl->tpl_vars['service']->value['methodNote'];?>

     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['service']->value['inParam'], 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
* @param  $<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
  <?php echo $_smarty_tpl->tpl_vars['v']->value['note'];?>

     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
* @return array
     <?php if (count($_smarty_tpl->tpl_vars['service']->value['inParam']) != 0) {?>* @throws <?php echo $_smarty_tpl->tpl_vars['className']->value;?>
Exception
     <?php }?>
*/
   public function <?php echo $_smarty_tpl->tpl_vars['service']->value['methodName'];?>
(<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['service']->value['inParam'], 'v', false, NULL, 'tmp', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['total'];
?>$<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];
if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_tmp']->value['last'] : null)) {
} else { ?>,<?php }?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
) {
        $data = array();
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['service']->value['inParam'], 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
if (empty($<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
))  throw new <?php echo $_smarty_tpl->tpl_vars['className']->value;?>
Exception('<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
'.self::EMPTY_NOTE);
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
echo $_smarty_tpl->tpl_vars['service']->value['content'];?>

        return $data;
   }
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

}
<?php }
}
