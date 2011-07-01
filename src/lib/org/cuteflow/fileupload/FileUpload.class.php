<?php

/**
 * Class handles file upload
 */

class FileUpload {


    /**
     * Upload a file for an workflowattachment. not a field-File!
     * File is stored in web/uploads/templateid/versionid/md5(time() . filename).**
     *
     * @param array $file, contains filename
     * @param <type> $versionid, id of the workflowversion
     * @param <type> $templateid, id of the workflowtemplate
     * @return boolean
     */
    public function uploadFile(array $file, $versionid, $templateid) {
        if($file['name'] != '') {
            $this->checkFolder($versionid, $templateid);
            $hashFileArray = explode('.', $file['name']);
            $hashString = time() . md5($hashFileArray[0]) . '.' . $hashFileArray[count($hashFileArray)-1];
            move_uploaded_file($file['tmp_name'], sfConfig::get('sf_upload_dir') . '/' . $templateid . '/' . $versionid . '/' . $hashString);
            $newFile = new WorkflowVersionAttachment();
            $newFile->setWorkflowVersionId($versionid);
            $newFile->setWorkflowTemplateId($templateid);
            $newFile->setFilename($file['name']);
            $newFile->setHashname($hashString);
            $newFile->save();
            
            return true;
        }
        return false;
    }

    /**
     * Check if the folders in upload dir are exisitng
     *
     * @param int $versionid, workflowversion id
     * @param int $templateid, workflow id
     * @return true
     */
    public function checkFolder($versionid, $templateid) {
        if(is_dir(sfConfig::get('sf_upload_dir') . '/' . $templateid) == false) {
            mkdir(sfConfig::get('sf_upload_dir') . '/' . $templateid);
        }

        if(is_dir(sfConfig::get('sf_upload_dir') . '/' . $templateid . '/' . $versionid) == false) {
            mkdir(sfConfig::get('sf_upload_dir') . '/' . $templateid . '/' . $versionid);
        }
        return true;
    }


    /**
     * Upload a file for a field FILE!
     * File is stored in web/uploads/templateid/versionid/md5(time() . filename).**
     *
     * @param array $file, contains filename
     * @param <type> $versionid, id of the workflowversion
     * @param <type> $templateid, id of the workflowtemplate
     * @return boolean
     */
    public function uploadFormFile(array $file, $field_id, $versionid, $templateid) {
        $this->checkFolder($versionid, $templateid);
        $hashFileArray = explode('.', $file['name']);
        $hashString = time() . md5($hashFileArray[0]) . '.' . $hashFileArray[count($hashFileArray)-1];
        move_uploaded_file($file['tmp_name'], sfConfig::get('sf_upload_dir') . '/' . $templateid . '/' . $versionid . '/' . $hashString);
        $wfs = new WorkflowSlotFieldFile();
        $wfs->setWorkflowSlotFieldId($field_id);
        $wfs->setFilename($file['name']);
        $wfs->setHashname($hashString);
        $wfs->save();
    }


    /**
     * Copy the files, if a new worklfowversion will be created
     *
     * @param array $oldValues, contains the hashname
     * @param int $newversionid, id of the new version
     * @param int $templateid, templateid of the workflow
     * @param int $oldversionid, id of the old version
     */
    public function moveFile(array $oldValues, $newversionid, $templateid, $oldversionid) {
        $this->checkFolder($newversionid, $templateid);
        $current = sfConfig::get('sf_upload_dir') . '/' . $templateid . '/' . $oldversionid . '/' . $oldValues['hashname'];
        $dest = sfConfig::get('sf_upload_dir') . '/' . $templateid . '/' . $newversionid . '/' . $oldValues['hashname'];
        @copy($current, $dest);
    }



}
?>