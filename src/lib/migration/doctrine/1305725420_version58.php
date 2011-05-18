<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version58 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('cf_userdata', 'lastaction');
        $this->addColumn('cf_userdata', 'last_action', 'string', '255', array(
             ));
        $this->changeColumn('cf_userlogin', 'id', 'integer', '8', array(
             'autoincrement' => '1',
             'primary' => '1',
             ));
    }

    public function down()
    {
        $this->addColumn('cf_userdata', 'lastaction', 'string', '255', array(
             ));
        $this->removeColumn('cf_userdata', 'last_action');
    }
}