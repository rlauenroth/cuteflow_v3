<?php

/**
 * Class that handles the additionaltext operation
 *
 * @author Manuel Schäfer
 */
class AddText
{

    /**
     * Function creates data for displaying all additional textes in datagrid
     * 
     * @param Doctrine_Collection $data, all records for grid
     * @param sfContext $context, context object
     * @return array $resultset, resultset.
     */
    public function buildAllText(Doctrine_Collection $data, sfContext $context)
    {

        $a = 0;
        $result = array();
        foreach ($data as $item) {
            $result[$a] = $item->toArray();
            $result[$a]['#'] = $a + 1;
            $result[$a]['content_type'] = $context->getI18N()->__($item->getContentType(), null, 'additionaltext');
            $result[$a]['raw_content_type'] = $item->getContentType();
            $a++;
        }
        return $result;
    }


}
