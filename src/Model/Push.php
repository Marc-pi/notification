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
namespace Module\Notification\Model;

use Pi\Application\Model\Model;

class Push extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $columns = array(
        'id',
        'time_create',
        'to',
        'title',
        'body',
        'sound',
        'time_to_live',
    );
}