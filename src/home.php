<?php
if ($core->_vars['user']['ga'] == 3) {
    include 'tabloides.php';
} else {
    include 'tabloidesap.php';
}

?>
