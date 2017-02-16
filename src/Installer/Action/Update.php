<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
namespace Module\Notification\Installer\Action;

use Pi;
use Pi\Application\Installer\Action\Update as BasicUpdate;
use Pi\Application\Installer\SqlSchema;
use Zend\EventManager\Event;

class Update extends BasicUpdate
{
    /**
     * {@inheritDoc}
     */
    protected function attachDefaultListeners()
    {
        $events = $this->events;
        $events->attach('update.pre', array($this, 'updateSchema'));
        parent::attachDefaultListeners();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function updateSchema(Event $e)
    {
        $moduleVersion = $e->getParam('version');

        // Update to version 0.1.2
        if (version_compare($moduleVersion, '0.1.2', '<')) {
            // Add table : push
            $sql = <<<'EOD'
CREATE TABLE `{push}` (
  `id`           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `time_create`  INT(10) UNSIGNED NOT NULL DEFAULT '0',
  # FCM
  `to`           VARCHAR(255)     NOT NULL DEFAULT '',
  `title`        VARCHAR(255)     NOT NULL DEFAULT '',
  `body`         TEXT,
  `sound`        VARCHAR(255)     NOT NULL DEFAULT '',
  `time_to_live` VARCHAR(255)     NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `time_create` (`time_create`)
);
EOD;
            SqlSchema::setType($this->module);
            $sqlHandler = new SqlSchema;
            try {
                $sqlHandler->queryContent($sql);
            } catch (\Exception $exception) {
                $this->setResult('db', array(
                    'status' => false,
                    'message' => 'SQL schema query for author table failed: '
                        . $exception->getMessage(),
                ));

                return false;
            }
        }

        return true;
    }
}