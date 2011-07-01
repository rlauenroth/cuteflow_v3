<?php

/**
 * file actions.
 *
 * @package    cf
 * @subpackage file
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class fileActions extends sfActions {


    /**
     * Function loads an attachment, and switches between file as attachment and file as field.
     * The files are stored in web/upload dir containing WorkflowID/WorkflowversionID/md5(date_filename)
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeShowAttachment(sfWebRequest $request) {
        $versionid = $request->getParameter('versionid');
        $workflowid = $request->getParameter('workflowid');
        $attachmentid = $request->getParameter('attachmentid');
        $file = $request->getParameter('file');

        if ($file == 1) {
            $attachment = WorkflowSlotFieldFileTable::instance()->geFileById($attachmentid)->toArray(); // file from field
        }
        else {
            $attachment = WorkflowVersionAttachmentTable::instance()->getAttachmentsById($attachmentid)->toArray(); // file from attachment table
        }
        $filepath = sfConfig::get('sf_upload_dir') . '/' . $workflowid . '/' . $versionid . '/' . $attachment[0]['hashname'];
        $file = new File();

        $filecontent = $file->getFileContent($filepath); // open file and get content
        $contenttyoe = $file->getContentType($attachment[0]['hashname']);

        $response = $this->getResponse();
        $response->clearHttpHeaders();

        $response->setHttpHeader('Content-Type', 'application/octet-stream'); // set content type of response
        $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=' . $attachment[0]['filename']);
        $response->setHttpHeader('Content-Length', @filesize($filepath)); // add filesize
        $response->sendHttpHeaders(); // send the headers before the file
        $response->setContent($filecontent); // set file string
        return sfView::NONE;
    }










}
