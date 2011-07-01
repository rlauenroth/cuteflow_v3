<?php
/**
 * Class that handles the additionaltext operation
 *
 * @author Manuel Schäfer
 */
class AddText {


    public function  __construct() {

    }

    /**
     * Function creates data for displaying all additional textes in datagrid
     * 
     * @param Doctrine_Collection $data, all records for grid
     * @param sfContext $context, context object
     * @return array $resultset, resultset.
     */
    public function buildAllText(Doctrine_Collection $data, sfContext $context) {
        $a = 0;
        $result = array();
        foreach($data as $item) {
            $result[$a]['#'] = $a+1;
            $result[$a]['title'] = $item->getTitle();
            $result[$a]['content_type'] = $context->getI18N()->__($item->getContentType(),null,'additionaltext');
            $result[$a]['rawcontenttype'] = $item->getContentType();
            $result[$a]['content'] = $item->getContent();
            $result[$a]['is_active'] = $item->getIsActive();
            $result[$a++]['id'] = $item->getId();
        }
        return $result;
    }


}
?>