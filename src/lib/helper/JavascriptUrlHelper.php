<?php
    /**
     *
     *  URL Helper to get correct URL for EXTJS
     *
     * @param String $js, URL to call. e.g. controller/action
     * @return String, correct url
     */
    function build_dynamic_javascript_url($js) {
        if(sfContext::getInstance()->getUser()->getAttribute('env') == '') {
            return sfContext::getInstance()->getUser()->getAttribute('env') . url_for($js);
        }
        else {
            return  '/' . sfContext::getInstance()->getUser()->getAttribute('env') . url_for($js);
        }
    }
?>