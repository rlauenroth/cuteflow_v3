<input type="hidden" id="url_login" value="<?php echo url_for('login/index'); ?>">
<input type="hidden" id="hidden_loadlanguage" value="<?php echo url_for('login/loadLanguage'); ?>">
<input type="hidden" id="url_installer" value="<?php echo url_for('installer/index'); ?>">
<input type="hidden" id="url_save" value="<?php echo url_for('installer/saveData'); ?>">
<input type="hidden" id="url_check" value="<?php echo url_for('installer/checkConnection'); ?>">



<script type="text/javascript" src="/js/i18n/<?php echo Login::buildExtjsLanguage($sf_user->getCulture());?>/ext-lang.js"/>
