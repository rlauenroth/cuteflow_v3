<?php
class FilterManagement {



    public function  __construct() {
        
    }

    /**
     *
     * @param Doctrine_Collection $filter, data with all filters
     * @return array $result
     */
    public function buildFilter(Doctrine_Collection $filter) {
        $result = array();
        $result = $filter[0]->toArray();
        $filterFields = FilterFieldTable::instance()->getFilterFieldByFilterId($filter[0]->getId())->toArray();
        $result['fields'] = $filterFields;
        return $result;
    }

    /**
     * get all running stations in the system
     *
     * @param Doctrine_Collection $data, data with running station
     * @return array $result
     */
    public function getRunningStation(Doctrine_Collection $data) {
        $result = array();
        $a = 0;
        foreach($data as $item) {
            $result[$a]['id'] = $item->getUserId();
            $user = UserLoginTable::instance()->findUserById($item->getUserId());
            $result[$a++]['name'] = $user[0]->getUsername();
        }
        $result = $this->mergeArray($result);
        return $result;
    }

    /**
     * Merge the running system array
     * @param array $data, running stations
     * @return array $result
     */
    public function mergeArray(array $data) {
        $result = array();
        $inArray = array();
        $a = 0;
        foreach($data as $item) {
            if(empty($result) == true) {
                $inArray[] = $item['id'];
                $result[$a++] = $item;
            }
            else {
                if(!in_array($item['id'], $inArray)) {
                    $result[$a++] = $item;
                }
            }
        }
        
        return $result;
    }

    /**
     * Adjust the paramter of the request, if the filter is set or not
     *
     * @param sfWebRequest $filter
     * @return array $result
     */
    public function checkFilter(sfWebRequest $filter) {
        $result = array();
        $result['name'] = $filter->getParameter('name',-1);
        $result['sender'] = $filter->getParameter('sender',-1);
        $result['activestation'] = $filter->getParameter('activestation',-1);
        $result['mailinglist'] = $filter->getParameter('mailinglist',-1);
        $result['documenttemplate'] = $filter->getParameter('documenttemplate',-1);
        $result['daysfrom'] = $filter->getParameter('daysfrom',-1);
        $result['daysto'] = $filter->getParameter('daysto',-1);
        $result['sendetfrom'] = $filter->getParameter('sendetfrom',-1);
        $result['sendetto'] = $filter->getParameter('sendetto',-1);
        $result['fields'] = $this->getFields($filter);
        return $result;

    }


    /**
     * Load the Fields for a filter when a filter is executed
     *
     * @param sfWebRequest $filter,
     * @return array $result, contains the fields, for which will be searched
     */
    public function getFields(sfWebRequest $filter) {
        $result = array();
        $hasElements = true;
        $startAt = 0;
        $a = 0;
        if($filter->hasParameter('field0')) {
            while($hasElements) {
                if($filter->hasParameter('field'.$startAt) == true) {
                    $result[$a]['field'] = $filter->getParameter('field'.$startAt);
                    $result[$a]['operator'] = $filter->getParameter('operator'.$startAt);
                    $result[$a]['value'] = $filter->getParameter('value'.$startAt);
                    $fieldTable = FieldTable::instance()->getFieldById($result[$a]['field'])->toArray();
                    $result[$a]['type'] = $fieldTable[0]['type'];
                    $startAt++;
                    $a++;
                }
                else {
                    $hasElements = false;
                }
            }
        }
        else {
            return -1;
        }
        return $result;
    }

}
?>
