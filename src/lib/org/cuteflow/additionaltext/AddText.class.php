<?php
/**
 * Class that handles the additionaltext operation
 *
 * @author Manuel Schäfer
 */
class AddText {


    public function  __construct() {
         sfLoader::loadHelpers('I18N');
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
            $result[$a]['contenttype'] = $context->getI18N()->__($item->getContenttype(),null,'additionaltext');
            $result[$a]['rawcontenttype'] = $item->getContenttype();
            $result[$a]['content'] = $item->getContent();
            $result[$a]['isactive'] = $item->getIsactive();
            $result[$a++]['id'] = $item->getId();
        }
        return $result;
    }


}
?>